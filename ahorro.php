<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Calculadora ahorro</title>

        <!-- Hoja de estilos para el mapa proporcionada por mapbox-->
        <!--link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.53.1/mapbox-gl.css' rel='stylesheet' /-->

        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

        <!-- Bootstrap JS -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <!-- Para el selector de rango de fechas-->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <!--link href="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css" rel="stylesheet">
        <script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script-->
        <?php
            include("bd.php");
            
            $_POST['edificio'] = isset($_POST['edificio']) ? $_POST['edificio'] : 'citic';
            $_POST['placas'] = isset($_POST['placas']) ? $_POST['placas'] : 5;    
            
        ?>


    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Energía Renovable</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <!--form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form-->
            <!-- Navbar
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#!">Logout</a></li>
                    </ul>
                </li>
            </ul-->
        </nav>
        
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">

                        <div class="sb-sidenav-menu-heading">Principal</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-map"></i></div>
                                Inicio
                            </a>
                            
                            
                            <a class="nav-link" href="mapa.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-map"></i></div>
                                Mapa
                            </a>

                            <div class="sb-sidenav-menu-heading">Estadisticas</div>
                            <a class="nav-link collapsed" href="graficas.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-simple"></i></div>
                                Graficas
                            </a>

                            <a class="nav-link collapsed" href="ahorro.php" >
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Calculadora de ahorro
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>

                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Asistencia</div>
                            <a class="nav-link" href="contacto.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Contacto
                            </a>
                            
                        </div>
                    </div>
                    
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Simulacion</h1>
                        <!--ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Placas solares</li>
                        </ol-->
                        <!------------------------------------------------------------------------------------------------------------------------------------>

                        <form action='#' method="POST">
                            <div class="row">
                            <div class="col-xl-6">
                                <div class="form-group">
                                <label for="edificio">Seleccione edificio:</label>
                                <select class="form-control" id="edificio" name="edificio">
                                    <option value="citic">Citic</option>
                                    <option value="cmaximo">Cmaximo</option>
                                    <option value="instrumentacion">Instrumentacion</option>
                                    <option value="mentecerebro">Mente y Cerebro</option>
                                    <option value="politecnico">Politecnico</option>
                                    <option value="politicas">Politicas</option>
                                </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Cambiar gráfica</button>

                        </form>

                    </div>

                    <!-- Aquí va tu gráfica de Bootstrap -->

                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                    $(document).ready(function() {
                        // Captura el evento "change" en los campos del formulario
                        $("#edificio, #paneles").change(function() {
                        // Obtén los nuevos valores del formulario
                        var edificio = $("#edificio").val();
                        var paneles = $("#paneles").val();

                        // Actualiza la gráfica con los nuevos datos
                        actualizarGrafica(edificio, paneles);
                        });
                    });
                    </script>



                        <!-------------------------------------------------------------------------------------------------------------------------------------->

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Con el tipo de placa actual, y a 0,34€/kWh, se tendrá el siguiente ahorro
                                </div>
                                <div class="card-body"><canvas id="myAhorroChart" width="100%" height="30%"></canvas></div>
                            </div>
                        </div>
                    </div>

                        <!-------------------------------------------------------------------------------------------------------------------------------------->    
                        
                </main>

                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <?php include("data/grafica-ahorro.php");?>
        
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
