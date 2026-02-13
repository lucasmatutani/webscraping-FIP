<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use App\Models\Brands;
use App\Models\Models;
use App\Models\Years;
use App\Models\CarsValue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FipeController extends Controller
{
    public function getBrands()
    {
        $brands = Cache::remember('brands', 60 * 24, function () {
            return Brands::all(['id', 'name']);
        });
        return response()->json($brands);
    }

    public function getModels($brandId)
    {
        $models = Models::where('brand_id', $brandId)->get(['id', 'name']);
        return response()->json($models);
    }

    public function getYears($modelId)
    {
        $years = Years::where('model_id', $modelId)->get(['year', 'fuel_type']);
        return response()->json($years);
    }

    public function getCarValue(Request $request)
{
    $modelId = $request->query('model_id');
    $year = $request->query('year');

    if (!$modelId || !$year) {
        return response()->json(['error' => 'Parâmetros ausentes'], 400);
    }

    $value = CarsValue::with('model.brand')
                      ->where('model_id', $modelId)
                      ->where('year', $year)
                      ->first(['value', 'reference_month', 'fipe_code', 'year', 'model_id']);

    if ($value) {
        return response()->json([
            'value' => $value->value,
            'reference_month' => $value->reference_month,
            'fipe_code' => $value->fipe_code,
            'year' => $value->year,
            'model' => $value->model->name ?? 'N/A',
            'brand' => $value->model->brand->name ?? 'N/A'
        ]);
    } else {
        return response()->json(['error' => 'Nenhum valor encontrado para essa combinação.'], 404);
    }
}

    /**
     * Exibe a página de resultado da consulta Fipe (server-side para SEO).
     */
    public function showResult(Request $request)
    {
        $modelId = $request->query('model_id');
        $year = $request->query('year');

        if (!$modelId || !$year) {
            return redirect('/')->with('error', 'Selecione modelo e ano para consultar.');
        }

        $yearValue = preg_match('/^(\d+)/', $year, $m) ? (int) $m[1] : null;
        if ($yearValue === null) {
            return redirect('/')->with('error', 'Ano inválido.');
        }

        $value = CarsValue::with('model.brand')
            ->where('model_id', $modelId)
            ->where('year', $yearValue)
            ->first();

        if (!$value) {
            return redirect('/')->with('error', 'Nenhum valor encontrado para essa combinação.');
        }

        $brandSlug = Str::slug($value->model->brand->name ?? '');
        $modelSlug = Str::slug($value->model->name ?? '');
        $yearSegment = (string) $value->year;

        return redirect()->route('resultado.slug', [
            'brandSlug' => $brandSlug,
            'modelSlug' => $modelSlug,
            'year' => $yearSegment,
        ], 301);
    }

    /**
     * Exibe a página de resultado pela URL indexável (marca/modelo/ano).
     */
    public function showResultBySlug(string $brandSlug, string $modelSlug, string $year): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        $yearValue = preg_match('/^(\d+)/', $year, $m) ? (int) $m[1] : null;
        if ($yearValue === null) {
            return redirect('/')->with('error', 'Ano inválido.');
        }

        if ($year !== (string) $yearValue) {
            return redirect()->route('resultado.slug', [
                'brandSlug' => $brandSlug,
                'modelSlug' => $modelSlug,
                'year' => (string) $yearValue,
            ], 301);
        }

        $brand = Brands::all()->first(function (Brands $b) use ($brandSlug) {
            return Str::slug($b->name) === $brandSlug;
        });

        if (!$brand) {
            return redirect('/')->with('error', 'Marca não encontrada.');
        }

        $model = Models::where('brand_id', $brand->id)->get()->first(function (Models $m) use ($modelSlug) {
            return Str::slug($m->name) === $modelSlug;
        });

        if (!$model) {
            return redirect('/')->with('error', 'Modelo não encontrado.');
        }

        $value = CarsValue::with('model.brand')
            ->where('model_id', $model->id)
            ->where('year', $yearValue)
            ->first();

        if (!$value) {
            return redirect('/')->with('error', 'Nenhum valor encontrado para essa combinação.');
        }

        $car = [
            'value' => $value->value,
            'value_schema' => $this->normalizePriceForSchema($value->value),
            'reference_month' => $value->reference_month,
            'fipe_code' => $value->fipe_code,
            'year' => (string) $value->year,
            'year_display' => $value->year == 0 ? '0km' : (string) $value->year,
            'model' => $value->model->name ?? 'N/A',
            'brand' => $value->model->brand->name ?? 'N/A',
        ];

        if (empty($car)) {
            return redirect('/')->with('error', 'Nenhum valor encontrado para essa combinação.');
        }

        $otherYears = CarsValue::where('model_id', $model->id)
            ->where('year', '!=', $yearValue)
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->limit(5)
            ->get()
            ->map(function ($row) use ($brandSlug, $modelSlug, $car) {
                $yearSegment = (string) $row->year;
                $yearDisplay = $row->year == 0 ? '0km' : (string) $row->year;
                return [
                    'year' => $yearSegment,
                    'year_display' => $yearDisplay,
                    'url' => route('resultado.slug', [
                        'brandSlug' => $brandSlug,
                        'modelSlug' => $modelSlug,
                        'year' => $yearSegment,
                    ]),
                    'link_text' => "Preço FIPE {$car['brand']} {$car['model']} {$yearDisplay}",
                ];
            })
            ->values()
            ->all();

        return view('result', ['car' => $car, 'otherYears' => $otherYears]);
    }

    /**
     * Normaliza o valor Fipe para o formato numérico do Schema.org (ex.: 125000.00).
     * Formato brasileiro: vírgula = decimal, ponto = milhar (ex.: R$ 125.000,00).
     */
    private function normalizePriceForSchema(string $value): string
    {
        $cleaned = preg_replace('/[^0-9,.]/', '', $value);
        $withoutThousands = str_replace('.', '', $cleaned);
        $withDecimalDot = str_replace(',', '.', $withoutThousands);

        $numeric = (float) $withDecimalDot;

        return number_format($numeric, 2, '.', '');
    }
}
