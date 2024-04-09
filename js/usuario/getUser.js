function getProd() {
    const userId = document.getElementById("getProdId").value;

    fetch('http://localhost:8080/backend/router/produto?id=' + userId, {
        method: 'GET',
        mode: 'cors',
        headers: {
            "Content-Type": "json/application"
        }
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

        if(data == false){
            Swal.fire('Produto não encontrado!')
            document.getElementById("inputNome").value = ''; 
        }else{
            document.getElementById("inputNome").value = data.nome; 
            document.getElementById("inputPreco").value = data.preco; 
            document.getElementById("inputQuantidade").value = data.quantidade; 
            document.getElementById("inputDescricao").textContent = data.descricao
            document.getElementById("inputDescricao").textContent = data.descricao
            
            // Suponha que 'data.categoria' contenha o valor da categoria recuperada do banco de dados
            var categoriaSelecionada = data.categoria;

            // Obter o elemento select
            var selectCategoria = document.getElementById("inputCategoria");

            // Iterar sobre as opções e definir o atributo 'selected' na opção correspondente
            for (var i = 0; i < selectCategoria.options.length; i++) {
                if (selectCategoria.options[i].value === categoriaSelecionada) {
                    selectCategoria.options[i].selected = true;
                    break;  // Para quando a opção correspondente for encontrada
                }
            }

        } 
       
    })
    .catch(error => {
        Swal.fire('Coloque algum um id válido!')
        console.log(error);
    });
}