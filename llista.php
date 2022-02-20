<!DOCTYPE html>
<html lang="es">
<link rel="shortcut icon" href="./images/logo.png">
<head>
    <!-- Conexio amb la base de dades -->
    <?php
        include 'connexio.php';
        date_default_timezone_set('UTC');

        //Iniciar una nueva sesió o reanudar la existent.
        session_start();
        //Si existeix la sesió "cliente"..., la guardarem en una variable.
        if (isset($_SESSION['usuari'])){
            $cliente = $_SESSION['usuari'];
        }else{
            header('Location: index.php'); //Aqui lo redireccionem al lloc de iniciar sessió.
            die() ;
        }

        function tornar(){
            header('Location: index.php'); //Aqui lo redireccionem al lloc de iniciar sessió.
            die() ;
        }
    
        // Es comprova si existeix un usuari administrador
        $sql = "SELECT COUNT(*) FROM usuari WHERE nom LIKE 'admin'";
        $r = mysqli_query($con,$sql);

        while($fila = mysqli_fetch_assoc($r)){
            foreach ($fila as $value) {
                $usuariAdminCreat = $value;
            }
        }

        // Es comprova el email del usuari actual
        $sql = "SELECT email FROM usuari WHERE nom LIKE '$cliente'";
        $r = mysqli_query($con,$sql);

        while($fila = mysqli_fetch_assoc($r)){
            foreach ($fila as $value) {
                $emailUsuariActual = $value;
            }
        }

        // Si el usuari administrador no esta creat es crea
        if($usuariAdminCreat == 0){
            $contrasenyaEn = md5("JVjv2021");
            $sql = "insert into usuari(email,password,nom,cognoms,direccio,poblacio,cPostal,dadesFoto,tipusFoto,admin) values('admin@gmail.com','". $contrasenyaEn ."','admin','admin','null','null','null','null','null',' 1 ')";
            $r = mysqli_query($con,$sql);
        }

        // Inicialitzacio de la variable llista
        $llistaCompraRealitzada = 0;
        
    ?>

    <!-- =====Estils de la pagina===== -->
    <style>
        table{
            color: black;
            background-color: white;
            text-align: center;
            margin-top: 15px;
            padding: 100px;
            border-radius: 10px;
        }

        .taula{
            color: black;
            text-align: right;
            padding: 10px !important;
            background-color: white;
            border-radius: 10px;
            text-align: left;
        }

        .imgLlista {
            width: 110px;
            height: 70px;
            border-radius: 10px;
        }

        .compraRealitzada{
            background-color: green;
            width: 100%;
            color: white;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        table{
            border-collapse: none !important;
        }

        p{
            color: white !important;
        }

        .blau{
            color: #00B4FF;
        }

        .compraRealitzada{
            background-color: green;
            width: 100%;
            color: white;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        small{
            color: white;
        }

        .copyright-text{
            color: black !important;
        }
    </style>

    <!-- =====Titul de la pagina===== -->
     <title>Llista | AmazonBlue</title>
     
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
            <a class="navbar-brand" href="client.php">Amazon<span class="blau">Blue</span></a>
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


     <!-- =====Part de la llista===== -->
     <section class="hero d-flex flex-column justify-content-center align-items-center" id="home">
            <div class="bg-overlay"></div>
               <div class="container">
                    <div class="row">
                         <div class="col-lg-8 col-md-10 mx-auto col-12">
                              <div class="hero-text mt-5 text-center">
                                  <br>
                                  <?php
                                        // Aqui es pot veure el apartat del paragraf cuan s'afegeix un producte a la cesta
                                        if($llistaCompraRealitzada == 1){
                                            echo "<p class='compraRealitzada'>Producte afegit a la cesta.</p>";   
                                        }
                                    ?>
                                    <h1 class="text-white" data-aos="fade-up" data-aos-delay="150">Llista Virtual</h1>
                                    <?php
                                        // Inicialitzacio de variables
                                        $suma = 0;
                                        $suma2 = 0;
                                        $numeroCompra = 0;
                                        $codiCompraAc = 0;

                                        // Insercio a la base de dades de compra
                                        if(isset($_POST['finalitzarCompra'])){
                                            $dataActual = date('y.m.d');
                                            // SQL per tenir un registre de les compres que es fan a la botiga
                                            $sql3 = "insert into compra (data, email) values ('$dataActual', '$emailUsuariActual')";
                                            $r3 = mysqli_query($con,$sql3);
                                        }

                                        // Comprovacio de stock de productes
                                        if(isset($_POST['finalitzarCompra'])){
                                            $productesSeparats2 = explode(";", $_SESSION["productesSeleccionats"]);
                                            $quantitatLlista2 = (count($productesSeparats2));
                                            $stockActualment = 0;
                                            
                                            for ($i=0; $i < $quantitatLlista2; $i++) {
                                
                                                // Comprovacio del stock actual del producte
                                                $sql2 = "SELECT stock FROM producte WHERE codiProducte LIKE $productesSeparats2[$i]";
                                                $r2 = mysqli_query($con,$sql2);
                                
                                                while($fila2 = mysqli_fetch_assoc($r2)){
                                                    foreach ($fila2 as $key => $value) {
                                                        $stockActualment = $value;
                                                    }
                                                }

                                                // Comptador de comandes fetes 
                                                $sql8 = "SELECT COUNT(*) FROM compra";
                                                $r8 = mysqli_query($con,$sql2);

                                                while($fila8 = mysqli_fetch_assoc($r8)){
                                                    foreach ($fila8 as $key => $value) {
                                                        $comandesFetes = $value;
                                                    }
                                                }

                                                // Seleccio de l'ultim codi de compra amb el email del usuari actual i ordenant per codi de compra
                                                $sql9 = "SELECT codiCompra FROM compra WHERE email LIKE '$emailUsuariActual' ORDER BY codiCompra";
                                                $r9 = mysqli_query($con,$sql9);

                                                while($fila9 = mysqli_fetch_assoc($r9)){
                                                    foreach ($fila9 as $key => $value) {
                                                        $comandaUsuari = $value;
                                                    }
                                                }
                                
                                                // Resta que treu un producte del stock actual per registrar-lo en la base de dades
                                                $stockActualment = $stockActualment - 1;
                                                
                                                // SQL que treu un producte de la base de dades seleccionat
                                                $sql = "update producte set stock='$stockActualment' where codiProducte = '$productesSeparats2[$i]'";
                                                $r = mysqli_query($con,$sql);

                                                // SQL per tenir un registre de les compres que es fan a la botiga
                                                $sql4 = "insert into comanda(codiCompra, codiProducte) values($comandaUsuari,$productesSeparats2[$i])";
                                                $r4 = mysqli_query($con,$sql4);
                                            }
                                            // Realitzar la compra i eliminar les sesions del usuaris, compra i la sessio i retornar a la pagina de iniciar sessio
                                            unset($_SESSION["usuari"]);
                                            if (isset($_SESSION['admin'])){
                                                $cliente = $_SESSION['admin'];
                                            }
                                            unset($_SESSION['productesSeleccionats']);
                                            session_destroy();
                                            tornar();
                                        }
                                        
                                        // Creacio de la llista de la compra dins de una taula
                                        if (isset($_SESSION['productesSeleccionats'])){
                                            $productesSeparats = explode(";", $_SESSION["productesSeleccionats"]);
                                            $quantitatLlista = (count($productesSeparats));
                                            for ($i=0; $i < $quantitatLlista; $i++) {
                                                
                                                $sql = "SELECT * FROM producte WHERE codiProducte LIKE $productesSeparats[$i]";
                                                $r = mysqli_query($con,$sql);
                                                
                                                echo "<table class='taula col-lg-10 col-md-10 mx-auto'>";
                                                while($fila = mysqli_fetch_assoc($r)){
                                                    $tipusImatge = $fila['tipusImatge'];
                                                    $dadesImatge = $fila['dadesImatge'];
                                                    echo "<tr>";
                                                    echo "<td>";
                                                    echo '<img class="imgLlista" src="data:'.$tipusImatge.';base64,'.base64_encode($dadesImatge).'">';
                                                    echo "</td>";
                                                    echo "<th>";
                                                    echo "Nom: ";
                                                    echo "</th>";
                                                    echo "<td>";
                                                    echo $fila['nom'];
                                                    echo "</td>";
                                                    echo "<th>";
                                                    echo "Descripcio: ";
                                                    echo "</th>";
                                                    echo "<td>";
                                                    echo $fila['descripcio'];
                                                    echo "</td>";
                                                    echo "<th>";
                                                    echo "Preu: ";
                                                    echo "</th>";
                                                    echo "<td>";
                                                    echo $fila['preu'];
                                                    echo " euros";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                    echo "<br>";
                                                    // Suma del preu en total de tots els productes
                                                    $suma = $suma + $fila['preu'];
                                                }
                                            }
                                            echo "</table>";
                                            echo "<br>";
                                            // Aquesta part mostra el total del preu de la llista
                                            echo "<p class='totalLlista'><strong>Total: </strong>";
                                            echo "$suma";
                                            echo " euros.</p>";
                                            echo "<form action='#' method='post' class='contact-form webform' data-aos-delay='150' role='form'>";
                                            echo "<br>";
                                            echo "<button class='form-control' id='submit-button' name='finalitzarCompra'>Finalitzar Compra</button>";
                                            echo "<small>Un cop presionis el boto de Finalitzar Compra, et demanarem les dades de la teva targeta bancaria. ";
                                            echo "<img src='./images/targetes.png' width='50px' heigth='50px'>";
                                            echo "</form>";
                                        } else {
                                            echo "<p>No has seleccionat cap producte.</p>";
                                        }
                                    ?>
                              </div>
                         </div>
                    </div>
               </div>
     </section>

     <!-- =====Footer de la pagina===== -->
     <footer class="site-footer">
          <div class="container">
               <div class="row">
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

     <!-- =====Scripts de la pagina===== -->
     <script src="js/jquery.min.js"></script>
     <script src="js/bootstrap.min.js"></script>
     <script src="js/aos.js"></script>
     <script src="js/smoothscroll.js"></script>
     <script src="js/custom.js"></script>

</body>
</html>