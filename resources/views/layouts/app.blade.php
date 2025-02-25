<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('assets/Logo.webp') }}">
    <title>Kasir</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/js/app.js'])

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- External Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/preline@latest/dist/preline.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://unpkg.com/flowbite@1.3.4/dist/flowbite.js"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/algoliasearch@4.10.5/dist/algoliasearch.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/preline@latest/dist/preline.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    
    <!-- Font Import -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
        }

        .sidebar {
            transition: transform 0.3s ease-in-out;
        }

        .sidebar.open {
            transform: translateX(0);
        }

        .sidebar.closed {
            transform: translateX(-100%);
        }

        .content {
            transition: margin-left 0.3s ease-in-out;
        }

        .content.open {
            margin-left: 250px;
        }

        .content.closed {
            margin-left: 70px;
        }

        .profile-info {
            display: flex;
            align-items: center;
        }

        .profile-info p {
            margin: 0;
            margin-left: 10px;
        }

        .dropdown-profile {
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 0.5rem;
        }

        .category-list {
            margin-top: 20px;
        }
    </style>

    <script>
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.getElementById('preloader').classList.add('transform', '-translate-y-full');
                setTimeout(function() {
                    document.getElementById('preloader').style.display = 'none';
                    document.getElementById('content').classList.remove('opacity-0');
                    document.getElementById('content').classList.add('opacity-100');
                }, 700);
            }, 700);
        });
    </script>
</head>

