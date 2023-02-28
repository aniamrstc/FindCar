<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/865258096d.js" crossorigin="anonymous"></script>
    <title>Connexion</title>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../../assets/LogoMini.PNG" alt="" width="50" height="50">
            </a>
            <a class="d-flex" href="#">
                <i class="fa-solid fa-user"></i>
            </a>
        </div>
    </nav>
    <div>
        <div class="card-body p-4 p-md-5 ">
            <h2 class="mb-4 pb-2 pb-md-0 mb-md-5 px-md-2 d-flex justify-content-center align-items-center">Connexion </h2>
            <form method="POST" class="px-md-2" style="margin:50px 150px">

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <input type="text" name="email" id="email" placeholder="Email" class="form-control">
                    </div>
                    <div class="col-md-6 mb-4">
                        <input type="password" name="password" id="password" placeholder="Mot de passe" class="form-control">
                    </div>
                </div>
                <div class="form-outline mb-4 d-flex justify-content-center align-items-center">
                    <input type="submit" name="connexion" id="Connexion" value="Connexion" class=" col-8 btn btn-primary">
                </div>
                <div class="d-flex justify-content-center align-items-center">
                    <p>Ou</p>
                </div>
                <div class="d-flex justify-content-center align-items-center">
                    <input type="submit" name="inscription" id="Inscription" value="Inscription" class="btn btn-primary col-6">
                </div>
            </form>
        </div>
    </div>
</body>

</html>