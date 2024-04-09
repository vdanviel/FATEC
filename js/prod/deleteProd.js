function deleteProd() {
    const prodId = document.getElementById("getProdId").value;

    if (!prodId) {
        Swal.fire('Por favor, insira um id!')
        return;
    }

    fetch('http://localhost:8080/backend/router/produto', {
        method: 'DELETE',
        body:JSON.stringify({
            id: prodId
        })
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
        if(data.success){

            Swal.fire('Excluido com sucesso!')
            
            document.getElementById("getProdId").value = "";
            document.getElementById("getProdId").value = "";
            document.getElementById("inputNome").value = "";
            document.getElementById("inputPreco").value = "";
            document.getElementById("inputQuantidade").value = 0;
            document.getElementById("inputDescricao").innerText = "";
            document.getElementById("inputCategoria").options[0].selected = true;
            
        }   
        
    })
    .catch(error => {
        console.log(error);
        Swal.fire('Coloque algum um id válido!')});
}