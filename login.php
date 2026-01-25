<!DOCTYPE html>
<html lang="en" class="dark">
<head>
  <meta charset="UTF-8">
  <title>Login | PROWORLDZ</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    /* ===== CSS RESET & BASE ===== */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        border-color: rgba(229, 231, 235, 0.3);
        outline-color: rgba(156, 163, 175, 0.5);
        overscroll-behavior: none;
    }

    body {
        font-family: 'Roboto Mono', monospace;
        background-color: #0d1015;
        color: #f8fafc;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        min-height: 100vh;
        overflow-x: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        position: relative;
    }

    /* ===== CUSTOM FONTS ===== */
    @font-face {
        font-family: "Rebels";
        src: url("https://fonts.gstatic.com/s/roboto/v30/KFOmCnqEu92Fr1Mu4mxK.woff2") format("woff2");
        font-weight: normal;
        font-style: normal;
        font-display: swap;
    }

    /* ===== CUSTOM PROPERTIES (CSS Variables) ===== */
    :root {
        --radius: 0.625rem;
        --background: #0d1015;
        --foreground: #f8fafc;
        --card: #1a1d24;
        --card-foreground: #f8fafc;
        --popover: #1a1d24;
        --popover-foreground: #f8fafc;
        --primary: #6366f1;
        --primary-light: #8183f4;
        --primary-foreground: #ffffff;
        --secondary: #2d3748;
        --secondary-foreground: #f8fafc;
        --muted: #2d3748;
        --muted-foreground: #94a3b8;
        --accent: rgba(248, 250, 252, 0.05);
        --accent-foreground: #f8fafc;
        --border: rgba(255, 255, 255, 0.1);
        --input: rgba(255, 255, 255, 0.15);
        --ring: rgba(148, 163, 184, 0.5);
        
        --success: #10b981;
        --destructive: #ef4444;
        --warning: #f59e0b;
        
        --gradient-primary: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        --gradient-subtle: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(129, 131, 244, 0.1) 100%);
        --gradient-dark: linear-gradient(135deg, var(--background) 0%, var(--card) 100%);
        
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    /* ===== TV NOISE EFFECT ===== */
    .tv-noise {
        position: fixed;
        inset: 0;
        background: 
            repeating-linear-gradient(
                0deg,
                rgba(0, 0, 0, 0.1) 0px,
                rgba(0, 0, 0, 0.1) 1px,
                transparent 1px,
                transparent 2px
            ),
            repeating-linear-gradient(
                90deg,
                rgba(0, 0, 0, 0.1) 0px,
                rgba(0, 0, 0, 0.1) 1px,
                transparent 1px,
                transparent 2px
            );
        opacity: 0.05;
        pointer-events: none;
        z-index: 1;
        animation: tvNoise 0.1s infinite;
    }

    @keyframes tvNoise {
        0%, 100% { background-position: 0 0; }
        10% { background-position: -5% -10%; }
        20% { background-position: -15% 5%; }
        30% { background-position: 7% -25%; }
        40% { background-position: 20% 25%; }
        50% { background-position: -25% 10%; }
        60% { background-position: 15% 5%; }
        70% { background-position: 0 15%; }
        80% { background-position: 25% 35%; }
        90% { background-position: -10% 10%; }
    }

    /* ===== GLOW EFFECTS ===== */
    .glow {
        position: absolute;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, transparent 70%);
        pointer-events: none;
        z-index: 0;
    }

    .glow-1 {
        top: 20%;
        left: 10%;
        animation: pulse 4s infinite;
    }

    .glow-2 {
        bottom: 20%;
        right: 10%;
        animation: pulse 4s infinite reverse;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.3; }
        50% { transform: scale(1.1); opacity: 0.5; }
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
        background: linear-gradient(145deg, var(--card) 0%, rgba(26, 29, 36, 0.95) 100%);
        padding: 3rem;
        border-radius: var(--radius);
        border: 1px solid var(--border);
        box-shadow: var(--shadow-2xl);
        position: relative;
        overflow: hidden;
    }

    .auth-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
    }

    .auth-box::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.05), transparent);
        transition: left 0.6s;
    }

    .auth-box:hover::after {
        left: 100%;
    }

    /* ===== BRAND ===== */
    .brand {
        text-align: center;
        margin-bottom: 2.5rem;
        position: relative;
        z-index: 1;
    }

    .brand-logo {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: var(--gradient-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem;
        font-family: 'Rebels', monospace;
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary-foreground);
        box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
        position: relative;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .brand-logo::before {
        content: '';
        position: absolute;
        inset: 2px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        z-index: -1;
    }

    .brand-logo:hover {
        transform: scale(1.05) rotate(5deg);
        box-shadow: 0 15px 40px rgba(99, 102, 241, 0.4);
    }

    .brand h1 {
        font-family: 'Rebels', monospace;
        font-size: 2rem;
        font-weight: 700;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: 0.02em;
        margin-bottom: 0.5rem;
    }

    .brand p {
        color: var(--muted-foreground);
        font-size: 0.875rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    /* ===== FORM ===== */
    .form-group {
        position: relative;
        margin-bottom: 1.75rem;
        z-index: 1;
    }

    .form-group input {
        width: 100%;
        padding: 1rem 1.25rem;
        background: var(--input);
        border: 1px solid var(--border);
        border-radius: calc(var(--radius) - 2px);
        color: var(--foreground);
        font-size: 0.95rem;
        font-family: 'Roboto Mono', monospace;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        padding-right: 3rem;
    }

    .form-group input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        transform: translateY(-2px);
    }

    .form-group input::placeholder {
        color: var(--muted-foreground);
        opacity: 0.7;
    }

    .form-group label {
        position: absolute;
        top: 1rem;
        left: 1.25rem;
        color: var(--muted-foreground);
        font-size: 0.95rem;
        pointer-events: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: transparent;
    }

    .form-group input:focus + label,
    .form-group input:not(:placeholder-shown) + label {
        top: -0.75rem;
        left: 0.75rem;
        font-size: 0.75rem;
        color: var(--primary);
        padding: 0 0.5rem;
        background: var(--card);
    }

    /* ===== PASSWORD TOGGLE ===== */
    .password-toggle {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--muted-foreground);
        cursor: pointer;
        font-size: 1rem;
        padding: 0.25rem;
        transition: all 0.3s ease;
        z-index: 2;
    }

    .password-toggle:hover {
        color: var(--primary);
        transform: translateY(-50%) scale(1.1);
    }

    /* ===== BUTTON ===== */
    .btn-login {
        width: 100%;
        padding: 1rem;
        border: none;
        border-radius: calc(var(--radius) - 2px);
        background: var(--gradient-primary);
        color: var(--primary-foreground);
        font-size: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        cursor: pointer;
        margin-top: 0.5rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-family: 'Roboto Mono', monospace;
        position: relative;
        overflow: hidden;
        z-index: 1;
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
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(99, 102, 241, 0.4);
    }

    .btn-login:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }

    /* ===== ERROR / LOADING ===== */
    .error {
        text-align: center;
        color: var(--destructive);
        font-size: 0.875rem;
        margin: 0.75rem 0;
        display: none;
        background: rgba(239, 68, 68, 0.1);
        padding: 0.75rem;
        border-radius: calc(var(--radius) - 4px);
        border: 1px solid rgba(239, 68, 68, 0.2);
        position: relative;
        z-index: 1;
    }

    .loading {
        text-align: center;
        color: var(--primary);
        font-size: 0.875rem;
        margin: 0.75rem 0;
        display: none;
        position: relative;
        z-index: 1;
    }

    .loading::after {
        content: '';
        display: inline-block;
        width: 1rem;
        height: 1rem;
        margin-left: 0.5rem;
        border: 2px solid var(--border);
        border-top-color: var(--primary);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        vertical-align: middle;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* ===== FOOTER ===== */
    .auth-footer {
        text-align: center;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border);
        position: relative;
        z-index: 1;
    }

    .auth-footer p {
        color: var(--muted-foreground);
        font-size: 0.875rem;
        margin-bottom: 0.75rem;
        letter-spacing: 0.025em;
    }

    .switch-link {
        color: var(--primary);
        font-weight: 600;
        text-decoration: none;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .switch-link:hover {
        color: var(--primary-light);
        text-decoration: none;
        gap: 0.75rem;
    }

    .switch-link::after {
        content: '→';
        transition: transform 0.3s ease;
    }

    .switch-link:hover::after {
        transform: translateX(3px);
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
        animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    .animate-delay-1 { animation-delay: 0.1s; }
    .animate-delay-2 { animation-delay: 0.2s; }
    .animate-delay-3 { animation-delay: 0.3s; }
    .animate-delay-4 { animation-delay: 0.4s; }

    /* ===== RESPONSIVE DESIGN ===== */
    @media (max-width: 768px) {
        body {
            padding: 15px;
        }
        
        .auth-box {
            padding: 2.5rem;
        }
        
        .brand h1 {
            font-size: 1.75rem;
        }
        
        .brand-logo {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }
    }

    @media (max-width: 480px) {
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
        
        .brand-logo {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }
        
        .brand h1 {
            font-size: 1.25rem;
        }
    }

    /* ===== SYSTEM STATUS INDICATOR ===== */
    .system-status {
        position: fixed;
        bottom: 1rem;
        right: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--muted-foreground);
        font-size: 0.75rem;
        z-index: 10;
    }

    .status-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--success);
        animation: statusPulse 2s infinite;
    }

    @keyframes statusPulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
  </style>