<body class="bg-gray-50 font-sans">
    <div class="flex h-auto overflow-auto">
        <!-- Sidebar -->
        <aside class="w-60 -translate-x-48 fixed transition transform ease-in-out duration-1000 z-50 flex h-screen bg-[#1E293B]">
            <!-- Open Sidebar Button -->
            <div class="max-toolbar translate-x-24 scale-x-0 w-full -right-6 transition transform ease-in duration-300 flex items-center justify-between border-4 border-white absolute top-2 rounded-full h-12">
                <div class="flex pl-4 items-center space-x-2"></div>
                <div class="flex items-center space-x-3 group bg-gradient-to-r from-cyan-500 to-blue-500 pl-10 pr-2 py-1 rounded-full text-white">
                    <div class="transform ease-in-out duration-300 mr-24 font-medium">Kasir</div>
                </div>
            </div>
            <div onclick="openNav()" class="-right-6 transition transform ease-in-out duration-500 flex border-4 border-white dark:border-[#0F172A] bg-[#1E293B] hover:bg-blue-500 absolute top-2 p-3 rounded-full text-white hover:rotate-45">
                <i class="bi bi-grid-fill"></i>
            </div>
            <!-- MAX SIDEBAR -->
            <div class="max hidden text-white mt-20 flex-col space-y-2 w-full h-[calc(100vh)]">
                <a href="/admin/dashboard" class="flex hover:ml-4 w-[90%] hover:text-blue-500 p-2 pl-8 rounded-full transform ease-in-out duration-300 flex-row items-center space-x-3 before:transition-all {{ request()->routeIs('home') ? 'text-blue-600 ' : '' }}">
                    <i class="bi bi-house-door-fill"></i>
                    <div>Dashboard</div>
                </a>
                @hasrole('SuperAdmin')
                <a href="{{ route('categories.index') }}" class="flex hover:ml-4 w-[90%] hover:text-blue-500 p-2 pl-8 rounded-full transform ease-in-out duration-300 flex-row items-center space-x-3 before:transition-all {{ request()->routeIs('categories.index') ? 'text-blue-600 ' : '' }}">
                    <i class="bi bi-list-task"></i>
                    <div>Categories</div>
                </a>
                <a href="{{ route('items.index') }}" class="flex hover:ml-4 w-[90%] hover:text-blue-500 p-2 pl-8 rounded-full transform ease-in-out duration-300 flex-row items-center space-x-3 before:transition-all {{ request()->routeIs('items.index') ? 'text-blue-600 ' : '' }}">
                    <i class="bi bi-box-seam"></i>
                    <div>Product</div>
                </a>
                <a href="{{ route('transactions.index') }}" class="flex hover:ml-4 w-[90%] hover:text-blue-500 p-2 pl-8 rounded-full transform ease-in-out duration-300 flex-row items-center space-x-3 before:transition-all {{ request()->routeIs('transactions.index') ? 'text-blue-600 ' : '' }}">
                    <i class="bi bi-cart4"></i>
                    <div>Transaksi</div>
                </a>
                @endhasrole
                @hasrole('Admin')
                <a href="{{ route('transactions-kasir.index') }}" class="flex hover:ml-4 w-[90%] hover:text-blue-500 p-2 pl-8 rounded-full transform ease-in-out duration-300 flex-row items-center space-x-3 before:transition-all {{ request()->routeIs('transactions-kasir.index') ? 'text-blue-600 ' : '' }}">
                    <i class="bi bi-cart4"></i>
                    <div>Transaksi</div>
                </a>
                @endhasrole
            </div>
            <!-- MINI SIDEBAR -->
            @hasrole('SuperAdmin')
            <div class="mini mt-20 flex flex-col space-y-1 w-full h-[calc(100vh)]">
                <button onclick="window.location.href='{{ route('home') }}'" class="hover:ml-4 justify-end pr-3 hover:text-blue-500 w-full bg-[#1E293B] p-3 rounded-full transform ease-in-out duration-300 flex before:transition-all {{ request()->routeIs('home') ? 'text-blue-600 ' : 'text-white' }}">
                    <i class="bi bi-house-door-fill"></i>
                </button>
                <button onclick="window.location.href='{{ route('categories.index') }}'" class="hover:ml-4 justify-end pr-3 hover:text-blue-500 w-full bg-[#1E293B] p-3 rounded-full transform ease-in-out duration-300 flex before:transition-all {{ request()->routeIs('categories.index') ? 'text-blue-600 ' : 'text-white' }}">
                    <i class="bi bi-list-task"></i>
                </button>
                <button onclick="window.location.href='{{ route('items.index') }}'" class="hover:ml-4 justify-end pr-3 hover:text-blue-500 w-full bg-[#1E293B] p-3 rounded-full transform ease-in-out duration-300 flex before:transition-all {{ request()->routeIs('items.index') ? 'text-blue-600 ' : 'text-white' }}">
                    <i class="bi bi-box-seam"></i>
                </button>
                <button onclick="window.location.href='{{ route('transactions.index') }}'" class="hover:ml-4 justify-end pr-3 hover:text-blue-500 w-full bg-[#1E293B] p-3 rounded-full transform ease-in-out duration-300 flex before:transition-all {{ request()->routeIs('transactions.index') ? 'text-blue-600 ' : 'text-white' }}">
                    <i class="bi bi-cart4"></i>
                </button>
            </div>
            @endhasrole
            @hasrole('Admin')
            <div class="mini mt-20 flex flex-col space-y-1 w-full h-[calc(100vh)]">
                <button onclick="window.location.href='{{ route('home') }}'" class="hover:ml-4 justify-end pr-3 hover:text-blue-500 w-full bg-[#1E293B] p-3 rounded-full transform ease-in-out duration-300 flex before:transition-all {{ request()->routeIs('home') ? 'text-blue-600 ' : 'text-white' }}">
                    <i class="bi bi-house-door-fill"></i>
                </button>
                <button onclick="window.location.href='{{ route('transactions-kasir.index') }}'" class="hover:ml-4 justify-end pr-3 hover:text-blue-500 w-full bg-[#1E293B] p-3 rounded-full transform ease-in-out duration-300 flex before:transition-all {{ request()->routeIs('transactions-kasir.index') ? 'text-blue-600 ' : 'text-white' }}">
                    <i class="bi bi-cart4"></i>
                </button>
            </div>
            @endhasrole
        </aside>

        <!-- Page Content -->
        <div class="flex-1 p-4 ml-[70px]">
            <div id="kt_app_header" class="app-header bg-white shadow rounded-xl">
                <div class="container-fluid flex justify-between items-center py-2 px-5">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <a href="/dashboard">
                            <img alt="Logo" src="{{ asset('assets/Logo.webp') }}" class="h-10 rounded-full" />
                        </a>
                    </div>

                    <!-- User Info and Profile -->
                    <div class="flex items-center space-x-3">
                        <div class="hidden md:flex flex-col text-right pt-4">
                            <p class="font-bold text-gray-800 uppercase">{{ Auth::user()->name }}</p>
                            <span class="badge badge-light-success text-sm">{{ Auth::user()->getRoleNames()->first() }}</span>
                        </div>
                        <div class="relative">
                            <!-- Profile Button -->
                            <button id="profile-button"
                                class="flex items-center p-2 text-white bg-blue-500 rounded-full hover:bg-blue-600 transition"
                                onclick="toggleDropdown('dropdown-profile')">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="h-6 w-6">
                                    <path fill-rule="evenodd"
                                        d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <!-- Dropdown Profile -->
                            <div id="dropdown-profile" class="hidden absolute right-0 mt-5 bg-white shadow-lg rounded-md text-sm z-50 min-w-[250px]">
                                <div class="px-4 py-2 border-b">
                                    <h1 class="text-gray-800 font-bold break-words">PROFILE</h1>
                                </div>
                                <div class="px-4 py-2 text-gray-600">
                                    <p class="break-words">Nama: {{ Auth::user()->name }}</p>
                                    <p class="break-words">Email: {{ Auth::user()->email }}</p>
                                </div>
                                <form action="{{ route('logout') }}" method="POST" class="px-4 py-2">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center justify-center px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                        <i class="bi bi-box-arrow-right"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    

    <script>
        const navbar = document.getElementById("navbar");
        const initialNavOffset = navbar.offsetTop;

        window.addEventListener("scroll", () => {
            if (window.scrollY > initialNavOffset) {
                navbar.classList.add("fixed", "top-2", "left-18", "w-[94%]", "border-2", "z-20");
                navbar.classList.remove("shadow-lg");
            } else {
                navbar.classList.remove("fixed", "top-2", "left-18", "w-[94%]", "border-2", "z-20");
                navbar.classList.add("shadow-lg");
            }
        });

        function openNav() {
            const sidebar = document.querySelector("aside");
            const maxSidebar = document.querySelector(".max");
            const miniSidebar = document.querySelector(".mini");
            const maxToolbar = document.querySelector(".max-toolbar");
            const logo = document.querySelector('.logo');
            const content = document.querySelector('.content');

            if (sidebar.classList.contains('-translate-x-48')) {
                sidebar.classList.remove("-translate-x-48");
                sidebar.classList.add("translate-x-none");
                maxSidebar.classList.remove("hidden");
                maxSidebar.classList.add("flex");
                miniSidebar.classList.remove("flex");
                miniSidebar.classList.add("hidden");
                maxToolbar.classList.add("translate-x-0");
                maxToolbar.classList.remove("translate-x-24", "scale-x-0");
                logo.classList.remove("ml-12");
                content.classList.remove("ml-12");
                content.classList.add("ml-12", "md:ml-60");
            } else {
                sidebar.classList.add("-translate-x-48");
                sidebar.classList.remove("translate-x-none");
                maxSidebar.classList.add("hidden");
                maxSidebar.classList.remove("flex");
                miniSidebar.classList.add("flex");
                miniSidebar.classList.remove("hidden");
                maxToolbar.classList.add("translate-x-24", "scale-x-0");
                maxToolbar.classList.remove("translate-x-0");
                logo.classList.add('ml-12');
                content.classList.remove("ml-12", "md:ml-60");
                content.classList.add("ml-12");
            }
        }

        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            dropdown.classList.toggle('hidden');
        }
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: '{{ session('success') }}',
                background: '#f0f9ff',
                color: '#1a202c',
                confirmButtonColor: '#3b82f6',
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                background: '#f0f9ff',
                color: '#1a202c',
                confirmButtonColor: '#3b82f6',
            });
        </script>
    @endif
    
</body>

</html>