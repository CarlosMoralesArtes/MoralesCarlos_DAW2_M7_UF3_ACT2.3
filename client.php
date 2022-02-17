<!DOCTYPE html>
<html lang="es">
<!-- Logo de la pagina -->
<link rel="shortcut icon" href="./images/logo.png">
<!-- ===== Header de la pagina client ===== -->
<head>
    <!-- ===== Comprovacions amb if ===== -->
    <?php
        //Iniciar una nueva sesió o reanudar la existent.
        session_start();

        $compraRealitzadaEn = 0;

        if(isset($_POST["seleccionat"])){
            $compraRealitzadaEn = 1;
        }

        // Connexio amb la base de dades
        include 'connexio.php';

        // if que funciona cuan se li dona al boto de tancar la sessio
        if(isset($_POST['tancarSessio'])){
            unset($_SESSION["usuari"]);
            if (isset($_SESSION['admin'])){
                unset($_SESSION['admin']);
            }
            unset($_SESSION['productesSeleccionats']);
            session_destroy();
            header('Location: index.php'); //Aqui lo redireccionem al lloc de iniciar sessió.
            die() ;
        }

        //Si existeix la sesió "client"..., la guardarem en una variable.
        if (isset($_SESSION['usuari'])){
            $client = $_SESSION['usuari'];
        }else{
            header('Location: index.php'); //Aqui lo redireccionem al lloc de iniciar sessió.
            die() ;
        }

        // Comprovacio i creacio del usuari administrador que en el cas de que no estigui creat es creara
        $sql = "SELECT COUNT(*) FROM usuari WHERE nom LIKE 'admin'";
        $r = mysqli_query($con,$sql);

        while($fila = mysqli_fetch_assoc($r)){
            foreach ($fila as $value) {
                $usuariAdminCreat = $value;
            }
        }

        // Si el usuari no esta creat es creara gracies a aquest insert into
        if($usuariAdminCreat == 0){
            $contrasenyaEn = md5("JVjv2021");
            $sql = "insert into usuari(email,password,nom,cognoms,direccio,poblacio,cPostal,dadesFoto,tipusFoto,admin) values('admin@gmail.com','". $contrasenyaEn ."','admin','admin','null','null','null','null','/png',' 1 ')";
            $r = mysqli_query($con,$sql);
        }

        
    ?>

    <!-- ===== Estils de la pagina ===== -->
    <style>
        .blocProducte{
            border: 1px black solid;
            padding: 10px;
            width: 267px;
            display: inline-block;
            margin-left: 100px !important;
            text-align: center;
        }

        .blocProducte img{
            width: 250px;
            height: 130px;
        }

        h4{
            font-size: 10px !important;
            text-transform: uppercase;
        }

        h3{
            text-transform: uppercase;
        }

        h1{
            text-align: center;
            font-size: 15px;
        }

        .imgRodona {
            width: 100px;
            height: 100px;
            border-radius: 150px;
        }

        .compraRealitzada{
            background-color: green;
            width: 100%;
            color: white;
            padding-top: 10px;
            padding-bottom: 10px;
        }
    </style>

    <!-- =====Titul de la pagina===== -->
     <title>AmazonCar</title>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=Edge">
     <meta name="description" content="">
     <meta name="keywords" content="">
     <meta name="author" content="">
     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
     <link rel="stylesheet" href="css/bootstrap.min.css">
     <link rel="stylesheet" href="css/font-awesome.min.css">
     <link rel="stylesheet" href="css/aos.css">
     <link rel="stylesheet" href="css/tooplate-gymso-style.css">
