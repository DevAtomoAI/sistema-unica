<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Incluir Frota</title>
    <link rel="stylesheet" href="incluirfrota.css">
</head>

<body>
    <form action="configs_incluir_frota.php" method="POST">
        <div class="conteudo-principal" id="conteudo-principal">
            <h1 class="text-incco">Incluir Frota</h1>
            <br>
            <div class="form-container">
                <!-- Formulário com os campos -->
                <div class="form-group">
                    <label for="placa">Placa</label>
                    <input name='placa' type="text" id="placa" placeholder="Informe a placa">

                    <label for="modelo">Modelo</label>
                    <input name="modelo" type="text" id="modelo" placeholder="Informe o modelo">

                </div>

                <div class="form-group">
                    <label for="km-atual">Renavam</label>
                    <input name="renavam" type="text" id="renavam" placeholder="Informe o renavam">

                    <label for="tipo-solicitacao">Ano de fabricação</label>
                    <input name="ano" type="text" id="ano" placeholder="Informe o ano de fabricação">
                </div>

                <div class="form-group">
                    <label for="plano-manutencao">Categoria</label>
                    <select name="plano-manutencao" id="plano-manutencao">
                        <option value="linha_leve">Linha leve</option>
                        <option value="linha_pesada">Linha pesada</option>
                        <option value="maquina_tratores">Máquinas e tratores</option>
                    </select>
                    <br>
                    <br>

                    <label for="orgao"> Orgão solicitante </label>
                    <input name="orgao" type="text" id="orgao" placeholder="Informe o orgão solicitante">
                </div>

                <div class="form-group">
                    <label for="combustivel">Combustivel</label>
                    <input name="combustivel" type="text" id="combustivel" placeholder="Informe o combustivel">

                    <br>
                    <label for="estado">Estado</label>
                    <input name="estado" type="text" id="estado" placeholder="Informe o estado">
                </div>

                <div class="form-group">
                    <label for="data-abertura">Chassi</label>
                    <input name="chassi" type="text" id="chassi" placeholder="Informe o chassi">

                    <label for="marca">Marca</label>
                    <input name="marca" type="text" id="marca" placeholder="Informe a marca">
                    <br>
                </div>

                <div class="form-group">
                    <label for="centro-custo">Centro de Custo</label>
                    <input name="centro-custo" type="text" id="centro-custo" placeholder="Informe o centro de custo">

                    <label for="ano-modelo">Ano modelo</label>
                    <input name="ano-modelo" type="text" id="ano-modelo" placeholder="Informe o ano do modelo">

                </div>


                <button name="confirmar-btn" id="confirmar-btn">Confirmar</button>
                <a class="voltar" href="../frota.php "> Voltar </a>

            </div>
        </div>
    </form>

</body>

</html>