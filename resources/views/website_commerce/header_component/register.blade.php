 <!-- Register Modal -->
    <div class="login-modal" id="registerModal">
        <div class="login-container">
            <span class="close-btn" onclick="closeLogin()">&times;</span>
            <div class="login-header">
                <img src="https://britishbody.uk/img/logo2.png" alt="BritishBody Logo" class="login-logo">
                <h2>Create Account</h2>
                <p>Join BritishBody for exclusive benefits</p>
            </div>
            <form class="login-form">
                <div class="form-group">
                    <label for="reg-name">Full Name</label>
                    <input type="text" id="reg-name" placeholder="Enter your full name" required>
                </div>
                <div class="form-group">
                    <label for="reg-email">Email Address</label>
                    <input type="email" id="reg-email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="reg-password">Password</label>
                    <input type="password" id="reg-password" placeholder="Create a password" required>
                </div>
                <div class="form-group">
                    <label for="reg-confirm">Confirm Password</label>
                    <input type="password" id="reg-confirm" placeholder="Confirm your password" required>
                </div>
                <button type="submit" class="login-btn">Register</button>
                <div class="register-link">
                    Already have an account? <a href="#" onclick="showLogin()">Sign In</a>
                </div>
            </form>
        </div>
    </div>
