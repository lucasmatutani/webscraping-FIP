<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use \App\Models\Brands;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Jobs\SearchModelJob;

class SearchBrandJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        // Você pode passar parâmetros para o job, se necessário
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $client = new Client(); // Instanciar o GuzzleHttp Client

        try {
            $url = 'https://veiculos.fipe.org.br/api/veiculos//ConsultarMarcas';

            $formParams = [
                'form_params' => [
                    'codigoTabelaReferencia' => 330,
                    'codigoTipoVeiculo' => 1
                ],
            ];

            $response = $client->request('POST', $url, $formParams);
            $brands = json_decode($response->getBody(), true);

            foreach ($brands as $brand) {
                Brands::updateOrCreate(
                    ['fipe_id' => $brand['Value'], 'name' => $brand['Label']],
                );
            }
            sleep(5);
            dispatch(new SearchModelJob());
        } catch (GuzzleException $e) {
            \Log::error('Erro no SearchBrandJob: ' . $e->getMessage());
        }
    }
}
