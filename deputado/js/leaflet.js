
var map = L.map('map').setView([-15.7801, -47.9292], 4);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

//envia para o back
function handle(e) {
    e.preventDefault();


}

//da display no mapa e retorna lat e lon
function find_loc(address, city, state) {

    //mostrando no mapa
    var address_info = `?format=json&street=${address}&city=${city}&state=${state}&country=Brazil`;

    const response = fetch(`https://nominatim.openstreetmap.org/search${address_info}`).then(data => data.json());

    return response;

    
}

//preenche formulario
async function fullfil_address(code) {

    //recu
    fetch(`https://viacep.com.br/ws/${code}/json/`)
        .then(response => response.json())
        .then(data => {

            if (!data.erro) {
                
                //preenchendo os campos
                document.getElementById('street').value = data.logradouro;
                document.getElementById('neighborhood').value = data.bairro;
                document.getElementById('city').value = data.localidade;
                document.getElementById('state').value = data.uf;

                
                find_loc(data.logradouro, data.localidade, data.uf).then((info) => {

                    console.log(info);

                    //mostrando no mapa
                    if (typeof info == 'object') {
                    
                        L.marker([info[0].lat, info[0].lon], 13).addTo(map);

                    }else{

                        L.marker([info.lat, info.lon], 13).addTo(map);

                    }

                });

                

            } else {
                alert("CEP inválido.");
            }

        })
        .catch(error => console.error('Erro ao buscar o CEP:', error));
}