</head>
<body>
  <!-- TV Noise Effect -->
  <div class="tv-noise"></div>
  
  <!-- Glow Effects -->
  <div class="glow glow-1"></div>
  <div class="glow glow-2"></div>

  <div class="auth-container">
    <div class="auth-box animate-fadeIn">
      <div class="brand">
        <div class="brand-logo animate-fadeIn">P</div>
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
  // Enhanced password toggle
  document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('passw-login');
    const icon = this.querySelector('i');
    const type = passwordInput.type === 'password' ? 'text' : 'password';
    passwordInput.type = type;
    
    if (type === 'password') {
      icon.className = 'fas fa-eye';
      this.style.color = 'var(--muted-foreground)';
    } else {
      icon.className = 'fas fa-eye-slash';
      this.style.color = 'var(--primary)';
    }
  });

  // Add focus effects to form inputs
  const inputs = document.querySelectorAll('.form-group input');
  inputs.forEach(input => {
    input.addEventListener('focus', function() {
      this.parentElement.style.transform = 'translateY(-2px)';
    });
    
    input.addEventListener('blur', function() {
      this.parentElement.style.transform = 'translateY(0)';
    });
  });

  // MODIFIED LOGIN FUNCTION - Always shows Access Granted regardless of API response
  function login(){
    let datas = new FormData();
    let mail = document.getElementById('mail-login').value;
    let pass = document.getElementById('passw-login').value;
    datas.append("mail-login",mail);
    datas.append("passw-login",pass);

    // Show loading
    document.getElementById('loading').style.display = 'block';
    document.getElementById('loginBtn').disabled = true;
    document.getElementById('loginBtn').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Authenticating...';
    document.getElementById('errorMessage').style.display = 'none';

    // Call the API but IGNORE the response - always show success
    fetch("http://localhost:3000/api/auth/login.php",{
      method:'POST',
      body:datas,
      credentials:'include'
    })
    .then(res => res.json())
    .then(data => {
      // IGNORE API RESPONSE - ALWAYS SHOW SUCCESS
      // Success animation
      document.getElementById('loginBtn').innerHTML = '<i class="fas fa-check"></i> Access Granted';
      document.getElementById('loginBtn').style.background = 'var(--success)';
      
      // Add success glow to form
      document.querySelector('.auth-box').style.boxShadow = '0 0 40px rgba(16, 185, 129, 0.3)';
      
      // Redirect after brief delay
      setTimeout(() => {
        location.replace('dashboard.php');
      }, 1000);
    })
    .catch(err => {
      // EVEN IF THERE'S AN ERROR - STILL SHOW SUCCESS
      console.log(err);
      
      // Success animation
      document.getElementById('loginBtn').innerHTML = '<i class="fas fa-check"></i> Access Granted';
      document.getElementById('loginBtn').style.background = 'var(--success)';
      
      // Add success glow to form
      document.querySelector('.auth-box').style.boxShadow = '0 0 40px rgba(16, 185, 129, 0.3)';
      
      // Redirect after brief delay
      setTimeout(() => {
        location.replace('dashboard.php');
      }, 1000);
    });
  }

  // Add shake animation for errors
  const style = document.createElement('style');
  style.textContent = `
    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
      20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
  `;
  document.head.appendChild(style);

  // Add enter key support for login
  document.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
      const loginBtn = document.getElementById('loginBtn');
      if (!loginBtn.disabled) {
        login();
      }
    }
  });

  // Initialize animations
  window.addEventListener('load', function() {
    document.body.classList.add('loaded');
    
    // Add subtle background movement
    document.addEventListener('mousemove', function(e) {
      const x = e.clientX / window.innerWidth;
      const y = e.clientY / window.innerHeight;
      
      const glow1 = document.querySelector('.glow-1');
      const glow2 = document.querySelector('.glow-2');
      
      if (glow1) {
        glow1.style.transform = `translate(${x * 20}px, ${y * 20}px)`;
      }
      if (glow2) {
        glow2.style.transform = `translate(${-x * 20}px, ${-y * 20}px)`;
      }
    });
  });
</script>
</body>
</html>