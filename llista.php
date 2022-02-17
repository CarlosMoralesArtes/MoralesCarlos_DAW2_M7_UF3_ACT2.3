<!DOCTYPE html>
<html lang="es">
<link rel="shortcut icon" href="./images/logo.png">
<head>
    <!-- Conexio amb la base de dades -->
    <?php
        include 'connexio.php';

        //Iniciar una nueva sesió o reanudar la existent.
        session_start();
        //Si existeix la sesió "cliente"..., la guardarem en una variable.
        if (isset($_SESSION['usuari'])){
            $cliente = $_SESSION['usuari'];
        }else{
            header('Location: index.php'); //Aqui lo redireccionem al lloc de iniciar sessió.
            die() ;
        }
    
        $sql = "SELECT COUNT(*) FROM usuari WHERE nom LIKE 'admin'";
        $r = mysqli_query($con,$sql);

        while($fila = mysqli_fetch_assoc($r)){
            foreach ($fila as $value) {
                $usuariAdminCreat = $value;
            }
        }

        if($usuariAdminCreat == 0){
            $contrasenyaEn = md5("JVjv2021");
            $sql = "insert into usuari(email,password,nom,cognoms,direccio,poblacio,cPostal,dadesFoto,tipusFoto,admin) values('admin@gmail.com','". $contrasenyaEn ."','admin','admin','null','null','null','null','null',' 1 ')";
            $r = mysqli_query($con,$sql);
        }

    ?>

    <style>
        table{
            color: black;
            background-color: white;
            text-align: center;
            margin-top: 15px;
            padding: 100px;
            border-radius: 10px;
        }

        .totalLlista{
            color: black;
            text-align: right;
            padding: 10px;
            background-color: white;
            border-radius: 10px;
            padding-right: 10px;
        }
    </style>

    <!-- Titul de la pagina -->
     <title>Diari</title>
     
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
                        <a href="client.php" class="nav-link smoothScroll">Seguir Comprant</a>
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
                                    <h1 class="text-white" data-aos="fade-up" data-aos-delay="150">Llista Virtual</h1>
                                    <?php
                                        if(isset($_POST['tancarSessio'])){
                                            unset($_SESSION["usuari"]);
                                            if (isset($_SESSION['admin'])){
                                                $cliente = $_SESSION['admin'];
                                            }
                                            header('Location: index.php'); //Aqui lo redireccionem al lloc de iniciar sessió.
                                            die() ;
                                        }
                                        $suma = 0;
                                        if (isset($_SESSION['productesSeleccionats'])){
                                            $productesSeparats = explode(";", $_SESSION["productesSeleccionats"]);
                                            $quantitatLlista = (count($productesSeparats));
                                            for ($i=0; $i < $quantitatLlista; $i++) {
                                                $sql = "SELECT nom, descripcio, preu FROM producte WHERE codiProducte LIKE $productesSeparats[$i]";
                                                $r = mysqli_query($con,$sql);
                                                echo "<table class='col-lg-12 col-md-10 mx-auto col-12'>";
                                                while($fila = mysqli_fetch_assoc($r)){
                                                    echo "<tr>";
                                                    echo "<th>";
                                                    echo "Nom";
                                                    echo "</th>";
                                                    echo "<th>";
                                                    echo "Descripcio";
                                                    echo "</th>";
                                                    echo "<th>";
                                                    echo "Preu";
                                                    echo "</th>";
                                                    echo "</tr>";
                                                    foreach ($fila as $key => $value) {
                                                        echo "<td>";
                                                        echo $value;
                                                        echo "</td>";
                                                    }
                                                    $suma = $suma + $fila['preu'];
                                                }
                                            }
                                            echo "</table>";
                                            echo "<br>";
                                            echo "<p class='totalLlista'><strong>Total: </strong>";
                                            echo "$suma";
                                            echo "</p>";
                                        } else {
                                            echo "<p>No has seleccionat cap producte.</p>";
                                        }
                                    ?>
                                    <form action="#" method="post" class="contact-form webform" data-aos="fade-up" data-aos-delay="150" role="form">
                                        <br>
                                        <button class="form-control" id="submit-button" name="tancarSessio">Finalitzar Compra</button>
                                    </form>
                                    <form action="#" method="post" class="contact-form webform" data-aos="fade-up" data-aos-delay="150" role="form">
                                        <br>
                                        <button class="form-control" id="submit-button" name="tancarSessio">Tancar Sessió</button>
                                    </form>
                              </div>
                         </div>
                    </div>
               </div>
     </section>

     <!-- FOOTER -->
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

    <!-- Modal -->
    <div class="modal fade" id="membershipForm" tabindex="-1" role="dialog" aria-labelledby="membershipFormLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">

        <div class="modal-content">
          <div class="modal-header">

            <h2 class="modal-title" id="membershipFormLabel">Membership Form</h2>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form class="membership-form webform" role="form">
                <input type="text" class="form-control" name="cf-name" placeholder="John Doe">

                <input type="email" class="form-control" name="cf-email" placeholder="Johndoe@gmail.com">

                <input type="tel" class="form-control" name="cf-phone" placeholder="123-456-7890" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required>

                <textarea class="form-control" rows="3" name="cf-message" placeholder="Additional Message"></textarea>

                <button type="submit" class="form-control" id="submit-button" name="submit">Submit Button</button>

                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="signup-agree">
                    <label class="custom-control-label text-small text-muted" for="signup-agree">I agree to the <a href="#">Terms &amp;Conditions</a>
                    </label>
                </div>
            </form>
          </div>
      </div>
    </div>

     <!-- SCRIPTS -->
     <script src="js/jquery.min.js"></script>
     <script src="js/bootstrap.min.js"></script>
     <script src="js/aos.js"></script>
     <script src="js/smoothscroll.js"></script>
     <script src="js/custom.js"></script>

</body>
</html>