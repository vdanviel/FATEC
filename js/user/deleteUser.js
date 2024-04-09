function deleteUser() {
    const userId = document.getElementById("getUserId").value;

    if (!userId) {
        Swal.fire('Por favor, insira um id!')
        return;
    }

    fetch('http://localhost:8080/backend/router/usuario', {
        method: 'DELETE',
        body:JSON.stringify({
            id: userId
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
            
            document.getElementById("getUserId").value = "";
            document.getElementById("nomeuser").value = "";
            document.getElementById("emailuser").value = "";
            document.getElementById("senhauser").value = "";
            document.getElementById("nascimentouser").value = '';
            
        }   
        
    })
    .catch(error => {
        console.log(error);
        Swal.fire('Coloque algum um id válido!')});
}