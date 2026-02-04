<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use \App\Models\Brands;
use \App\Models\Models;
use \App\Models\Years;
use \App\Models\CarsValue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SearchCarJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        // Parâmetros para o job, se necessário
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Log::info('Iniciando SearchBrandJob');
        $client = new Client();
        $brands = Brands::all();

        foreach ($brands as $brand) {
            $models = Models::where('brand_id', $brand->id)->get();

            foreach ($models as $model) {
                $years = Years::where('model_id', $model->id)->get();

                foreach ($years as $year) {
                    try {
                        $url = 'https://veiculos.fipe.org.br/api/veiculos//ConsultarValorComTodosParametros';
                        
                        $formParams = [
                            'form_params' => [
                                'codigoTabelaReferencia' => 308,
                                'codigoMarca' => $brand->fipe_id,
                                'codigoModelo' => $model->fipe_id,
                                'codigoTipoVeiculo' => 1,
                                'anoModelo' => $year->year,
                                'codigoTipoCombustivel' => $year->fuel_type,
                                'tipoVeiculo' => 1,
                                'tipoConsulta' => 'tradicional'
                            ],
                        ];

                        $response = $client->request('POST', $url, $formParams);
                        $carData = json_decode($response->getBody(), true);
                        
                        if(isset($carData["erro"])){
                            \Log::error('Erro no SearchCarJob: brand ' . $brand->fipe_id . " model " . $model->fipe_id . " year: " . $year->year . "\n");
                            continue;
                        }

                        CarsValue::updateOrCreate(
                            [
                                'fipe_code' => $carData['CodigoFipe'],
                                'model_id' => $model->id,
                                'year' => $year->year
                            ],
                            [
                                'value' => $carData['Valor'],
                                'reference_month' => $carData['MesReferencia']
                            ]
                        );
                        sleep(5);
                    } catch (GuzzleException $e) {
                        \Log::error('Erro no SearchCarJob: ' . $e->getMessage());
                    }
                }
            }
        }
        \Log::info('Finalizando SearchBrandJob');
    }
}
