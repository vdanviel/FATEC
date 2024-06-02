import { api } from "../../requests/handle.js";
import { general } from "../../general.js";

document.addEventListener('DOMContentLoaded', async () => {
    
    render_page();

});

const render_page = async () => {

    let url_query = window.location.search.replace('?','');//pega a GET query da url e retira o "?" para a função URLSearchParams funcionar..

    let id = new URLSearchParams(url_query).get('id');

    const data = await api.dep.find(id);

    document.title = data.dados.nomeCivil;

    //construindo front
    document.querySelector('.form img').src = data.dados.ultimoStatus.urlFoto;
    document.querySelector('.form h1').innerHTML = 'DEPUTADO(A) ' + data.dados.nomeCivil;

    let form = document.querySelector('.data-form');

    //dados gerais
    general.createFieldInput('name','Nome*', data.dados.nomeCivil,'text',form);//email
    general.createFieldInput('email','Email*', data.dados.ultimoStatus.email,'text',form);//email
    general.createFieldInput('document','CPF*', data.dados.cpf,'text',form);//cpf
    general.createFieldInput('sex','Gênero*', data.dados.sexo,'text',form);//sex
    general.createFieldInput('birth','Aniversário', data.dados.dataNascimento,'text',form);//birth
    general.createFieldInput('education','Educação', data.dados.escolaridade,'text',form);//education
    general.createFieldInput('death','Falecimento', data.dados.dataFalecimento,'text',form);//falecimento
    general.createFieldInput('acronym','Partido*', data.dados.ultimoStatus.siglaPartido,'text',form);//sigla

}