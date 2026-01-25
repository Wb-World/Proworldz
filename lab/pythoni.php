<?php
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Python Interpreter - ProWorldz</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/pyodide/v0.24.1/full/pyodide.js"></script>
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
            overflow-x: auto;
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
            
            --sidebar: #1a1d24;
            --sidebar-foreground: #f8fafc;
            --sidebar-primary: #6366f1;
            --sidebar-primary-foreground: #ffffff;
            --sidebar-accent: rgba(248, 250, 252, 0.05);
            --sidebar-accent-foreground: #f8fafc;
            --sidebar-border: rgba(255, 255, 255, 0.1);
            --sidebar-ring: rgba(148, 163, 184, 0.5);
            
            --gap: 1.5rem;
            --sides: 1.5rem;
        }

        /* ===== DESKTOP-ONLY LAYOUT ===== */
        .desktop-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: var(--gap);
            min-height: 100vh;
            padding: var(--sides);
            background-color: var(--background);
        }

        /* Main Content Area */
        .desktop-main {
            display: flex;
            flex-direction: column;
            gap: var(--gap);
        }

        /* ===== TYPOGRAPHY ===== */
        .font-display {
            font-family: 'Rebels', 'Roboto Mono', monospace;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        /* ===== UTILITY CLASSES ===== */
        .flex {
            display: flex;
        }

        .grid {
            display: grid;
        }

        .relative {
            position: relative;
        }

        .absolute {
            position: absolute;
        }

        .w-full {
            width: 100%;
        }

        .h-full {
            height: 100%;
        }

        .rounded-lg {
            border-radius: var(--radius);
        }

        .rounded-md {
            border-radius: calc(var(--radius) - 2px);
        }

        .border {
            border-width: 1px;
        }

        .border-2 {
            border-width: 2px;
        }

        .bg-card {
            background-color: var(--card);
        }

        .bg-accent {
            background-color: var(--accent);
        }

        .bg-primary {
            background-color: var(--primary);
        }

        .bg-secondary {
            background-color: var(--secondary);
        }

        .text-foreground {
            color: var(--foreground);
        }

        .text-primary {
            color: var(--primary);
        }

        .text-primary-foreground {
            color: var(--primary-foreground);
        }

        .text-muted-foreground {
            color: var(--muted-foreground);
        }

        .text-success {
            color: var(--success);
        }

        .text-destructive {
            color: var(--destructive);
        }

        .text-xs {
            font-size: 0.75rem;
            line-height: 1rem;
        }

        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }

        .text-base {
            font-size: 1rem;
            line-height: 1.5rem;
        }

        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem;
        }

        .text-xl {
            font-size: 1.25rem;
            line-height: 1.75rem;
        }

        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem;
        }

        .text-3xl {
            font-size: 1.875rem;
            line-height: 2.25rem;
        }

        .font-medium {
            font-weight: 500;
        }

        .font-semibold {
            font-weight: 600;
        }

        .font-bold {
            font-weight: 700;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .text-center {
            text-align: center;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        .transition-colors {
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }

        /* ===== LAYOUT GRID ===== */
        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }

        .grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .gap-2 {
            gap: 0.5rem;
        }

        .gap-3 {
            gap: 0.75rem;
        }

        .gap-4 {
            gap: 1rem;
        }

        .gap-6 {
            gap: 1.5rem;
        }

        .gap-8 {
            gap: 2rem;
        }

        .gap-gap {
            gap: var(--gap);
        }

        .p-3 {
            padding: 0.75rem;
        }

        .p-4 {
            padding: 1rem;
        }

        .p-6 {
            padding: 1.5rem;
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .py-6 {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .pt-4 {
            padding-top: 1rem;
        }

        .pb-4 {
            padding-bottom: 1rem;
        }

        .pr-4 {
            padding-right: 1rem;
        }

        .mt-2 {
            margin-top: 0.5rem;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .mb-6 {
            margin-bottom: 1.5rem;
        }

        .space-y-2 > * + * {
            margin-top: 0.5rem;
        }

        .space-y-3 > * + * {
            margin-top: 0.75rem;
        }

        .space-y-4 > * + * {
            margin-top: 1rem;
        }

        .flex-1 {
            flex: 1 1 0%;
        }

        .flex-col {
            flex-direction: column;
        }

        .items-center {
            align-items: center;
        }

        .items-start {
            align-items: flex-start;
        }

        .justify-center {
            justify-content: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .size-10 {
            width: 2.5rem;
            height: 2.5rem;
        }

        .size-12 {
            width: 3rem;
            height: 3rem;
        }

        .size-16 {
            width: 4rem;
            height: 4rem;
        }

        /* ===== CUSTOM COMPONENT STYLES ===== */
        .card {
            background-color: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border: 1px solid transparent;
        }

        .badge-destructive {
            background-color: var(--destructive);
            color: white;
            border-color: var(--destructive);
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: calc(var(--radius) - 2px);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: all 0.2s;
            cursor: pointer;
            border: 1px solid transparent;
            user-select: none;
            white-space: nowrap;
        }

        .button-default {
            background-color: var(--primary);
            color: var(--primary-foreground);
        }

        .button-default:hover:not(:disabled) {
            background-color: color-mix(in srgb, var(--primary) 90%, black);
            transform: translateY(-2px);
        }

        .button-secondary {
            background-color: var(--secondary);
            color: var(--secondary-foreground);
            border-color: var(--border);
        }

        .button-secondary:hover:not(:disabled) {
            background-color: color-mix(in srgb, var(--secondary) 90%, black);
            transform: translateY(-2px);
        }

        .button-ghost {
            background-color: transparent;
            color: currentColor;
        }

        .button-ghost:hover:not(:disabled) {
            background-color: var(--accent);
        }

        .button-lg {
            height: 3rem;
            padding: 0 1.5rem;
            font-size: 1rem;
        }

        .button-xl {
            height: 3.5rem;
            padding: 0 2rem;
            font-size: 1rem;
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }

        .animate-slideUp {
            animation: slideUp 0.3s ease-out;
        }

        .animate-pulse {
            animation: pulse 2s infinite;
        }

        /* ===== CUSTOM SCROLLBAR ===== */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--muted);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--muted-foreground);
        }

        /* ===== PYTHON INTERPRETER SPECIFIC STYLES ===== */
        .interpreter-header {
            background: linear-gradient(135deg, var(--card) 0%, rgba(13, 16, 21, 0.9) 100%);
            border-bottom: 1px solid var(--border);
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .interpreter-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            height: 100%;
            background: radial-gradient(circle at center, rgba(99, 102, 241, 0.1) 0%, transparent 70%);
        }

        .interpreter-hero {
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .interpreter-hero h1 {
            font-size: 2.8rem;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--primary) 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .interpreter-hero p {
            font-size: 1.2rem;
            color: var(--muted-foreground);
            max-width: 600px;
            line-height: 1.6;
        }

        .environment-info {
            display: flex;
            gap: 2rem;
            margin-top: 1.5rem;
            flex-wrap: wrap;
        }

        .env-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: calc(var(--radius) - 2px);
            font-size: 0.875rem;
        }

        .env-item i {
            color: var(--primary);
        }

        .interpreter-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            height: 600px;
            margin-bottom: 2rem;
        }

        @media (max-width: 1024px) {
            .interpreter-grid {
                grid-template-columns: 1fr;
                height: auto;
                min-height: 800px;
            }
        }

        .editor-section, .output-section {
            background: linear-gradient(135deg, var(--card) 0%, rgba(26, 29, 36, 0.9) 100%);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .editor-section::before, .output-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(to right, var(--primary), #8b5cf6);
        }

        .editor-section:hover, .output-section:hover {
            transform: translateY(-2px);
            border-color: var(--primary);
            box-shadow: 0 10px 40px rgba(99, 102, 241, 0.3);
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }

        .section-header h3 {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--foreground);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-header h3 i {
            color: var(--primary);
            font-size: 1.2rem;
        }

        .status-indicator {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.875rem;
            color: var(--muted-foreground);
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--success);
        }

        .status-dot.loading {
            background: var(--warning);
            animation: pulse 1.5s infinite;
        }

        .status-dot.error {
            background: var(--destructive);
        }

        .code-editor-container {
            flex: 1;
            background: rgba(13, 16, 21, 0.5);
            border: 1px solid var(--border);
            border-radius: calc(var(--radius) - 2px);
            overflow: hidden;
            position: relative;
        }

        #code {
            width: 100%;
            height: 100%;
            padding: 1.5rem;
            font-family: 'Roboto Mono', monospace;
            font-size: 15px;
            line-height: 1.6;
            color: var(--foreground);
            background: transparent;
            border: none;
            outline: none;
            resize: none;
            white-space: pre;
            tab-size: 4;
            caret-color: var(--primary);
        }

        #code::placeholder {
            color: var(--muted-foreground);
            opacity: 0.6;
        }

        #code::-webkit-scrollbar {
            width: 8px;
        }

        #code::-webkit-scrollbar-track {
            background: transparent;
        }

        #code::-webkit-scrollbar-thumb {
            background: var(--muted);
            border-radius: 4px;
        }

        #code::-webkit-scrollbar-thumb:hover {
            background: var(--muted-foreground);
        }

        .output-display {
            flex: 1;
            background: rgba(13, 16, 21, 0.5);
            border: 1px solid var(--border);
            border-radius: calc(var(--radius) - 2px);
            padding: 1.5rem;
            font-family: 'Roboto Mono', monospace;
            font-size: 15px;
            line-height: 1.6;
            color: var(--foreground);
            white-space: pre-wrap;
            word-break: break-word;
            overflow-y: auto;
        }

        .output-display::-webkit-scrollbar {
            width: 8px;
        }

        .output-display::-webkit-scrollbar-track {
            background: transparent;
        }

        .output-display::-webkit-scrollbar-thumb {
            background: var(--muted);
            border-radius: 4px;
        }

        .output-display::-webkit-scrollbar-thumb:hover {
            background: var(--muted-foreground);
        }

        .output-success {
            color: var(--success);
        }

        .output-error {
            color: var(--destructive);
        }

        .output-info {
            color: var(--primary);
        }

        .controls-section {
            background: linear-gradient(135deg, var(--card) 0%, rgba(26, 29, 36, 0.9) 100%);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .controls-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(to right, #8b5cf6, var(--primary));
        }

        .controls-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .shortcut-hint {
            margin-top: 1.5rem;
            padding: 1rem;
            background: rgba(99, 102, 241, 0.1);
            border-left: 4px solid var(--primary);
            border-radius: 0 calc(var(--radius) - 2px) calc(var(--radius) - 2px) 0;
            font-size: 0.9rem;
            color: var(--muted-foreground);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .shortcut-hint i {
            color: var(--primary);
        }

        .shortcut-hint kbd {
            background: var(--secondary);
            padding: 0.25rem 0.75rem;
            border-radius: calc(var(--radius) - 4px);
            font-family: 'Roboto Mono', monospace;
            font-size: 0.875rem;
            border: 1px solid var(--border);
            color: var(--foreground);
            margin: 0 0.25rem;
        }

        .editor-stats {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border);
            font-size: 0.875rem;
            color: var(--muted-foreground);
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        @media (max-width: 768px) {
            .desktop-container {
                padding: 1rem;
            }

            .interpreter-hero h1 {
                font-size: 2.2rem;
            }

            .interpreter-hero p {
                font-size: 1rem;
            }

            .interpreter-grid {
                height: auto;
                min-height: 700px;
            }

            .editor-section, .output-section {
                padding: 1.25rem;
            }

            .controls-grid {
                grid-template-columns: 1fr;
            }

            .environment-info {
                gap: 1rem;
            }

            .env-item {
                padding: 0.5rem 0.75rem;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="desktop-container">
        <!-- Main Content Area -->
        <div class="desktop-main">
            <!-- Python Interpreter Header -->
            <div class="card interpreter-header">
                <div class="interpreter-hero">
                    <h1 class="font-display">Python Interpreter</h1>
                    <p>Write, execute, and debug Python 3.11 code directly in your browser with full standard library support</p>
                    
                    <!-- <div class="environment-info">
                        <div class="env-item">
                            <i class="fab fa-python"></i>
                            <span>Python 3.11</span>
                        </div>
                        <div class="env-item">
                            <i class="fas fa-microchip"></i>
                            <span>Pyodide v0.24.1</span>
                        </div>
                        <div class="env-item">
                            <i class="fas fa-shield-alt"></i>
                            <span>Browser-Safe Execution</span>
                        </div>
                        <div class="env-item">
                            <i class="fas fa-bolt"></i>
                            <span>WebAssembly Runtime</span>
                        </div>
                    </div> -->
                </div>
            </div>

            <!-- Interpreter Grid -->
            <div class="interpreter-grid">
                <!-- Code Editor -->
                <div class="editor-section" style="height: 100cap;">
                    <div class="section-header">
                        <h3><i class="fas fa-code"></i> Code Editor</h3>
                        <div class="status-indicator">
                            <div class="status-dot" id="statusDot"></div>
                            <span id="statusText">Initializing...</span>
                        </div>
                    </div>
                    <div class="code-editor-container">
                        <textarea id="code" placeholder="# Welcome to ProWorldz Python Interpreter
# Write your Python code here
# Press Ctrl+Enter to execute
# Use Tab for indentation

# Example: Simple calculator
def calculate(a, b, operation='add'):
    operations = {
        'add': a + b,
        'subtract': a - b,
        'multiply': a * b,
        'divide': a / b if b != 0 else 'Error: Division by zero'
    }
    return operations.get(operation, 'Invalid operation')

# Test the function
if __name__ == '__main__':
    result = calculate(10, 5, 'multiply')
    print(f'10 * 5 = {result}')">print("Welcome to ProWorldz Python Interpreter")
print("=" * 40)

# Calculate circle area
import math

def calculate_circle_area(radius):
    return math.pi * radius * radius

def calculate_factorial(n):
    if n == 0:
        return 1
    return n * calculate_factorial(n - 1)

# Execute main program
if __name__ == "__main__":
    # Circle calculation
    radius = 7.5
    area = calculate_circle_area(radius)
    print(f"Circle with radius {radius}:")
    print(f"  Area = {area:.2f}")
    print()
    
    # Factorial calculation
    num = 6
    factorial = calculate_factorial(num)
    print(f"Factorial of {num}:")
    print(f"  {num}! = {factorial}")
    print()
    
    print("Program execution completed successfully!")</textarea>
                    </div>
                    <div class="editor-stats">
                        <div class="stat-item">
                            <i class="fas fa-file-code"></i>
                            <span id="lineCount">Lines: 0</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-font"></i>
                            <span id="charCount">Characters: 0</span>
                        </div>
                    </div>
                    <div class="shortcut-hint">
                        <i class="fas fa-keyboard"></i>
                        <div>
                            <strong>Keyboard Shortcuts:</strong> 
                            <kbd>Ctrl</kbd> + <kbd>Enter</kbd> Run Code • 
                            <kbd>Tab</kbd> Indent • 
                            <kbd>Shift</kbd> + <kbd>Tab</kbd> Outdent
                        </div>
                    </div>
                </div>

                <!-- Output Console -->
                <div class="output-section">
                    <div class="section-header">
                        <h3><i class="fas fa-terminal"></i> Output Console</h3>
                        <div class="status-indicator">
                            <span id="executionTime">Ready</span>
                        </div>
                    </div>
                    <pre id="output" class="output-display">Initializing Python interpreter environment...</pre>
                </div>
            </div>

            <!-- Controls Section -->
            <div class="controls-section">
                <div class="controls-grid">
                    <button onclick="runPython()" class="button button-lg button-default" id="runBtn">
                        <i class="fas fa-play"></i> Execute Code
                    </button>
                    <button onclick="clearCode()" class="button button-lg button-secondary">
                        <i class="fas fa-eraser"></i> Clear Editor
                    </button>
                    <button onclick="resetInterpreter()" class="button button-lg button-ghost">
                        <i class="fas fa-redo"></i> Reset Environment
                    </button>
                    <button onclick="saveToFile()" class="button button-lg button-ghost">
                        <i class="fas fa-download"></i> Save Script
                    </button>
                </div>
                <!-- <div class="shortcut-hint">
                    <i class="fas fa-info-circle"></i>
                    <div>
                        <strong>Features:</strong> Full Python 3.11 Standard Library • 
                        Math, Statistics, Random Modules • Safe Browser Execution • 
                        Real-time Output • Error Handling with Traceback
                    </div>
                </div> -->
            </div>
        </div>
    </div>

    <script>
        let pyodide = null;
        let isInitialized = false;
        let codeTextarea = null;
        let executionStartTime = 0;

        async function initializePyodide() {
            const statusDot = document.getElementById('statusDot');
            const statusText = document.getElementById('statusText');
            const runBtn = document.getElementById('runBtn');
            const output = document.getElementById('output');

            try {
                statusDot.className = 'status-dot loading';
                statusText.textContent = 'Loading Python Runtime...';
                runBtn.disabled = true;
                output.textContent = 'Initializing WebAssembly Python environment...\nLoading Pyodide v0.24.1...';

                pyodide = await loadPyodide();
                
                // Load additional packages if needed
                await pyodide.loadPackage(['numpy', 'micropip']);
                
                isInitialized = true;
                
                statusDot.className = 'status-dot';
                statusText.textContent = 'Python 3.11 Ready';
                runBtn.disabled = false;
                output.innerHTML = '<span class="output-success">✓ Python 3.11 environment initialized successfully!</span>\n' +
                                  '<span class="output-info">Standard library modules loaded.</span>\n' +
                                  '<span class="output-info">Write your Python code in the editor and press Execute.</span>';
                
            } catch (error) {
                statusDot.className = 'status-dot error';
                statusText.textContent = 'Initialization Failed';
                output.innerHTML = '<span class="output-error">✗ Failed to initialize Python environment.</span>\n\n' +
                                 'Error: ' + error.message + '\n\n' +
                                 '<span class="output-info">Please check your internet connection and refresh the page.</span>';
                console.error('Pyodide initialization error:', error);
            }
        }

        function setupEditor() {
            codeTextarea = document.getElementById('code');
            
            if (!codeTextarea) return;
            
            // Update character and line count
            function updateStats() {
                const text = codeTextarea.value;
                const lines = text.split('\n').length;
                const chars = text.length;
                document.getElementById('lineCount').textContent = `Lines: ${lines}`;
                document.getElementById('charCount').textContent = `Characters: ${chars}`;
            }
            
            codeTextarea.addEventListener('input', updateStats);
            updateStats(); // Initial count
            
            codeTextarea.addEventListener('keydown', function(e) {
                if (e.key === 'Tab') {
                    e.preventDefault();
                    const start = this.selectionStart;
                    const end = this.selectionEnd;
                    
                    this.value = this.value.substring(0, start) + '    ' + this.value.substring(end);
                    this.selectionStart = this.selectionEnd = start + 4;
                    updateStats();
                }
                
                if (e.ctrlKey && e.key === 'Enter') {
                    e.preventDefault();
                    runPython();
                }
                
                if (e.shiftKey && e.key === 'Tab') {
                    e.preventDefault();
                    const start = this.selectionStart;
                    const before = this.value.substring(0, start);
                    
                    if (before.endsWith('    ')) {
                        this.value = this.value.substring(0, start - 4) + this.value.substring(start);
                        this.selectionStart = this.selectionEnd = start - 4;
                        updateStats();
                    }
                }
            });
        }

        async function runPython() {
            if (!pyodide || !isInitialized) {
                document.getElementById('output').innerHTML = '<span class="output-error">Python environment is still initializing. Please wait...</span>';
                return;
            }

            const code = codeTextarea.value;
            const output = document.getElementById('output');
            const runBtn = document.getElementById('runBtn');
            const statusDot = document.getElementById('statusDot');
            const statusText = document.getElementById('statusText');
            const executionTime = document.getElementById('executionTime');

            runBtn.disabled = true;
            runBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Executing...';
            statusDot.className = 'status-dot loading';
            statusText.textContent = 'Executing Code';
            executionTime.textContent = 'Running...';

            executionStartTime = performance.now();

            const wrappedCode = `
import sys
import io
import traceback
import time

# Capture output
old_stdout = sys.stdout
sys.stdout = io.StringIO()

# Capture errors
old_stderr = sys.stderr
sys.stderr = io.StringIO()

try:
    # User code
${code.split("\n").map(l => "    " + l).join("\n")}
    
    # Get captured output
    stdout_output = sys.stdout.getvalue()
    stderr_output = sys.stderr.getvalue()
    
    # Restore original stdout/stderr
    sys.stdout = old_stdout
    sys.stderr = old_stderr
    
    # Combine outputs
    if stderr_output:
        result = "STDERR:\\n" + stderr_output + "\\nSTDOUT:\\n" + stdout_output
    else:
        result = stdout_output
        
except Exception as e:
    # Restore original stdout/stderr
    sys.stdout = old_stdout
    sys.stderr = old_stderr
    
    # Format error with traceback
    tb = traceback.format_exception(type(e), e, e.__traceback__)
    result = "ERROR:\\n" + ''.join(tb)

result
`;

            try {
                const result = await pyodide.runPythonAsync(wrappedCode);
                const executionEndTime = performance.now();
                const executionDuration = (executionEndTime - executionStartTime).toFixed(2);
                
                if (result.startsWith('ERROR:')) {
                    output.innerHTML = `<span class="output-error">${escapeHtml(result)}</span>`;
                    statusDot.className = 'status-dot error';
                    statusText.textContent = 'Execution Failed';
                } else if (result.startsWith('STDERR:')) {
                    output.textContent = result;
                    statusDot.className = 'status-dot';
                    statusText.textContent = 'Completed with Warnings';
                } else if (result.trim() !== '') {
                    output.textContent = result;
                    statusDot.className = 'status-dot';
                    statusText.textContent = 'Execution Successful';
                } else {
                    output.innerHTML = '<span class="output-info">✓ Code executed successfully (no output generated)</span>';
                    statusDot.className = 'status-dot';
                    statusText.textContent = 'Execution Complete';
                }
                
                executionTime.textContent = `${executionDuration}ms`;
                
            } catch (err) {
                const executionEndTime = performance.now();
                const executionDuration = (executionEndTime - executionStartTime).toFixed(2);
                
                output.innerHTML = `<span class="output-error">FATAL ERROR: ${escapeHtml(err.toString())}</span>`;
                statusDot.className = 'status-dot error';
                statusText.textContent = 'Fatal Error';
                executionTime.textContent = `${executionDuration}ms`;
                
            } finally {
                runBtn.disabled = false;
                runBtn.innerHTML = '<i class="fas fa-play"></i> Execute Code';
            }
        }

        function clearCode() {
            if (codeTextarea) {
                codeTextarea.value = '';
                const lineCount = document.getElementById('lineCount');
                const charCount = document.getElementById('charCount');
                lineCount.textContent = 'Lines: 0';
                charCount.textContent = 'Characters: 0';
            }
            document.getElementById('output').innerHTML = '<span class="output-info">✓ Editor cleared. Write your Python code above.</span>';
        }

        async function resetInterpreter() {
            const output = document.getElementById('output');
            output.innerHTML = '<span class="output-info">Resetting Python environment...</span>';
            isInitialized = false;
            await initializePyodide();
        }

        function saveToFile() {
            const code = codeTextarea.value;
            if (!code.trim()) {
                alert('No code to save!');
                return;
            }
            
            const blob = new Blob([code], { type: 'text/x-python' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'python_script.py';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        document.addEventListener('DOMContentLoaded', function() {
            setupEditor();
            initializePyodide();
        });
    </script>
</body>
</html>