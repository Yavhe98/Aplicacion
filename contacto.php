<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Contacto</title>

        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

        <!-- Bootstrap JS -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <!-- Para el selector de rango de fechas-->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Energía Renovable</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

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
                        <h1 class="mt-4">Contacto</h1>
                        <!--ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Placas solares</li>
                        </ol-->
                        <!------------------------------------------------------------------------------------------------------------------------------------>

                        <form id="contact-form">

                            <div class=row>
                                <label for="name">Nombre:</label>
                                <input type="text" id="name" name="name" required>
                            </div>

                            <div class=row>
                                <label for="email">Correo electrónico:</label>
                                <input type="email" id="email" name="email" required>
                            </div>

                            <div class=row>
                                <label for="message">Mensaje:</label>
                                <textarea id="message" name="message" rows="7" required></textarea>
                            </div>
    <hr/>
                            <input type="submit" value="Enviar">

                        </form>

                        <script>
                            document.getElementById("contact-form").addEventListener("submit", function(event) {
                            event.preventDefault(); // Evita el envío del formulario predeterminado

                            // Obtiene los valores de los campos del formulario
                            var name = document.getElementById("name").value;
                            var email = document.getElementById("email").value;
                            var message = document.getElementById("message").value;

                            // Construye el enlace de correo electrónico con los valores del formulario
                            var mailtoLink = "mailto:kikemerino@correo.ugr.es" +
                            "?subject=" + encodeURIComponent("Mensaje de contacto") +
                            "&body=" + encodeURIComponent("Nombre: " + name + "\n\nCorreo electrónico: " + email + "\n\nMensaje: " + message);

                            // Abre el enlace de correo electrónico en una nueva ventana o pestaña
                            window.open(mailtoLink, "_blank");
                        });

                        </script>

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
        
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>







