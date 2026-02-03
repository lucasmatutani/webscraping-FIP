
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
        <section class="search-section" id="commonSearchSection">
            
            <h1>Consulta Tabela FIPE Atualizada</h1>
            <h2>Preço de Carros Hoje</h2>
            
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
                <select id="brandSelect" name="brand" style="width: 100%;">
                    <option value="">Selecione ou digite a marca</option>
                </select>
                
                <label for="model">Modelo:</label>
                <select name="model" id="modelSelect">
                    <option value="">Selecione ou digite o modelo</option>
                </select>

                <label for="year">Ano:</label>
                <select id="yearSelect" name="year">
                    <option value="">Selecione ou digite o ano</option>
                </select>

                <button class="buttom-submit" type="submit">PESQUISAR</button>
            </div>
        </section>
        
        <section class="result-section" id="result-section" style="display: none">
            <div class="container-result">
                <div class="container-btn">
                    <button><i class="fas fa-print"></i> IMPRIMIR</button>
                    <button>  <i class="fas fa-clipboard"></i> COPIAR URL</button>
                </div>
                <div class="container-table">
                    <div class="container-padding">
                    
                        <div class="container-values price">
                            <span class="label">Valor FIPE:</span>
                            <span class="value" id="car_value"></span>
                        </div>
                        <span class="underline"></span>

                        <div class="container-values">
                            <span class="label">Mês Referência:</span>
                            <span class="value" id="reference_month"></span>
                        </div>
                        <span class="underline"></span>

                        <div class="container-values">
                            <span class="label">Código FIPE:</span>
                            <span class="value" id="fipe_code"></span>
                        </div>
                        <span class="underline"></span>

                        <div class="container-values">
                            <span class="label">Marca:</span>
                            <span class="value" id="brand-result"></span>
                        </div>
                        <span class="underline"></span>

                        <div class="container-values">
                            <span class="label">Modelo:</span>
                            <span class="value" id="model-result"></span>
                        </div>
                        <span class="underline"></span>

                        <div class="container-values">
                            <span class="label">Ano:</span>
                            <span class="value" id="year-result"></span>
                        </div>
                        <span class="underline"></span>  

                        <div class="container-values">
                            <span class="label">Data da consulta:</span>
                            <span class="value" id="today"></span>
                        </div>
                        <span class="underline"></span>
                    </div>
                </div>
            </div>
            <button class="buttom-submit" type="submit">REFAZER PESQUISA</button>
        </section>
    </div>
</body>
</html>
