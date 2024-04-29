const btn = document.getElementById('send');

btn.addEventListener('click', (e) => {

    e.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;


    const myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    fetch("http://10.67.255.175:8000/src", 
        {
            method: "POST",
            headers: myHeaders,
            body: JSON.stringify(
                {
                "email": email,
                "password": password
                }
            ),
            redirect: "follow"
        }
    )
    .then((response) => response.json())
    .then((result) => {
        localStorage.setItem('token', result.token);
    })
    .catch((error) => console.error(error));

});