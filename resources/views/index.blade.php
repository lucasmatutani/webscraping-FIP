@php
    $title = 'Tabela FIPE OFICIAL: Consulte o Preço de Carros por Marca, Modelo e Ano';
    $description = 'Consulte a Tabela FIPE oficial e veja o preço médio de carros por marca, modelo e ano. Resultado rápido com mês de referência e dados oficiais.';
    $canonical = url('/');
    $referenceMonthHuman = now()->locale('pt_BR')->translatedFormat('F \d\e Y');
@endphp
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ $canonical }}">
    <link rel="icon" href="{{ asset('images/icon_i_love_carros.png') }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
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

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "Carros do Brasil - Tabela FIPE OFICIAL",
        "url": "{{ $canonical }}",
        "description": "{{ $description }}",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "{{ url('/resultado') }}?brand={brand}&model_id={model_id}&year={year}",
            "query-input": "required name=brand required name=model_id required name=year"
          }
    }
    </script>

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    @vite(['resources/js/app.js'])
</head>

<body>
    <header class="header" role="banner">
        <a href="{{ url('/') }}" aria-label="Ir para página inicial - Consulta FIPE">
            <img src="{{ asset('images/logo_i_love_carros.png') }}" alt="Carros do Brasil - Tabela FIPE">
        </a>
    </header>

    <main class="container" role="main">
        <form action="{{ route('resultado') }}" method="GET" id="searchForm">
            <section class="search-section" id="commonSearchSection" aria-labelledby="search-title">
                <h1 id="search-title">Consulta Tabela FIPE</h1>

                @if(session('error'))
                    <p class="search-error" role="alert">{{ session('error') }}</p>
                @endif

                <p>
                    Sua pesquisa será realizada de acordo com o seguinte mês e ano
                    de referência:
                </p>
                <h2 id="currentDateCommon">{{ $referenceMonthHuman }}</h2>
                <p>
                    Primeiro, selecione a marca do seu carro. Depois, é só adicionar
                    o modelo e o ano.
                </p>
                <div class="search-form">
                    <label for="brandSelect">Marca:</label>
                    <select id="brandSelect" name="brand" style="width: 100%;" aria-label="Selecione a marca">
                        <option value="">Selecione ou digite a marca</option>
                    </select>

                    <label for="modelSelect">Modelo:</label>
                    <select id="modelSelect" name="model_id" aria-label="Selecione o modelo" required>
                        <option value="">Selecione ou digite o modelo</option>
                    </select>

                    <label for="yearSelect">Ano:</label>
                    <select id="yearSelect" name="year" aria-label="Selecione o ano" required>
                        <option value="">Selecione ou digite o ano</option>
                    </select>

                    <button class="buttom-submit" type="submit">PESQUISAR</button>
                </div>
            </section>
        </form>

        <section class="seo-content" aria-labelledby="seo-content-title">
            <h2 id="seo-content-title" class="seo-content__title">O que é a Tabela FIPE?</h2>
            <p class="seo-content__text">
                A Tabela FIPE é uma referência nacional de preços médios de veículos no Brasil. Aqui você consulta o
                preço FIPE por
                marca, modelo e ano usando o mês de referência mais recente.
            </p>

            <h2 class="seo-content__heading">Para que serve o valor FIPE?</h2>
            <p class="seo-content__text">
                O valor FIPE é usado como base em negociações de compra e venda, avaliação de usados, seguros e
                financiamentos.
                Ele não é o “preço final” da loja, mas uma média de mercado.
            </p>

            <h2 class="seo-content__heading">Como consultar o preço FIPE no site</h2>
            <ol class="seo-content__list">
                <li>Selecione a marca do veículo.</li>
                <li>Escolha o modelo.</li>
                <li>Selecione o ano (e versão/combustível, quando aplicável).</li>
                <li>Clique em <strong>PESQUISAR</strong> para ver o resultado.</li>
            </ol>

            <h2 class="seo-content__heading">Perguntas frequentes</h2>
            <div class="seo-content__faq">
                <details class="seo-content__details">
                    <summary class="seo-content__summary">A Tabela FIPE muda todo mês?</summary>
                    <p class="seo-content__details-text">Sim. Os valores são atualizados mensalmente. Por isso sempre
                        mostramos o mês de referência da consulta.</p>
                </details>
                <details class="seo-content__details">
                    <summary class="seo-content__summary">O valor FIPE é igual ao preço de venda?</summary>
                    <p class="seo-content__details-text">Não necessariamente. O preço de venda pode variar por estado,
                        conservação, quilometragem e demanda.</p>
                </details>
            </div>
        </section>
    </main>
</body>

</html>