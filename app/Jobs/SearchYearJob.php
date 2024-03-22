<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use \App\Models\Models;
use \App\Models\Years;
use \App\Models\Brands;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Jobs\SearchCarJob;

class SearchYearJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        // Parâmetros para o job, se necessário
    }

    public function handle(): void
    {
        $client = new Client();
        $models = Models::with('brand')->get(); 

        foreach ($models as $model) {
            try {
                $url = 'https://veiculos.fipe.org.br/api/veiculos//ConsultarAnoModelo';

                $formParams = [
                    'form_params' => [
                        'codigoTipoVeiculo' => 1,
                        'codigoTabelaReferencia' => 305,
                        'codigoModelo' => $model->fipe_id,
                        'codigoMarca' => $model->brand->fipe_id
                    ],
                ];

                $response = $client->request('POST', $url, $formParams);
                $yearsData = json_decode($response->getBody(), true);

                if(isset($yearsData["erro"])){
                    \Log::error('Erro no SearchCarJob: brand ' . $model->name . "\n");
                    continue;
                }

                foreach ($yearsData as $yearItem) {
                    preg_match('/^\d+/', $yearItem['Label'], $matches);
                    $yearNumber = intval($matches[0]);

                    Years::updateOrCreate(
                        ['year' => $yearNumber, 'value' => $yearItem['Value'] ,'model_id' => $model->id]
                    );
                }
                sleep(2);
            } catch (GuzzleException $e) {
                \Log::error('Erro no SearchYearJob: ' . $e->getMessage());
            }
        }
        dispatch(new SearchCarJob());
    }
}
