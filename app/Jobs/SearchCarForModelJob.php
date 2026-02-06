<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use App\Models\Models;
use App\Models\Years;
use App\Models\CarsValue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SearchCarForModelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private int $modelId,
        private int $codigoTabelaReferencia = 330
    ) {}

    public function handle(): void
    {
        $model = Models::with('brand')->find($this->modelId);

        if (! $model || ! $model->brand) {
            return;
        }

        $years = Years::where('model_id', $model->id)->get();

        if ($years->isEmpty()) {
            return;
        }

        $client = new Client();

        foreach ($years as $year) {
            $maxAttempts = 3;
            $attempt = 0;
            $success = false;

            while (! $success && $attempt < $maxAttempts) {
                try {
                    $attempt++;

                    $anoParaApi = $year->year === 0 ? 32000 : $year->year;

                    $formParams = [
                        'form_params' => [
                            'codigoTabelaReferencia' => $this->codigoTabelaReferencia,
                            'codigoMarca' => $model->brand->fipe_id,
                            'codigoModelo' => $model->fipe_id,
                            'codigoTipoVeiculo' => 1,
                            'anoModelo' => $anoParaApi,
                            'codigoTipoCombustivel' => $year->fuel_type,
                            'tipoVeiculo' => 1,
                            'tipoConsulta' => 'tradicional',
                        ],
                    ];

                    $response = $client->request(
                        'POST',
                        'https://veiculos.fipe.org.br/api/veiculos//ConsultarValorComTodosParametros',
                        $formParams
                    );

                    $carData = json_decode($response->getBody(), true);

                    if (isset($carData['erro'])) {
                        Log::debug('SearchCarForModelJob: sem valor model ' . $model->id . ' year ' . $year->year);
                        $success = true;
                        continue;
                    }

                    CarsValue::updateOrCreate(
                        [
                            'fipe_code' => $carData['CodigoFipe'],
                            'model_id' => $model->id,
                            'year' => $year->year,
                        ],
                        [
                            'value' => $carData['Valor'],
                            'reference_month' => $carData['MesReferencia'],
                        ]
                    );

                    $success = true;
                    sleep(2);
                } catch (GuzzleException $e) {
                    if ($attempt >= $maxAttempts) {
                        Log::error('SearchCarForModelJob falhou após ' . $maxAttempts . ' tentativas: model ' . $model->id . ' year ' . $year->year . ' – ' . $e->getMessage());
                    } else {
                        sleep(30);
                    }
                }
            }
        }
    }
}
