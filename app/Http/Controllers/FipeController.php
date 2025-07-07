<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use \App\Models\Brands;
use \App\Models\Models;
use \App\Models\Years;
use \App\Models\CarsValue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class FIPEController extends Controller
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

}
