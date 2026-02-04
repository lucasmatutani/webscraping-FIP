@php
    $ano = isset($car) ? $car['year'] : null;
    $title = isset($car) ? "Preço FIPE {$car['brand']} {$car['model']} {$ano} - {$car['reference_month']}" : 'Tabela FIPE';
    $description = isset($car) ? "Consulte o preço FIPE do {$car['brand']} {$car['model']} {$ano} para compra, venda. Valor atualizado em {$car['reference_month']}" : 'Consulte os valores atualizados da tabela FIPE para carros de todo o Brasil.';
    $canonical = route('resultado.slug', [
        'brandSlug' => Str::slug($car['brand']),
        'modelSlug' => Str::slug($car['model']),
        'year' => $car['year'],
    ]);
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
            <nav class="result-section__breadcrumb" aria-label="Breadcrumb">
                <ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
                    <li class="breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a itemprop="item" href="{{ url('/') }}"><span itemprop="name">Início</span></a>
                        <meta itemprop="position" content="1" />
                    </li>
                    @if(isset($car))
                    <li class="breadcrumb__item breadcrumb__item--current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <link itemprop="item" href="{{ $canonical }}">
                        <span itemprop="name">{{ $car['brand'] }} {{ $car['model'] }} {{ $ano }}</span>
                        <meta itemprop="position" content="2" />
                    </li>
                    @else
                    <li class="breadcrumb__item breadcrumb__item--current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <span itemprop="name">Nenhum valor encontrado</span>
                        <meta itemprop="position" content="2" />
                    </li>
                    @endif
                </ol>
            </nav>
            @if(isset($car))
                <h1 id="result-title" class="result-title">
                    Preço {{ $car['brand'] }} {{ $car['model'] }} {{ $car['year'] }} – Valor Atualizado
                </h1>
                <p>Confira o valor de referência FIPE do {{ $car['brand'] }} {{ $car['model'] }} {{ $car['year'] }} para
                    {{ $car['reference_month'] }}.
                </p>

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
                    {{-- <button type="button" onclick="window.print()" class="result-action-icon"
                        aria-label="Imprimir resultado" title="Imprimir">
                        <i class="fas fa-print" aria-hidden="true"></i>
                    </button> --}}
                    <button type="button" id="shareUrlBtn" class="result-action-icon" aria-label="Compartilhar link"
                        title="Compartilhar link"
                        data-share-url="{{ $canonical }}"
                        data-share-title="{{ $title }}"
                        data-share-text="Confira o valor FIPE do {{ $car['brand'] }} {{ $car['model'] }} {{ $car['year'] }} - {{ $car['reference_month'] }}">
                        <span class="result-action-icon__svg" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 6m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M19 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M5 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M7 12h3l3.5 6h3.5" /><path d="M17 6h-3.5l-3.5 6" /></svg>
                        </span>
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
            (function () {
                var shareBtn = document.getElementById('shareUrlBtn');
                if (!shareBtn) return;

                var copySvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 6m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M19 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M5 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M7 12h3l3.5 6h3.5" /><path d="M17 6h-3.5l-3.5 6" /></svg>';
                var checkSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>';
                var span = shareBtn.querySelector('.result-action-icon__svg');

                function showSuccess() {
                    if (span) {
                        span.innerHTML = checkSvg;
                        setTimeout(function () { span.innerHTML = copySvg; }, 2000);
                    }
                }

                shareBtn.addEventListener('click', function () {
                    var url = shareBtn.getAttribute('data-share-url') || '{{ $canonical }}';
                    var title = shareBtn.getAttribute('data-share-title') || document.title;
                    var text = shareBtn.getAttribute('data-share-text') || '';

                    if (navigator.share) {
                        navigator.share({
                            title: title,
                            text: text,
                            url: url
                        }).then(function () {
                            showSuccess();
                        }).catch(function (err) {
                            if (err.name !== 'AbortError') {
                                fallbackCopy(url);
                            }
                        });
                    } else {
                        fallbackCopy(url);
                    }
                });

                function fallbackCopy(url) {
                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        navigator.clipboard.writeText(url).then(showSuccess);
                    } else {
                        var input = document.createElement('input');
                        input.value = url;
                        input.setAttribute('readonly', '');
                        input.style.position = 'absolute';
                        input.style.left = '-9999px';
                        document.body.appendChild(input);
                        input.select();
                        try {
                            document.execCommand('copy');
                            showSuccess();
                        } catch (e) {}
                        document.body.removeChild(input);
                    }
                }
            })();
        </script>
    @endif
</body>

</html>