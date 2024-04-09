function getUser() {
    const userId = document.getElementById("getUserId").value;

    fetch('http://localhost:8080/backend/router/usuario?id=' + userId, {
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

            document.getElementById("getUserId").value;
            document.getElementById("nomeuser").value = data.nome;
            document.getElementById("emailuser").value = data.email;
            document.getElementById("senhauser").value = data.senha;
            document.getElementById("nascimentouser").value = data.datanascimento;

        } 
       
    })
    .catch(error => {
        Swal.fire('Coloque algum um id válido!')
        console.log(error);
    });
}