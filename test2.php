<?php
session_start();
$userName = 'Demo User';
$course = 'Computer Science';

$courses = [
    ['title' => 'Secure X', 'description' => 'Master advanced cybersecurity techniques.', 'image' => 'images/jai-bro/secure-x.png', 'badge' => 'Advanced'],
    ['title' => 'AI Verse Web Labs', 'description' => 'Build intelligent web applications.', 'image' => 'images/jai-bro/ai.png', 'badge' => 'Professional'],
    ['title' => 'Hunt Elite', 'description' => 'Professional bug bounty hunting.', 'image' => 'images/jai-bro/hunt-elite.png', 'badge' => 'Expert'],
    ['title' => 'Creative Craft', 'description' => 'Master visual communication design.', 'image' => 'images/jai-bro/creative-craft.png', 'badge' => 'Creative'],
    ['title' => 'Py Desk Systems', 'description' => 'Develop desktop applications.', 'image' => 'images/jai-bro/py-desk.png', 'badge' => 'Development'],
    ['title' => 'Biz Dev', 'description' => 'Combine business strategy.', 'image' => 'images/jai-bro/biz.png', 'badge' => 'Business'],
    ['title' => 'Code Foundry', 'description' => 'Professional programming mastery.', 'image' => 'images/jai-bro/code-f.png', 'badge' => 'Fundamental'],
    ['title' => 'Startup Gene Labs', 'description' => 'Venture creation.', 'image' => 'images/jai-bro/startup.png', 'badge' => 'Entrepreneurship'],
    ['title' => 'CLI++ Systems', 'description' => 'C++ command-line tools.', 'image' => 'images/jai-bro/cli.png', 'badge' => 'Systems'],
    ['title' => 'API Man', 'description' => 'Master API development.', 'image' => 'images/jai-bro/app.png', 'badge' => 'Backend']
];
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - Proworldz</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;border-color:rgba(229,231,235,0.3);outline-color:rgba(156,163,175,0.5);}
        body{font-family:'Roboto Mono',monospace;background-color:#0d1015;color:#f8fafc;min-width:1280px;overflow-x:auto;}
        @font-face{font-family:"Rebels";src:url("https://fonts.gstatic.com/s/roboto/v30/KFOmCnqEu92Fr1Mu4mxK.woff2") format("woff2");font-display:swap;}
        :root{--radius:0.625rem;--background:#0d1015;--foreground:#f8fafc;--card:#1a1d24;--primary:#6366f1;--primary-foreground:#ffffff;--muted:#2d3748;--muted-foreground:#94a3b8;--accent:rgba(248,250,252,0.05);--border:rgba(255,255,255,0.1);--destructive:#ef4444;}
        .desktop-container{display:grid;grid-template-columns:1fr;gap:1.5rem;min-height:100vh;padding:1.5rem;background-color:var(--background);}
        .header{display:flex;justify-content:space-between;align-items:center;padding:1rem 0;margin-bottom:1.5rem;}
        .logo-section{display:flex;align-items:center;gap:1rem;}
        .logo-icon{width:3rem;height:3rem;background-color:var(--primary);border-radius:var(--radius);display:flex;align-items:center;justify-content:center;}
        .logo-icon svg{width:2rem;height:2rem;color:var(--primary-foreground);}
        .logo-text h1{font-family:'Rebels','Roboto Mono',monospace;font-size:2rem;font-weight:700;letter-spacing:-0.02em;}
        .logo-text .subtitle{font-size:0.875rem;color:var(--muted-foreground);text-transform:uppercase;letter-spacing:0.1em;}
        .user-section{display:flex;align-items:center;gap:1.5rem;}
        .user-info{text-align:right;}
        .user-name{font-size:1.25rem;font-weight:600;}
        .user-course{font-size:0.875rem;color:var(--muted-foreground);}
        .logout-btn{background-color:var(--destructive);color:white;border:none;border-radius:calc(var(--radius)-2px);padding:0.5rem 1.5rem;font-family:inherit;font-weight:500;text-transform:uppercase;letter-spacing:0.05em;cursor:pointer;transition:all 0.2s;}
        .logout-btn:hover{background-color:color-mix(in srgb, var(--destructive) 90%, black);}
        .courses-container{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.5rem;margin-top:2rem;}
        .course-card{background-color:var(--card);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;transition:all 0.3s ease;animation:fadeIn 0.5s ease-out;}
        .course-card:hover{transform:translateY(-4px);box-shadow:0 10px 30px rgba(0,0,0,0.3);border-color:var(--primary);}
        .course-image{position:relative;height:180px;overflow:hidden;}
        .course-image img{width:100%;height:100%;object-fit:cover;transition:transform 0.3s ease;}
        .course-card:hover .course-image img{transform:scale(1.05);}
        .course-badge{position:absolute;top:1rem;right:1rem;background-color:var(--primary);color:var(--primary-foreground);padding:0.25rem 0.75rem;border-radius:9999px;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;}
        .course-body{padding:1.5rem;}
        .course-body h3{font-size:1.25rem;font-weight:600;margin-bottom:0.75rem;color:var(--foreground);}
        .course-body p{font-size:0.875rem;color:var(--muted-foreground);line-height:1.6;margin-bottom:1.5rem;}
        .course-action{display:flex;align-items:center;justify-content:center;gap:0.5rem;width:100%;background-color:var(--primary);color:var(--primary-foreground);border:none;border-radius:calc(var(--radius)-2px);padding:0.75rem 1.5rem;font-family:inherit;font-weight:500;text-transform:uppercase;letter-spacing:0.05em;cursor:pointer;transition:all 0.2s;}
        .course-action:hover{background-color:color-mix(in srgb, var(--primary) 90%, black);transform:translateY(-1px);}
        @keyframes fadeIn{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}
        .animate-fadeIn{animation:fadeIn 0.5s ease-out;}
        @media(max-width:1400px){.courses-container{grid-template-columns:repeat(3,1fr);}}
        @media(max-width:1200px){.courses-container{grid-template-columns:repeat(2,1fr);}}
        @media(max-width:768px){body{min-width:unset;}.desktop-container{padding:1rem;}.courses-container{grid-template-columns:1fr;}.header{flex-direction:column;gap:1rem;text-align:center;}.user-section{flex-direction:column;gap:1rem;}.user-info{text-align:center;}}
    </style>
</head>
<body>
    <div class="desktop-container">
        <div class="header">
            <div class="logo-section">
                <div class="logo-icon">
                    <svg viewBox="0 0 20 20" fill="currentColor"><path d="M10 6.559 6.166 8.16l-.22 3.536 1.76 1.587.346 1.729L10 15.42l1.949-.408.345-1.729 1.76-1.587-.22-3.536L10 6.56Zm0-4.039 1.556 1.791 2.326-.691-.833 1.996 2.703 1.131A3.055 3.055 0 0 1 18.8 9.811c0 1.666-1.32 3.018-2.954 3.065l-1.681 1.461-.503 2.42L10 17.48l-3.661-.723-.503-2.42-1.682-1.461C2.52 12.829 1.2 11.477 1.2 9.81A3.055 3.055 0 0 1 4.25 6.747l2.703-1.131-.833-1.996 2.325.691L10 2.52Zm-.597 7.04c0 .754-.566 1.383-1.336 1.383-.785 0-1.367-.629-1.367-1.383h2.703Zm-.597 2.451h2.389L10 13.913 8.806 12.01ZM13.3 9.56c0 .754-.581 1.383-1.367 1.383-.77 0-1.336-.629-1.336-1.383H13.3Zm-10.198.251c0 .519.361.959.832 1.085l.173-2.2A1.111 1.111 0 0 0 3.102 9.81Zm12.964 1.085c.471-.126.833-.566.833-1.085 0-.581-.44-1.052-1.006-1.115l.173 2.2Z"/></svg>
                </div>
                <div class="logo-text">
                    <h1>Proworldz Academy</h1>
                    <div class="subtitle">Professional Courses</div>
                </div>
            </div>
            <div class="user-section">
                <div class="user-info">
                    <div class="user-name"><?php echo htmlspecialchars($userName); ?></div>
                    <div class="user-course"><?php echo htmlspecialchars($course); ?></div>
                </div>
                <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>
            </div>
        </div>
        <div class="courses-container">
            <?php foreach ($courses as $index => $course): ?>
            <div class="course-card animate-fadeIn" style="animation-delay: <?php echo $index * 0.1; ?>s">
                <div class="course-image">
                    <img src="<?php echo htmlspecialchars($course['image']); ?>" alt="<?php echo htmlspecialchars($course['title']); ?>">
                    <div class="course-badge"><?php echo htmlspecialchars($course['badge']); ?></div>
                </div>
                <div class="course-body">
                    <h3><?php echo htmlspecialchars($course['title']); ?></h3>
                    <p><?php echo htmlspecialchars($course['description']); ?></p>
                    <button class="course-action" onclick="window.open('coursev.php?title=<?php echo urlencode($course['title']); ?>', '_blank')">
                        Course Videos
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" style="margin-left:4px;"><path d="M8 0L6.59 1.41 12.17 7H0v2h12.17l-5.58 5.59L8 16l8-8-8-8z"/></svg>
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {threshold: 0.1, rootMargin: '0px 0px -50px 0px'});
        document.querySelectorAll('.course-card').forEach(card => observer.observe(card));
    </script>
</body>
</html>