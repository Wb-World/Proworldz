<?php
session_start();
if(!isset($_SESSION['current-student'])) header("Location: login.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Python Interpreter - ProWorldz</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/pyodide/v0.24.1/full/pyodide.js"></script>
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
            overflow-x: hidden;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background: #121212;
            border-bottom: 1px solid #333;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo h1 {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, #ff5722, #ff005d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2196F3, #1976D2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
        }

        .logout-btn {
            padding: 8px 20px;
            background: linear-gradient(135deg, #ff5722, #ff005d);
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #ff005d, #ff5722);
            box-shadow: 0 10px 20px rgba(255, 60, 0, 0.4);
            transform: translateY(-2px);
        }

        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .interpreter-grid {
            display: grid;
            grid-template-columns: 70% 30%;
            gap: 20px;
            height: calc(100vh - 220px);
            min-height: 400px;
        }

        @media (max-width: 1100px) {
            .interpreter-grid {
                grid-template-columns: 1fr;
                height: auto;
                min-height: auto;
            }
            
            .editor-section {
                height: 500px;
            }
            
            .output-section {
                height: 300px;
            }
        }

        .editor-section, .output-section {
            background: #1a1a1a;
            border-radius: 15px;
            padding: 20px;
            border: 1px solid #333;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .editor-section:hover, .output-section:hover {
            border-color: #ff5722;
            box-shadow: 0 10px 30px rgba(255, 87, 34, 0.1);
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 12px;
            border-bottom: 1px solid #333;
            flex-shrink: 0;
        }

        .section-header h3 {
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
        }

        .section-header h3 i {
            color: #ff5722;
        }

        .status-indicator {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.8rem;
            color: #aaa;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #4CAF50;
        }

        .status-dot.loading {
            background: #FFC107;
            animation: pulse 1.5s infinite;
        }

        .status-dot.error {
            background: #F44336;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        /* Code Editor Container - Takes 70% width */
        .code-editor-container {
            position: relative;
            width: 100%;
            height: 100%;
            background: #1e1e1e;
            border-radius: 8px;
            overflow: hidden;
            flex: 1;
            border: 1px solid #444;
        }

        #code {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            padding: 20px;
            font-family: 'Fira Code', 'Courier New', monospace;
            font-size: 15px;
            color: #d4d4d4 !important;
            background: transparent !important;
            line-height: 1.6;
            border: none;
            outline: none;
            caret-color: #d4d4d4;
            z-index: 2;
            white-space: pre;
            tab-size: 4;
            overflow: auto;
            resize: none;
        }

        /* REMOVED the code-highlight overlay - This was causing the HTML overlap issue */
        /* We'll use a different approach for syntax highlighting */

        /* Scrollbar styling for editor */
        #code::-webkit-scrollbar {
            width: 12px;
            height: 12px;
        }

        #code::-webkit-scrollbar-track {
            background: #252525;
            border-radius: 6px;
        }

        #code::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #ff5722, #ff005d);
            border-radius: 6px;
            border: 3px solid #252525;
        }

        #code::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #ff005d, #ff5722);
        }

        /* Output Section - Takes 30% width */
        .output-display {
            width: 100%;
            height: 100%;
            background: #0e0e0e;
            border: 1px solid #444;
            border-radius: 8px;
            padding: 15px;
            font-family: 'Fira Code', 'Courier New', monospace;
            font-size: 14px;
            color: #fff;
            line-height: 1.5;
            overflow-y: auto;
            white-space: pre-wrap;
            word-break: break-word;
            flex: 1;
            margin: 0;
        }

        .output-display::-webkit-scrollbar {
            width: 10px;
        }

        .output-display::-webkit-scrollbar-track {
            background: #2a2a2a;
            border-radius: 6px;
        }

        .output-display::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #2196F3, #1976D2);
            border-radius: 6px;
            border: 2px solid #2a2a2a;
        }

        .output-success {
            color: #4CAF50;
        }

        .output-error {
            color: #F44336;
        }

        .output-info {
            color: #2196F3;
        }

        .controls-section {
            background: #1a1a1a;
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
            border: 1px solid #333;
        }

        .controls-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 12px;
        }

        .control-btn {
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .run-btn {
            background: linear-gradient(135deg, #ff5722, #ff005d);
            color: white;
        }

        .run-btn:hover:not(:disabled) {
            background: linear-gradient(135deg, #ff005d, #ff5722);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 87, 34, 0.4);
        }

        .clear-btn {
            background: #333;
            color: #aaa;
            border: 1px solid #444;
        }

        .clear-btn:hover {
            background: #444;
            color: #fff;
            border-color: #ff5722;
        }

        .reset-btn {
            background: transparent;
            color: #2196F3;
            border: 1px solid #2196F3;
        }

        .reset-btn:hover {
            background: rgba(33, 150, 243, 0.1);
        }

        .control-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .shortcut-hint {
            background: rgba(255, 87, 34, 0.1);
            border-left: 4px solid #ff5722;
            padding: 10px 15px;
            border-radius: 0 8px 8px 0;
            margin-top: 15px;
            font-size: 0.8rem;
            color: #aaa;
            flex-shrink: 0;
        }

        .shortcut-hint i {
            color: #ff5722;
            margin-right: 6px;
        }

        .shortcut-hint kbd {
            background: #333;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: monospace;
            font-size: 0.9em;
            border: 1px solid #444;
        }

        /* Placeholder styling */
        #code::placeholder {
            color: #6a9955;
            opacity: 0.7;
        }

        @media (max-width: 768px) {
            .header {
                padding: 15px 20px;
            }
            
            .main-container {
                padding: 15px;
            }
            
            .logo h1 {
                font-size: 1.4rem;
            }
            
            .interpreter-grid {
                gap: 15px;
            }
            
            .editor-section, .output-section, .controls-section {
                padding: 15px;
            }
            
            #code {
                font-size: 14px;
                padding: 15px;
            }
            
            .output-display {
                font-size: 13px;
                padding: 12px;
            }
            
            .controls-grid {
                grid-template-columns: 1fr;
            }
            
            .control-btn {
                width: 100%;
            }
            
            .logout-btn {
                padding: 6px 15px;
                font-size: 0.8rem;
            }
            
            .user-avatar {
                width: 35px;
                height: 35px;
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .section-header {
                flex-direction: column;
                gap: 8px;
                align-items: flex-start;
            }
            
            .status-indicator {
                align-self: flex-start;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">
            <h1><i class="fa-brands fa-python"></i> Python Interpreter</h1>
        </div>
        <div class="user-info">
            <button onclick="goBack()" class="logout-btn">
                <i class="fa-solid fa-arrow-left"></i>
                Back
            </button>
            <div class="user-avatar" onclick="goBack()">
                <?= isset($_SESSION['current-student']) ? htmlspecialchars(substr($_SESSION['current-student'], 0, 1)) : 'U' ?>
            </div>
        </div>
    </header>

    <main class="main-container">
        <div class="interpreter-grid">
            <section class="editor-section">
                <div class="section-header">
                    <h3><i class="fas fa-code"></i> Python Code Editor</h3>
                    <div class="status-indicator">
                        <div class="status-dot" id="statusDot"></div>
                        <span id="statusText">Loading Python...</span>
                    </div>
                </div>
                <div class="code-editor-container">
                    <textarea id="code" placeholder="# Write Python code here...
# Press Ctrl+Enter to run
# Press Tab for indentation

print(&quot;Welcome to Python Interpreter!&quot;)

def greet(name):
    return f&quot;Hello, {name}!&quot;

# Example usage
result = greet(&quot;ProWorldz&quot;)
print(result)">print("hello bro")
print("Welcome to ProWorldz Python Interpreter")
import math

def calculate_circle_area(radius):
    return math.pi * radius * radius

if __name__ == "__main__":
    r = 5
    area = calculate_circle_area(r)
    print(f"Area of circle with radius {r} is {area:.2f}")</textarea>
                </div>
                <div class="shortcut-hint">
                    <i class="fas fa-keyboard"></i>
                    <strong>Pro Tip:</strong> Press <kbd>Ctrl</kbd> + <kbd>Enter</kbd> to run your code • <kbd>Tab</kbd> for indentation • <kbd>Shift</kbd> + <kbd>Tab</kbd> for outdent
                </div>
            </section>

            <section class="output-section">
                <div class="section-header">
                    <h3><i class="fas fa-terminal"></i> Output Console</h3>
                    <div class="status-indicator">
                        <span>Execution Results</span>
                    </div>
                </div>
                <pre id="output" class="output-display">Initializing Python interpreter...</pre>
            </section>
        </div>

        <section class="controls-section">
            <div class="controls-grid">
                <button onclick="runPython()" class="control-btn run-btn" id="runBtn">
                    <i class="fas fa-play"></i> Run Python Code
                </button>
                <button onclick="clearCode()" class="control-btn clear-btn">
                    <i class="fas fa-eraser"></i> Clear Code
                </button>
                <button onclick="resetInterpreter()" class="control-btn reset-btn">
                    <i class="fas fa-redo"></i> Reset Interpreter
                </button>
            </div>
        </section>
    </main>

    <script>
        let pyodide = null;
        let isInitialized = false;
        let codeTextarea = null;

        // Initialize Pyodide
        async function initializePyodide() {
            const statusDot = document.getElementById('statusDot');
            const statusText = document.getElementById('statusText');
            const runBtn = document.getElementById('runBtn');
            const output = document.getElementById('output');

            try {
                statusDot.className = 'status-dot loading';
                statusText.textContent = 'Loading Python...';
                runBtn.disabled = true;
                output.textContent = 'Loading Python interpreter (Pyodide v0.24.1)...';

                pyodide = await loadPyodide();
                isInitialized = true;
                
                statusDot.className = 'status-dot';
                statusText.textContent = 'Python Ready';
                runBtn.disabled = false;
                output.innerHTML = '<span class="output-success">✓ Python interpreter initialized successfully!</span>\n\n<span class="output-info">You can now write and execute Python code.</span>\n<span class="output-info">Try the example code or write your own.</span>';
                
            } catch (error) {
                statusDot.className = 'status-dot error';
                statusText.textContent = 'Load Failed';
                output.innerHTML = '<span class="output-error">✗ Failed to load Python interpreter.</span>\n\nPlease check your internet connection and try refreshing the page.';
                console.error('Pyodide load error:', error);
            }
        }

        // Setup editor functionality
        function setupEditor() {
            codeTextarea = document.getElementById('code');
            
            if (!codeTextarea) return;
            
            // Tab key handling
            codeTextarea.addEventListener('keydown', function(e) {
                if (e.key === 'Tab') {
                    e.preventDefault();
                    const start = this.selectionStart;
                    const end = this.selectionEnd;
                    
                    // Insert 4 spaces
                    this.value = this.value.substring(0, start) + '    ' + this.value.substring(end);
                    this.selectionStart = this.selectionEnd = start + 4;
                }
                
                // Ctrl+Enter to run
                if (e.ctrlKey && e.key === 'Enter') {
                    e.preventDefault();
                    runPython();
                }
                
                // Shift+Tab for outdent
                if (e.shiftKey && e.key === 'Tab') {
                    e.preventDefault();
                    const start = this.selectionStart;
                    const before = this.value.substring(0, start);
                    
                    // Find if there are 4 spaces before cursor
                    if (before.endsWith('    ')) {
                        this.value = this.value.substring(0, start - 4) + this.value.substring(start);
                        this.selectionStart = this.selectionEnd = start - 4;
                    }
                }
            });
        }

        // Run Python code
        async function runPython() {
            if (!pyodide || !isInitialized) {
                document.getElementById('output').innerHTML = '<span class="output-error">Python interpreter is still loading. Please wait...</span>';
                return;
            }

            const code = codeTextarea.value;
            const output = document.getElementById('output');
            const runBtn = document.getElementById('runBtn');
            const statusDot = document.getElementById('statusDot');
            const statusText = document.getElementById('statusText');

            runBtn.disabled = true;
            runBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Running...';
            statusDot.className = 'status-dot loading';
            statusText.textContent = 'Executing Code';

            const wrappedCode = `
import sys
from io import StringIO
import traceback

_stdout = sys.stdout
sys.stdout = StringIO()

try:
${code.split("\n").map(l => "    " + l).join("\n")}
    result = sys.stdout.getvalue()
except Exception as e:
    result = f"Error: {str(e)}\\n\\nTraceback:\\n{''.join(traceback.format_exception(type(e), e, e.__traceback__))}"

sys.stdout = _stdout
result
`;

            try {
                const result = await pyodide.runPythonAsync(wrappedCode);
                
                if (result && result.startsWith('Error:')) {
                    output.innerHTML = `<span class="output-error">${escapeHtml(result)}</span>`;
                    statusDot.className = 'status-dot error';
                    statusText.textContent = 'Execution Error';
                } else if (result && result.trim() !== '') {
                    output.textContent = result;
                    statusDot.className = 'status-dot';
                    statusText.textContent = 'Execution Complete';
                } else {
                    output.innerHTML = '<span class="output-info">Code executed successfully (no output).</span>';
                    statusDot.className = 'status-dot';
                    statusText.textContent = 'Execution Complete';
                }
            } catch (err) {
                output.innerHTML = `<span class="output-error">Fatal Error: ${escapeHtml(err.toString())}</span>`;
                statusDot.className = 'status-dot error';
                statusText.textContent = 'Fatal Error';
            } finally {
                runBtn.disabled = false;
                runBtn.innerHTML = '<i class="fas fa-play"></i> Run Python Code';
            }
        }

        // Clear code editor
        function clearCode() {
            if (codeTextarea) {
                codeTextarea.value = '';
            }
            document.getElementById('output').innerHTML = '<span class="output-info">Code editor cleared. Write your Python code above.</span>';
        }

        // Reset interpreter
        async function resetInterpreter() {
            const output = document.getElementById('output');
            output.innerHTML = '<span class="output-info">Resetting Python interpreter...</span>';
            isInitialized = false;
            await initializePyodide();
        }

        // Go back function
        function goBack() {
            if (document.referrer && document.referrer.includes(window.location.hostname)) {
                window.history.back();
            } else {
                window.location.href = 'dashboard.php';
            }
            return false;
        }

        // Escape HTML helper
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Initialize everything
        document.addEventListener('DOMContentLoaded', function() {
            setupEditor();
            initializePyodide();
        });
    </script>
</body>
</html>