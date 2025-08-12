 <!-- login  Modal -->
    <div class="login-modal" id="loginModal">
        <div class="login-container">
            <span class="close-btn" onclick="closeLogin()">&times;</span>
            <div class="login-header">
                <img src="https://britishbody.uk/img/logo2.png" alt="BritishBody Logo" class="login-logo">
                <h2>Welcome Back</h2>
                <p>Sign in to your account to continue</p>
            </div>
            <form class="login-form">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" placeholder="Enter your password" required>
                    <a href="#" class="forgot-password">Forgot password?</a>
                </div>
                <button type="submit" class="login-btn">Sign In</button>
                <div class="social-login">
                    <p>Or sign in with</p>
                    <div class="social-icons">
                        <a href="#" class="social-icon"><i class="fab fa-google"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-apple"></i></a>
                    </div>
                </div>
                <div class="register-link">
                    Don't have an account? <a href="#" onclick="showRegister()">Register</a>
                </div>
            </form>
        </div>
    </div>
    <!-- Register & login style  -->
    <style>
        /* Login Modal Styles */
        .login-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 2000;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background-color: white;
            border-radius: 10px;
            width: 100%;
            max-width: 450px;
            padding: 30px;
            position: relative;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.3);
            animation: modalFadeIn 0.3s;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .close-btn {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 28px;
            font-weight: bold;
            color: #2c3e50;
            cursor: pointer;
            transition: color 0.3s;
        }

        .close-btn:hover {
            color: #e74c3c;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h2 {
            color: #2c3e50;
            margin: 15px 0 5px;
        }

        .login-header p {
            color: #7f8c8d;
            font-size: 14px;
        }

        .login-logo {
            width: 80px;
            height: auto;
        }

        .login-form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 600;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            border-color: #e74c3c;
            outline: none;
        }

        .forgot-password {
            display: block;
            text-align: right;
            font-size: 13px;
            color: #7f8c8d;
            margin-top: 5px;
            text-decoration: none;
            transition: color 0.3s;
        }

        .forgot-password:hover {
            color: #e74c3c;
        }

        .login-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        .login-btn:hover {
            background-color: #c0392b;
        }

        .social-login {
            text-align: center;
            margin: 25px 0;
        }

        .social-login p {
            color: #7f8c8d;
            font-size: 14px;
            margin-bottom: 15px;
            position: relative;
        }

        .social-login p::before,
        .social-login p::after {
            content: "";
            position: absolute;
            height: 1px;
            width: 30%;
            background-color: #ddd;
            top: 50%;
        }

        .social-login p::before {
            left: 0;
        }

        .social-login p::after {
            right: 0;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2c3e50;
            text-decoration: none;
            transition: all 0.3s;
        }

        .social-icon:hover {
            background-color: #e74c3c;
            color: white;
        }

        .register-link {
            text-align: center;
            font-size: 14px;
            color: #7f8c8d;
        }

        .register-link a {
            color: #e74c3c;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .register-link a:hover {
            color: #c0392b;
        }
    </style>
