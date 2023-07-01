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

            // Por defecto se mostrará el rango de fechas desde hace un mes hasta el dia de hoy
            $_POST['minDate'] = isset($_POST['minDate']) ? $_POST['minDate'] : '2015-01-01 00:00';
            $_POST['maxDate'] = isset($_POST['maxDate']) ? $_POST['maxDate'] : '2015-12-31 00:00';
            $_POST['edificio'] = isset($_POST['edificio']) ? $_POST['edificio'] : 'citic';
            $_POST['counter'] = isset($_POST['counter']) ? $_POST['counter'] : 5;
        ?>

        <style>
            .checkbox-inline {
            display: inline-block;
            margin-right: 10px;
            }
        </style>

    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Energía Renovable</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
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
            </ul>
        </nav>
        
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">

                            <div class="sb-sidenav-menu-heading">Principal</div>
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
                            <div class="sb-sidenav-menu-heading">Addons</div>
                            <a class="nav-link" href="charts.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Contacto
                            </a>
                            <a class="nav-link" href="tables.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-info"></i></div>
                                Acerca de
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
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

                        
                        <form action="#" method="POST">

                            <div class="row">

                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="selector">Edificio:</label>
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

                            </div>

                            <div class="row">

                                <div class="col-xl-6">
                                    <label for="fecha-inicio">Desde:</label>
                                    <input type="datetime-local" class="form-control" id="minDate" name="minDate" value="<?php echo $_POST["minDate"];?>">
                                </div>

                                <div class="col-xl-6">
                                    <label for="fecha-fin">Hasta:</label>
                                    <input type="datetime-local" class="form-control" id="maxDate" name="maxDate" value="<?php echo $_POST["maxDate"];?>">
                                </div>

                            </div>

                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="grafica[]" value="consumo" checked> Consumo
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="grafica[]" value="generacion"> Generación
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </form>


                        <script>
                            $(document).ready(function () {
                                var dateFormat = "yy-mm-dd";
                                var startDate = new Date(2015, 0, 1);
                                var endDate = new Date(2022, 11, 31);
                                var counter = <?php echo json_encode($_POST["counter"]); ?>;

                                $("#fecha-inicio").datepicker({
                                    dateFormat: dateFormat,
                                    defaultDate: startDate
                                });

                                $("#fecha-fin").datepicker({
                                    dateFormat: dateFormat,
                                    defaultDate: endDate
                                });

                                $("#slider-range").slider({
                                    range: true,
                                    min: startDate.getTime(),
                                    max: endDate.getTime(),
                                    values: [startDate.getTime(), endDate.getTime()],
                                    slide: function (event, ui) {
                                        var minDate = new Date(ui.values[0]);
                                        var maxDate = new Date(ui.values[1]);

                                        $("#fecha-inicio").datepicker("setDate", minDate);
                                        $("#fecha-fin").datepicker("setDate", maxDate);
                                    }
                                });


                            });

                            document.addEventListener("DOMContentLoaded", function () {
                                var counter = <?php echo json_encode($_POST["counter"]);?>;
                                var counterElement = document.getElementById("counter");
                                var counterInput = document.getElementById("counter-input");
                                var btnAdd = document.getElementById("btn-add");
                                var btnRemove = document.getElementById("btn-remove");

                                btnAdd.addEventListener("click", function () {
                                    counter++;
                                    counterElement.textContent = counter;
                                    counterInput.value = counter;
                                });

                                btnRemove.addEventListener("click", function () {
                                    if (counter > 0) {
                                        counter--;
                                        counterElement.textContent = counter;
                                        counterInput.value = counter;
                                    }
                                });
                            });
                        </script>


                        <!-------------------------------------------------------------------------------------------------------------------------------------->

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Area Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myLineChart" width="100%" height="40%"></canvas></div>
                                </div>
                            </div>
                        </div>

                        <!-------------------------------------------------------------------------------------------------------------------------------------->    
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DataTable Example
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Start date</th>
                                            <th>Salary</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Start date</th>
                                            <th>Salary</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>
                                            <td>Tiger Nixon</td>
                                            <td>System Architect</td>
                                            <td>Edinburgh</td>
                                            <td>61</td>
                                            <td>2011/04/25</td>
                                            <td>$320,800</td>
                                        </tr>
                                        <tr>
                                            <td>Garrett Winters</td>
                                            <td>Accountant</td>
                                            <td>Tokyo</td>
                                            <td>63</td>
                                            <td>2011/07/25</td>
                                            <td>$170,750</td>
                                        </tr>
                                        <tr>
                                            <td>Ashton Cox</td>
                                            <td>Junior Technical Author</td>
                                            <td>San Francisco</td>
                                            <td>66</td>
                                            <td>2009/01/12</td>
                                            <td>$86,000</td>
                                        </tr>
                                        <tr>
                                            <td>Cedric Kelly</td>
                                            <td>Senior Javascript Developer</td>
                                            <td>Edinburgh</td>
                                            <td>22</td>
                                            <td>2012/03/29</td>
                                            <td>$433,060</td>
                                        </tr>
                                        <tr>
                                            <td>Airi Satou</td>
                                            <td>Accountant</td>
                                            <td>Tokyo</td>
                                            <td>33</td>
                                            <td>2008/11/28</td>
                                            <td>$162,700</td>
                                        </tr>
                                        <tr>
                                            <td>Brielle Williamson</td>
                                            <td>Integration Specialist</td>
                                            <td>New York</td>
                                            <td>61</td>
                                            <td>2012/12/02</td>
                                            <td>$372,000</td>
                                        </tr>
                                        <tr>
                                            <td>Herrod Chandler</td>
                                            <td>Sales Assistant</td>
                                            <td>San Francisco</td>
                                            <td>59</td>
                                            <td>2012/08/06</td>
                                            <td>$137,500</td>
                                        </tr>
                                        <tr>
                                            <td>Rhona Davidson</td>
                                            <td>Integration Specialist</td>
                                            <td>Tokyo</td>
                                            <td>55</td>
                                            <td>2010/10/14</td>
                                            <td>$327,900</td>
                                        </tr>
                                        <tr>
                                            <td>Colleen Hurst</td>
                                            <td>Javascript Developer</td>
                                            <td>San Francisco</td>
                                            <td>39</td>
                                            <td>2009/09/15</td>
                                            <td>$205,500</td>
                                        </tr>
                                        <tr>
                                            <td>Sonya Frost</td>
                                            <td>Software Engineer</td>
                                            <td>Edinburgh</td>
                                            <td>23</td>
                                            <td>2008/12/13</td>
                                            <td>$103,600</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
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
        <?php include("data/grafica-principal.php");?>
        <?php //include("data/chart-bar-demo.php");?>
        
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
