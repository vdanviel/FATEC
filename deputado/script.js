import { api } from "../requests/handle.js";

document.addEventListener('DOMContentLoaded', async () => {
    
    let url_query = window.location.search.replace('?','');//pega a GET query da url e retira o "?" para a função URLSearchParams funcionar..

    let id = new URLSearchParams(url_query).get('id');

    const data = await api.dep.find(id);

    document.title = data.dados.nomeCivil;

    console.log(data);

    //construindo front
    document.querySelector('.form img').src = data.dados.ultimoStatus.urlFoto;
    document.querySelector('.form h1').innerHTML = 'DEPUTADO(A) ' + data.dados.nomeCivil;

    let name = document.createElement('input');
    let cpf = document.createElement('input');
    let sex = document.createElement('input');
    let birth = document.createElement('input');
    let uf = document.createElement('input');
    let education = document.createElement('input');
    let bairro = document.createElement('input');
    let death = document.createElement('input');

    cpf.type = 'text'
    sex.type = 'text'
    birth.type = 'text'
    uf.type = 'text'
    education.type = 'text'
    bairro.type = 'text'
    death.type = 'text'

    cpf.disabled = true;
    sex.disabled = true;
    birth.disabled = true;
    uf.disabled = true;
    education.disabled = true;
    bairro.disabled = true;
    death.disabled = true;

    cpf.value = data.dados.cpf == null ? 'CPF - N/A' : 'CPF - ' + data.dados.cpf;
    sex.value = data.dados.sexo == null ? 'GÊNERO - N/A' : 'GÊNERO - ' + data.dados.sexo;
    birth.value = data.dados.dataNascimento == null ? 'NASCIMENTO - N/A' : 'NASCIMENTO - ' + data.dados.dataNascimento;
    uf.value = data.dados.ufNascimento == null ? 'ESTADO - N/A' : 'ESTADO - ' + data.dados.ufNascimento;
    education.value = data.dados.escolaridade == null ? 'ESCOLARIDADE - N/A' : 'ESCOLARIDADE - ' + data.dados.escolaridade;
    bairro.value = data.dados.municipioNascimento == null ? 'MUNICÍPIO - N/A' : 'MUNICÍPIO - ' + data.dados.municipioNascimento;
    death.value = data.dados.dataFalecimento == null ? 'MORTE - N/A' : 'MORTE - ' + data.dados.dataFalecimento;

    let form = document.querySelector('.data-form');

    form.append(cpf);
    form.append(sex);
    form.append(birth);
    form.append(uf);
    form.append(education);
    form.append(bairro);
    form.append(death);


});