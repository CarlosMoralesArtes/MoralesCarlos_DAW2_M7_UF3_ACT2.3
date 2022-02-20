<!DOCTYPE html>
<html lang="es">
<link rel="shortcut icon" href="./images/logo.png">
<head>
    <!-- Connexio amb la base de dades -->
    <?php
        include 'connexio.php';

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
    <!-- =====Titul de la pagina===== -->
     <title>Registrar-se | AmazonBlue</title>
     <!-- Estils de la pagina de registre -->
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

            .container{
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
                                    <br>
                                    <h1 class="text-white" data-aos="fade-up" data-aos-delay="500">REGISTRAT</h1>
                                    <p data-aos="fade-up" data-aos-delay="300">
                <div class="container">
                <div class="ml-auto col-lg-12 col-md-12 col-12">
                <!-- Registrar el usuari en la base de dades -->
                <?php
                
                // Encriptar dos contrasenyes per poderles cambiar si fa falta
                $usuari = "admin";
                $contrasenyaEn = md5("JVjv2021");
                $contador = 0;

                if(!isset($_REQUEST['usuari'])){
                    $_SESSION["usuari"] = "admin";
                    $_SESSION["password"] = $contrasenyaEn;
                }

                // Part on es pujan les dades del registre a la base de dades de usuari
                if(isset($_POST['submit'])){
                    $imgContenido = $_FILES["foto2"]["tmp_name"];
                    $foto2 = addslashes(file_get_contents($imgContenido));
                    $posicio = strpos($_FILES["foto2"]["type"], '/');
                    $extension = substr($_FILES["foto2"]["type"], $posicio);
                    $correcte = false;

                    if($extension == '/png'){
                        $correcte = true;
                    } else if ($extension == '/jpg'){
                        $correcte = true;
                    } else if ($extension == '/gif'){
                        $correcte = true;
                    } else if ($extension == '/jpeg'){
                        $correcte = true;
                    } else {
                        $correcte = false;
                    }

                    $email = $_POST["cf-email"];
                    $contrasenya = $_POST["cf-contrasenya"];
                    $nom = $_POST["cf-nom"];
                    $cognoms = $_POST["cf-cognoms"];
                    $direccio = $_POST["cf-direccio"];
                    $poblacio = $_POST["cf-poblacio"];
                    $cPostal = $_POST["cf-cPostal"];
                    $dadesFoto = $foto2;
                    $tipusFoto = $extension;

                    // Control de errors del registre de usuaris
                    if($email != ""){
                        $contador++;
                    }
                    if($contrasenya != ""){
                        $contador++;
                    }
                    if($nom != ""){
                        $contador++;
                    }
                    if($cognoms != ""){
                        $contador++;
                    }
                    if($direccio != ""){
                        $contador++;
                    }
                    if($poblacio != ""){
                        $contador++;
                    }
                    if($cPostal != ""){
                        $contador++;
                    }
                    if($dadesFoto != ""){
                        $contador++;
                    }
                    if($tipusFoto != ""){
                        $contador++;
                    }

                    if($contador == 9){
                        $contrasenyaEn = md5($contrasenya);

                        // Insercio del usuari registrat a la base de dades
                        $sql = "insert into usuari(email,password,nom,cognoms,direccio,poblacio,cPostal,dadesFoto,tipusFoto,admin) values('" .$email. "','" .$contrasenyaEn. "','" .$nom. "','" .$cognoms. "','" .$direccio. "','" .$poblacio. "','" .$cPostal. "','". $dadesFoto ."','". $tipusFoto ."',' 0 ')";
                        $r = mysqli_query($con,$sql);

                        if(mysqli_error($con)){
                            echo "ERROR: ".mysqli_error($con);
                        } else {
                            echo "Dades introduides correctament. ";
                            echo "<br>";
                        }
                    } else {
                        echo "No pots deixar cap camp en vuit. ";
                    }
                }
                ?>

                <!-- Formulari del registre -->
                <form method="post" class="contact-form webform" data-aos="fade-up" data-aos-delay="150" role="form" enctype="multipart/form-data">
                    <input type="email" class="form-control" name="cf-email" placeholder="Email">
                    <input type="password" class="form-control" name="cf-contrasenya" placeholder="Contrasenya">
                    <input type="text" class="form-control" name="cf-nom" placeholder="Nom">
                    <input type="text" class="form-control" name="cf-cognoms" placeholder="Cognoms">
                    <input type="text" class="form-control" name="cf-direccio" placeholder="Direccio">
                    <input type="text" class="form-control" name="cf-poblacio" placeholder="Poblacio">
                    <input type="text" class="form-control" name="cf-cPostal" placeholder="cPostal">
                    <p>Imatge de Perfil: </p>
                    <input type="file" name="foto2">
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