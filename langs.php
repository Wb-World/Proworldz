<?php
session_start();
if(!isset($_SESSION['current-student'])) header("Location: login.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Programming Labs | ProWorldz</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background: #0e0e0e;
    color: #fff;
    min-height: 100vh;
}

.dashboard {
    display: flex;
    min-height: 100vh;
    flex-direction: column;
}

/* BACK BUTTON STYLES */
.back-btn-container {
    padding: 20px 30px;
    display: flex;
    align-items: center;
}

.back-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(255, 87, 34, 0.1);
    border: 1px solid rgba(255, 87, 34, 0.3);
    color: #ff5722;
    padding: 10px 20px;
    border-radius: 30px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    width: fit-content;
}

.back-btn:hover {
    background: rgba(255, 87, 34, 0.2);
    box-shadow: 0 0 15px rgba(255, 87, 34, 0.3);
    transform: translateY(-2px);
}

.back-btn i {
    font-size: 18px;
}

/* MAIN CONTENT */
.main {
    padding: 0 30px 30px;
    width: 100%;
    min-height: 100vh;
}

/* PAGE HEADER */
.page-header {
    margin-bottom: 40px;
    text-align: center;
}

.page-header h1 {
    font-size: 2.5rem;
    color: #ff5722;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* LABS GRID */
.lab-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
}

/* LAB CARD */
.lab-card {
    background: #1a1a1a;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.lab-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(255, 87, 34, 0.3);
    border-color: rgba(255, 87, 34, 0.3);
}

.lab-icon {
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.2);
    overflow: hidden;
}

.lab-icon i {
    font-size: 6rem;
    transition: transform 0.3s ease;
}

.lab-card:hover .lab-icon i {
    transform: scale(1.1);
}

.lab-content {
    padding: 25px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.lab-content h3 {
    font-size: 1.5rem;
    margin-bottom: 15px;
    color: #fff;
    text-align: center;
}

.lab-content p {
    color: #aaa;
    line-height: 1.6;
    margin-bottom: 20px;
    flex-grow: 1;
    text-align: center;
}

.lab-btn {
    background: linear-gradient(135deg, #ff5722, #ff005d);
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 30px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.9rem;
    width: 100%;
}

.lab-btn:hover {
    background: linear-gradient(135deg, #ff005d, #ff5722);
    box-shadow: 0 5px 15px rgba(255, 87, 34, 0.4);
    transform: translateY(-2px);
}

/* RESPONSIVE DESIGN */
@media (max-width: 1200px) {
    .lab-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        max-width: 900px;
    }
}

@media (max-width: 1024px) {
    .lab-grid {
        grid-template-columns: repeat(2, 1fr);
        max-width: 700px;
    }
    
    .main {
        padding: 0 20px 20px;
    }
}

@media (max-width: 768px) {
    .main {
        padding: 0 15px 15px;
    }
    
    .lab-grid {
        grid-template-columns: 1fr;
        max-width: 500px;
        gap: 20px;
    }
    
    .page-header h1 {
        font-size: 2rem;
    }
    
    .back-btn-container {
        padding: 15px;
    }
}

@media (max-width: 480px) {
    .lab-content {
        padding: 20px;
    }
    
    .lab-content h3 {
        font-size: 1.3rem;
    }
    
    .lab-icon {
        height: 180px;
    }
    
    .lab-btn {
        padding: 10px 20px;
        font-size: 0.85rem;
    }
}
</style>
</head>
<body>

<div class="dashboard">
  <!-- BACK BUTTON -->
  <div class="back-btn-container">
    <a href="lab.php" class="back-btn">
      <i class="fas fa-arrow-left"></i>
      <span>Back to Lab</span>
    </a>
  </div>

  <!-- MAIN -->
  <main class="main">

    <!-- HEADER -->
    <section class="page-header">
      <h1>Coding Language Labs</h1>
    </section>

    <!-- LABS GRID - 3 per row -->
    <section class="lab-grid">
      
      <!-- Python Lab -->
      <div class="lab-card">
        <div class="lab-icon" style="background: linear-gradient(135deg, rgba(49, 112, 143, 0.2), rgba(0, 0, 0, 0.2));">
          <i class="fab fa-python" style="color:#ff5722; font-size: 7rem;"></i>
        </div>
        <div class="lab-content">
          <h3 style="color:#ff5722">Python Lab</h3>
          <p>Write, run and debug Python code in our interactive environment. Perfect for beginners and advanced developers alike.</p>
          <button class="lab-btn" onclick="location.href='lab/pythoni.php'" style="background:#ff5722">
            Go to Python Lab
          </button>
        </div>
      </div>

      <!-- C++ Lab -->
      <!-- <div class="lab-card">
        <div class="lab-icon" style="background: linear-gradient(135deg, rgba(0, 85, 164, 0.2), rgba(0, 0, 0, 0.2));">
          <i class="fas fa-cogs" style="color: #ff5722; font-size: 6.5rem;"></i>
        </div>
        <div class="lab-content">
          <h3 style="color: #ff5722;">C++ Lab</h3>
          <p>Compile and execute C++ programs with our dedicated lab. Supports C++11, C++14, C++17 and C++20 standards.</p>
          <button class="lab-btn" onclick="location.href='cpp-lab.php'" style="background: #ff5722;">
            Go to C++ Lab
          </button>
        </div>
      </div> -->

      <!-- PHP Lab -->
      <!-- <div class="lab-card">
        <div class="lab-icon" style="background: linear-gradient(135deg, rgba(119, 123, 180, 0.2), rgba(0, 0, 0, 0.2));">
          <i class="fab fa-php" style="color: #ff5722; font-size: 7rem;"></i>
        </div>
        <div class="lab-content">
          <h3 style="color: #ff5722;">PHP Lab</h3>
          <p>Develop server-side scripts with PHP in our web-focused lab. Includes MySQL database integration and Apache server.</p>
          <button class="lab-btn" onclick="location.href='php-lab.php'" style="background: #ff5722;">
            Go to php Lab
          </button>
        </div>
      </div> -->

    </section>

  </main>
</div>

<script>
// Add hover effect to lab cards
const labCards = document.querySelectorAll('.lab-card');
labCards.forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-10px)';
        this.style.boxShadow = '0 15px 30px rgba(255, 87, 34, 0.3)';
    });
    
    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
        this.style.boxShadow = '0 10px 20px rgba(0, 0, 0, 0.2)';
    });
});

// Button hover effects
const labButtons = document.querySelectorAll('.lab-btn');
labButtons.forEach(button => {
    button.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-2px)';
        this.style.boxShadow = '0 5px 15px rgba(255, 87, 34, 0.4)';
    });
    
    button.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
        this.style.boxShadow = 'none';
    });
});
</script>

</body>
</html>