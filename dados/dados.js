let contador = 0;

function novosCentros(event) {
    contador++;
    event.preventDefault();

    const tabela = document.getElementById("tabela-centro");
    const novaLinha = tabela.insertRow();

    novaLinha.innerHTML = `
        <td><input type="text" name="nomeCentro[]"></td>
        <td><input type="text" name="valorContrato[]"></td>
        <td><input type="text" name="fonteRecurso[]"></td>
        <td><input type="date" name="dataCredito[]"></td>
        <td><input type="text" name="ordemBancaria[]"></td>
        <td><input type="text" name="valorCredito[]"></td>
    `;
}


