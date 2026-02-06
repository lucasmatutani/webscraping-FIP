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

    private int $codigoTabelaReferencia;
    
    public function __construct(int $codigoTabelaReferencia = 330)
    {
        $this->codigoTabelaReferencia = $codigoTabelaReferencia;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Log::info('Iniciando SearchCarJob');
        $client = new Client();
        $brands = Brands::all();

        foreach ($brands as $brand) {
            $models = Models::where('brand_id', $brand->id)->get();

            foreach ($models as $model) {
                $years = Years::where('model_id', $model->id)->get();

                foreach ($years as $year) {
                    $maxAttempts = 3;
                    $attempt = 0;
                    $success = false;

                    while (! $success && $attempt < $maxAttempts) {
                        try {
                            $attempt++;
                            $url = 'https://veiculos.fipe.org.br/api/veiculos//ConsultarValorComTodosParametros';

                            $anoParaApi = $year->year === 0 ? 32000 : $year->year;

                            $formParams = [
                                'form_params' => [
                                    'codigoTabelaReferencia' => $this->codigoTabelaReferencia,
                                    'codigoMarca' => $brand->fipe_id,
                                    'codigoModelo' => $model->fipe_id,
                                    'codigoTipoVeiculo' => 1,
                                    'anoModelo' => $anoParaApi,
                                    'codigoTipoCombustivel' => $year->fuel_type,
                                    'tipoVeiculo' => 1,
                                    'tipoConsulta' => 'tradicional'
                                ],
                            ];

                            $response = $client->request('POST', $url, $formParams);
                            $carData = json_decode($response->getBody(), true);

                            if (isset($carData['erro'])) {
                                // API retorna "erro" para combinações inexistentes (ex.: ano 32000) – não é falha do job
                                \Log::debug('SearchCarJob: sem valor FIPE para brand ' . $brand->fipe_id . ' model ' . $model->fipe_id . ' year ' . $year->year);
                                $success = true;
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
                            $success = true;
                            sleep(2);
                        } catch (GuzzleException $e) {
                            if ($attempt >= $maxAttempts) {
                                \Log::error('SearchCarJob falhou após ' . $maxAttempts . ' tentativas: brand ' . $brand->fipe_id . ' model ' . $model->fipe_id . ' year ' . $year->year . ' – ' . $e->getMessage());
                            } else {
                                sleep(30);
                            }
                        }
                    }
                }
            }
        }
        \Log::info('Finalizando SearchCarJob');
    }
}
