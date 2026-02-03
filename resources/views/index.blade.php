
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valores Tabela FIPE - Carros do Brasil</title>
    <meta name="description"
        content="Consulte os valores atualizados da tabela FIPE para carros de todo o Brasil. Encontre preços, modelos e mais informações de forma rápida e precisa.">
    {{-- <title>I ❤️ Carros</title> --}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    @vite(['resources/js/app.js'])
</head>

<body>
    <div class="header">
        <img src="{{ asset('images/logo_i_love_carros.png') }}" alt="Descrição">
    </div>

    <div class="container">
        <form action="{{ route('resultado') }}" method="GET" id="searchForm">
            <section class="search-section" id="commonSearchSection">
                <h1>Consulta Tabela FIPE Atualizada</h1>
                <h2>Preço de Carros Hoje</h2>

                @if(session('error'))
                    <p class="search-error" role="alert">{{ session('error') }}</p>
                @endif

                <p>
                    Sua pesquisa será realizada de acordo com o seguinte mês e ano
                    de referência:
                </p>
                <h2 id="currentDateCommon">Carregando data...</h2>
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
    </div>
</body>
</html>
