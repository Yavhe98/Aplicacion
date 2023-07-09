<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Simulador Solar</title>

        <!-- Hoja de estilos para el mapa proporcionada por mapbox-->
        <!--link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.53.1/mapbox-gl.css' rel='stylesheet' /-->

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

        <!-- Bootstrap JS -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <?php 
            session_start();
            //$_POST['edificio'] = isset($_POST['edificio']) ? $_POST['edificio'] : 'citic'; 
        ?>

    </head>


    <script>
        $(document).ready(function() {
            $('form').submit(function(event) {
                event.preventDefault(); // Evitar el envío del formulario

                var eficiencia = $('#eficiencia').val();
                var area = $('#area').val();
                var edificio = $('#edificio').val();
                document.querySelector('#prueba').classList.remove('d-none');
                document.querySelector('.text').innerText='Buscando configuración más óptima';
                $.ajax({
                    type: 'POST',
                    url: 'ejecutar_generacion.php',
                    data: {
                        eficiencia: eficiencia,
                        area: area,
                        edificio: edificio
                    },
                    success: function(response) {
                        // Procesar la respuesta del servidor
                        document.querySelector('#prueba').innerText='';
                        $('#resultado').html(response);
                    }
                });
            });
        });
    </script>


    <body class="sb-nav-fixed" style="background-image: url('assets/img/pantalla_inicio.jpg'); background-size: cover; background-repeat: no-repeat;">
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
                        <h1 class="mt-4">Energía Renovable</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Placas solares</li>
                        </ol>
                        <!------------------------------------------------------------------------------------------------------------------------------------>
                        
                        <form action="#" method="POST">

                            <div class="row">
                                <div class="col-xl-4 col-md-6">
                                    <div class="card bg-primary text-white mb-4">
                                        <div class="card-body">Area del panel</div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <input type="number" name="area" id="area" step="0.1" value=1.50 required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="card bg-warning text-white mb-4">
                                        <div class="card-body">Eficiencia del panel</div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <input type="number" name="eficiencia" id="eficiencia" step="1"value=20 required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="card bg-info text-white mb-4">
                                        <div class="card-body">Edificio</div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                        <select class="form-control" id="edificio" name="edificio">
                                            <option value="citic" <?php if(isset($_POST['edificio']) && $_POST['edificio'] === 'citic') echo 'selected'; ?>>Citic</option>
                                            <option value="cmaximo" <?php if(isset($_POST['edificio']) && $_POST['edificio'] === 'cmaximo') echo 'selected'; ?>>Cmaximo</option>
                                            <option value="instrumentacion" <?php if(isset($_POST['edificio']) && $_POST['edificio'] === 'instrumentacion') echo 'selected'; ?>>Instrumentacion</option>
                                            <option value="mentecerebro" <?php if(isset($_POST['edificio']) && $_POST['edificio'] === 'mentecerebro') echo 'selected'; ?>>Mente y Cerebro</option>
                                            <option value="politecnico" <?php if(isset($_POST['edificio']) && $_POST['edificio'] === 'politecnico') echo 'selected'; ?>>Politecnico</option>
                                            <option value="politicas" <?php if(isset($_POST['edificio']) && $_POST['edificio'] === 'politicas') echo 'selected'; ?>>Politicas</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>

                                <center>
                                    <div class="col-xl-6 col-md-6">
                                        <div class="card bg-dark text-green mb-4">
                                            <input class="card-body" type="submit" value="Enviar">
                                            <div id="loadingAnimation" class="loading hidden"></div>
                                        </div>
                                    </div>
                                    <div id='prueba' class='d-none'>
                                        <img src="/assets/img/charging.gif" alt="" width='10%'>
                                        <p class='text'></p>
                                    </div>
                                </center>
                            </div>
                        </form>
                        <div id="resultado"></div>

                        
                        <!-------------------------------------------------------------------------------------------------------------------------------------->    
                        
                    </div>
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
        <?php //include("data/chart-bar-demo.php");?>
        
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
