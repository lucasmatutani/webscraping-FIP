@php
    $ano = isset($car) ? $car['year'] : null;
    $title = isset($car) ? "Preço FIPE {$car['brand']} {$car['model']} {$ano} - {$car['reference_month']}" : 'Tabela FIPE';
    $description = isset($car) ? "Consulte o preço FIPE do {$car['brand']} {$car['model']} {$ano} para compra, venda. Valor atualizado em {$car['reference_month']}" : 'Consulte os valores atualizados da tabela FIPE para carros de todo o Brasil.';
    $canonical = url()->current();
    $dataConsulta = isset($car) ? now()->format('d/m/Y') : '';
@endphp
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    @if(!isset($car))
        <meta name="robots" content="noindex,follow">
    @endif
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ $canonical }}">
    <link rel="icon" href="{{ asset('images/icon_i_love_carros.png') }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="article">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:site_name" content="Carros do Brasil - Tabela FIPE">
    <meta property="og:image" content="{{ asset('images/social_media.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{{ $description }}">
    <meta name="twitter:image" content="{{ asset('images/social_media.png') }}">
    <meta name="twitter:image:width" content="1200">
    <meta name="twitter:image:height" content="630">

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet">
    @vite(['resources/js/app.js'])

    @if(isset($car))
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Product",
            "name": "{{ $car['brand'] }} {{ $car['model'] }} {{ $ano }}",
            "url": "{{ $canonical }}",
            "image": "{{ asset('images/social_media.png') }}",
            "brand": {
                "@type": "Brand",
                "name": "{{ $car['brand'] }}"
            },
            "description": "Valor FIPE de referência - {{ $car['reference_month'] }}",
            "offers": {
                "@type": "Offer",
                "price": "{{ $car['value_schema'] }}",
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
                    Preço {{ $car['brand'] }} {{ $car['model'] }} {{ $car['year'] }} – Valor Atualizado
                </h1>
                <p>Confira o valor de referência FIPE do {{ $car['brand'] }} {{ $car['model'] }} {{ $car['year'] }} para
                    {{ $car['reference_month'] }}.</p>

                <p class="result-price" aria-label="Valor FIPE">{{ $car['value'] }}</p>

                <h2>Sobre o preço FIPE do {{ $car['brand'] }} {{ $car['model'] }} {{ $car['year'] }}</h2>
                <p>
                    O preço médio FIPE do {{ $car['brand'] }} {{ $car['model'] }} {{ $car['year'] }}
                    em {{ $car['reference_month'] }} é de {{ $car['value'] }}.
                    Esse valor é usado como referência no mercado brasileiro.
                </p>
                <div class="container-result">
                    <div class="container-table">
                        <div class="container-padding">
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
                <div class="result-actions">
                    <a href="{{ url('/') }}" class="buttom-submit">REFAZER PESQUISA</a>
                    <button type="button" onclick="window.print()" class="result-action-icon"
                        aria-label="Imprimir resultado" title="Imprimir">
                        <i class="fas fa-print" aria-hidden="true"></i>
                    </button>
                    <button type="button" id="copyUrlBtn" class="result-action-icon" aria-label="Copiar URL"
                        title="Copiar URL">
                        <i class="fas fa-clipboard" aria-hidden="true"></i>
                    </button>
                </div>
            @else
                <h1 id="result-title" class="result-title">Nenhum valor encontrado</h1>
                <p>Não foi possível encontrar o valor FIPE para a combinação selecionada.</p>
                <a href="{{ url('/') }}" class="buttom-submit"
                    style="text-decoration: none; display: inline-block; margin-top: 20px;">NOVA PESQUISA</a>
            @endif
        </section>
    </main>

    @if(isset($car))
        <script>
            document.getElementById('copyUrlBtn').addEventListener('click', function () {
                navigator.clipboard.writeText('{{ $canonical }}').then(function () {
                    var btn = document.getElementById('copyUrlBtn');
                    var icon = btn.querySelector('i');
                    var prevClass = icon.className;
                    icon.className = 'fas fa-check';
                    setTimeout(function () { icon.className = prevClass; }, 2000);
                });
            });
        </script>
    @endif
</body>

</html>