function updateProd() {
    const prodId = document.getElementById("getProdId").value;
    const nomePro = document.getElementById("inputNome").value;
    const precoPro = document.getElementById("inputPreco").value;
    const quantidadePro = document.getElementById("inputQuantidade").value;
    const descricaoPro = document.getElementById("inputDescricao").value;
    const categoriaPro = document.getElementById("inputCategoria").value;

    const usuarioAtualizado = {
        id: prodId,
        nome: nomePro,
        preco: precoPro,
        quantidade: quantidadePro,
        descricao: descricaoPro,
        categoria: categoriaPro
    };

    if (!prodId) {
        Swal.fire('Por favor, insira um id!')
        return;
    }

    fetch('http://localhost:8080/backend/router/produto', { 
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(usuarioAtualizado)
    })
    .then(response => {
        if (!response.ok) {
            if (response.status === 401) {
                throw new Error('Não autorizado');
            } else {
                throw new Error('Sem rede ou não conseguiu localizar o recurso');
            }
        }
        return response.json();
    })
    .then(data => {

        if(data.success) Swal.fire('Atualizado com sucesso!')

        
    })
    .catch(error => alert('Erro na requisição: ' + error));
}
