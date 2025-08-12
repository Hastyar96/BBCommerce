<!-- Secondary Navbar -->
<nav class="secondary-navbar">
    <div class="container">
        <button class="mobile-menu-toggle" aria-label="Toggle menu">&#9776;</button>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link">{{ __('f.home') }}</a>
            </li>
            <!-- More nav items here -->

            <li class="nav-item">
                <a href="{{ url('/products') }}"  class="nav-link">{{ __('f.all_products') }}</a>
            </li>
           <li class="nav-item">
                <a href="{{ url('/contact') }}"  class="nav-link">{{ __('f.contact') }}</a>
            </li>
               <li class="nav-item">
                <a href="{{ url('/about') }}"  class="nav-link">{{ __('f.about') }}</a>
            </li>

        </ul>
    </div>
</nav>



 <style>
        /* Your full CSS pasted here, unchanged */

        /* Secondary Navbar */
        .secondary-navbar {
            background-color: #2c3e50;
            padding: 10px 0;
            position: sticky;
            top: 85px;
            z-index: 999;
        }

        /* Hide toggle button on desktop */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 28px;
            color: #fff;
            cursor: pointer;
            padding: 10px 15px;
        }

        /* Mobile Styles */
        @media (max-width: 768px) {
            .nav-menu {
                flex-direction: column;
                display: none;
                /* hidden by default on mobile */
                background-color: #2c3e50;
                margin-top: 10px;
                border-radius: 8px;
            }

            .nav-menu.show {
                display: flex;
                flex-direction: column;
                /* for mobile */
            }

            .nav-item {
                width: 100%;
            }

            .nav-link {
                padding: 12px 20px;
                font-size: 16px;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            /* Dropdown menus inside mobile menu */
            .dropdown-menu {
                position: relative;
                top: 0;
                left: 0;
                width: 100%;
                box-shadow: none;
                opacity: 1 !important;
                visibility: visible !important;
                background-color: #34495e;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease;
            }

            /* Show dropdown menu when parent is active */
            .nav-item.active>.dropdown-menu {
                max-height: 500px;
                /* big enough for dropdown items */
            }

            .dropdown-item {
                padding: 10px 40px;
                color: #ecf0f1;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .dropdown-item:hover {
                background-color: #3d566e;
            }

            /* Show toggle button on mobile */
            .mobile-menu-toggle {
                display: block;
            }
        }

        .nav-menu {
            display: flex;
            justify-content: space-between;
            list-style: none;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
            transition: background-color 0.3s;
            text-transform: uppercase;
            font-size: 14px;
            font-weight: 600;
        }

        .nav-link:hover {
            background-color: #e74c3c;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #fff;
            width: 200px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
            z-index: 1000;
        }

        .nav-item:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
        }

        .dropdown-item {
            display: block;
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
    </style>
