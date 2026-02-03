@php
    $ano = isset($car) ? $car['year'] : null;
    $title = isset($car) ? "Valor FIPE {$car['brand']} {$car['model']} {$ano} - Tabela FIPE | Carros do Brasil" : 'Valor FIPE - Tabela FIPE | Carros do Brasil';
    $description = isset($car) ? "Consulte o valor FIPE do {$car['brand']} {$car['model']} {$ano}. Preço de referência: {$car['value']}. Mês de referência: {$car['reference_month']}. Código FIPE: {$car['fipe_code']}." : 'Consulte os valores atualizados da tabela FIPE para carros de todo o Brasil.';
    $canonical = url()->current();
    $dataConsulta = isset($car) ? now()->format('d/m/Y') : '';
@endphp
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ $canonical }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:site_name" content="Carros do Brasil - Tabela FIPE">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{{ $description }}">

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    @vite(['resources/js/app.js'])

    @if(isset($car))
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Product",
        "name": "{{ $car['brand'] }} {{ $car['model'] }} {{ $ano }}",
        "brand": {
            "@type": "Brand",
            "name": "{{ $car['brand'] }}"
        },
        "description": "Valor FIPE de referência - {{ $car['reference_month'] }}",
        "offers": {
            "@type": "Offer",
            "price": "{{ preg_replace('/[^0-9,]/', '', str_replace(',', '.', $car['value'])) }}",
            "priceCurrency": "BRL",
            "availability": "https://schema.org/InStock"
        },
        "additionalProperty": [
            {
                "@type": "PropertyValue",
                "name": "Ano Modelo",
                "value": "{{ $ano }}"
            },
            {
                "@type": "PropertyValue",
                "name": "Código FIPE",
                "value": "{{ $car['fipe_code'] }}"
            },
            {
                "@type": "PropertyValue",
                "name": "Mês Referência",
                "value": "{{ $car['reference_month'] }}"
            }
        ]
    }
    </script>
    @endif
</head>

<body>
    <header class="header" role="banner">
        <a href="{{ url('/') }}" aria-label="Voltar para consulta FIPE">
            <img src="{{ asset('images/logo_i_love_carros.png') }}" alt="Carros do Brasil - Tabela FIPE">
        </a>
    </header>

    <main class="container" role="main">
        <section class="result-section" aria-labelledby="result-title">
            @if(isset($car))
                <h1 id="result-title" class="result-title">
                    Valor FIPE: {{ $car['brand'] }} {{ $car['model'] }} {{ $car['year'] }}
                </h1>
                <p class="result-subtitle">Consulta realizada em {{ $dataConsulta }}</p>

                <div class="container-result">
                    <div class="container-btn">
                        <button type="button" onclick="window.print()" aria-label="Imprimir resultado">
                            <i class="fas fa-print" aria-hidden="true"></i> IMPRIMIR
                        </button>
                        <button type="button" id="copyUrlBtn" aria-label="Copiar URL para a área de transferência">
                            <i class="fas fa-clipboard" aria-hidden="true"></i> COPIAR URL
                        </button>
                    </div>
                    <div class="container-table">
                        <div class="container-padding">
                            <div class="container-values price">
                                <span class="label">Valor FIPE:</span>
                                <span class="value">{{ $car['value'] }}</span>
                            </div>
                            <span class="underline" aria-hidden="true"></span>

                            <div class="container-values">
                                <span class="label">Mês Referência:</span>
                                <span class="value">{{ $car['reference_month'] }}</span>
                            </div>
                            <span class="underline" aria-hidden="true"></span>

                            <div class="container-values">
                                <span class="label">Código FIPE:</span>
                                <span class="value">{{ $car['fipe_code'] }}</span>
                            </div>
                            <span class="underline" aria-hidden="true"></span>

                            <div class="container-values">
                                <span class="label">Marca:</span>
                                <span class="value">{{ $car['brand'] }}</span>
                            </div>
                            <span class="underline" aria-hidden="true"></span>

                            <div class="container-values">
                                <span class="label">Modelo:</span>
                                <span class="value">{{ $car['model'] }}</span>
                            </div>
                            <span class="underline" aria-hidden="true"></span>

                            <div class="container-values">
                                <span class="label">Ano:</span>
                                <span class="value">{{ $car['year'] }}</span>
                            </div>
                            <span class="underline" aria-hidden="true"></span>

                            <div class="container-values">
                                <span class="label">Data da consulta:</span>
                                <span class="value">{{ $dataConsulta }}</span>
                            </div>
                            <span class="underline" aria-hidden="true"></span>
                        </div>
                    </div>
                </div>
                <a href="{{ url('/') }}" class="buttom-submit" style="text-decoration: none; display: inline-block; margin-top: 20px;">REFAZER PESQUISA</a>
            @else
                <h1 id="result-title" class="result-title">Nenhum valor encontrado</h1>
                <p>Não foi possível encontrar o valor FIPE para a combinação selecionada.</p>
                <a href="{{ url('/') }}" class="buttom-submit" style="text-decoration: none; display: inline-block; margin-top: 20px;">NOVA PESQUISA</a>
            @endif
        </section>
    </main>

    @if(isset($car))
    <script>
        document.getElementById('copyUrlBtn').addEventListener('click', function() {
            navigator.clipboard.writeText('{{ $canonical }}').then(function() {
                var btn = document.getElementById('copyUrlBtn');
                var text = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check"></i> URL COPIADA';
                setTimeout(function() { btn.innerHTML = text; }, 2000);
            });
        });
    </script>
    @endif
</body>
</html>
