<!DOCTYPE html>
<html lang="en" x-data="{ sidebarCollapsed: false }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | TaniHub</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous">
    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.0/dist/cdn.min.js"></script>
    <style>
        body {
            display: flex;
            margin: 0;
            text-decoration: none;
        }

        #sidebar {
            min-height: 100vh;
            width: 250px;
            transition: width 0.3s;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        #sidebar.collapsed {
            width: 70px;
        }

        #content {
            flex-grow: 1;
            transition: margin-left 0.3s;
            padding-left: 20px;
        }

        #content.collapsed {
            margin-left: 70px;
        }

        .toggle-btn {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 1;
        }

        .logo {
            width: 40px;
            cursor: pointer;
        }

        .sidebar-item {
            padding: 10px 15px;
            display: flex;
            align-items: center;
        }

        .sidebar-item .icon {
            min-width: 30px;
        }

        .sidebar-item .text {
            display: inline-block;
            transition: opacity 0.3s;
        }

        #sidebar.collapsed .text {
            opacity: 0;
        }

        .logout-btn {
            margin: 10px;
            padding: 10px 15px;
            text-align: center;
        }

        .logout-btn .icon {
            min-width: 30px;
        }

        .logout-btn .text {
            display: inline-block;
            transition: opacity 0.3s;
        }
    </style>
</head>

<body>
    <div id="sidebar" class="bg-dark text-white" :class="{ 'collapsed': sidebarCollapsed }">
        <div>
            <div class="sidebar-item">
                <img src="{{ asset('image/logo.png') }}" alt="Logo" class="logo toggle-btn" @click="sidebarCollapsed = !sidebarCollapsed">
                <span class="sidebar-item text fs-3 p-0 ms-5">TaniHub</span>
            </div>
            <ul class="list-unstyled">
                <a href="" class="text-decoration-none"><li class="sidebar-item text-white"><span class="icon"><i class="bi bi-house-door-fill"></i></span><span class="text">Dashboard</span></li></a>
                <a href="" class="text-decoration-none"><li class="sidebar-item text-white"><span class="icon"><i class="bi bi-info-circle-fill"></i></span><span class="text">Device</span></li></a>
                <a href="" class="text-decoration-none"><li class="sidebar-item text-white"><span class="icon"><i class="bi bi-gear-fill"></i></span><span class="text">Account</span></li></a>
                <a href="" class="text-decoration-none"><li class="sidebar-item text-white"><span class="icon"><i class="bi bi-envelope-fill"></i></span><span class="text">Contact</span></li></a>
            </ul>
        </div>
        <div class="logout-btn">
            <span class="btn btn-danger text"><i class="bi bi-box-arrow-right me-2"></i>Logout</span>
        </div>
    </div>

    <div id="content" class="p-4" :class="{ 'collapsed': sidebarCollapsed }">
        @yield('content')
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>
