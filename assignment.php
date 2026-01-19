<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Assignments | ProWorldz</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assignment.css">
<link rel="stylesheet" href="dashboard.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="dashboard">
  <aside class="sidebar">
      <div class="close-btn" id="closeBtn">
          <i class="fa-solid fa-xmark"></i>
      </div>
      <ul class="menu">
          <li class="active">
              <a href="dashboard.php" style="color: inherit; text-decoration: none;">
                  <i class="fa-solid fa-house"></i>
                  <span>Dashboard</span>
              </a>
          </li>
          <li>
              <a href="assignment.php" style="color: inherit; text-decoration: none;">
                  <i class="fa-solid fa-book"></i>
                  <span>Assignment</span>
              </a>
          </li>
         
          <li>
              <a href="ourcourse.php" style="color: inherit; text-decoration: none;">
                  <i class="fa-solid fa-graduation-cap"></i>
                  <span>Courses</span>
              </a>
          </li>
      </ul>
  </aside>
  <!-- MAIN -->
  <main class="main" id="main-content">
    <!-- This content will be dynamically loaded based on course availability -->
  </main>
</div>

<!-- Modal for GitHub Link Submission -->
<div id="submitModal" class="modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
  <div class="modal-content" style="background-color: white; margin: 15% auto; padding: 30px; border-radius: 12px; width: 90%; max-width: 500px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
    <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h2 style="color: #333; font-size: 24px;">Submit Assignment</h2>
      <span class="close-modal" style="cursor: pointer; font-size: 28px; color: #999;">&times;</span>
    </div>
    <div class="modal-body">
      <p style="margin-bottom: 20px; color: #666;">Please provide your GitHub repository link for this assignment:</p>
      <div class="form-group">
        <label for="githubLink" style="display: block; margin-bottom: 8px; font-weight: 600; color: #444;">GitHub Repository Link</label>
        <input type="url" id="githubLink" placeholder="https://github.com/username/repository" style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border 0.3s;">
      </div>
      <div class="modal-actions" style="display: flex; gap: 15px; margin-top: 30px;">
        <button id="cancelSubmit" class="btn" style="background-color: #f5f5f5; color: #666; padding: 12px 24px; border-radius: 8px; border: none; cursor: pointer; font-weight: 600; flex: 1;">Cancel</button>
        <button id="confirmSubmit" class="btn" style="background-color: #4361ee; color: white; padding: 12px 24px; border-radius: 8px; border: none; cursor: pointer; font-weight: 600; flex: 1;">Submit Assignment</button>
      </div>
    </div>
  </div>
</div>

