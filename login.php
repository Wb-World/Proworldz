<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | PROWORLDZ</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="auth.css">
  <style>
    /* Basic styles if auth.css is missing */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }
    
    .auth-container {
      width: 100%;
      max-width: 400px;
    }
    
    .auth-box {
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(10px);
      padding: 40px;
      border-radius: 16px;
      border: 1px solid rgba(255, 255, 255, 0.1);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }
    
    h2 {
      color: #fff;
      text-align: center;
      margin-bottom: 10px;
      font-size: 28px;
    }
    
    p {
      color: #b0b0b0;
      text-align: center;
      margin-bottom: 30px;
      font-size: 14px;
    }
    
    .input-group {
      position: relative;
      margin-bottom: 25px;
    }
    
    .input-group input {
      width: 100%;
      padding: 15px;
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 8px;
      color: #fff;
      font-size: 16px;
      outline: none;
      transition: all 0.3s ease;
    }
    
    .input-group input:focus {
      border-color: #ff5722;
      box-shadow: 0 0 0 2px rgba(255, 87, 34, 0.2);
    }
    
    .input-group label {
      position: absolute;
      left: 15px;
      top: 15px;
      color: #888;
      pointer-events: none;
      transition: all 0.3s ease;
      font-size: 16px;
    }
    
    .input-group input:focus + label,
    .input-group input:not(:placeholder-shown) + label {
      top: -10px;
      left: 10px;
      font-size: 12px;
      color: #ff5722;
      background: #0a0a0a;
      padding: 0 8px;
    }
    
    button {
      width: 100%;
      padding: 15px;
      background: linear-gradient(135deg, #ff5722 0%, #ff4081 100%);
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-bottom: 20px;
    }
    
    button:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(255, 87, 34, 0.3);
    }
    
    button:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none;
    }
    
    .switch {
      display: block;
      text-align: center;
      color: #b0b0b0;
      font-size: 14px;
    }
    
    .switch a {
      color: #ff5722;
      text-decoration: none;
      font-weight: 600;
    }
    
    .switch a:hover {
      text-decoration: underline;
    }
    
    .error {
      color: #ff4444;
      font-size: 14px;
      margin-top: 10px;
      text-align: center;
      display: none;
    }
    
    .loading {
      display: none;
      text-align: center;
      color: #ff5722;
      margin: 10px 0;
    }
  </style>
</head>
<body>

<div class="auth-container">
  <div class="auth-box">
    <h2>Welcome Back</h2>
    <p>Login to access your PROWORLDZ dashboard</p>

    <div class="input-group">
      <input type="email" id="mail-login" name="mail-login" required>
      <label>Email Address</label>
    </div>

    <div class="input-group">
      <input type="password" id="passw-login" name="passw-login" required>
      <label>Password</label>
    </div>

    <button type="submit" onclick="login()">Login</buatton>
  </div>
</div>

<script>
  function login(){
    let datas = new FormData();
    let mail = document.getElementById('mail-login').value;
    let pass = document.getElementById('passw-login').value;
    datas.append("mail-login",mail);
    datas.append("passw-login",pass);

    fetch("http://localhost:3000/api/login.php",{
      method:'POST',
      body:datas
    }).then(res => res.json())
    .then(data => {
      if(data['result'] !== null) location.replace('dashboard.php');
    }).catch(err => console.log(err));
  }
</script>

