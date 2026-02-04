@php
    $title = 'Tabela FIPE Atualizada: Consulte o Preço de Carros por Marca, Modelo e Ano';
    $description = 'Consulte a Tabela FIPE atualizada e veja o preço médio de carros por marca, modelo e ano. Resultado rápido com mês de referência e dados oficiais.';
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
        "name": "Carros do Brasil - Tabela FIPE",
        "url": "{{ $canonical }}",
        "description": "{{ $description }}"
        "potentialAction": {
            "@type": "SearchAction",
            "target": "https://ilovecarros.com/resultado?brand={brand}&model_id={model_id}&year={year}",
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
                <h1 id="search-title">Consulta Tabela FIPE Atualizada</h1>
                <h2>Preço de Carros Hoje</h2>

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
    </main>
</body>

</html>