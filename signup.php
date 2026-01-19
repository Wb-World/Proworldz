<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up | PROWORLDZ</title>
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
      max-width: 500px;
    }
    
    .auth-box {
      background: #121212;
      padding: 40px;
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
      padding: 16px;
      background: #1a1a1a;
      border: 1px solid #333;
      border-radius: 10px;
      color: #fff;
      font-size: 16px;
      outline: none;
      transition: all 0.2s ease;
    }
    
    .input-group input:focus {
      border-color: #ff5722;
      box-shadow: 0 0 0 2px rgba(255, 87, 34, 0.2);
    }
    
    .input-group label {
      position: absolute;
      left: 16px;
      top: 16px;
      color: #888;
      pointer-events: none;
      transition: all 0.2s ease;
      font-size: 16px;
    }
    
    .input-group input:focus + label,
    .input-group input:not(:placeholder-shown) + label {
      top: -10px;
      left: 12px;
      font-size: 13px;
      color: #ff5722;
      background: #121212;
      padding: 0 8px;
    }
    
    button {
      width: 100%;
      padding: 16px;
      background: linear-gradient(135deg, #ff5722 0%, #ff005d 100%);
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: transform 0.2s ease;
      margin-top: 10px;
      margin-bottom: 25px;
    }
    
    button:hover {
      transform: translateY(-2px);
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
      margin-top: 5px;
      display: none;
    }
    
    .loading {
      display: none;
      text-align: center;
      color: #ff5722;
      margin: 10px 0;
    }
    
    .success {
      color: #4CAF50;
      font-size: 14px;
      text-align: center;
      margin: 10px 0;
      display: none;
    }
    
    .gender-group {
      display: flex;
      gap: 15px;
      margin-bottom: 25px;
    }
    
    .gender-option {
      flex: 1;
      padding: 16px;
      background: #1a1a1a;
      border: 1px solid #333;
      border-radius: 10px;
      color: #888;
      text-align: center;
      cursor: pointer;
      transition: all 0.2s ease;
    }
    
    .gender-option.selected {
      border-color: #ff5722;
      color: #ff5722;
      background: rgba(255, 87, 34, 0.1);
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
      .auth-container {
        max-width: 450px;
      }
      
      .auth-box {
        padding: 30px;
      }
      
      h2 {
        font-size: 24px;
      }
      
      .gender-group {
        flex-direction: column;
        gap: 10px;
      }
    }
    
    @media (max-width: 480px) {
      body {
        padding: 15px;
      }
      
      .auth-container {
        max-width: 100%;
      }
      
      .auth-box {
        padding: 25px 20px;
        border-radius: 15px;
      }
      
      h2 {
        font-size: 22px;
      }
      
      p {
        font-size: 13px;
      }
      
      .input-group input {
        padding: 14px;
        font-size: 15px;
      }
      
      button {
        padding: 14px;
        font-size: 15px;
      }
    }
    
    @media (max-width: 360px) {
      .auth-box {
        padding: 20px 15px;
      }
      
      h2 {
        font-size: 20px;
      }
      
      .input-group input {
        padding: 12px;
      }
      
      button {
        padding: 12px;
      }
    }
  </style>
</head>
<body>

<div class="auth-container">
  <div class="auth-box">
    <h2>Create Your Account</h2>
    <p>Join PROWORLDZ and start your tech journey</p>

    <form id="signupForm">
      <div class="input-group">
        <input type="text" id="student-name" name="student-name" required placeholder=" ">
        <label for="student-name">Full Name</label>
        <div class="error" id="nameError">Please enter your full name</div>
      </div>

      <div class="input-group">
        <input type="email" id="email" name="email" required placeholder=" ">
        <label for="email">Email Address</label>
        <div class="error" id="emailError">Please enter a valid email</div>
      </div>

      <div class="gender-group">
        <div class="gender-option" data-value="male">Male</div>
        <div class="gender-option" data-value="female">Female</div>
        <div class="gender-option" data-value="other">Other</div>
      </div>
      <input type="hidden" id="gender" name="gender">

      <div class="input-group">
        <input type="tel" id="phone" name="phone" required placeholder=" ">
        <label for="phone">Mobile Number</label>
        <div class="error" id="phoneError">Please enter a valid phone number</div>
      </div>

      <div class="input-group">
        <input type="password" id="passw" name="passw" required placeholder=" ">
        <label for="passw">Password</label>
        <div class="error" id="passwError">Password must be at least 8 characters</div>
      </div>

      <div class="input-group">
        <input type="password" id="confirm-passw" name="confirm-passw" required placeholder=" ">
        <label for="confirm-passw">Confirm Password</label>
        <div class="error" id="confirmError">Passwords do not match</div>
      </div>

      <div class="error" id="formError"></div>
      <div class="success" id="formSuccess"></div>
      <div class="loading" id="loading">Creating account...</div>

      <button type="submit" id="submitBtn">Create Account</button>

      <span class="switch">
        Already have an account?
        <a href="login.php">Login</a>
      </span>
    </form>
  </div>
</div>
<script>
  document.querySelectorAll('.gender-option').forEach(option => {
    option.addEventListener('click', function() {
      document.querySelectorAll('.gender-option').forEach(opt => {
        opt.classList.remove('selected');
      });
      this.classList.add('selected');
      document.getElementById('gender').value = this.dataset.value;
    });
  });

  function validateForm() {
    let isValid = true;
    
    document.querySelectorAll('.error').forEach(el => el.style.display = 'none');
    document.getElementById('formError').style.display = 'none';
    
    const name = document.getElementById('student-name').value.trim();
    const email = document.getElementById('email').value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const gender = document.getElementById('gender').value;
    const phone = document.getElementById('phone').value.trim();
    const phoneRegex = /^[+]?[0-9\s\-]{10,}$/;
    const password = document.getElementById('passw').value;
    const confirmPassword = document.getElementById('confirm-passw').value;
    
    if (!name) {
      document.getElementById('nameError').style.display = 'block';
      isValid = false;
    }
    
    if (!email || !emailRegex.test(email)) {
      document.getElementById('emailError').style.display = 'block';
      isValid = false;
    }
    
    if (!gender) {
      document.getElementById('formError').textContent = 'Please select your gender';
      document.getElementById('formError').style.display = 'block';
      isValid = false;
    }
    
    if (!phone || !phoneRegex.test(phone)) {
      document.getElementById('phoneError').style.display = 'block';
      isValid = false;
    }
    
    if (password.length < 8) {
      document.getElementById('passwError').style.display = 'block';
      isValid = false;
    }
    
    if (password !== confirmPassword) {
      document.getElementById('confirmError').style.display = 'block';
      isValid = false;
    }
    
    return isValid;
  }

  document.getElementById('signupForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (!validateForm()) return;
    
    document.getElementById('loading').style.display = 'block';
    document.getElementById('submitBtn').disabled = true;
    document.getElementById('formError').style.display = 'none';
    
    const formData = new FormData();
    formData.append('student-name', document.getElementById('student-name').value);
    formData.append('email', document.getElementById('email').value);
    formData.append('gender', document.getElementById('gender').value);
    formData.append('phone', document.getElementById('phone').value);
    formData.append('passw', document.getElementById('passw').value);
    
    fetch('https://proworldz.page.gd/api/signup.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {

      switch (data.result) {
        case 200:
          alert("Signup successful");
          window.location.href = "login.php";
          break;

        case 409:
          showError("User already exists");
          break;

        case 422:
          showError("Invalid input");
          break;

        default:
          showError("Signup failed");
      }
    })
    .catch(() => showError("Network error"));

    function showError(msg) {
      document.getElementById('formError').textContent = msg;
      document.getElementById('formError').style.display = 'block';
    }

  });

  document.addEventListener('keypress', function(e) {
    if (e.key === 'Enter' && e.target.tagName !== 'BUTTON') {
      e.preventDefault();
    }
  });
</script>
</body>
</html>