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

            return response.json(); // Retorna os dados em formato JSON
        },
    }
}

export { api }; // Exporta o objeto api