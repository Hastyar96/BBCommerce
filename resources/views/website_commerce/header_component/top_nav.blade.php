 <header class="top-navbar">
     <div class="container nav-container">
         <!-- Language Switcher -->
         <div class="language-switcher-wrapper">
             <!-- 🌐 Icon-only toggle button -->
             <div class="language-toggle" onclick="toggleLanguageMenu()" title="Choose Language">
                 <img src="{{ asset('image_website/image/language-svgrepo-com.svg') }}" alt="Language" />
             </div>

             <!-- Language Flags -->
             <div class="language-switcher" id="languageMenu">
                 <a href="/change/lang/1" title="English">
                     <img src="{{ asset('image_website/image/us.png') }}" alt="English">
                 </a>
                 <a href="/change/lang/3" title="Kurdish">
                     <img src="{{ asset('image_website/image/kurdistan-flag.png') }}" alt="Kurdish">
                 </a>
                 <a href="/change/lang/2" title="Arabic">
                     <img src="{{ asset('image_website/image/iq.png') }}" alt="Arabic">
                 </a>
             </div>
         </div>

         <!-- Logo -->
         <a href="" class="logo">
             <img src="https://britishbody.uk/img/logo2.png" alt="British Body Logo">
         </a>

         <!-- User Actions -->
         <div class="user-actions">
             {{ Auth::user()->first_name }}
             <i class="fas fa-user" onclick="toggleLogin()"></i>
         </div>
     </div>
 </header>

 <!-- Secondary Navbar-top navbar-language  -->
 <style>
     .top-navbar {
         background-color: #fff;
         box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
         padding: 15px 0;
         position: sticky;
         top: 0;
         z-index: 1000;
     }

     .nav-container {
         display: flex;
         justify-content: space-between;
         align-items: center;
     }

     .logo img {
         width: 150px;
         margin-right: 40px;
         margin-left: 65px;
     }

     .language-switcher-wrapper {
         position: relative;
         z-index: 999;
         font-family: 'Segoe UI', sans-serif;
     }

     /* Icon toggle button */
     .language-toggle {
         display: none;
         cursor: pointer;
         background-color: #ffffff;
         padding: 8px;
         border-radius: 50%;
         border: 1px solid #ddd;
         box-shadow: 0 3px 6px rgba(0, 0, 0, 0.05);
         transition: background-color 0.2s, transform 0.2s;
         width: 45px;
         height: 45px;
         align-items: center;
         justify-content: center;
         display: flex;
     }

     .language-toggle:hover {
         background-color: #f1f1f1;
         transform: scale(1.05);
     }

     .language-toggle img {
         width: 24px;
         height: 24px;
     }

     /* Flag list container */
     .language-switcher {
         display: flex;
         gap: 10px;
     }

     .language-switcher img {
         width: 42px;
         height: 30px;
         cursor: pointer;
         border-radius: 8px;
         box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
         transition: transform 0.2s, box-shadow 0.2s;
     }

     .language-switcher img:hover {
         transform: scale(1.1);
         box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
     }

     /* Mobile styles */
     @media (max-width: 768px) {
         .language-toggle {
             display: flex;
         }

         .language-switcher {
             display: none;
             flex-direction: column;
             position: absolute;
             top: 100%;
             left: 0;
             margin-top: 10px;
             background-color: #ffffff;
             padding: 12px;
             border-radius: 12px;
             box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
             z-index: 1000;

         }

         .language-switcher.show {
             display: flex;
         }
     }

     /* This hides the language toggle button (globe icon) on desktop */
     @media (min-width: 769px) {
         .language-toggle {
             display: none !important;
         }
     }

     /* This shows the toggle button only on mobile (width ≤ 768px) */
     @media (max-width: 768px) {
         .language-toggle {
             display: flex;
         }

         /* Optional: Also convert flags to vertical list */
         .language-switcher {
             flex-direction: column;
         }
     }



     .user-actions {
         display: flex;
         gap: 20px;
         margin-right: 10px;
         position: relative;
     }

     .user-actions i {
         font-size: 20px;
         color: #2c3e50;
         cursor: pointer;
         transition: color 0.3s;
     }

     .user-actions i:hover {
         color: #e74c3c;
     }

     /* Base styles */
     .nav-menu {
         display: flex;
         justify-content: space-between;
         list-style: none;
         margin: 0;
         padding: 0;
         overflow: visible;
         /* default */
         max-height: none;
         transition: none;
     }

     /* Mobile styles */
     @media (max-width: 768px) {
         .nav-menu {
             flex-direction: column;
             max-height: 0;
             overflow: hidden;
             transition: max-height 0.4s ease;
             background-color: #2c3e50;
             margin-top: 10px;
             border-radius: 8px;
         }

         /* When active, expand with a large max-height */
         .nav-menu.show {
             max-height: 1000px;
             /* large enough to show entire menu */
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
             background: none;
             border: none;
             font-size: 28px;
             color: #fff;
             cursor: pointer;
             padding: 10px 15px;
         }
     }

 </style>
