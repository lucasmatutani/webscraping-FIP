@php
    $referenceMonthHuman = now()->locale('pt_BR')->translatedFormat('F \d\e Y');
    $title = 'Tabela FIPE Atualizada: Consulte o Preço de Carros por Marca, Modelo e Ano';
    $description = 'Consulte a Tabela FIPE atualizada e veja o preço médio de carros por marca, modelo e ano. Resultado rápido atualizado em ' . $referenceMonthHuman . '.';
    $canonical = "https://ilovecarros.com.br/";
@endphp
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- CSS crítico acima da dobra: header, layout base, tipografia, grid, skeleton --}}
    <style>
        body{margin:0;padding:0;font-family:'Arial',sans-serif;background:#fff}
        .container{display:flex;flex-direction:column;align-items:center;justify-content:center;font-family:'Montserrat',sans-serif}
        .container p{font-size:17px}
        .container button{font-family:'Montserrat',sans-serif}
        .header{display:flex;align-items:center;min-height:80px;background:#000;width:100%;box-sizing:border-box;padding:0 1rem}
        .header a{display:inline-block}
        .header img{display:block;width:20vw;max-height:140px;height:auto;object-fit:contain;aspect-ratio:320/140}
        .container{position:relative}
        #searchForm{display:flex;align-items:center;justify-content:center;width:100%}
        .search-section,.result-section{display:flex;flex-direction:column;justify-content:center;align-items:center;background:#910506;padding:18px 36px;color:#fff;border-radius:35px;width:40%;margin:20px 0;text-align:center}
        .search-section h1{text-align:center}
        .search-section h2{margin:10px 0;font-weight:700}
        .search-form{display:flex;flex-direction:column;text-align:left;width:55%}
        .search-form label{margin:20px 0 10px 5px;font-weight:700;font-size:18px}
        .choices__inner{width:100%;min-height:48px;border-radius:20px;padding:10px 20px;box-sizing:border-box}
        .search-form .choices,.search-form label+*{min-height:48px}
        .buttom-submit{padding:10px 25px;font-size:16px;font-weight:700;border-radius:15px;margin:20px auto 0;cursor:pointer;display:inline-block;text-align:center}
        .search-error{padding:10px 15px;border-radius:10px;margin-bottom:15px;font-weight:700}
        .footer{width:100%;box-sizing:border-box;padding:2rem 1rem}
        .seo-content{display:flex;flex-direction:column;align-items:center;width:50%;margin-bottom:2rem;box-sizing:border-box}
        @media (max-width:1024px){.search-section,.result-section{width:60%}.seo-content{width:60%}}
        .banner-sidebar{position:absolute;top:20px;right:0;width:120px;min-height:480px}
        @media (max-width:450px){.banner-sidebar{display:none}.search-section,.result-section{width:100%;margin:0;border-radius:0;padding:10px;min-height:480px}.search-form{width:100%;min-height:320px;gap:4px}.search-form .choices__inner,.search-form .choices{min-height:48px}.container p{font-size:0.9rem}h1{font-size:1.1rem}h2{font-size:1rem}.header img{width:60vw;margin:0 auto}.seo-content{width:100%;padding:2rem 1.5rem}}
        @media (max-width:320px){.search-section,.result-section{width:75%;min-height:460px}.search-form{min-height:300px}}
    </style>
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

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5083190284611847"
     crossorigin="anonymous"></script>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "Ilovecarros - Tabela FIPE Atualizada",
        "url": "{{ $canonical }}",
        "description": "{{ $description }}",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "{{ url('/resultado') }}?brand={brand}&model_id={model_id}&year={year}",
            "query-input": "required name=brand required name=model_id required name=year"
          }
    }
    </script>

    {{-- Preload do logo em WebP (LCP, menor tamanho no mobile) --}}
    <link rel="preload" as="image" href="{{ asset('images/logo_i_love_carros.webp') }}" type="image/webp" fetchpriority="high">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- CSS completo carregado de forma assíncrona (acima da dobra já está no crítico inline) --}}
    <link rel="preload" href="{{ asset('css/style.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('css/style.css') }}"></noscript>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=optional" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=optional"></noscript>
    <script async="async" data-cfasync="false" src="https://pl28747347.effectivegatecpm.com/769b5b2f74c150b281688d65356a64d6/invoke.js"></script>
    @vite(['resources/js/app.js'])
</head>

<body>
    <header class="header" role="banner">
        <a href="{{ url('/') }}" aria-label="Ir para página inicial - Consulta FIPE">
            <picture>
                <source srcset="{{ asset('images/logo_i_love_carros.webp') }}" type="image/webp">
                <img src="{{ asset('images/logo_i_love_carros.png') }}" alt="Carros do Brasil - Tabela FIPE" width="320" height="140" fetchpriority="high" loading="eager">
            </picture>
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
                    <select id="brandSelect" name="brand" style="width: 100%;" aria-label="Selecione a marca" required>
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

        <aside class="banner-sidebar" aria-label="Publicidade">
            <div id="container-769b5b2f74c150b281688d65356a64d6"></div>
        </aside>

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

    <x-footer />
</body>

</html>