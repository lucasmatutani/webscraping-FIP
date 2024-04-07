
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
</head>

<body>
    <div class="header">
        <img src="{{ asset('images/logo_i_love_carros.png') }}" alt="Descrição">
    </div>

    <div class="container">
        <section class="search-section" id="commonSearchSection">
            <h1>CONSULTE O PREÇO DOS CARROS DA <br> TABELA FIPE EM TEMPO REAL</h1>
            <div class="search-buttons" id="searchButtons">
                <button class="btnCommonSearch active" id="btnCommonSearch">PESQUISA COMUM</button>
                <button class="btnCodeSearch">PESQUISA POR CÓDIGO FIPE</button>
            </div>
            <p>
                Sua pesquisa será realizada de acordo com o seguinte mês e ano
                de referência:
            </p>
            <h2 id="currentDateCommon">Carregando data...</h2>
            <p>
                Primeiro, selecione a marca do seu carro. Depois, é só adicionar
                o modelo e o ano, na ordem que preferir. E se quiser agilizar,
                digite essas infos direto no campo de busca do formulário.
                Simples assim.
            </p>
            <div class="search-form">
                <label for="brand">Marca:</label>
                <select name="brand" id="brand">
                    <option value="">Selecione ou digite a marca</option>
                </select>

                <label for="model">Modelo:</label>
                <select name="model" id="model">
                    <option value="">Selecione ou digite o modelo</option>
                </select>

                <label for="year">Ano:</label>
                <select name="year" id="year">
                    <option value="">Selecione ou digite o ano</option>
                </select>

                <button class="buttom-submit" type="submit">PESQUISAR</button>
            </div>
        </section>

        <section class="search-section code" style="display: none;" id="codeSearchSection">
            <h1>CONSULTE O PREÇO DOS CARROS DA <br> TABELA FIPE EM TEMPO REAL</h1>
            <div class="search-buttons" id="searchButtons">
                <button class="btnCommonSearch active">PESQUISA COMUM</button>
                <button class="btnCodeSearch">PESQUISA POR CÓDIGO FIPE</button>
            </div>
            <p>
                Sua pesquisa será realizada de acordo com o seguinte mês e ano
                de referência:
            </p>
            <h2 id="currentDateCode">Carregando data...</h2>
            <p>
                Agora, basta informar o Código Fipe e ano modelo do veículo que
                você quer pesquisar.
            </p>
            <div class="search-form">
                <label for="fipeCode">Código FIPE:</label>
                <select name="fipeCode" id="fipeCode">
                    <option value="">Digite o código FIPE</option>
                </select>

                <label for="year">Ano:</label>
                <select name="year" id="year">
                    <option value="">Selecione o ano do modelo</option>
                </select>

                <button class="buttom-submit" type="submit">PESQUISAR</button>
            </div>
        </section>

        <section class="result-section" id="codeSearchSection" >
            <div class="container-result">
                <div class="container-btn">
                    <button><i class="fas fa-print"></i> IMPRIMIR</button>
                    <button>  <i class="fas fa-clipboard"></i> COPIAR URL</button>
                </div>
                <div class="container-table">
                    <div class="container-padding">
                        <div class="container-values">
                            <span class="label">Mês de Referência:</span>
                            <span class="value">Janeiro de 2024</span>
                        </div>
                        <span class="underline"></span>

                        <div class="container-values">
                            <span class="label">Código FIPE:</span>
                            <span class="value">038003-2</span>
                        </div>
                        <span class="underline"></span>

                        <div class="container-values">
                            <span class="label">Marca:</span>
                            <span class="value">Acura</span>
                        </div>
                        <span class="underline"></span>

                        <div class="container-values">
                            <span class="label">Modelo:</span>
                            <span class="value">Integra GS 1.8</span>
                        </div>
                        <span class="underline"></span>

                        <div class="container-values">
                            <span class="label">Ano Modelo:</span>
                            <span class="value">1992</span>
                        </div>
                        <span class="underline"></span>

                        <div class="container-values">
                            <span class="label">Autenticação:</span>
                            <span class="value">gpdl1jv8cd</span>
                        </div>
                        <span class="underline"></span>

                        <div class="container-values">
                            <span class="label">Data da consulta:</span>
                            <span class="value">domingo, 14 de janeiro de 2024 13:00</span>
                        </div>
                        <span class="underline"></span>

                        <div class="container-values price">
                            <span class="label">Preço Médio:</span>
                            <span class="value">R$ 11.520,00</span>
                        </div>
                        <span class="underline"></span>
                    </div>
                </div>
            </div>
            <button class="buttom-submit" type="submit">REFAZER PESQUISA</button>
        </section>
    </div>
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>

</html>
