<?php

namespace App\Jobs;

use App\Models\CarsValue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class GenerateSitemapJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     * Gera e sobrescreve public/sitemap.xml com todas as URLs canônicas de resultado.
     */
    public function handle(): void
    {
        $urls = $this->collectCanonicalUrls();
        $xml = $this->buildSitemapXml($urls);
        $this->writeSitemap($xml);
    }

    /**
     * Coleta todas as URLs canônicas únicas (brandSlug/modelSlug/year) a partir de car_values.
     * Escalável: usa chunk para não carregar tudo em memória de uma vez.
     */
    private function collectCanonicalUrls(): array
    {
        $baseUrl = rtrim(config('app.url'), '/');
        $lastmod = now()->format('Y-m-d');
        $seen = [];
        $urls = [];

        // URL da home (sempre primeira no sitemap)
        $urls[] = [
            'loc' => $baseUrl . '/',
            'lastmod' => $lastmod,
            'changefreq' => 'monthly',
        ];

        CarsValue::with('model.brand')
            ->chunkById(1000, function ($items) use ($baseUrl, $lastmod, &$seen, &$urls) {
                foreach ($items as $cv) {
                    $brandSlug = Str::slug($cv->model->brand->name ?? '');
                    $modelSlug = Str::slug($cv->model->name ?? '');
                    $year = (string) $cv->year;
                    $key = "{$brandSlug}|{$modelSlug}|{$year}";

                    if (isset($seen[$key])) {
                        continue;
                    }
                    $seen[$key] = true;

                    $urls[] = [
                        'loc' => "{$baseUrl}/resultado/{$brandSlug}/{$modelSlug}/{$year}",
                        'lastmod' => $lastmod,
                        'changefreq' => 'monthly',
                    ];
                }
            });

        return $urls;
    }

    /**
     * Monta o XML do sitemap no padrão oficial (sem priority).
     */
    private function buildSitemapXml(array $urls): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $entry) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . $this->escapeXml($entry['loc']) . "</loc>\n";
            $xml .= '    <lastmod>' . $this->escapeXml($entry['lastmod']) . "</lastmod>\n";
            $xml .= '    <changefreq>' . $this->escapeXml($entry['changefreq']) . "</changefreq>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }

    private function escapeXml(string $value): string
    {
        return htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }

    /**
     * Escreve o conteúdo em public/sitemap.xml (sobrescreve a cada execução).
     */
    private function writeSitemap(string $xml): void
    {
        $path = base_path('public/sitemap.xml');
        file_put_contents($path, $xml, LOCK_EX);
    }
}
