<!-- Footer -->
<footer>
    <div class="container">
        <div class="footer-container">
            <!-- About Us Column -->
            <div class="footer-column">
                <h3>{{ __('f.about_us') }}</h3>
                <p>{{ __('f.about_us_text') }}</p>
                <div class="contact-info">
                    <p><i class="fas fa-map-marker-alt"></i> {{ __('f.address') }}</p>
                    <p><i class="fas fa-phone"></i> {{ __('f.phone') }}</p>
                    <p><i class="fas fa-envelope"></i> {{ __('f.email') }}</p>
                </div>
            </div>

            <!-- Quick Links Column -->
            <div class="footer-column">
                <h3>{{ __('f.quick_links') }}</h3>
                <ul>
                    <li><a href="#">{{ __('f.home') }}</a></li>
                    <li><a href="#">{{ __('f.about_us') }}</a></li>
                    <li><a href="#">{{ __('f.products') }}</a></li>
                    <li><a href="#">{{ __('f.blog') }}</a></li>
                    <li><a href="#">{{ __('f.contact') }}</a></li>
                </ul>
            </div>

            <!-- Customer Service Column -->
            <div class="footer-column">
                <h3>{{ __('f.customer_service') }}</h3>
                <ul>
                    <li><a href="#">{{ __('f.my_account') }}</a></li>
                    <li><a href="#">{{ __('f.order_tracking') }}</a></li>
                    <li><a href="#">{{ __('f.wish_list') }}</a></li>
                    <li><a href="#">{{ __('f.customer_service') }}</a></li>
                    <li><a href="#">{{ __('f.returns_exchange') }}</a></li>
                </ul>
            </div>

            <!-- Newsletter Column -->
            <div class="footer-column">
                <h3>{{ __('f.newsletter') }}</h3>
                <p>{{ __('f.newsletter_text') }}</p>
                <form class="newsletter-form">
                    <input readonly type="email" class="newsletter-input" placeholder="{{ __('f.your_email') }}">
                    <button type="submit" class="newsletter-btn">{{ __('f.subscribe') }}</button>
                </form>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>&copy; 2025 BritishBody. {{ __('f.rights_reserved') }}</p>
        </div>
    </div>
