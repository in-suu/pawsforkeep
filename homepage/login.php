<?php
session_start();
include 'db_connect.php';

// Auto-fill email: from session (signup_logic redirect) OR from ?prefill= query param (JS redirect)
$prefill_email = '';
if (isset($_SESSION['prefill_email']) && $_SESSION['prefill_email'] !== '') {
    $prefill_email = $_SESSION['prefill_email'];
} elseif (isset($_GET['prefill']) && $_GET['prefill'] !== '') {
    $prefill_email = trim($_GET['prefill']);
}

$login_error   = isset($_SESSION['login_error'])   ? $_SESSION['login_error']   : '';
$signup_notice = isset($_SESSION['signup_notice']) ? $_SESSION['signup_notice'] : '';

// Clear session vars after reading
unset($_SESSION['prefill_email'], $_SESSION['login_error'], $_SESSION['signup_notice']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Paws For Keeps</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link rel="stylesheet" href="navbar-footer.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #FFBE3E; margin: 0; }

        .main-wrapper {
            min-height: 100vh;
            padding-top: 80px;
            padding-bottom: 40px;
            display: flex;
            flex-direction: column;
        }

        .container {
            background: #f2f2f2;
            width: 450px;
            border-radius: 20px;
            padding: 25px 35px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: auto;
        }

        .subtitle {
            font-size: 13px;
            font-weight: 500;
            color: #525252;
            margin-bottom: 15px;
            text-align: center;
        }

        /* ── Error / Notice banners ── */
        .alert-box {
            width: 100%;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 14px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            line-height: 1.5;
        }
        .alert-error   { background: #fdecea; color: #c0392b; border: 1px solid #f5c6c2; }
        .alert-notice  { background: #fff8e1; color: #7d5a00; border: 1px solid #ffe082; }
        .alert-box svg { width: 16px; height: 16px; flex-shrink: 0; margin-top: 1px; }

        form { width: 100%; }

        label {
            display: block;
            text-align: left;
            font-size: 12px;
            margin-bottom: 4px;
            font-weight: 600;
            color: #4D2412;
        }

        input {
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #949B9E;
            margin-bottom: 12px;
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
            transition: border-color 0.2s;
        }
        input:focus { outline: none; border-color: #FFBE3E; }
        input.input-error { border-color: #e74c3c; background: #fff8f8; }

        .password-wrap { position: relative; }
        .password-wrap i {
            position: absolute;
            top: 50%;
            transform: translateY(-85%);
            right: 15px;
            color: #484E51;
            font-size: 16px;
            cursor: pointer;
        }

        .forgot {
            display: block;
            text-align: right;
            margin-bottom: 10px;
            font-size: 11px;
            color: #525252;
            text-decoration: none;
        }

        .forgot-divider { width: 100%; height: 1px; background-color: #ddd; margin: 8px 0; }

        .social {
            width: 100%;
            padding: 10px;
            border-radius: 100px;
            border: 1px solid #949B9E;
            background: #fff;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            margin-bottom: 8px;
            font-family: 'Poppins', sans-serif;
        }
        .social img { margin-right: 10px; width: 18px; }

        .terms {
            font-size: 10px;
            color: #484E51;
            margin: 10px 0;
            text-align: center;
            line-height: 1.4;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            border-radius: 50px;
            border: none;
            background: linear-gradient(135deg, #A35524, #FFBE3E);
            color: white;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s;
            font-family: 'Poppins', sans-serif;
        }
        .login-btn:hover { transform: scale(1.03); }

        /* ── Form toggle (login ↔ signup) ── */
        .form-panel {
            width: 100%;
            display: none;
            flex-direction: column;
            align-items: center;
        }
        .form-panel.active {
            display: flex;
        }
        /* Smooth fade transition */
        .form-panel {
            animation: none;
        }
        .form-panel.active {
            animation: fadeIn 0.25s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Switch link style */
        .switch-link {
            color: #4D2412;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            border-bottom: 1px solid transparent;
            transition: border-color 0.2s;
        }
        .switch-link:hover {
            border-bottom-color: #4D2412;
        }

        /* Signup-specific */
        .input-group { margin-bottom: 8px; }
        .pw-hint {
            font-size: 10px;
            color: #aaa;
            margin-top: -5px;
            margin-bottom: 6px;
            padding-left: 4px;
        }
        .login-text {
            text-align: center;
            font-size: 12px;
            margin: 10px 0;
            color: #525252;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="main-wrapper">
        <div class="container">

            <!-- ── LOGIN PANEL ── -->
            <div class="form-panel active" id="loginPanel">

                <p class="subtitle"><b>Sign In</b> to manage your store</p>

                <?php if ($signup_notice): ?>
                <div class="alert-box alert-notice">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <?php echo htmlspecialchars($signup_notice); ?>
                </div>
                <?php endif; ?>

                <?php if ($login_error): ?>
                <div class="alert-box alert-error">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    <?php echo htmlspecialchars($login_error); ?>
                </div>
                <?php endif; ?>

                <form action="login_logic.php" method="POST" id="loginForm">
                    <label>Email</label>
                    <input type="email" name="email" id="emailInput"
                        placeholder="Enter email address"
                        value="<?php echo htmlspecialchars($prefill_email); ?>"
                        required
                        class="<?php echo $login_error ? 'input-error' : ''; ?>">

                    <label>Password</label>
                    <div class="password-wrap">
                        <input type="password" id="pass" name="password"
                            placeholder="Enter Password" required
                            class="<?php echo $login_error ? 'input-error' : ''; ?>">
                        <i class="fa-solid fa-eye" onclick="toggle('pass')"></i>
                    </div>

                    <a href="#" class="forgot">Forgot Password?</a>
                    <div class="forgot-divider"></div>

                    <button type="button" class="social"><img src="images/google.png"> Continue with Google</button>
                    <button type="button" class="social"><img src="images/facebook.png"> Continue with Facebook</button>

                    <p class="subtitle" style="margin-top:8px; font-size:11px;">
                        Don't have an account?
                        <a class="switch-link" onclick="showPanel('signup')">Create one here</a>
                    </p>
                    <p class="terms">By continuing, you agree to Paws For Keep's Terms and Privacy Policy.</p>
                    <button type="submit" class="login-btn">Log In</button>
                </form>
            </div>

            <!-- ── SIGNUP PANEL ── -->
            <div class="form-panel" id="signupPanel">

                <p class="subtitle"><b>Create Account</b> to start your journey</p>

                <div class="alert-box alert-error" id="signupErrorBox" style="display:none;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    <span id="signupErrorMsg"></span>
                </div>

                <form action="signup_logic.php" method="POST" id="signupForm" onsubmit="return validateSignup()">
                    <div class="input-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name" id="signupName" placeholder="Enter full name" required>
                    </div>
                    <div class="input-group">
                        <label>Email Address</label>
                        <input type="email" name="email" id="signupEmail" placeholder="Enter email" required>
                    </div>
                    <div class="input-group">
                        <label>Password</label>
                        <div class="password-wrap">
                            <input type="password" id="sp1" name="password" placeholder="Create password (min. 6 characters)" required>
                            <i class="fa-solid fa-eye" onclick="toggle('sp1')"></i>
                        </div>
                    </div>
                    <div class="input-group">
                        <label>Confirm Password</label>
                        <div class="password-wrap">
                            <input type="password" id="sp2" name="confirm_password" placeholder="Confirm password" required>
                            <i class="fa-solid fa-eye" onclick="toggle('sp2')"></i>
                        </div>
                    </div>
                    <p class="pw-hint" id="pwMatchHint"></p>
                    <p class="login-text">
                        Already have an account?
                        <a class="switch-link" onclick="showPanel('login')">Login here</a>
                    </p>
                    <p class="terms">By continuing, you agree to Paws For Keep's Terms and Privacy Policy.</p>
                    <button type="submit" class="login-btn">Sign Up</button>
                </form>
            </div>

        </div>
    </div>

    <script>
        function toggle(id) {
            const x = document.getElementById(id);
            x.type = x.type === "password" ? "text" : "password";
        }

        // ── Panel switcher ────────────────────────────────────────
        function showPanel(which) {
            document.getElementById('loginPanel').classList.toggle('active', which === 'login');
            document.getElementById('signupPanel').classList.toggle('active', which === 'signup');
            // Update URL hash silently so back button works
            history.replaceState(null, '', which === 'signup' ? '#signup' : '#');
        }

        // ── Auto-show signup if URL has #signup (navbar SIGN UP link) ──
        document.addEventListener('DOMContentLoaded', function () {
            if (window.location.hash === '#signup') {
                showPanel('signup');
            }

            // Auto-focus pre-filled email
            const email = document.getElementById('emailInput');
            if (email && email.value.trim() !== '') {
                email.focus();
                const v = email.value; email.value = ''; email.value = v;
            }

            // Live password match feedback (signup form)
            ['sp1','sp2'].forEach(function(id) {
                const el = document.getElementById(id);
                if (el) el.addEventListener('input', checkPwMatch);
            });
        });

        function checkPwMatch() {
            const p1   = document.getElementById('sp1').value;
            const p2   = document.getElementById('sp2').value;
            const hint = document.getElementById('pwMatchHint');
            if (!p2) { hint.innerText = ''; return; }
            if (p1 === p2) {
                hint.style.color = '#27ae60';
                hint.innerText   = '✓ Passwords match';
            } else {
                hint.style.color = '#e74c3c';
                hint.innerText   = '✗ Passwords do not match';
            }
        }

        // ── Signup client-side validation ─────────────────────────
        function validateSignup() {
            const p1 = document.getElementById('sp1').value;
            const p2 = document.getElementById('sp2').value;
            const errBox = document.getElementById('signupErrorBox');
            const errMsg = document.getElementById('signupErrorMsg');

            function showErr(msg) {
                errMsg.innerText = msg;
                errBox.style.display = 'flex';
                errBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            if (p1.length < 6) {
                showErr('Password must be at least 6 characters.');
                return false;
            }
            if (p1 !== p2) {
                showErr('Passwords do not match.');
                return false;
            }
            errBox.style.display = 'none';
            return true;
        }
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>