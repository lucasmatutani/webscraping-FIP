<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use \App\Models\Brands;
use \App\Models\Models;
use \App\Models\Years;
use \App\Models\CarsValue;

class FIPEController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function execute()
    {
        $this->searchCar();
    }

    public function searchBrand()
    {
        try {
            $url = 'https://veiculos.fipe.org.br/api/veiculos//ConsultarMarcas';

            $formParams = [
                'form_params' => [
                    'codigoTabelaReferencia' => 305,
                    'codigoTipoVeiculo' => 1
                ],
            ];

            $response = $this->client->request('POST', $url, $formParams);

            $brands = json_decode($response->getBody(), true);
            foreach ($brands as $brand) {
                Brands::updateOrCreate(
                    ['fipe_id' => $brand['Value']],
                    ['name' => $brand['Label']]
                );
            }
            var_dump($brands);
        } catch (GuzzleException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function searchModel()
    {
        $brands = Brands::all();
        foreach ($brands as $brand) {
            try {
                $url = 'https://veiculos.fipe.org.br/api/veiculos//ConsultarModelos';

                $formParams = [
                    'form_params' => [
                        'codigoTipoVeiculo' => 1,
                        'codigoTabelaReferencia' => 305,
                        'codigoMarca' => $brand->fipe_id
                    ],
                ];

                $response = $this->client->request('POST', $url, $formParams);
                $models = json_decode($response->getBody(), true);
                foreach ($models["Modelos"] as $model) {
                    Models::updateOrCreate(
                        ['fipe_id' => $model['Value'], 'brand_id' => $brand->id],
                        ['name' => $model['Label']]
                    );
                }
            } catch (GuzzleException $e) {
                // Trate a exceção conforme necessário
                return response()->json(['error' => $e->getMessage()], 500);
            }
            exit();
        }
    }

    public function searchYear()
    {
        // $models = Models::all();
        // foreach ($models as $model) {
            try {
                $url = 'https://veiculos.fipe.org.br/api/veiculos//ConsultarAnoModelo';

                $formParams = [
                    'form_params' => [
                        'codigoTipoVeiculo' => 1,
                        'codigoTabelaReferencia' => 305,
                        'codigoModelo' => 1,
                        'codigoMarca' => 1
                    ],
                ];

                $response = $this->client->request('POST', $url, $formParams);
                $years = json_decode($response->getBody(), true);
                foreach ($years as $year) {
                    preg_match('/^\d+/', $year['Label'], $matches); // Extrai o ano numérico
                    $yearNumber = intval($matches[0]);
                    Years::updateOrCreate(
                        ['year' => $yearNumber, 'value' => $year['Value'], 'model_id' => 1]
                    );
                }
                exit();
            } catch (GuzzleException $e) {
                // Trate a exceção conforme necessário
                return response()->json(['error' => $e->getMessage()], 500);
            }
        // }
    }

    public function searchCar()
    {
        $brands = Brands::all(); 

        // foreach ($brands as $brand) {
        //     $models = Models::where('brand_id', $brand->id)->get();

            // foreach ($models as $model) {
            //     $years = Years::where('model_id', $model->id)->get();

                // foreach ($years as $year) {
                    try {
                        $url = 'https://veiculos.fipe.org.br/api/veiculos//ConsultarValorComTodosParametros';

                        $formParams = [
                            'form_params' => [
                                'codigoTabelaReferencia' => 306,
                                'codigoMarca' => 2,
                                'codigoModelo' => 4,
                                'codigoTipoVeiculo' => 1,
                                'anoModelo' => 2007,
                                'codigoTipoCombustivel' => 3,
                                'tipoVeiculo' => 'carro',
                                'tipoConsulta' => 'tradicional'
                            ],
                        ];

                        $response = $this->client->request('POST', $url, $formParams);
                        $car = json_decode($response->getBody(), true);
                        var_dump($car);
                        exit();
                        if(isset($car["erro"])){
                            \Log::error('Erro no SearchCarJob: brand ' . $brand->fipe_id . " model " . $model->fipe_id . " year: " . $year->year . "\n");
                        }
                        CarsValue::create([
                            'valor' => $car['Valor'],
                            'codigo_fipe' => $car['CodigoFipe'],
                            'mes_referencia' => $car['MesReferencia'],
                            'model_id' => $model->id
                        ]);
                    } catch (GuzzleException $e) {
                        return response()->json(['error' => $e->getMessage()], 500);
                    }
                // }
            // }
        // }
    }
}
