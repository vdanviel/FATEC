import { api } from "../requests/handle.js";

async function renderize_deps(){

    let deps = await api.dep.all();
    let table = document.querySelector('.simple-table tbody');

    let loading = document.createElement('p');
    loading.innerText = 'Carregando...'
    table.append(loading);

    //montando no front
    deps.dados.forEach(element => {

        let row = document.createElement('tr');//criando linha
        let id = document.createElement('td');
        let name = document.createElement('td');
        let email = document.createElement('td');
        let part = document.createElement('td');

        id.innerText = element.id;
        name.innerText = element.nome;
        email.innerText = element.email;
        part.innerText = element.siglaPartido;

        row.append(id);
        row.append(name);
        row.append(email);
        row.append(part);

        //preparando para clicar e redenrizar dep
        row.style.cursor = 'pointer'//colocando pointer no mouse me cada linha

        row.addEventListener('click',() => {

            window.location = ''

        });

        table.append(row);

    });

    loading.remove();

}

renderize_deps()

