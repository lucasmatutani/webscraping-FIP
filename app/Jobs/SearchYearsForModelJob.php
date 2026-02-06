<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use App\Models\Models;
use App\Models\Years;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SearchYearsForModelJob implements ShouldQueue
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

        $client = new Client();

        try {
            $url = 'https://veiculos.fipe.org.br/api/veiculos//ConsultarAnoModelo';

            $formParams = [
                'form_params' => [
                    'codigoTipoVeiculo' => 1,
                    'codigoTabelaReferencia' => $this->codigoTabelaReferencia,
                    'codigoModelo' => $model->fipe_id,
                    'codigoMarca' => $model->brand->fipe_id,
                ],
            ];

            $response = $client->request('POST', $url, $formParams);
            $yearsData = json_decode($response->getBody(), true);

            if (isset($yearsData['erro'])) {
                Log::debug('SearchYearsForModelJob: sem anos para model ' . $model->id . ' ' . $model->name);
                return;
            }

            foreach ($yearsData as $yearItem) {
                preg_match('/^\d+/', $yearItem['Label'], $matches);
                $yearNumber = (int) ($matches[0] ?? 0);
                if ($yearNumber === 32000) {
                    $yearNumber = 0;
                }
                $type = explode('-', $yearItem['Value']);

                Years::updateOrCreate(
                    ['year' => $yearNumber, 'fuel_type' => $type[1], 'model_id' => $model->id]
                );
            }

            sleep(2);

            dispatch(new SearchCarForModelJob($this->modelId, $this->codigoTabelaReferencia));
        } catch (GuzzleException $e) {
            Log::error('SearchYearsForModelJob model ' . $this->modelId . ': ' . $e->getMessage());
            throw $e;
        }
    }
}