<script>
  // Global variables
  let currentCourseData = null;
  let currentAssignmentTitle = null;

  // Function to show normal page content
  function showNormalPage(courseData) {
    const mainContent = document.getElementById('main-content');
    currentCourseData = courseData;
    
    // Get assignment based on course
    let assignmentTitle = "Make portfolio website for you";
    if (courseData.course_name === "Secure X") {
      assignmentTitle = "Network Security Audit Report";
    } else if (courseData.course_name === "AI Verse Web Labs") {
      assignmentTitle = "AI-Powered Web Application";
    } else if (courseData.course_name === "Code Foundry") {
      assignmentTitle = "Multi-language Coding Project";
    } else if (courseData.course_name === "CLI++ Systems") {
      assignmentTitle = "C++ Command Line Tool";
    } else if (courseData.course_name === "APMan") {
      assignmentTitle = "REST API Development";
    }
    
    currentAssignmentTitle = assignmentTitle;
    
    mainContent.innerHTML = `
      <!-- HEADER -->
      <div class="assignment-header">
        <h1>Assignments - ${courseData.course_name}</h1>
        <p>Track and submit your course assignments</p>
      </div>

      <!-- STATS -->
      <div class="stats">
        <div class="stat-card">
          <i class="fa-solid fa-file"></i>
          <div>
            <h2 id="show-assigns">${courseData.total_assigns}</h2>
            <span>Total Assignments</span>
          </div>
        </div>

        <div class="stat-card success">
          <i class="fa-solid fa-circle-check"></i>
          <div>
            <h2 id="fine-assigns">${courseData.assignment_completion}</h2>
            <span>Submitted</span>
          </div>
        </div>
      </div>

      <!-- ASSIGNMENT LIST -->
      <div class="assignment-list">
        <div class="assignment-card" id="assignment-card-1">
          <div class="left">
            <div class="icon"><i class="fa-solid fa-file-lines"></i></div>
            <div>
              <h3>${assignmentTitle}</h3>
              <p>${courseData.course_name}</p>
              <span><i class="fa-regular fa-calendar"></i> Dec 28, 2024 • 100 pts</span>
            </div>
          </div>
          <div class="right">
            <button class="btn submit" onclick="openSubmitModal()">Submit</button>
          </div>
        </div>
      </div>
    `;
  }

  // Function to show "no assignment found" page
  function showNoAssignmentPage() {
    const mainContent = document.getElementById('main-content');
    
    mainContent.innerHTML = `
      <div class="no-assignment-container" style="text-align: center; padding: 50px 20px;">
        <div class="icon-container" style="font-size: 80px; color: #6c757d; margin-bottom: 20px;">
          <i class="fa-solid fa-book-open-reader"></i>
        </div>
        <h2 style="color: #495057; margin-bottom: 15px;">No Course Found</h2>
        <p style="color: #6c757d; font-size: 16px; max-width: 500px; margin: 0 auto 30px;">
          You haven't enrolled in any course yet. Please enroll in a course to access assignments.
        </p>
        <a href="ourcourse.php" class="btn" style="background-color:  #ff5722; color: white; padding: 12px 30px; 
           border-radius: 8px; text-decoration: none; display: inline-block; font-weight: 600;">
          <i class="fa-solid fa-graduation-cap"></i> Browse Courses
        </a>
      </div>
    `;
  }

  // Modal functions
  function openSubmitModal() {
    document.getElementById('submitModal').style.display = 'block';
    document.getElementById('githubLink').value = '';
  }

  function closeSubmitModal() {
    document.getElementById('submitModal').style.display = 'none';
  }

  // Function to submit assignment
  async function submitAssignment(githubLink) {
    try {
      // 1. Update database - set assignment_completion to 1
      const updateResponse = await fetch('update_assignment.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          course_id: currentCourseData.id,
          assignment_completion: 1
        })
      });

      if (!updateResponse.ok) {
        throw new Error('Failed to update database');
      }

      // 2. Send WhatsApp notification
      const whatsappData = {
        phone: "9944994778", // Replace with your WhatsApp number
        message: `New Assignment Submission!\n\nStudent: ${currentCourseData.username || 'Unknown'}\nCourse: ${currentCourseData.course_name}\nAssignment: ${currentAssignmentTitle}\nGitHub: ${githubLink}\nSubmitted at: ${new Date().toLocaleString()}`
      };

      // Call WhatsApp API (replace with your actual WhatsApp API endpoint)
      const whatsappResponse = await fetch('YOUR_WHATSAPP_API_ENDPOINT', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(whatsappData)
      });

      if (whatsappResponse.ok) {
        // Update UI to show "Submitted" status
        updateAssignmentStatus();
        
        // Show success message
        alert('Assignment submitted successfully! You will receive confirmation shortly.');
        closeSubmitModal();
        
        // Refresh page after 2 seconds to show updated stats
        setTimeout(() => {
          location.reload();
        }, 2000);
      } else {
        throw new Error('WhatsApp notification failed, but assignment was recorded');
      }

    } catch (error) {
      console.error('Submission error:', error);
      alert('Error submitting assignment. Please try again or contact support.');
    }
  }

  // Function to update UI after submission
  function updateAssignmentStatus() {
    const submitButton = document.querySelector('.btn.submit');
    if (submitButton) {
      submitButton.innerHTML = '<i class="fa-solid fa-circle-check"></i> Submitted';
      submitButton.style.backgroundColor = '#4CAF50';
      submitButton.style.cursor = 'default';
      submitButton.disabled = true;
      submitButton.onclick = null;
      
      // Update stats
      const fineAssigns = document.getElementById('fine-assigns');
      if (fineAssigns) {
        const current = parseInt(fineAssigns.textContent) || 0;
        fineAssigns.textContent = current + 1;
      }
    }
  }

  // Event listeners for modal
  document.addEventListener('DOMContentLoaded', function() {
    // Close modal when clicking X
    document.querySelector('.close-modal').addEventListener('click', closeSubmitModal);
    
    // Close modal when clicking cancel
    document.getElementById('cancelSubmit').addEventListener('click', closeSubmitModal);
    
    // Handle form submission
    document.getElementById('confirmSubmit').addEventListener('click', function() {
      const githubLink = document.getElementById('githubLink').value.trim();
      
      // Validate GitHub link
      if (!githubLink) {
        alert('Please enter your GitHub repository link');
        return;
      }
      
      if (!githubLink.startsWith('https://github.com/')) {
        alert('Please enter a valid GitHub repository URL');
        return;
      }
      
      // Show loading state
      this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Submitting...';
      this.disabled = true;
      
      // Submit assignment
      submitAssignment(githubLink);
    });
    
    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
      const modal = document.getElementById('submitModal');
      if (event.target === modal) {
        closeSubmitModal();
      }
    });
  });

  // Fetch course data and render appropriate content
  fetch('https://proworldz.page.gd/api/get_courses.php', {
    method: 'GET',
    credentials: 'include'
  })
  .then(res => res.json())
  .then(data => {
    if (data.error) {
      console.error('Error:', data.error);
      showNoAssignmentPage();
    } else if (data.result === 'No Course found' || !data.result) {
      showNoAssignmentPage();
    } else {
      // If result is an array, take the first course
      let courseData;
      if (Array.isArray(data.result)) {
        if (data.result.length === 0) {
          showNoAssignmentPage();
          return;
        }
        courseData = data.result[0]; // Take the first course
      } else {
        courseData = data.result; // Single course object
      }
      
      // Check if course_name exists
      if (courseData.course_name) {
        showNormalPage(courseData);
      } else {
        showNoAssignmentPage();
      }
    }
  })
  .catch(error => {
    console.error('Fetch error:', error);
    showNoAssignmentPage();
  });
</script>

<style>
  /* Modal styles */
  .modal-content {
    animation: modalFadeIn 0.3s;
  }
  
  @keyframes modalFadeIn {
    from { opacity: 0; transform: translateY(-50px); }
    to { opacity: 1; transform: translateY(0); }
  }
  
  #githubLink:focus {
    border-color: #4361ee;
    outline: none;
  }
  
  #confirmSubmit:disabled {
    background-color: #ccc;
    cursor: not-allowed;
  }
  
  .btn.submit {
    transition: all 0.3s ease;
  }
  
  .btn.submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
  }
</style>
</body>
</html>