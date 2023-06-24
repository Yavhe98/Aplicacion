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

        <!-- Para enviar datos de fecha en tiempo real-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Para el selector de rango de fechas-->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <!--link href="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css" rel="stylesheet">
        <script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script-->

        <style>
            .switch {
              position: relative;
              display: inline-block;
              width: 50px;
              height: 26px;
              margin: 10px;
            }
        
            .switch input {
              opacity: 0;
              width: 0;
              height: 0;
            }
        
            .slider {
              position: absolute;
              cursor: pointer;
              top: 0;
              left: 0;
              right: 0;
              bottom: 0;
              background-color: #ccc;
              border-radius: 26px;
              -webkit-transition: .4s;
              transition: .4s;
            }
        
            .slider:before {
              position: absolute;
              content: "";
              height: 20px;
              width: 20px;
              left: 3px;
              bottom: 3px;
              background-color: white;
              border-radius: 50%;
              -webkit-transition: .4s;
              transition: .4s;
            }
        
            input:checked + .slider {
              background-color: #2196F3;
            }
        
            input:focus + .slider {
              box-shadow: 0 0 1px #2196F3;
            }
        
            input:checked + .slider:before {
              -webkit-transform: translateX(20px);
              -ms-transform: translateX(20px);
              transform: translateX(20px);
            }
        
            /* Estilo adicional para personalizar el aspecto del texto */
            .switch-label {
              margin-left: 10px;
              font-weight: bold;
            }
            /* Ajusto el ancho del selector de edificios */
            #edificio {
                width: 200px;
                margin-bottom: 10%;
                margin-top: 5%;
            }

            
            #map {
                position: absolute;
                top: 0;
                bottom: 0;
                width: 50%;
                height: 50%;
                margin-top: 5%;
            }

            #slider-range{
                margin-top: 30px;
                margin-bottom: 30px;
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
                            <a class="nav-link collapsed" href="#">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-simple"></i></div>
                                Graficas
                            </a>

                            <a class="nav-link collapsed" href="#" >
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
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Placas solares</li>
                        </ol>
                        <!------------------------------------------------------------------------------------------------------------------------------------>
                        
                        <div class="row">

                            
                            <div class="col-xl-3 col-md-6">
                                <form>
                                    <label for="opcion">Elige un edficio:</label>
                                    <select id="opcion" name="opcion">
                                        <option value="citic">Citic-UGR</option>
                                        <option value="cmaximo">Cmaximo</option>
                                        <option value="mentecerebro">Mente y Cerebro</option>
                                        <option value="instrumentacion">Intrumentacion</option>
                                        <option value="politecnico">Politécnico</option>
                                        <option value="politicas">Políticas</option>
                                    </select>
                                </form>
                            </div>

                            <script>
                                // Obtener el elemento select
                                var select = document.getElementById("opcion");
                        
                                // Manejar el evento cuando cambia la opción seleccionada
                                select.addEventListener("change", function() {
                                    // Obtener el valor seleccionado
                                    var opcionSeleccionada = select.value;
                                    
                                    // Realizar la solicitud AJAX al archivo php
                                    $.ajax({
                                        url:"data/chart-bar-demo.php",
                                        type: "POST",
                                        data: { opcion: opcionSeleccionada},
                                        success: function(response) {
                                            console.log("Valor enviado al archivo PHP: " + opcionSeleccionada);
                                            // Realizar acciones adicionales según sea necesario
                                        },
                                        error: function() {
                                            console.log("Error al enviar el valor al archivo PHP");
                                        }
                                    });
                                });
                            </script>

                            <div class="col-xl-3 col-md-6">
                                <button onclick="addPanel()" style="display: block; margin: 0 auto;">(+) Añadir placa</button>
                                <button onclick="removePanel()" style="display: block; margin: 0 auto;">(-) Quitar placa</button>
                            </div>

                            <script>
                              function addPanel() {
                                // Aquí puedes escribir el código para la acción que deseas que ocurra
                                console.log("Acción realizada");
                                // Puedes agregar más líneas de código para realizar otras tareas
                              }

                              function removePanel(){
                                // Codigo que quite la placa solar del edificio
                              }
                            </script>

                        </div>
                        

                        <!--div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Invierno</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">Ver detalles</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Primavera</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">Ver detalles</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Verano</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">Ver detalles</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Otoño</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">Ver detalles</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div-->

                        <!-------------------------------------------------------------------------------------------------------------------------------------->

                        <div class="row">
                            <div class="col-xl-12">

                                <label for="fecha-inicio">Desde:</label>
                                <input type="text" id="fecha-inicio" name="fecha-inicio" value="2015-1-1">

                                <label for="fecha-fin">Hasta:</label>
                                <input type="text" id="fecha-fin" name="fecha-fin" value="2022-12-31">

                                <div id="slider-range"></div>
                            </div>
                        </div>

                        <script>
                            $(document).ready(function() {
                              var dateFormat = "yy-mm-dd";
                              var startDate = new Date(2015, 1, 1); // Modificado el índice del mes a 0 para enero
                              var endDate = new Date(2022, 11, 31); // Modificado el índice del mes a 11 para diciembre
                          
                              $("#fecha-inicio").datepicker({
                                dateFormat: dateFormat,
                                defaultDate: startDate,
                                onSelect: function(selectedDate) {
                                  $("#slider-range").slider("values", 0, selectedDate);
                                  sendDates();
                                }
                              });
                          
                              $("#fecha-fin").datepicker({
                                dateFormat: dateFormat,
                                defaultDate: endDate,
                                onSelect: function(selectedDate) {
                                  $("#slider-range").slider("values", 1, selectedDate);
                                  sendDates();
                                }
                              });
                          
                              $("#slider-range").slider({
                                range: true,
                                min: startDate.getTime(),
                                max: endDate.getTime(),
                                values: [startDate.getTime(), endDate.getTime()],
                                slide: function(event, ui) {
                                  var minDate = new Date(ui.values[0]);
                                  var maxDate = new Date(ui.values[1]);
                          
                                  $("#fecha-inicio").datepicker("setDate", minDate);
                                  $("#fecha-fin").datepicker("setDate", maxDate);
                                  sendDates();
                                }
                              });
                          
                              // Obtener las fechas seleccionadas y enviarlas a través de AJAX
                              function sendDates() {
                                var startDate = $("#fecha-inicio").val();
                                var endDate = $("#fecha-fin").val();
                          
                                $.ajax({
                                  url: "prueba.php",
                                  method: "POST",
                                  data: { startDate: startDate, endDate: endDate },
                                  success: function(response) {
                                    console.log("Fechas enviadas: " + response);
                                  }
                                });
                              }
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
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
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

        <!--script src="https://api.tiles.mapbox.com/mapbox-gl-js/v0.53.1/mapbox-gl.js"></script-->
        <script src="js/scripts.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <!--script src="data/chart-area-demo.js"></script-->
        <?php require "data/chart-area-demo.php"?>
        <?php require "data/chart-bar-demo.php"?>
        
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
