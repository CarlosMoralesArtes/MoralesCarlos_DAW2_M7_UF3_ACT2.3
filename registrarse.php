<!DOCTYPE html>
<html lang="es">
<link rel="shortcut icon" href="./images/logo.png">
<head>
    <!-- Connexio amb la base de dades -->
    <?php
        include 'connexio.php';
    ?>
    <!-- Titul de la pagina de inici de sessio -->
     <title>Registrar-se</title>
     <!-- Estils de la pagina login -->
        <style>
            table, tr, th, td{
                border: 1px solid #000000;
                padding: 10px;
            }
            .espai{
                padding-right: 960px;
            }

            p{
                color: white;
            }
        </style>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=Edge">
     <meta name="description" content="">
     <meta name="keywords" content="">
     <meta name="author" content="">
     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

     <link rel="stylesheet" href="css/bootstrap.min.css">
     <link rel="stylesheet" href="css/font-awesome.min.css">
     <link rel="stylesheet" href="css/aos.css">

     <!-- MAIN CSS -->
     <link rel="stylesheet" href="css/tooplate-gymso-style.css">
</head>
<body data-spy="scroll" data-target="#navbarNav" data-offset="50">

    <!-- MENU BAR -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-lg-auto">
                    <li class="nav-item">
                        <a href="client.php" class="nav-link smoothScroll">Tornar</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>


     <!-- HERO -->
     <section class="hero d-flex flex-column justify-content-center align-items-center" id="home">

            <div class="bg-overlay"></div>

               <div class="container">
                    <div class="row">

                         <div class="col-lg-8 col-md-10 mx-auto col-12">
                              <div class="hero-text mt-5 text-center">

                                    <h1 class="text-white" data-aos="fade-up" data-aos-delay="500">INICIA SESSIÓ</h1>
                                    <p data-aos="fade-up" data-aos-delay="300">
                <div class="container">
                <div class="ml-auto col-lg-12 col-md-12 col-12">
                <!-- Registrar el usuari en la base de dades -->
                <?php

                $sql = "select nom from usuari";
                $r = mysqli_query($con,$sql);

                while($fila = mysqli_fetch_assoc($r)){
                    foreach ($fila as $value) {
                        echo $value;
                    }
                }
                
                // Encriptar dos contrasenyes per poderles cambiar si fa falta
                
                $usuari = "admin";
                $contrasenyaEn = md5("JVjv2021");

                if(!isset($_REQUEST['usuari'])){
                    $_SESSION["usuari"] = "admin";
                    $_SESSION["password"] = $contrasenyaEn;
                }

                if(isset($_POST['submit'])){
                    $email = $_POST["cf-email"];
                    $nom = $_POST[];
                    $cognoms = $_POST[];
                    $direccio = $_POST[];
                    $poblacio = $_POST[];
                    $cPostal = $_POST[];
                    $dadesFoto = $_POST[];
                    $tipusFoto = $_POST[];
                    $admin = $_POST=[];
                    $contrasenya = $_POST["cf-contrasenya"];

                    $sql = "insert into producte(nom,descripcio,preu,stock,dadesImatge,tipusImatge,contingut) values('" .$nom. "','" .$descripcio. "','" .$preu. "','" .$stock. "','" .$foto. "','" .$extension. "','null')";
                    $r = mysqli_query($con,$sql);

                    if(mysqli_error($con)){
                        echo "ERROR: ".mysqli_error($con);
                    } else {
                        echo "Dades introduides correctament. ";
                        echo "<br>";
                    }
                    } else {
                        echo "<p>Coloca el usuari o la contrasenya correctament.</p>";
                    }
                ?>
                <!-- Formulari del login -->
                <form method="post" class="contact-form webform" data-aos="fade-up" data-aos-delay="150" role="form">
                    <input type="text" class="form-control" name="cf-email" placeholder="Usuari">
                    <input type="text" class="form-control" name="cf-contrasenya" placeholder="Contrasenya">
                    <input type="text" class="form-control" name="cf-nom" placeholder="Nom">
                    <input type="text" class="form-control" name="cf-cognoms" placeholder="Cognoms">
                    <input type="text" class="form-control" name="cf-direccio" placeholder="Direccio">
                    <input type="text" class="form-control" name="cf-poblacio" placeholder="Poblacio">
                    <input type="text" class="form-control" name="cf-cPostal" placeholder="cPostal">
                    <input type="file" name="foto">
                    <button type="submit" class="form-control" id="submit-button" name="submit">Registrar-se</button>
                </form>
            </div>
        </div>                             
                                    </p>
                              </div>
                         </div>

                    </div>
               </div>
     </section>
         

     <!-- SCRIPTS -->
     <script src="js/jquery.min.js"></script>
     <script src="js/bootstrap.min.js"></script>
     <script src="js/aos.js"></script>
     <script src="js/smoothscroll.js"></script>
     <script src="js/custom.js"></script>

</body>
</html>