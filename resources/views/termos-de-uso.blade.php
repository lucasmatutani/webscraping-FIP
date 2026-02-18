@php
    $title = 'Termos de Uso - Carros do Brasil - Tabela FIPE';
    $description = 'Termos de Uso do Carros do Brasil. Conheça as condições de utilização do nosso site de consulta à Tabela FIPE.';
    $canonical = 'https://ilovecarros.com.br/termos-de-uso';
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
    @vite(['resources/js/app.js'])
</head>

<body>
    <header class="header" role="banner">
        <a href="{{ url('/') }}" aria-label="Ir para página inicial - Consulta FIPE">
            <picture>
                <source srcset="{{ asset('images/logo_i_love_carros.webp') }}" type="image/webp">
                <img src="{{ asset('images/logo_i_love_carros.png') }}" alt="Carros do Brasil - Tabela FIPE">
            </picture>
        </a>
    </header>

    <main class="container" role="main">
        <section class="seo-content politica-privacidade" aria-labelledby="termos-title">
            <h1 id="termos-title" class="seo-content__title">Termos de Uso</h1>
            <p class="seo-content__text">
                Bem-vindo ao <strong>Carros do Brasil - Tabela FIPE</strong>. Ao acessar e utilizar este site,
                você concorda com os termos e condições descritos abaixo. Leia-os atentamente antes de prosseguir.
            </p>
            <p class="seo-content__text">
                Última atualização: {{ now()->locale('pt_BR')->translatedFormat('d \d\e F \d\e Y') }}.
            </p>

            <h2 class="seo-content__heading">1. Aceitação dos Termos</h2>
            <p class="seo-content__text">
                O uso deste site constitui aceitação integral dos presentes Termos de Uso. Caso não concorde com
                alguma disposição, solicitamos que não utilize nossos serviços. Podemos alterar estes termos a
                qualquer momento; a continuação do uso após alterações constitui aceitação das novas condições.
            </p>

            <h2 class="seo-content__heading">2. Uso do Serviço</h2>
            <p class="seo-content__text">
                O Carros do Brasil disponibiliza consultas à Tabela FIPE (Fundação Instituto de Pesquisas
                Econômicas) para fins informativos. Você concorda em utilizar o site apenas para fins lícitos e
                de boa-fé, sem:
            </p>
            <ul class="seo-content__list" style="list-style: disc; padding-left: 2rem;">
                <li>Violar leis ou regulamentos aplicáveis</li>
                <li>Prejudicar, sobrecarregar ou interferir no funcionamento do site</li>
                <li>Utilizar mecanismos automatizados para extração de dados sem autorização</li>
                <li>Reproduzir, distribuir ou comercializar o conteúdo sem permissão</li>
            </ul>

            <h2 class="seo-content__heading">3. Natureza Informativa dos Valores</h2>
            <p class="seo-content__text">
                Os valores exibidos neste site têm <strong>caráter exclusivamente informativo</strong> e não
                substituem consulta oficial à FIPE. Os preços médios de referência podem variar conforme o mês
                de atualização, região, estado de conservação do veículo e condições de mercado.
            </p>
            <p class="seo-content__text">
                Não nos responsabilizamos por decisões tomadas com base nas informações aqui apresentadas.
                Recomendamos sempre conferir os valores na fonte oficial quando necessário para fins comerciais,
                legais ou contratuais.
            </p>

            <h2 class="seo-content__heading">4. Propriedade Intelectual</h2>
            <p class="seo-content__text">
                O conteúdo do site (layout, logotipos, textos, design e demais elementos) é de propriedade do
                Carros do Brasil ou de seus licenciadores. A Tabela FIPE é de responsabilidade da Fundação
                Instituto de Pesquisas Econômicas (FIPE). A reprodução não autorizada de qualquer parte do site
                pode constituir violação de direitos autorais.
            </p>

            <h2 class="seo-content__heading">5. Isenção de Responsabilidade</h2>
            <p class="seo-content__text">
                O site é fornecido "como está", sem garantias de disponibilidade contínua ou ausência de erros.
                Não nos responsabilizamos por:
            </p>
            <ul class="seo-content__list" style="list-style: disc; padding-left: 2rem;">
                <li>Decisões comerciais ou jurídicas tomadas com base nos valores consultados</li>
                <li>Interrupções temporárias ou falhas técnicas</li>
                <li>Conteúdo de sites de terceiros vinculados ou anúncios exibidos</li>
                <li>Danos indiretos decorrentes do uso ou da incapacidade de usar o serviço</li>
            </ul>

            <h2 class="seo-content__heading">6. Links e Anúncios</h2>
            <p class="seo-content__text">
                Nosso site pode exibir anúncios de terceiros (por exemplo, Google AdSense) e links para outros
                sites. Não controlamos o conteúdo desses recursos e não nos responsabilizamos pelas práticas ou
                políticas de terceiros. O uso de serviços de terceiros está sujeito aos respectivos termos e
                políticas.
            </p>

            <h2 class="seo-content__heading">7. Modificações</h2>
            <p class="seo-content__text">
                Reservamo-nos o direito de alterar estes Termos de Uso a qualquer momento. As alterações entram
                em vigor na data da publicação nesta página. Recomendamos a revisão periódica destes termos.
            </p>

            <h2 class="seo-content__heading">8. Lei Aplicável</h2>
            <p class="seo-content__text">
                Estes Termos de Uso regem-se pelas leis da República Federativa do Brasil. Eventuais disputas
                serão submetidas ao foro da comarca do domicílio do usuário.
            </p>

            <h2 class="seo-content__heading">9. Contato</h2>
            <p class="seo-content__text">
                Para dúvidas sobre estes Termos de Uso, acesse nossa
                <a href="{{ route('politica-privacidade') }}" class="politica-link">Política de Privacidade</a>
                ou entre em contato através dos canais disponíveis em nosso site.
            </p>

            <div class="politica-privacidade__back">
                <a href="{{ url('/') }}" class="buttom-submit" style="text-decoration: none; margin-top: 1.5rem; display: inline-block;">Voltar para Consulta FIPE</a>
            </div>
        </section>
    </main>

    <x-footer />
</body>

</html>