</head>
<body data-spy="scroll" data-target="#navbarNav" data-offset="50">

    <!-- =====Menu===== -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <!-- Titul principal de la pagina -->
            <a class="navbar-brand" href="client.php">AmazonCar</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Menu de la pagina -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-lg-auto">
                    <li class="nav-item">
                        <a href="#home" class="nav-link smoothScroll">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#productes" class="nav-link smoothScroll">Productes</a>
                    </li>
                    <li class="nav-item">
                        <a href="#contact" class="nav-link smoothScroll">Ubicacio</a>
                    </li>
                </ul>

                <ul class="social-icon ml-lg-3">
                    <a href="index.php">
                        <svg class="text-light" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                        </svg>
                    </a>
                    <a href="llista.php">
                        <svg class="text-light" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg>
                    </a>
                </ul>
            </div>
        </div>
    </nav>

     <!-- =====Titul===== -->
     <section class="hero d-flex flex-column justify-content-center align-items-center" id="home">
            <div class="bg-overlay"></div>
               <div class="container">
                    <div class="row">
                         <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                              <div class="hero-text mt-5 text-center">
                                    <!-- Missatge de benvinguda al usuari amb la seva imatge de perfil -->
                                    <div class="benvinguda">
                                        <?php 
                                            if($compraRealitzadaEn == 1){
                                                echo "<p class='compraRealitzada'>Producte afegit a la cesta.</p>";   
                                            }
                                            echo "<p>Benvingut de nou " . $_SESSION['usuari'] . "</p>";
                                            $sql = "SELECT dadesFoto, tipusFoto
                                                    FROM usuari
                                                    WHERE nom LIKE '$client'";
                                            $r = mysqli_query($con,$sql);
                                            while($fila = mysqli_fetch_assoc($r)){
                                                foreach ($fila as $camp => $valor) {
                                                    $tipusImatge = $fila["tipusFoto"];
                                                    $dadesImatge = $fila["dadesFoto"];
                                            }
                                            echo '<img src="data:'.$tipusImatge.';base64,'.base64_encode($dadesImatge).'" class="imgRodona">';
                                        }
                                        ?>
                                    </div>
                                    <h1 class="text-white" data-aos="fade-up" data-aos-delay="150">AmazonCar</h1>
                                    <h6 data-aos="fade-up" data-aos-delay="150">Compra tot el que vulguis!</h6><br>
                                    <a href="#productes" class="btn custom-btn bordered mt-3" data-aos="fade-up" data-aos-delay="150">Productes</a>
                                    <a href="#contact" class="btn custom-btn bordered mt-3" data-aos="fade-up" data-aos-delay="150">Contacta</a>
                                    <form action="#" method="post" class="contact-form webform" data-aos="fade-up" data-aos-delay="150" role="form">
                                        <br>
                                        <button class="form-control" id="submit-button" name="tancarSessio">Tancar Sessió</button>
                                    </form>
                              </div>
                         </div>
                    </div>
               </div>
     </section>

     <!-- Productes -->
     
     <section id="productes">
         <div class="container">
             <br>
             <h1>PRODUCTES</h1>
         <?php
         if(isset($_POST["seleccionat"])){
            if(isset($_SESSION['productesSeleccionats'])){
                $seleccionats = $_SESSION['productesSeleccionats'];
                $_SESSION['productesSeleccionats'] = $seleccionats ." ; ". $_POST["seleccionat"];
            } else {
                $_SESSION['productesSeleccionats'] = $_POST["seleccionat"];
            }
         }
                $sql = "SELECT * 
                          FROM producte";
                $r = mysqli_query($con,$sql);
                while($fila = mysqli_fetch_assoc($r)){
                    echo "<div class='blocProducte col-lg-3 col-md-10 mx-auto col-12'>";
                    foreach ($fila as $camp => $valor) { 
                        $tipusImatge = $fila["tipusImatge"];
                        $dadesImatge = $fila["dadesImatge"];
                    }
                    echo '<img src="data:'.$tipusImatge.';base64,'.base64_encode($dadesImatge).'">';
                    echo "<br><br>";
                    echo "<h3>";
                    echo $fila["nom"];
                    echo "</h3>";
                    echo "<h4>Descripcio: ";
                    echo "<p>";
                    echo $fila["descripcio"];
                    echo "</p>";
                    echo "</h4>";
                    echo "<h4>Preu: ";
                    echo "<p>";
                    echo $fila["preu"];
                    echo "</p>";
                    echo "</h4>";
                    echo "<form method='post' class='contact-form webform' data-aos='fade-up' data-aos-delay='150' role='form'>";
                    echo "<button class='form-control' name='seleccionat' value='". $fila['codiProducte'] ."'>Comprar</button>";
                    echo "</form>";
                    echo "</div>";
                }
        ?>
        </div>
     </section>

     <!-- =====Mapa===== -->
     <section class="contact section" id="contact">
          <div class="container">
               <div class="row">
                    <div class="mx-auto mt-4 mt-lg-0 mt-md-0 col-lg-5 col-md-6 col-12">
                        <h2 class="mb-4" data-aos="fade-up" data-aos-delay="150">On pots <span>Trobarnos</span></h2>
                        <p data-aos="fade-up" data-aos-delay="150"><i class="fa fa-map-marker mr-1"></i> Carrer del Doctor Almera, 33, 08205 Sabadell, Barcelona</p>
                        <div class="google-map" data-aos="fade-up" data-aos-delay="150">
                           <iframe src="https://www.google.com/maps/embed?pb=!1m26!1m12!1m3!1d11944.028556075145!2d2.0797216875741857!3d41.54744266799509!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m11!3e6!4m3!3m2!1d41.5547788!2d2.0812307999999997!4m5!1s0x12a494f7a6b86651%3A0xe9a74531a2b7ca1!2sjaume%20viladoms!3m2!1d41.5439553!2d2.0982765999999997!5e0!3m2!1ses!2ses!4v1639120364282!5m2!1ses!2ses" width="1920" height="250" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                        </div>
                    </div>
               </div>
          </div>
     </section>

     <!-- =====Footer===== -->
     <footer class="site-footer">
          <div class="container">
               <div class="row">
                    <!-- Footer de la pagina principal -->
                    <div class="ml-auto col-lg-4 col-md-5">
                        <p class="copyright-text">Copyright &copy; 2022.
                        <br>Design: Carlos Morales</p>
                    </div>
                    <div class="d-flex justify-content-center mx-auto col-lg-5 col-md-7 col-12">
                        <p class="mr-4">
                            <i class="fa fa-envelope-o mr-1"></i>
                            <a href="#contact">secretaria@jviladoms.cat</a>
                        </p>
                    </div>
               </div>
          </div>
     </footer>

    <!-- =====Modal===== -->
    <div class="modal fade" id="membershipForm" tabindex="-1" role="dialog" aria-labelledby="membershipFormLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title" id="membershipFormLabel">Membership Form</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
      </div>
    </div>

     <!-- =====Scripts===== -->
     <script src="js/jquery.min.js"></script>
     <script src="js/bootstrap.min.js"></script>
     <script src="js/aos.js"></script>
     <script src="js/smoothscroll.js"></script>
     <script src="js/custom.js"></script>

</body>
</html>