@php
    $ano = isset($car) ? ($car['year_display'] ?? $car['year']) : null;
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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="{{ asset('css/style.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </noscript>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap"
        as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap">
    </noscript>

    @if(isset($car))
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5083190284611847"
            crossorigin="anonymous"></script>
    @endif
    @vite(['resources/js/app.js'])

    @if(isset($car))
        <script type="application/ld+json">
                        {
                            "@context": "https://schema.org",
                            "@type": "WebPage",
                            "name": "{{ $car['brand'] }} {{ $car['model'] }} {{ $ano }}",
                            "url": "{{ $canonical }}",
                            "image": "{{ asset('images/social_media.png') }}",
                            "description": "Valor FIPE Atualizado de referência - {{ $car['reference_month'] }}"
                        }
                        </script>
    @endif
</head>

<body>
    <header class="header" role="banner">
        <a href="{{ url('/') }}" aria-label="Voltar para consulta FIPE">
            <picture>
                <source srcset="{{ asset('images/logo_i_love_carros.webp') }}" type="image/webp">
                <img src="{{ asset('images/logo_i_love_carros.png') }}" alt="Carros do Brasil - Tabela FIPE"
                    fetchpriority="high" loading="eager">
            </picture>
        </a>
    </header>

    <main class="container" role="main">
        <section class="result-section" aria-labelledby="result-title">
            <div class="result-section-container">
                <nav class="result-section__breadcrumb" aria-label="Breadcrumb">
                    <ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
                        <li class="breadcrumb__item" itemprop="itemListElement" itemscope
                            itemtype="https://schema.org/ListItem">
                            <a itemprop="item" href="{{ url('/') }}"><span itemprop="name">Início</span></a>
                            <meta itemprop="position" content="1" />
                        </li>
                        @if(isset($car))
                            <li class="breadcrumb__item breadcrumb__item--current" itemprop="itemListElement" itemscope
                                itemtype="https://schema.org/ListItem">
                                <link itemprop="item" href="{{ $canonical }}">
                                <span itemprop="name">{{ $car['brand'] }} {{ $car['model'] }} {{ $ano }}</span>
                                <meta itemprop="position" content="2" />
                            </li>
                        @else
                            <li class="breadcrumb__item breadcrumb__item--current" itemprop="itemListElement" itemscope
                                itemtype="https://schema.org/ListItem">
                                <span itemprop="name">Nenhum valor encontrado</span>
                                <meta itemprop="position" content="2" />
                            </li>
                        @endif
                    </ol>
                </nav>
                @if(isset($car))
                    <h1 id="result-title" class="result-title">
                        Preço {{ $car['brand'] }} {{ $car['model'] }} {{ $ano }} – Valor Atualizado
                    </h1>
                    <p>Confira o valor de referência FIPE do {{ $car['brand'] }} {{ $car['model'] }} {{ $ano }} para
                        {{ $car['reference_month'] }}.
                    </p>

                    <p class="result-price" aria-label="Valor FIPE">{{ $car['value'] }}</p>

                    <h2>Sobre o preço FIPE do {{ $car['brand'] }} {{ $car['model'] }} {{ $ano }}</h2>
                    <p>
                        O preço médio FIPE do {{ $car['brand'] }} {{ $car['model'] }} {{ $ano }}
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
                                    <span class="value">{{ $ano }}</span>
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
                            title="Compartilhar link" data-share-url="{{ $canonical }}" data-share-title="{{ $title }}"
                            data-share-text="Confira o valor FIPE do {{ $car['brand'] }} {{ $car['model'] }} {{ $ano }} - {{ $car['reference_month'] }}">
                            <span class="result-action-icon__svg" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 6m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                    <path d="M19 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                    <path d="M5 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                    <path d="M7 12h3l3.5 6h3.5" />
                                    <path d="M17 6h-3.5l-3.5 6" />
                                </svg>
                            </span>
                        </button>
                    </div>
                @endif
            </div>
        </section>
        <section class="seo-content" aria-labelledby="interpretacao-title">
            <h2 id="interpretacao-title" class="seo-content__heading">O que significa o valor FIPE?</h2>

            <p class="seo-content__text">
                O valor FIPE é uma <strong>referência de preço médio</strong> usada no Brasil para orientar negociações
                e avaliações
                de veículos. Ele ajuda a ter uma base para compra e venda, mas <strong>não representa obrigatoriamente o
                    preço final</strong>
                que você vai pagar ou receber em uma negociação.
            </p>

            <p class="seo-content__text">
                <strong>Transparência:</strong> este site é um projeto independente e não possui vínculo com a FIPE
                (Fundação Instituto de Pesquisas Econômicas). Os valores exibidos são usados como referência e podem
                variar conforme o mercado.
            </p>
        </section>
        <section class="seo-content" aria-labelledby="variacao-title">
            <h2 id="variacao-title" class="seo-content__heading">Por que o preço pode variar em relação à FIPE?</h2>
          
            <p class="seo-content__text">
              Mesmo com a FIPE como referência, o preço de mercado pode ficar acima ou abaixo dependendo de vários fatores.
              Use o valor FIPE como ponto de partida e ajuste sua expectativa conforme a realidade do veículo.
            </p>
          
            <ul class="seo-content__list">
              <li><strong>Estado de conservação:</strong> funilaria, pintura, interior e histórico de manutenção.</li>
              <li><strong>Quilometragem:</strong> veículos com baixa km tendem a valer mais.</li>
              <li><strong>Região e demanda:</strong> preços variam por cidade/estado e sazonalidade.</li>
              <li><strong>Versão e itens:</strong> opcionais, pacote de tecnologia, multimídia, rodas, etc.</li>
              <li><strong>Histórico:</strong> sinistro, leilão, restrições e documentação impactam bastante.</li>
            </ul>
          </section>
          <section class="seo-content" aria-labelledby="usar-title">
            <h2 id="usar-title" class="seo-content__heading">Como usar o valor FIPE na prática</h2>
          
            <p class="seo-content__text">
              O valor FIPE é muito útil para tomar decisões com mais segurança. Abaixo estão usos comuns no dia a dia:
            </p>
          
            <ul class="seo-content__list">
              <li><strong>Compra:</strong> compare o preço anunciado com a FIPE e negocie com base em conservação e histórico.</li>
              <li><strong>Venda:</strong> use a FIPE como referência e justifique diferença (opcionais, estado, revisões).</li>
              <li><strong>Seguro:</strong> muitas seguradoras usam FIPE como referência de indenização (pode variar por apólice).</li>
              <li><strong>Financiamento:</strong> pode ajudar a avaliar se o valor financiado está coerente com o mercado.</li>
            </ul>
          
            <p class="seo-content__text">
              Dica rápida: se o valor anunciado estiver <strong>muito abaixo</strong> da FIPE, vale redobrar a atenção para histórico e documentação.
            </p>
          </section>
          <section class="seo-content" aria-labelledby="checklist-title">
            <h2 id="checklist-title" class="seo-content__heading">Checklist rápido antes de fechar negócio</h2>
          
            <ul class="seo-content__list">
              <li>Confirme se <strong>chassi/placa</strong> e dados do documento batem com o veículo.</li>
              <li>Verifique <strong>histórico de sinistro</strong>, leilão, multas e restrições.</li>
              <li>Analise <strong>revisões</strong> e notas fiscais de manutenção (quando houver).</li>
              <li>Faça um <strong>test-drive</strong> e, se possível, uma avaliação com mecânico de confiança.</li>
              <li>Compare anúncios semelhantes na sua região para entender o <strong>preço real de mercado</strong>.</li>
            </ul>
          </section>
          <section class="seo-content" aria-labelledby="faq-title">
            <h2 id="faq-title" class="seo-content__heading">Perguntas frequentes</h2>
          
            <div class="seo-content__faq">
              <details class="seo-content__details">
                <summary class="seo-content__summary">A Tabela FIPE muda todo mês?</summary>
                <p class="seo-content__details-text">
                  Sim. Os valores são atualizados mensalmente. Por isso mostramos o mês de referência junto do resultado.
                </p>
              </details>
          
              <details class="seo-content__details">
                <summary class="seo-content__summary">O valor FIPE é o mesmo que preço de venda?</summary>
                <p class="seo-content__details-text">
                  Não necessariamente. A FIPE é uma referência de preço médio. O valor final depende de conservação, quilometragem,
                  versão, região e demanda.
                </p>
              </details>
          
              <details class="seo-content__details">
                <summary class="seo-content__summary">Por que existem valores diferentes para combustíveis/versões?</summary>
                <p class="seo-content__details-text">
                  Alguns modelos têm mais de uma versão (motor/combustível/acabamento). Cada versão pode ter um valor de referência
                  diferente na FIPE.
                </p>
              </details>
            </div>
          </section>
    </main>

    <x-footer />

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
                        } catch (e) { }
                        document.body.removeChild(input);
                    }
                }
            })();
        </script>
    @endif
</body>

</html>