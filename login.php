<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
  <meta charset="UTF-8">
  <title>Login | PROWORLDZ</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --primary-red: #ffffff;
        --primary-red-hover: #e0e0e0;
        --secondary-red: #d0d0d0;
        --accent-red: #a0a0a0;
        --dark-bg: #000000;
        --darker-bg: #050505;
        --card-bg: #111111;
        --card-hover: #1a1a1a;
        --text-primary: #ffffff;
        --text-secondary: #a3a3a3;
        --text-muted: #737373;
        --border-color: rgba(255, 255, 255, 0.1);
        --border-hover: rgba(255, 255, 255, 0.2);
        --success: #ffffff;
        --danger: #ffffff;
        
        --shadow-glow: 0 0 40px rgba(255, 255, 255, 0.1);
        --shadow-intense: 0 20px 60px rgba(255, 255, 255, 0.15);
        --transition-smooth: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        --transition-fast: all 0.2s ease;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: var(--dark-bg);
        color: var(--text-primary);
        line-height: 1.6;
        overflow-x: hidden;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        position: relative;
    }

    h1, h2, h3, h4 {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 700;
        line-height: 1.2;
    }

    /* ===== BACKGROUND EFFECTS ===== */
    .bg-effects {
        position: fixed;
        inset: 0;
        pointer-events: none;
        z-index: 0;
    }

    .bg-effects::before {
        content: '';
        position: absolute;
        inset: 0;
        background: 
            linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.03) 50%, transparent 100%),
            repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(255, 255, 255, 0.01) 2px, rgba(255, 255, 255, 0.01) 4px);
        opacity: 0.5;
    }

    /* ===== AUTH CONTAINER ===== */
    .auth-container {
        width: 100%;
        max-width: 420px;
        position: relative;
        z-index: 2;
    }

    /* ===== AUTH BOX ===== */
    .auth-box {
        background: var(--card-bg);
        padding: 3rem;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-glow);
        position: relative;
        overflow: hidden;
        transition: var(--transition-smooth);
    }

    .auth-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-red), var(--secondary-red));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.5s ease;
    }

    .auth-box:hover::before {
        transform: scaleX(1);
    }

    .auth-box:hover {
        background: var(--card-hover);
        border-color: var(--border-hover);
        transform: translateY(-5px);
        box-shadow: var(--shadow-intense);
    }

    /* ===== BRAND ===== */
    .brand {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .logo-img {
        width: 150px;
        height: 150px;
        object-fit: contain;
        margin: 0 auto 1.5rem;
        filter: brightness(1.2);
        transition: var(--transition-smooth);
    }

    .logo-img:hover {
        transform: rotate(10deg) scale(1.1);
        filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.5));
    }

    .brand h1 {
        font-size: 2rem;
        font-weight: 900;
        background: linear-gradient(135deg, var(--text-primary) 0%, var(--secondary-red) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
    }

    .brand p {
        color: var(--text-secondary);
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    /* ===== FORM ===== */
    .form-group {
        position: relative;
        margin-bottom: 1.75rem;
    }

    .form-group input {
        width: 100%;
        padding: 1rem 1.25rem;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        color: var(--text-primary);
        font-size: 0.95rem;
        font-family: 'Inter', sans-serif;
        transition: var(--transition-smooth);
        padding-right: 3rem;
    }

    .form-group input:focus {
        outline: none;
        border-color: var(--primary-red);
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
        background: rgba(255, 255, 255, 0.08);
    }

    .form-group input::placeholder {
        color: var(--text-muted);
    }

    .form-group label {
        position: absolute;
        top: 1rem;
        left: 1.25rem;
        color: var(--text-secondary);
        font-size: 0.95rem;
        pointer-events: none;
        transition: var(--transition-smooth);
        background: transparent;
    }

    .form-group input:focus + label,
    .form-group input:not(:placeholder-shown) + label {
        top: -0.75rem;
        left: 0.75rem;
        font-size: 0.75rem;
        color: var(--text-primary);
        padding: 0 0.5rem;
        background: var(--card-bg);
    }

    /* ===== PASSWORD TOGGLE ===== */
    .password-toggle {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--text-secondary);
        cursor: pointer;
        font-size: 1rem;
        padding: 0.25rem;
        transition: var(--transition-fast);
    }

    .password-toggle:hover {
        color: var(--text-primary);
        transform: translateY(-50%) scale(1.1);
    }

    /* ===== BUTTON ===== */
    .btn-login {
        width: 100%;
        padding: 1rem;
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg, #ffffff 0%, #d0d0d0 100%);
        color: #000000;
        font-size: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        cursor: pointer;
        margin-top: 0.5rem;
        transition: var(--transition-smooth);
        font-family: 'Space Grotesk', sans-serif;
        position: relative;
        overflow: hidden;
    }

    .btn-login::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn-login:hover::before {
        left: 100%;
    }

    .btn-login:hover {
        background: linear-gradient(135deg, #ffffff 0%, #e0e0e0 100%);
        box-shadow: var(--shadow-intense);
        transform: translateY(-3px);
    }

    .btn-login:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    /* ===== ERROR / LOADING ===== */
    .error {
        text-align: center;
        color: var(--text-primary);
        font-size: 0.875rem;
        margin: 0.75rem 0;
        display: none;
        background: rgba(255, 255, 255, 0.05);
        padding: 0.75rem;
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .loading {
        text-align: center;
        color: var(--text-primary);
        font-size: 0.875rem;
        margin: 0.75rem 0;
        display: none;
    }

    .loading::after {
        content: '';
        display: inline-block;
        width: 1rem;
        height: 1rem;
        margin-left: 0.5rem;
        border: 2px solid var(--border-color);
        border-top-color: var(--text-primary);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        vertical-align: middle;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeIn {
        opacity: 0;
        animation: fadeInUp 0.6s ease forwards;
    }

    .animate-delay-1 { animation-delay: 0.1s; }
    .animate-delay-2 { animation-delay: 0.2s; }
    .animate-delay-3 { animation-delay: 0.3s; }
    .animate-delay-4 { animation-delay: 0.4s; }

    /* ===== RESPONSIVE DESIGN ===== */
    @media (max-width: 768px) {
        .auth-box {
            padding: 2.5rem;
        }
        
        .logo-img {
            width: 70px;
            height: 70px;
        }
        
        .brand h1 {
            font-size: 1.75rem;
        }
    }

    @media (max-width: 480px) {
        body {
            padding: 15px;
        }
        
        .auth-box {
            padding: 2rem;
        }
        
        .brand h1 {
            font-size: 1.5rem;
        }
        
        .brand p {
            font-size: 0.75rem;
        }
        
        .form-group input {
            padding: 0.875rem 1rem;
            font-size: 0.875rem;
        }
        
        .btn-login {
            padding: 0.875rem;
            font-size: 0.875rem;
        }
    }

    @media (max-width: 360px) {
        .auth-box {
            padding: 1.75rem 1.5rem;
        }
        
        .logo-img {
            width: 60px;
            height: 60px;
            margin-bottom: 1rem;
        }
        
        .brand h1 {
            font-size: 1.25rem;
        }
    }

    /* Font weight enforcement */
    body, h1, h2, h3, h4, h5, h6, p, span, div, li, a, button, input {
        font-weight: 700 !important;
    }
  </style>
</head>
<body>
  <!-- Background Effects -->
  <div class="bg-effects"></div>

  <div class="auth-container">
    <div class="auth-box animate-fadeIn">
      <div class="brand">
        <img src="images/eaglone/e-welcome-gen.png" alt="ProWorldz Logo" class="logo-img animate-fadeIn">
        <h1 class="animate-fadeIn animate-delay-1">PROWORLDZ</h1>
        <p class="animate-fadeIn animate-delay-2">Access your professional learning dashboard</p>
      </div>

      <div class="form-group animate-fadeIn animate-delay-3">
        <input type="email" id="mail-login" name="mail-login" placeholder=" " required>
        <label>Email Address</label>
      </div>

      <div class="form-group animate-fadeIn animate-delay-4">
        <input type="password" id="passw-login" name="passw-login" placeholder=" " required>
        <label>Password</label>
        <button type="button" class="password-toggle" id="togglePassword">
          <i class="fas fa-eye"></i>
        </button>
      </div>

      <div class="error" id="errorMessage">
        <i class="fas fa-exclamation-circle"></i> Invalid credentials. Please try again.
      </div>
      
      <div class="loading" id="loading">
        Authenticating...
      </div>

      <button type="submit" class="btn-login animate-fadeIn animate-delay-4" onclick="login()" id="loginBtn">
        <i class="fas fa-sign-in-alt"></i> Login
      </button>
    </div>
  </div>

<script>
  // Password toggle
  document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('passw-login');
    const icon = this.querySelector('i');
    const type = passwordInput.type === 'password' ? 'text' : 'password';
    passwordInput.type = type;
    
    if (type === 'password') {
      icon.className = 'fas fa-eye';
      this.style.color = 'var(--text-secondary)';
    } else {
      icon.className = 'fas fa-eye-slash';
      this.style.color = 'var(--text-primary)';
    }
  });

  // Form focus effects
  const inputs = document.querySelectorAll('.form-group input');
  inputs.forEach(input => {
    input.addEventListener('focus', function() {
      this.parentElement.style.transform = 'translateY(-2px)';
    });
    
    input.addEventListener('blur', function() {
      this.parentElement.style.transform = 'translateY(0)';
    });
  });

  // Login function
  function login(){
    let datas = new FormData();
    let mail = document.getElementById('mail-login').value;
    let pass = document.getElementById('passw-login').value;
    datas.append("mail-login",mail);
    datas.append("passw-login",pass);

    // Show loading
    document.getElementById('loading').style.display = 'block';
    document.getElementById('loginBtn').disabled = true;
    document.getElementById('errorMessage').style.display = 'none';

    fetch("https://proworldz.page.gd/api/auth/login.php", {
        method: 'POST',
        body: datas,
        credentials: 'include'
    })
    .then(res => res.json())
    .then(data => {
        console.log('API Response:', data);
        console.log('Result value:', data['result']);

        if(data['result'] === 203) {
            alert('Invalid email found');
            showAccessDenied();
            window.location.reload();
        } 
        else if(typeof data['result'] === 'string' && data['result'].toLowerCase() === 'try again') {
            alert(data['result']);
            showAccessDenied();
            window.location.reload();
        } 
        else if(data['result'] === null) {
            showAccessDenied();
            window.location.reload();
        } 
        else if(data['result'] !== null && data['result'].includes('PWZ')) {
            document.getElementById('loginBtn').innerHTML =
                '<i class="fas fa-check"></i> Access Granted';
            document.getElementById('loginBtn').style.background = 'var(--success)';

            // Success effect
            document.querySelector('.auth-box').style.boxShadow =
                '0 0 40px rgba(255, 255, 255, 0.3)';

            setTimeout(() => {
                location.replace('dashboard.php');
            }, 1000);
        }
        else {
            showAccessDenied();
        }
    })
    .catch(err => {
        console.error('Network/Server Error:', err);
        showAccessDenied();
    })
    .finally(() => {
        document.getElementById('loading').style.display = 'none';
        document.getElementById('loginBtn').disabled = false;
    });
  }

  // Access denied handler
  function showAccessDenied() {
    const btn = document.getElementById('loginBtn');
    btn.innerHTML = '<i class="fas fa-times"></i> Access Denied';
    btn.style.background = 'var(--danger)';

    document.querySelector('.auth-box').style.boxShadow =
        '0 0 40px rgba(255, 255, 255, 0.2)';

    setTimeout(() => {
        btn.innerHTML = 'Login';
        btn.style.background = '';
        document.querySelector('.auth-box').style.boxShadow = '';
    }, 2000);
  }

  // Enter key support
  document.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
      const loginBtn = document.getElementById('loginBtn');
      if (!loginBtn.disabled) {
        login();
      }
    }
  });

  // Animation on load
  window.addEventListener('load', function() {
    document.body.classList.add('loaded');
  });
</script>
</body>
</html>