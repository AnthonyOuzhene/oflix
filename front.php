<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <button id="login" onclick="connect()">Se Connecter</button>

    <button id="list-user">Lister les user</button>

    <div id="resultat"></div>

    <script>
        function connect()
        {
            fetch("http://localhost:8000/api/login_check", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json', // le type de retour accepté
                    'Content-Type': 'application/json'
                },
                body:  JSON.stringify({ // dans le body il faut une donnée username et une donnée password au format
                    "username":"admin@admin.com", // à récupérer depuis un formulaire par exemple
                    "password":"admin"
                })
            })
            .then(function (data){ // on recoit une réponse contenant du json
                return data.json(); // on récupère le json de la réponse et on renvoie une nouvelle promesse
            })
            .then(function(jsonData)
            {
                console.log(jsonData);
                // choisissez localStorage ou sessionStorage comme vous voulez
                sessionStorage.setItem("jwtToken", jsonData.token)
            })
        }
    </script>
</body>
</html>