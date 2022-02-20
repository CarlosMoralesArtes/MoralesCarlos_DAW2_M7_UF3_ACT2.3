<!DOCTYPE html>
<html lang="es">
<link rel="shortcut icon" href="./images/logo.png">
<head>
    <!-- Connexio amb la base de dades -->
    <?php
        include 'connexio.php';

        session_start();

        $comprarCompte = false;

        $sql = "SELECT COUNT(*) FROM usuari";
        $r = mysqli_query($con,$sql);

        while($fila = mysqli_fetch_assoc($r)){
            foreach ($fila as $value) {
                $contadorUsuaris = $value;
            }
        }
    ?>
    <style>
        *{
            color: white;
        }
    </style>
    <!-- =====Titul de la pagina===== -->
     <title>Iniciar Sessio | AmazonBlue</title>
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
                        <a href="registrarse.php" class="nav-link smoothScroll">Registrar-se</a>
                        <?php
                            // Boto que solament apareix cuan tens la sessio iniciada per poder tonar a la pagina on estan els productes
                            if (isset($_SESSION['usuari'])){
                                echo "<a href='client.php' class='nav-link smoothScroll'>Tornar</a>";
                            }
                        ?>
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
                                  <h1 class="text-white" data-aos="fade-up" data-aos-delay="500">Benvingut a la Botiga</h1>
                                  <p class="text-white" data-aos="fade-up" data-aos-delay="500">Registrat/Inicia Sessio per poder accedir a la pagina</p>
                                    <h1 class="text-white" data-aos="fade-up" data-aos-delay="500">INICIA SESSIÓ</h1>
                                    <p data-aos="fade-up" data-aos-delay="300">
                <div class="container">
                <div class="ml-auto col-lg-12 col-md-12 col-12">
                <!-- Inici de sessio per pasar de la pagina principal a la pagina de administrador-->
                <?php
                // Iniciar sessio
                    if(isset($_POST['submit'])){
                        $usuari = $_POST['cf-usuari'];
                        $contrasenya = $_POST['cf-contrasenya'];
                        $contrasenyaUserEnc = md5($contrasenya);

                        $sql = "SELECT COUNT(*) FROM usuari WHERE nom LIKE '". $usuari ."'";
                        $r = mysqli_query($con,$sql);

                        while($fila = mysqli_fetch_assoc($r)){
                            foreach ($fila as $value) {
                                $usuariExistent = $value;
                            }
                        }

                        if($usuari == "admin"){
                            if($usuariExistent >= 1){
                                $sql = "SELECT COUNT(*) FROM usuari WHERE nom LIKE '". $usuari ."' AND password LIKE '". $contrasenyaUserEnc ."'";
                                $r = mysqli_query($con,$sql);

                                while($fila = mysqli_fetch_assoc($r)){
                                    foreach ($fila as $value) {
                                        $contrasenyaExistent = $value;
                                    }
                                }
                                if($contrasenyaExistent == 1){
                                    header('Location: admin.php');
                                    session_start();
                                    $_SESSION["usuari"] = $usuari;
                                    die() ;
                                } else {
                                    echo "Usuari o contrasenya incorrecte. ";
                                }
                                } else {
                                    echo "Usuari o contrasenya incorrecte. ";
                            }
                        } else {
                            if($usuariExistent >= 1){
                                $sql = "SELECT COUNT(*) FROM usuari WHERE nom LIKE '". $usuari ."' AND password LIKE '". $contrasenyaUserEnc ."'";
                                $r = mysqli_query($con,$sql);

                                while($fila = mysqli_fetch_assoc($r)){
                                    foreach ($fila as $value) {
                                        $contrasenyaExistent = $value;
                                    }
                                }
                                if($contrasenyaExistent == 1){
                                    header('Location: client.php');
                                    session_start();
                                    $_SESSION["usuari"] = $usuari;
                                    die() ;
                                } else {
                                    echo "Usuari o contrasenya incorrecte. ";
                                }
                                } else {
                                    echo "Usuari o contrasenya incorrecte. ";
                            }
                        }
                        
                    }
                ?>
                <!-- Formulari del login -->
                <form method="post" class="contact-form webform" data-aos="fade-up" data-aos-delay="150" role="form">
                    <input type="text" class="form-control" name="cf-usuari" placeholder="Usuari">
                    <input type="password" class="form-control" name="cf-contrasenya" placeholder="Contrasenya">
                    <button type="submit" class="form-control" id="submit-button" name="submit">Iniciar Sessio</button>
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