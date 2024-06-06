import { info } from "../../system.js";

//da display do mapa
var map = L.map('map').setView([-15.7801, -47.9292], 10);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

//envia para o back
function handle(e) {
    e.preventDefault();

    const myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    //dados necessários para envio.
    let name = document.getElementById('name').value;
    let sex = document.getElementById('sex').value;
    let acronym = document.getElementById('acronym').value;
    let email = document.getElementById('email').value;
    let address_code = document.getElementById('address_code').value;
    let city = document.getElementById('city').value;
    let neighborhood = document.getElementById('neighborhood').value;
    let street = document.getElementById('street').value;
    let lat = document.getElementById('lat').value;
    let lon = document.getElementById('lon').value;

    if (name.length == 0 || sex.length == 0 ||acronym.length == 0 ||email.length == 0 ||address_code.length == 0 ||city.length == 0 ||neighborhood.length == 0 ||street.length == 0 ||lat.length == 0 ||lon.length == 0) {

        alert('Preencha os dados obrigatórios.');

    }else{

        const raw = JSON.stringify({
            "nome": name,
            "sexo": sex,
            "partido": acronym,
            "email": email,
            "cep": address_code,
            "cidade": city,
            "bairro": neighborhood,
            "rua": street,
            "latitude": lat,
            "longitude": lon
        });
    
        const requestOptions = {
            method: "POST",
            headers: myHeaders,
            body: raw,
            redirect: "follow"
        };
    
        fetch("../app/Backend/Routes/DeputadosRoute.php", requestOptions)
        .then((response) => response.json())
        .then((result) => {
            if (result.status == true) {
                
                alert("Dados enviados com sucesso!");
    
                window.location = "https://vdanviel.github.io/FATEC/"
    
            }
        })
        .catch((error) => {
            console.error(error)
            alert("Erro ao enviar o formulário.")
        });

    }




}

//retorna lat e lon
function find_loc(address, city, state) {

    //mostrando no mapa
    var address_info = `?format=json&street=${address}&city=${city}&state=${state}&country=Brazil`;

    const response = fetch(`https://nominatim.openstreetmap.org/search${address_info}`).then(data => data.json());

    return response;

    
}

//preenche formulario e da display no mapa da localização
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