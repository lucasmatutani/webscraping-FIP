<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use \App\Models\Brands;
use \App\Models\Models;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Jobs\SearchYearJob;

class SearchModelJob implements ShouldQueue
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
        $client = new Client();
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

                $response = $client->request('POST', $url, $formParams);
                $modelsData = json_decode($response->getBody(), true);

                if(isset($modelsData["erro"])){
                    \Log::error('Erro no SearchCarJob: brand ' . $brand->name . "\n");
                    continue;
                }

                if (isset($modelsData['Modelos'])) {
                    foreach ($modelsData['Modelos'] as $modelItem) {
                        Models::updateOrCreate(
                            ['fipe_id' => $modelItem['Value'], 'brand_id' => $brand->id],
                            ['name' => $modelItem['Label']]
                        );
                    }
                }
                sleep(2);
            } catch (GuzzleException $e) {
                \Log::error('Erro no SearchModelJob: ' . $e->getMessage());
            }
        }
        dispatch(new SearchYearJob());
    }
}

