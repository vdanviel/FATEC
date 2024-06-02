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

        row.style.cursor = 'pointer';

        row.onclick = () => {
          window.location = `https://vdanviel.github.io/FATEC/deputado/?id=${element.id}`
        }

        table.append(row);

    });

    loading.remove();
    return deps;

}

document.addEventListener('DOMContentLoaded', async () => {

  await renderize_deps()
  
})