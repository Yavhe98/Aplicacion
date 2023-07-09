<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Create and style clusters</title>
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
    body { margin: 0; padding: 0; }
    #map { position: absolute; top: 0; bottom: 0; width:90%; height:90%; margin:5%;}
    #yearSelector {
        width: 100%;
        margin-bottom: 20px;
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
                        <div class="sb-sidenav-menu-heading">Addons</div>
                        <a class="nav-link" href="contacto.php">
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
        
        <div id='layoutSidenav_content'>
            <main>
                <div class="container-fluid px-4">
                    <!--h1 class="mt-4">Mapa</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">De Granada</li>
                    </ol-->
                    
                    <div class="row">
                        <div class="col-xl-12">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>



    <script src="js/scripts.js"></script>

</body>
</html>