</footer>
   <style>
        footer {
            background-color: #2c3e50;
            color: #fff;
            padding: 50px 0 20px;
        }

        .footer-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .footer-column h3 {
            font-size: 18px;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-column h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background-color: #e74c3c;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column ul li {
            margin-bottom: 10px;
        }

        .footer-column ul li a {
            color: #ecf0f1;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-column ul li a:hover {
            color: #e74c3c;
        }

        .contact-info p {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .contact-info i {
            margin-right: 10px;
            color: #e74c3c;
        }

        .newsletter-form {
            margin-top: 20px;
        }

        .newsletter-input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .newsletter-btn {
            background-color: #e74c3c;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .newsletter-btn:hover {
            background-color: #c0392b;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            margin-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Responsive Footer */

        @media (max-width: 992px) {
            .footer-container {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
        }

        @media (max-width: 576px) {
            .footer-container {
                grid-template-columns: 1fr;
            }

            .newsletter-input {
                padding: 8px;
            }

            .newsletter-btn {
                width: 100%;
                padding: 10px;
            }

            .contact-info p {
                font-size: 14px;
            }

            .footer-column h3 {
                font-size: 16px;
            }
        }
    </style>

<!-- JavaScript -->
<script>
    // ======================
    // Language Menu Toggle
    // ======================
    function toggleLanguageMenu() {
        const menu = document.getElementById("languageMenu");
        menu.classList.toggle("show");
    }

    // ======================
    // Shopping Basket Logic
    // ======================
    let basket = [];
    const basketContainer = document.getElementById('basketContainer');
    const basketItems = document.getElementById('basketItems');
    const cartCount = document.getElementById('cartCount');
    const subtotalEl = document.getElementById('subtotal');
    const totalEl = document.getElementById('total');

    function toggleBasket() {
        document.body.classList.toggle('basket-open');
        basketContainer.classList.toggle('active');
    }

    function closeBasket() {
        document.body.classList.remove('basket-open');
        basketContainer.classList.remove('active');
    }

    function addToCart(name, price, image) {
        const existingItem = basket.find(item => item.name === name);

        if (existingItem) {
            existingItem.quantity++;
        } else {
            basket.push({
                name: name,
                price: price,
                image: image,
                quantity: 1
            });
        }

        updateBasket();
        toggleBasket();
        alert(`${name} added to basket!`);
    }

    function updateBasket() {
        const totalItems = basket.reduce((sum, item) => sum + item.quantity, 0);
        cartCount.textContent = totalItems;

        const subtotal = basket.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const shipping = 5.00;
        const total = subtotal + shipping;

        subtotalEl.textContent = `$${subtotal.toFixed(2)}`;
        totalEl.textContent = `$${total.toFixed(2)}`;

        if (basket.length === 0) {
            basketItems.innerHTML = `
                <div class="empty-basket">
                    <i class="fas fa-shopping-basket"></i>
                    <p>Your basket is empty</p>
                </div>`;
            return;
        }

        basketItems.innerHTML = '';
        basket.forEach((item, index) => {
            const itemElement = document.createElement('div');
            itemElement.className = 'basket-item';
            itemElement.innerHTML = `
                <div class="item-image">
                    <img src="${item.image}" alt="${item.name}">
                </div>
                <div class="item-details">
                    <div class="item-name">${item.name}</div>
                    <div class="item-price">$${item.price.toFixed(2)}</div>
                    <div class="item-controls">
                        <button class="quantity-btn" onclick="updateQuantity(${index}, -1)">-</button>
                        <span class="quantity-display">${item.quantity}</span>
                        <button class="quantity-btn" onclick="updateQuantity(${index}, 1)">+</button>
                        <span class="remove-item" onclick="removeItem(${index})">
                            <i class="fas fa-trash"></i>
                        </span>
                    </div>
                </div>
            `;
            basketItems.appendChild(itemElement);
        });
    }

    function updateQuantity(index, change) {
        basket[index].quantity += change;
        if (basket[index].quantity <= 0) {
            basket.splice(index, 1);
        }
        updateBasket();
    }

    function removeItem(index) {
        basket.splice(index, 1);
        updateBasket();
    }

    // Close basket when clicking outside
    document.addEventListener('click', function(event) {
        const isClickInside = basketContainer.contains(event.target) ||
                             event.target.closest('.fa-shopping-basket') ||
                             event.target.closest('.cart-count');

        if (!isClickInside && basketContainer.classList.contains('active')) {
            closeBasket();
        }
    });

    // ======================
    // Login/Register Modals
    // ======================
    function toggleLogin() {
        document.getElementById('loginModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeLogin() {
        document.getElementById('loginModal').style.display = 'none';
        document.getElementById('registerModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function showRegister() {
        document.getElementById('loginModal').style.display = 'none';
        document.getElementById('registerModal').style.display = 'flex';
    }

    function showLogin() {
        document.getElementById('registerModal').style.display = 'none';
        document.getElementById('loginModal').style.display = 'flex';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.className === 'login-modal') {
            closeLogin();
        }
    }

    // ======================
    // Mobile Menu
    // ======================
    const toggleBtn = document.querySelector('.mobile-menu-toggle');
    const navMenu = document.querySelector('.nav-menu');

    toggleBtn.addEventListener('click', () => {
        navMenu.classList.toggle('show');
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!navMenu.contains(e.target) && !toggleBtn.contains(e.target)) {
            navMenu.classList.remove('show');
        }
    });

    // Mobile dropdown toggle on parent menu click
    document.querySelectorAll('.nav-item > .nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                const parent = this.parentElement;
                const dropdown = parent.querySelector('.dropdown-menu');
                if (dropdown) {
                    e.preventDefault();
                    parent.classList.toggle('active');
                }
            }
        });
    });

    // ======================
    // Search Functionality
    // ======================
    function handleSearch(event) {
        event.preventDefault();
        const query = document.getElementById('searchInput').value.trim();

        if (query) {
            window.location.href = `/search.html?q=${encodeURIComponent(query)}`;
            console.log("Search query:", query);
        } else {
            alert("Please enter a search term.");
        }
    }




</script>
</body>
</html>
