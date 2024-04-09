function updateUser() {

    const userId = document.getElementById("getUserId").value;
    const nomeuser = document.getElementById("nomeuser").value;
    const emailuser = document.getElementById("emailuser").value;
    const senhauser = document.getElementById("senhauser").value;
    const nascimentouser = document.getElementById("nascimentouser").value;

    const usuarioAtualizado = {
        id: userId,
        nome: nomeuser,
        email: emailuser,
        senha: senhauser,
        nascimento: nascimentouser
    };

    if (!userId) {
        Swal.fire('Por favor, insira um id!')
        return;
    }

    fetch('http://localhost:8080/backend/router/usuario', { 
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