</body>
</html> -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | PROWORLDZ</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      background: #0a0a0a;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }
    
    .auth-container {
      width: 100%;
      max-width: 450px;
    }
    
    .auth-box {
      background: #121212;
      padding: 50px 40px;
      border-radius: 20px;
      border: 1px solid #333;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
      position: relative;
    }
    
    .auth-box::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, #ff5722, #ff005d);
    }
    
    .brand {
      text-align: center;
      margin-bottom: 40px;
    }
    
    .brand-logo {
      width: 60px;
      height: 60px;
      background: linear-gradient(135deg, #ff5722 0%, #ff005d 100%);
      border-radius: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
      font-size: 24px;
      font-weight: 700;
      color: white;
    }
    
    .brand h1 {
      color: #fff;
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 8px;
    }
    
    .brand p {
      color: #888;
      font-size: 14px;
    }
    
    .form-group {
      position: relative;
      margin-bottom: 30px;
    }
    
    .form-group input {
      width: 100%;
      padding: 16px;
      background: #1a1a1a;
      border: 1px solid #333;
      border-radius: 10px;
      color: #fff;
      font-size: 16px;
      outline: none;
    }
    
    .form-group input:focus {
      border-color: #ff5722;
      box-shadow: 0 0 0 2px rgba(255, 87, 34, 0.2);
    }
    
    .form-group label {
      position: absolute;
      left: 16px;
      top: 16px;
      color: #777;
      pointer-events: none;
      transition: all 0.2s ease;
    }
    
    .form-group input:focus + label,
    .form-group input:not(:placeholder-shown) + label {
      top: -10px;
      left: 12px;
      font-size: 13px;
      color: #ff5722;
      background: #121212;
      padding: 0 8px;
    }
    
    .password-toggle {
      position: absolute;
      right: 16px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #777;
      cursor: pointer;
    }
    
    .btn-login {
      width: 100%;
      padding: 16px;
      background: linear-gradient(135deg, #ff5722 0%, #ff005d 100%);
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      margin-top: 10px;
      margin-bottom: 25px;
      transition: transform 0.2s ease;
    }
    
    .btn-login:hover {
      transform: translateY(-2px);
    }
    
    .btn-login:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none;
    }
    
    .auth-footer {
      text-align: center;
      padding-top: 20px;
      border-top: 1px solid #333;
    }
    
    .auth-footer p {
      color: #777;
      font-size: 14px;
      margin-bottom: 15px;
    }
    
    .switch-link {
      color: #ff5722;
      text-decoration: none;
      font-weight: 600;
      font-size: 14px;
    }
    
    .switch-link:hover {
      text-decoration: underline;
    }
    
    .error {
      color: #ff4444;
      font-size: 14px;
      margin: 10px 0;
      text-align: center;
      display: none;
    }
    
    .loading {
      display: none;
      text-align: center;
      color: #ff5722;
      margin: 10px 0;
    }
    
    @media (max-width: 768px) {
      .auth-box {
        padding: 40px 30px;
      }
      
      .brand h1 {
        font-size: 24px;
      }
    }
    
    @media (max-width: 480px) {
      .auth-box {
        padding: 35px 25px;
        border-radius: 15px;
      }
      
      .brand-logo {
        width: 50px;
        height: 50px;
        font-size: 20px;
      }
    }
  </style>
</head>
<body>

<div class="auth-container">
  <div class="auth-box">
    <div class="brand">
      <div class="brand-logo">P</div>
      <h1>PROWORLDZ</h1>
      <p>Access your professional learning dashboard</p>
    </div>

    <div class="form-group">
      <input type="email" id="mail-login" name="mail-login" required>
      <label>Email Address</label>
    </div>

    <div class="form-group">
      <input type="password" id="passw-login" name="passw-login" required>
      <label>Password</label>
      <button type="button" class="password-toggle" id="togglePassword">
        👁️
      </button>
    </div>

    <div class="error" id="errorMessage">
      Invalid credentials. Please try again.
    </div>
    
    <div class="loading" id="loading">
      Loading...
    </div>

    <button type="submit" class="btn-login" onclick="login()" id="loginBtn">
      Sign In to Dashboard
    </button>

    <div class="auth-footer">
      <p>Don't have an account?</p>
      <a href="signup.php" class="switch-link">
        Create Account
      </a>
    </div>
  </div>
</div>

<script>
  // Simple password toggle - lightweight
  document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('passw-login');
    const type = passwordInput.type === 'password' ? 'text' : 'password';
    passwordInput.type = type;
    this.textContent = type === 'password' ? '👁️' : '👁️‍🗨️';
  });


  // YOUR ORIGINAL CODE - Kept exactly as is
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

    fetch("https://proworldz.page.gd/api/login.php",{
      method:'POST',
      body:datas,
      credentials:'include'
    }).then(res => res.json())
    .then(data => {
      if(data != null) {
        location.replace('dashboard.php');
      } else {
        document.getElementById('errorMessage').style.display = 'block';
        document.getElementById('loading').style.display = 'none';
        document.getElementById('loginBtn').disabled = false;
      }
    }).catch(err => {
      console.log(err);
      document.getElementById('errorMessage').style.display = 'block';
      document.getElementById('loading').style.display = 'none';
      document.getElementById('loginBtn').disabled = false;
    });
  }
</script>

</body>
</html>