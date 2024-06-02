## Documentação

#### Instruções da aplicação:

1. No começo da aplicação o usuário é direcionado a uma tabela dos *deputados disponíveis*.
2. Quando o usuário clica em uma das linhas (ou seja em um deputado) ele é redirecionado a uma página onde existem as informações do deputado e um mapa de referência de localização.
3. Ele precisa escrever o CEP e as informações obrigatórias com "*" para conseguir enviar o formulário.
4. Quando o usuário preenche o campo de CEP, automaticamente a localização do CEP é revelada no mapa e os dados do endereço do deputado são preenchidos.
5. O usuário envia o formulário e as informações são salvas no banco de dados.

#### Funcionalidades:

1. Requisições dos deputados - ([Dados Abertos da Câmara Municipal](https://dadosabertos.camara.leg.br/swagger/api.html)):
`
    const api = {
        dep: {
            async all() {
                const response = await fetch("https://dadosabertos.camara.leg.br/api/v2/deputados?pagina=1&ordenarPor=nome", {
                    headers: {
                        'accept': 'application/json'
                    },
                    mode: "cors",
                    method: "GET"
                });

                return response.json();
            },

            async find(id) {
                const response = await fetch("https://dadosabertos.camara.leg.br/api/v2/deputados/" + id, {
                    headers: {
                        'accept': 'application/json'
                    },
                    mode: "cors",
                    method: "GET"
                });

                return response.json();
            }
        }
    }
`

Esse objeto é responsável por lidar com a parte de de requisições em relação a API dos deputados, ([Dados Abertos da Câmara Municipal](https://dadosabertos.camara.leg.br/swagger/api.html)), onde a **página principal** e a **página de deputado** são as suas consumidoras, está em `requests/deputies.js`.

2. Renderização dos deputados na tela principal:
`
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
`

Esta função é a função assíncrona responsável por renderizar os deputados na tabela da página inicial. Como é possível ver, nós recuperamos o objeto `api` em `requests/deputies.js` e usamos o método `all()` que retorna todos os deputados. Depois disso iteramos sobre esses deputados para a criação de cada linha para cada deputado. É notável que para cada linha que é adicionada um evento de clique é criado que redireciona para uma pagina com uma query e dentro desta query tem o valor `id`, que é o id do deputado que vem da ([Dados Abertos da Câmara Municipal](https://dadosabertos.camara.leg.br/swagger/api.html)).

3. Renderização de *um deputado* na tela de deputado:
`
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
`

Esta função renderiza as informações do deputado na tela.
Primeiro ela recupera o id do deputado que está na URI com o objeto `URLSearchParams()` depois esse id é passado para o método `find()` também recuperado de `requests/deputies.js`, e dessa forma nós conseguimos os dados do deputado em questão. Com esses dados nós adicionamos os campos a página com o método `createFieldInput()` que está em `general.js`:


`
    const general = {

        createFieldInput(name, label_name, valueinp, typeinp, appendtoelement){

            let lb = document.createElement('label');
            let inp = document.createElement('input')

            inp.type = typeinp;
            inp.value = valueinp == null ? 'N/A' : valueinp;
            inp.id = name;

            lb.innerText = label_name;
            lb.htmlFor = name;

            lb.append(inp);

            appendtoelement.append(lb);

        }

    }
`

Este método cria uma estrutura de campo com seus valores em uma linha. Desta maneira conseguimos obter a página do deputado com suas informações gerais.

4. A parte de endereçamento do candidato:
Em `deputado/js/addressing.js` temos os seguintes trechos:
`
    var map = L.map('map').setView([-15.7801, -47.9292], 10);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
`
Este trecho **renderiza o mapa do [Leaflet.js](https://leafletjs.com/index.html)** assim que a página de deputado é carregada, e o mapa a vizualização do mapa é apontada para as cordenadas do *Congresso Nacional na capital no Brasil, Brasília*.

`
    async function fullfil_address(code) {

        //recuperar informações e colocar no formulario
        fetch(`https://viacep.com.br/ws/${code}/json/`)
        .then(response => response.json())
        .then(data => {

            if (!data.erro) {
                
                //preenchendo os campos
                document.getElementById('street').value = data.logradouro;
                document.getElementById('neighborhood').value = data.bairro;
                document.getElementById('city').value = data.localidade;
                document.getElementById('state').value = data.uf;

                let loc_finder = find_loc(data.logradouro, data.localidade, data.uf)

                try {
                    
                    document.getElementById('lat').value = 'Carregando...';
                    document.getElementById('lon').value = 'Carreagando...';

                    loc_finder.then((info) => {

                        //mostrando no mapa
                        if (typeof info == 'object') {

                            map.setView([info[0].lat, info[0].lon], 15);
                            L.marker([info[0].lat, info[0].lon]).addTo(map);

                            //adicionando lat e lon no formulário..
                            document.getElementById('lat').value = info[0].lat;
                            document.getElementById('lon').value = info[0].lon;

                        }else{

                            map.setView([info.lat, info.lon], 15);
                            L.marker([info.lat, info.lon]).addTo(map);

                            //adicionando lat e lon no formulário..
                            document.getElementById('lat').value = info.lat;
                            document.getElementById('lon').value = info.lon;

                        }

                    });

                } catch (error) {
                    
                    alert("Ocorreu um erro na localização");
                    console.error(error);

                }

            } else {
                alert("CEP inválido.");
            }

        })
        .catch(error => console.error('Erro ao buscar o CEP:', error));
    }
`
No próximo trecho temos uma função acionada pelo evento `onblur` no campo de CEP na página deputado. Ela faz uma requisição para o ViaCEP com o CEP que o usuário enviou, e a partir dessa requisição com os dados recuperados nós podemos

#### APIS UTILIZADAS NO PROJETO:

[ViaCep](https://viacep.com.br/) - utilzada para conseguir dados do endereço através do CEP.
[Leaflet.js](https://leafletjs.com/index.html) - utilizada para montar o mapa na página de deputado.
[Dados Abertos da Câmara Municipal](https://dadosabertos.camara.leg.br/swagger/api.html) - utilizada para consumir informações sobre o deputado.
[Nominatim](https://nominatim.org/) - utilizada para recuperar latitude e longitude com base nos dados que a ViaCep fornece.