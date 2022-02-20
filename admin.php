<!DOCTYPE html>
<html lang="es">
<link rel="shortcut icon" href="./images/logo.png">
<head>
    <!-- Conexio amb la base de dades -->
    <?php
        include 'connexio.php';

        // Valors inicialitzats per saber quan s'inserta, elimina o modifica un producte
        $procedimentInsertarCorrecte = 0;
        $procedimentModificatCorrecte = 0;
        $procedimentEliminarCorrecte = 0;

        // Insertar el producte
        if(isset($_POST['submit'])){
            date_default_timezone_set("Europe/Madrid");
            $data = date("d/m/y H:i:s");
            $imgContenido = $_FILES["foto"]["tmp_name"];
            $foto = addslashes(file_get_contents($imgContenido));
            $posicio = strpos($_FILES["foto"]["type"], '/');
            $extension = substr($_FILES["foto"]["type"], $posicio);
            $correcte = false;
            // Comprovacio de les imatges
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
        if($correcte == true){
            $nom = $_POST["cf-nom"];
            $descripcio = $_POST["cf-descripcio"];
            $preu = $_POST["cf-preu"];
            $stock = $_POST["cf-stock"];

            $sql = "insert into producte(nom,descripcio,preu,stock,dadesImatge,tipusImatge,contingut) values('" .$nom. "','" .$descripcio. "','" .$preu. "','" .$stock. "','" .$foto. "','" .$extension. "','null')";
            $r = mysqli_query($con,$sql);

            if(!mysqli_error($con)){
                // Mostrar la confirmacio de la insercio del producte
                $procedimentInsertarCorrecte = 1;
            }
        } else {
            echo "El arxiu te que ser png, jpg, jpeg o gif. ";
        }
    }

    // Eliminar un producte

    if(isset($_POST['submit2'])){
        $eliminarproducte = $_POST['cf-eliminarproducte'];
        $sql = "delete from producte where nom like '$eliminarproducte'";
        $r = mysqli_query($con,$sql);

        if(mysqli_error($con)){
            echo "ERROR: ".mysqli_error($con);
        } else {
            // Mostrar la confirmacio de la eliminacio del producte
            $procedimentEliminarCorrecte = 1;
        }
    }

    // Modificar un producte

    if(isset($_POST['submit3'])){
        $seccio3 = $_POST["seccio3"];
        date_default_timezone_set("Europe/Madrid"); 
        $imgContenido2 = $_FILES["foto2"]["tmp_name"];
        $foto2 = addslashes(file_get_contents($imgContenido2));
        $posicio2 = strpos($_FILES["foto2"]["type"], '/');
        $extension2 = substr($_FILES["foto2"]["type"], $posicio2);
        $correcte2 = false;
        if($extension2 == '/png'){
            $correcte2 = true;
        } else if ($extension2 == '/jpg'){
            $correcte2 = true;
        } else if ($extension2 == '/gif'){
            $correcte2 = true;
        } else if ($extension2 == '/jpeg'){
            $correcte2 = true;
        } else {
            $correcte2 = false;
        }
        if($correcte2 == true){
            $nom2 = $_POST["cf-nom2"];
            $descripcio2 = $_POST["cf-descripcio2"];
            $preu2 = $_POST["cf-preu2"];
            $stock2 = $_POST["cf-stock2"];

            $sql = "update producte set nom='$nom2', descripcio='$descripcio2', preu='$preu2', stock='$stock2', dadesImatge='$foto2', tipusImatge='$extension2' where nom like '$seccio3'";
            $r = mysqli_query($con,$sql);

            if(mysqli_error($con)){
                echo "ERROR: ".mysqli_error($con);
            } else {
                // Mostrar la confirmacio de la modificacio del producte
                $procedimentModificatCorrecte = 1;
            }
        } else {
            echo "El arxiu te que ser png, jpg, jpeg o gif. ";
        }
    }
        
        //Iniciar una nueva sesió o reanudar la existent.
        session_start();
        //Si existeix la sesió "cliente"..., la guardarem en una variable.
        if (isset($_SESSION['usuari'])){
            $usuari = $_SESSION['usuari'];
        }else{
            // Es canvia a la direccio del inici de sessio si no te cap usuari colocat correctament
            header('Location: index.php'); //Aqui lo redireccionem al lloc de iniciar sessió.
            die() ;
        }

        // Es comprova si el usuari es un usuari administrador
        $sql = "SELECT COUNT(*) FROM usuari WHERE nom LIKE '". $usuari ."' AND admin = 1";
        $r = mysqli_query($con,$sql);

        while($fila = mysqli_fetch_assoc($r)){
            foreach ($fila as $value) {
                $usuariAdminCreat = $value;
            }
        }

        if($usuariAdminCreat == 0){
            header('Location: index.php'); //Aqui lo redireccionem al lloc de iniciar sessió.
        }

        // Contador per saber si hi han productes o si no hi han
        $sql6 = "SELECT COUNT(*) FROM producte";
        $r6 = mysqli_query($con,$sql6);

        while($fila6 = mysqli_fetch_assoc($r6)){
            foreach ($fila6 as $value) {
                $contadordeProductes = $value;
            }
        }
    ?>

    <!-- =====Titul de la pagina===== -->
    <title>Admin | Configuració Productes</title>
    <!-- =====Estils de la pagina===== -->
        <style>
            table, tr, th, td{
                border: 1px solid #000000;
                padding: 10px;
            }
            
            .espai{
                padding-right: 960px;
            }

            .compraRealitzada{
            background-color: green;
            width: 100%;
            color: white;
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: center;
            }
        </style>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=Edge">
     <meta name="description" content="">
     <meta name="keywords" content="">
     <meta name="author" content="">
     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

     <!-- Conexions amb fitxers -->
     <link rel="stylesheet" href="css/bootstrap.min.css">
     <link rel="stylesheet" href="css/font-awesome.min.css">
     <link rel="stylesheet" href="css/aos.css">
     <link rel="stylesheet" href="css/tooplate-gymso-style.css">
