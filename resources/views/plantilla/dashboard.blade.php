<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../plantilla/css/sidebar.css">

    @yield('css')
    <style type="text/css">
        .btn-modificaciones {
            background-color: rgba(255, 214, 29, 0.418);
            border: 0.6px solid gray;
            transition-duration: 0.4s;
        }

        .btn-modificaciones:hover {
            background-color: rgba(223, 190, 43, 0.651);
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="logo_content">
            <div class="logo">
                <div class="logo_name">CONTABILIDAD UNT</div>
            </div>
            <i class='bx bx-menu' id="btn-menu"></i>
        </div>
        <ul class="nav_list">
            @include('plantilla.nav')
        </ul>
    </div>

    <div class="home_content">
        <nav class="navbar navcustom">
            <div class="container-fluid" style="display:flex; justify-content:flex-end; margin-right:10px;">
                <div class="col-4 col-sm-2 col-lg-1" style="text-align:center;">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle aOnline" href="#" id="navbarDropdownMenuLink"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Online
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li>
                                    @include('plantilla.logout')
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="content d-flex align-items-center">
            <div class="container-fluid">
                <div class="card text-center shadow bg-white rounded">
                    @yield('contenido')
                </div>
            </div>
        </div>
        <div class="bottom-fixed">
            <strong>Copyright &copy; 2022.</strong> By: Rios Reyes & Vasquez Chiclayo & Dr. Juan Carlos Miranda Robles.
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script type="text/javascript">
        let btn = document.querySelector('#btn-menu');
        let sidebar = document.querySelector('.sidebar');
        btn.onclick = function() {
            sidebar.classList.toggle('active');
        }
    </script>

</body>
@yield('js')

</html>
