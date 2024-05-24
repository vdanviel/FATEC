let name = document.querySelector('#name').value;
let specie = document.querySelector('#specie').value;
let status = document.querySelector('#status').value;
let type = document.querySelector('#specie').value;
let gender = document.querySelector('#gender').value;

let search = document.querySelector('#search').value;

let sender1 = document.querySelector('form').querySelectorAll('input[type=submit]')[0];
let sender2 = document.querySelector('form').querySelectorAll('input[type=submit]')[1];

document.addEventListener('DOMContentLoaded', () => {

    //envia para bd
    sender1.addEventListener('click', async (e) => {

        e.preventDefault();

        const data = find_by_some_data(name,status,specie,type,gender);

        document.querySelector('display').innerHTML = 'Carregando..';

        await save_person(data.result);

        

    });

    //envia para bd
    sender2.addEventListener('click', async (e) => {

        e.preventDefault();

        const data = find_by_id(search);

        document.querySelector('display').innerHTML = 'Carregando..';

        await save_person(data)

    });

});



async function find_by_some_data(name = '', status = '', species = '', type = '', gender = '') {

    let query = '';

    if (name !== '') {
        
        query += 'name=' + name + '&';

    }

    if (status !== '') {
        
        query += 'status=' + status + '&';

    }

    if (species !== '') {
        
        query += 'species=' + species + '&';

    }

    if (type !== '') {
        
        query += 'type=' + type + '&';

    }

    if (gender !== '') {
        
        query += 'gender=' + gender + '&';

    }

    if(query != '') query = '?' + query.substring(0, query.length -1);
    
    const response = fetch(`https://rickandmortyapi.com/api/character${query}`, {
        mode: 'cors',
        headers: {
            'Content-Type': 'application/json'
        }
    })

    return await response;

}

async function find_by_id(id) {
    
    const response = fetch(`https://rickandmortyapi.com/api/${id}`, {
        mode: 'cors',
        headers: {
            'Content-Type': 'application/json'
        }
    });

    return await response;

}

async function save_person(person) {
    
    const response = fetch(`./app/Router/UsuarioRouter.php`, {
        mode: 'cors',
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: {
            nome: person.name,
            email: person.species
        }
    });

    if (response.ok) {
        
        document.querySelector('display').innerHTML = 'OK!';

    }

    return await response;

}