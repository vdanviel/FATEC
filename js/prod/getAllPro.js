
function getAll() {
    fetch('http://localhost:8080/backend/router/produto', {
        method: 'GET'
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
        displayUsers(data);
    })
    .catch(error => alert('Erro na requisição: ' + error));
}

function displayUsers(data) {
    const usersDiv = document.getElementById('proList');
    usersDiv.innerHTML = ''; 

    const list = document.createElement('ul');
    let listItem = document.createElement('tr');
    listItem.textContent = `# - NOME - PREÇO - QUANTIDADE - CATEGORIA`;
    list.appendChild(listItem);
    data.forEach(prod => {
        const listItem = document.createElement('li');
        listItem.textContent = `${prod.id} - ${prod.nome} - ${prod.preco} - ${prod.quantidade}  - ${prod.categoria}`;
        list.appendChild(listItem);
    });

    usersDiv.appendChild(list);
}

getAll();