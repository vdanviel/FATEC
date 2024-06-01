
var map = L.map('map').setView([-15.7801, -47.9292], 4);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

function handle(e) {
    e.preventDefault();


}

function find_loc() {
        


    //mostrando no mapa
    var address = `${data.logradouro},${data.bairro},${data.localidade},${data.uf},Brazil`;

    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
    .then(response => response.json())
    .then(locations => {

        console.log(locations);

        if (locations.length > 0) {
            var location = locations[0];
            var lat = location.lat;
            var lon = location.lon;

            
            map.setView([lat, lon], 16);
            L.marker([lat, lon]).addTo(map).bindPopup(`Local encontrado.`).openPopup();

            

        } else {


            alert("Localização não encontrada.");
        }
    });
}

function fullfil_address(code) {

    //recu
    fetch(`https://viacep.com.br/ws/${code}/json/`)
        .then(response => response.json())
        .then(data => {

            if (!data.erro) {
                
                //preenchendo os campos
                let street = document.getElementById('street');
                let neighborhood = document.getElementById('neighborhood');
                let city = document.getElementById('city');
                let state = document.getElementById('state');
                let lat = document.getElementById('lat');
                let lon = document.getElementById('lon');


                

            } else {
                alert("CEP inválido.");
            }

        })
        .catch(error => console.error('Erro ao buscar o CEP:', error));
}

functi
