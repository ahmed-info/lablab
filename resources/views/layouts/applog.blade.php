<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Labor Of Ministry</title>
        <link href="{{asset('css/dashboard_style.css')}}" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="app">
        
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            
            <a class="navbar-brand ps-3" href="#">ministry of labor</a>

            
            <!-- Navbar Search-->
            
            <!-- Navbar-->
         
        </nav>
        <form class="input-group" method="GET" action="{{route('search')}}">
            <div class="form-group">
              <input type="search" id="form1" name="getSearch" placeholder="Search" class="form-control" />

            </div>
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-search"></i>
            </button>
          </form>
        <div id="layoutSidenav">
            
            <div id="layoutSidenav_nav">
                
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    
                    <div class="sb-sidenav-menu">

                        
                        <div class="nav">
                            
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <h6><a href="#">Logout</a> </h6>
                        
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                @yield('content')
            <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2021</div>
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
        
    </div>
</body>
</html>
