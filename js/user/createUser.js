document.getElementById('submitButton').addEventListener('click', createUser);

function createUser() {
    const nomeuser = document.getElementById('nomeuser').value;
    const emailuser = document.getElementById('emailuser').value;
    const senhauser = document.getElementById('senhauser').value;
    const nascimentouser = document.getElementById('nascimentouser').value;

    console.log(nascimentouser);

    if (!nomeuser) {
        alert("Por favor, insira um nome!");
        return;
    }

    const usuario = {
        nome: nomeuser,
        email: emailuser,
        senha: senhauser,
        nascimento: nascimentouser,
    };

    fetch('http:localhost:8080/backend/router/usuario', { 
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(usuario)
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

        if(data.error){
            if (data.error == "usuario_existe") {
                Swal.fire('Usuário já existe!')            
            }
            
            Swal.fire(data.error)

        }else{
            Swal.fire('Usuário criado!')
        }     
       
    })
    .catch(error => {
        console.log(error);
        alert('Erro na requisição: ' + error)
    });

}
