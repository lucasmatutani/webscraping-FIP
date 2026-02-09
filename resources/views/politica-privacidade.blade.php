@php
    $title = 'Política de Privacidade - Carros do Brasil - Tabela FIPE';
    $description = 'Política de Privacidade do Carros do Brasil. Conheça como tratamos cookies, dados do Google AdSense e Google DoubleClick em nosso site de consulta à Tabela FIPE.';
    $canonical = url('/politica-de-privacidade');
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

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{{ $description }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="{{ asset('css/style.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('css/style.css') }}"></noscript>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap"></noscript>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5083190284611847"
     crossorigin="anonymous"></script>
    @vite(['resources/js/app.js'])
</head>

<body>
    <header class="header" role="banner">
        <a href="{{ url('/') }}" aria-label="Ir para página inicial - Consulta FIPE">
            <img src="{{ asset('images/logo_i_love_carros.png') }}" alt="Carros do Brasil - Tabela FIPE">
        </a>
    </header>

    <main class="container" role="main">
        <section class="seo-content politica-privacidade" aria-labelledby="politica-title">
            <h1 id="politica-title" class="seo-content__title">Política de Privacidade</h1>
            <p class="seo-content__text">
                Esta Política de Privacidade descreve como o <strong>Carros do Brasil - Tabela FIPE</strong> coleta,
                usa e protege as informações dos visitantes. Ao utilizar nosso site, você concorda com as práticas
                descritas neste documento.
            </p>
            <p class="seo-content__text">
                Última atualização: {{ now()->locale('pt_BR')->translatedFormat('d \d\e F \d\e Y') }}.
            </p>

            <h2 class="seo-content__heading">1. Cookies</h2>
            <p class="seo-content__text">
                Utilizamos <strong>cookies</strong> para melhorar sua experiência de navegação. Cookies são pequenos
                arquivos de texto armazenados no seu dispositivo quando você visita nosso site.
            </p>
            <p class="seo-content__text">
                <strong>Tipos de cookies utilizados:</strong>
            </p>
            <ul class="seo-content__list" style="list-style: disc; padding-left: 2rem;">
                <li><strong>Cookies essenciais:</strong> necessários para o funcionamento básico do site.</li>
                <li><strong>Cookies de preferências:</strong> armazenam suas escolhas (por exemplo, idioma).</li>
                <li><strong>Cookies de desempenho:</strong> ajudam a analisar como o site é utilizado.</li>
                <li><strong>Cookies de publicidade:</strong> usados para exibir anúncios relevantes (veja AdSense e DoubleClick abaixo).</li>
            </ul>
            <p class="seo-content__text">
                Você pode configurar seu navegador para recusar ou excluir cookies. Porém, isso pode afetar o
                funcionamento de algumas funcionalidades do site.
            </p>

            <h2 class="seo-content__heading">2. Google AdSense</h2>
            <p class="seo-content__text">
                O site utiliza o <strong>Google AdSense</strong>, serviço de publicidade fornecido pelo Google
                Inc. O AdSense exibe anúncios personalizados com base no seu histórico de navegação e nos dados
                coletados durante a visita.
            </p>
            <p class="seo-content__text">
                <strong>O que o Google AdSense coleta:</strong>
            </p>
            <ul class="seo-content__list" style="list-style: disc; padding-left: 2rem;">
                <li>Endereço IP</li>
                <li>Informações do navegador e do dispositivo</li>
                <li>Páginas visitadas e interações com anúncios</li>
            </ul>
            <p class="seo-content__text">
                Esses dados são tratados de acordo com a <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer" class="politica-link">Política de Privacidade do Google</a>.
                O Google pode compartilhar informações com parceiros para personalizar anúncios em toda a rede.
            </p>
            <p class="seo-content__text">
                Para gerenciar suas preferências de anúncios e desativar a personalização, acesse as
                <a href="https://adssettings.google.com/" target="_blank" rel="noopener noreferrer" class="politica-link">Configurações de anúncios do Google</a>.
            </p>

            <h2 class="seo-content__heading">3. Google DoubleClick</h2>
            <p class="seo-content__text">
                O <strong>Google DoubleClick</strong> (DART) é uma tecnologia de publicidade que permite ao
                Google e seus parceiros exibirem anúncios com base nas visitas anteriores aos nossos sites e a
                outros sites da internet.
            </p>
            <p class="seo-content__text">
                <strong>Funcionamento:</strong>
            </p>
            <ul class="seo-content__list" style="list-style: disc; padding-left: 2rem;">
                <li>Utiliza cookies para rastrear impressões e cliques em anúncios</li>
                <li>Pode associar dados de navegação entre diferentes sites para segmentação</li>
                <li>Permite medição de eficácia das campanhas publicitárias</li>
            </ul>
            <p class="seo-content__text">
                O DoubleClick está integrado aos serviços do Google Ads e segue as mesmas políticas de privacidade.
                Você pode optar por não receber anúncios personalizados através do cookie DART em
                <a href="https://www.google.com/settings/ads" target="_blank" rel="noopener noreferrer" class="politica-link">www.google.com/settings/ads</a>.
            </p>

            <h2 class="seo-content__heading">4. Seus Direitos</h2>
            <p class="seo-content__text">
                De acordo com a LGPD (Lei Geral de Proteção de Dados), você tem direito a:
            </p>
            <ul class="seo-content__list" style="list-style: disc; padding-left: 2rem;">
                <li>Acesso aos dados que mantemos sobre você</li>
                <li>Correção de dados incompletos ou desatualizados</li>
                <li>Exclusão de dados pessoais, quando aplicável</li>
                <li>Revogação do consentimento para coleta e uso de dados</li>
            </ul>

            <h2 class="seo-content__heading">5. Contato</h2>
            <p class="seo-content__text">
                Para dúvidas sobre esta Política de Privacidade ou para exercer seus direitos, entre em contato
                conosco através dos canais disponíveis em nosso site.
            </p>

            <div class="politica-privacidade__back">
                <a href="{{ url('/') }}" class="buttom-submit" style="text-decoration: none; margin-top: 1.5rem; display: inline-block;">Voltar para Consulta FIPE</a>
            </div>
        </section>
    </main>

    <x-footer />
</body>

</html>