</head>


<body data-spy="scroll" data-target="#navbarNav" data-offset="50">
    <!-- =====Menu desplegable===== -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <!-- Titul de la pagina -->
            <a class="navbar-brand" href="admin.php">Admin - Configuració Productes</a>

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
                        <a href="#about" class="nav-link smoothScroll">Insertar</a>
                    </li>
                    <li class="nav-item">
                        <a href="#eliminar" class="nav-link smoothScroll">Eliminar</a>
                    </li>
                    <li class="nav-item">
                        <a href="#modificar" class="nav-link smoothScroll">Modificar</a>
                    </li>
                    <li class="nav-item">
                        <a href="client.php" class="nav-link smoothScroll">Visió Usuari</a>
                    </li>
                    <li class="nav-item">
                        <a href="#productesActuals" class="nav-link smoothScroll">Productes Actuals</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

     <!-- =====Header de la pagina===== -->
     <section class="hero d-flex flex-column justify-content-center align-items-center" id="home">
            <div class="bg-overlay"></div>
               <div class="container">
                    <div class="row">
                         <div class="col-lg-8 col-md-10 mx-auto col-12">
                              <div class="hero-text mt-5 text-center">
                                    <!-- Titul principal de la pagina -->
                                    <h1 class="text-white" data-aos="fade-up" data-aos-delay="500">ADMINISTRADOR</h1>
                                    <h6 data-aos="fade-up" data-aos-delay="300"><?php echo "REGISTRE DE PRODUCTES" ?></h6><br>
                                    <p data-aos="fade-up" data-aos-delay="300">
                                        <!-- Comprobacio de la pagina -->
                                        <?php 

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
                                            
                                            if (!$con) {
                                                echo ("Conexio fallida " . mysqli_connect_error());
                                            } else{
                                                echo "Conectat Correctament. ";
                                            }
                                        ?>
                                    </p>
                                    <a href="#about" class="btn custom-btn bordered mt-3" data-aos="fade-up" data-aos-delay="700">Insertar Productes</a>
                                    <a href="#eliminar" class="btn custom-btn bordered mt-3" data-aos="fade-up" data-aos-delay="700">Eliminar Productes</a>
                                    <a href="#modificar" class="btn custom-btn bordered mt-3" data-aos="fade-up" data-aos-delay="700">Modificar Productes</a>
                                    <a href="#productesActuals" class="btn custom-btn bordered mt-3" data-aos="fade-up" data-aos-delay="700">Productes Actuals</a>
                                    <!-- Boto per finalitzar la sessio -->
                                    <?php
                                        if(isset($_POST['tancarSessio'])){
                                            unset($_SESSION["usuari"]);
                                            if (isset($_SESSION['admin'])){
                                                $cliente = $_SESSION['admin'];
                                            }
                                            unset($_SESSION['productesSeleccionats']);
                                            session_destroy();
                                            header('Location: index.php'); //Aqui lo redireccionem al lloc de iniciar sessió.
                                            die() ;
                                        }
                                        
                                    ?>
                                    <!-- Formulari del boto de finalitzar sessio -->
                                    <form action="#" method="post" class="contact-form webform" data-aos="fade-up" data-aos-delay="150" role="form">
                                        <br>
                                        <button class="form-control" id="submit-button" name="tancarSessio">Tancar Sessió</button>
                                    </form>
                              </div>
                         </div>
                    </div>
               </div>
     </section>

     <?php
        
        // Paragrafs amb el text que surt quan el administrador crea, modifica o elimina un producte
        if($procedimentInsertarCorrecte == 1){
            echo "<p class='compraRealitzada'>Producte creat correctament.</p>";   
        }

        if($procedimentModificatCorrecte == 1){
            echo "<p class='compraRealitzada'>Producte modificat correctament.</p>";   
        }

        if($procedimentEliminarCorrecte == 1){
            echo "<p class='compraRealitzada'>Producte eliminat correctament.</p>";   
        }
     ?>
     <br>
     <!-- Seccio amb una taula per poder veure tots els productes actualment -->
     <section class="d-flex flex-column justify-content-center align-items-center" id="productesActuals">
            <?php
                echo "<h1>PRODUCTES ACTUALS</h1>";

                if($contadordeProductes != 0){
                $sql3 = "SELECT nom, descripcio, stock, preu FROM producte";
                $r3 = mysqli_query($con,$sql3);

                echo "<table class='taula col-lg-10 col-md-10 mx-auto'>";
                while($fila4 = mysqli_fetch_assoc($r3)){
                        echo "<tr>";
                        echo "<th>";
                        echo "Nom: ";
                        echo "</th>";
                        echo "<td>";
                        echo $fila4["nom"];
                        echo "</td>";
                        echo "<th>";
                        echo "Descripcio: ";
                        echo "</th>";
                        echo "<td>";
                        echo $fila4["descripcio"];
                        echo "</td>";
                        echo "<th>";
                        echo "Stock ";
                        echo "</th>";
                        echo "<td>";
                        echo $fila4["stock"];
                        echo "</td>";
                        echo "<th>";
                        echo "Preu: ";
                        echo "</th>";
                        echo "<td>";
                        echo $fila4["preu"];
                        echo " euros";
                        echo "</td>";
                        echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No hi han productes registrats a la base de dades. ";
            }
                ?>
            </section>
            <br><br>

     <!-- Insertar un producte -->
     <section class="about section" id="about">
     <div class="container">
            <div class="ml-auto col-lg-12 col-md-12 col-12">
                <h2 class="mb-4 pb-2" data-aos="fade-up" data-aos-delay="150">Formulari de Inserció de Productes</h2>
                <!-- Formulari per insertar el producte -->
                <form method="post" class="contact-form webform" role="form" enctype="multipart/form-data">
                    <input type="text" class="form-control" name="cf-nom" placeholder="Nom del producte">
                    <textarea rows="3" cols="50" name="cf-descripcio" placeholder=" Descripció del producte"></textarea>
                    <input type="text" class="form-control" name="cf-preu" placeholder="Preu">
                    <input type="text" class="form-control" name="cf-stock" placeholder="Stock del Producte">
                    <input type="file" name="foto">
                    <button type="submit" class="form-control" id="submit-button" name="submit">Publicar</button>
                </form>
            </div>
        </div>
     </div>
     </section>
     <div class="container">
     <section id="eliminar">
         <br>
    <!-- Eliminar una producte amb el formulari per eliminar el producte -->
     <h2 class="mb-4 pb-2" data-aos="fade-up" data-aos-delay="150">Eliminar una producte</h2>
     <h3>Escolleig el producte que vols eliminar.</h3><br>
     <?php  
     if($contadordeProductes != 0){          
        $sql = "select nom from producte";
        $r = mysqli_query($con,$sql);

        echo "<form action='#' method='post'>";
        while($fila = mysqli_fetch_assoc($r)){
            foreach ($fila as $value) {
                echo "<input type='radio' name='cf-eliminarproducte' value='$value'> $value ";
            }
        }
        echo "<button type='submit' class='form-control' id='submit-button' name='submit2'>Eliminar</button>";
        echo "</form>";
    } else {
        echo "No hi ha ningun producte per eliminar. ";
    }
     ?>
     </div>
    </section>
    <br>
    <!-- Modificar una producte amb el formulari per modificar el producte -->
    <section class="about section" id="modificar">
        <br>
        <div class="container">
        <h2 class="mb-4 pb-2" data-aos="fade-up" data-aos-delay="150">Modificar una producte</h2>
        <h3>Escolleig el producte que vols modificar.</h3><br>
        <?php
            // Modificar les dades de la base de dades
            if($contadordeProductes != 0){
                $sql2 = "select nom from producte";
                $r = mysqli_query($con,$sql2);
            
                echo "<form method='post' role='form' enctype='multipart/form-data'>";
                echo "Si carregues les dades no t'oblidis de tornar a seleccionar el producte.<br><br>";
                echo "<select name='seccio3'>";
                while($fila = mysqli_fetch_assoc($r)){
                    foreach ($fila as $value) {
                        echo "<option value='$value'>$value</option>";
                    }
                }
                echo "</select>";
            } else {
                echo "No hi ha ningun producte per modificar. ";
            }

                ?>
                <!-- Boto que carrega les dades de la base de dades -->
                <button name="carregar">Carregar dades</button>
                <!-- Formulari amb les dades per modificar -->
                    <input type="text" class="form-control" name="cf-nom2" value="<?php if(isset($_POST['carregar'])){
                                                                                                        $titul = $_POST['seccio3'];
                                                                                                        $sql2 = "SELECT nom 
                                                                                                                FROM producte 
                                                                                                                WHERE nom LIKE '$titul'";
                                                                                                        $r = mysqli_query($con,$sql2);
                                                                                                    
                                                                                                        while($fila = mysqli_fetch_assoc($r)){
                                                                                                            foreach ($fila as $value) {
                                                                                                                echo $value;
                                                                                                            }
                                                                                                        }
                                                                                                    }
                                                                                                    ?>" placeholder="Nom del producte">
                    <textarea rows="3" cols="50" name="cf-descripcio2" placeholder=" Descripcio del producte"> <?php if(isset($_POST['carregar'])){
                                                                                                    $cos = $_POST['seccio3'];
                                                                                                    $sql2 = "SELECT descripcio
                                                                                                                FROM producte 
                                                                                                                WHERE nom LIKE '$cos'";
                                                                                                    $r = mysqli_query($con,$sql2);
                                                                                                
                                                                                                    while($fila = mysqli_fetch_assoc($r)){
                                                                                                        foreach ($fila as $value) {
                                                                                                            echo $value;
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                                ?></textarea>
                    <br>
                    <input type="text" class="form-control" name="cf-preu2" value="<?php if(isset($_POST['carregar'])){
                                                                                                        $titul = $_POST['seccio3'];
                                                                                                        $sql2 = "SELECT preu
                                                                                                                FROM producte 
                                                                                                                WHERE nom LIKE '$titul'";
                                                                                                        $r = mysqli_query($con,$sql2);
                                                                                                    
                                                                                                        while($fila = mysqli_fetch_assoc($r)){
                                                                                                            foreach ($fila as $value) {
                                                                                                                echo $value;
                                                                                                            }
                                                                                                        }
                                                                                                    }
                                                                                                    ?>" placeholder="Preu">
                    <input type="text" class="form-control" name="cf-stock2" value="<?php if(isset($_POST['carregar'])){
                                                                                                        $titul = $_POST['seccio3'];
                                                                                                        $sql2 = "SELECT stock
                                                                                                                FROM producte 
                                                                                                                WHERE nom LIKE '$titul'";
                                                                                                        $r = mysqli_query($con,$sql2);
                                                                                                    
                                                                                                        while($fila = mysqli_fetch_assoc($r)){
                                                                                                            foreach ($fila as $value) {
                                                                                                                echo $value;
                                                                                                            }
                                                                                                        }
                                                                                                    }
                                                                                                    ?>" placeholder="Stock del Producte">
                    <input type="file" name="foto2">
                    <button type="submit" class="form-control" id="submit-button" name="submit3">Modificar</button>
                </form>
            <br>
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