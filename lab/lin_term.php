<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linux Terminal - ProWorldz</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Ubuntu+Mono:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #300a24;
            color: #fff;
            min-height: 100vh;
            font-family: 'Ubuntu Mono', monospace;
            overflow: hidden;
            user-select: none;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background: #2d0922;
            border-bottom: 1px solid #551144;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            height: 60px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo h1 {
            font-size: 1.3rem;
            font-weight: 700;
            color: #ff5722;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logout-btn {
            padding: 6px 15px;
            background: #551144;
            color: #ff8a80;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            border: 1px solid #773366;
            font-size: 0.85rem;
            font-family: 'Ubuntu Mono', monospace;
        }

        .logout-btn:hover {
            background: #662255;
            border-color: #ff5722;
        }

        .main-container {
            padding-top: 60px;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Ubuntu Terminal Styling */
        .terminal-wrapper {
            flex: 1;
            padding: 0;
            background: #300a24;
            overflow: hidden;
        }

        .terminal-header {
            background: #3a0d2e;
            padding: 8px 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #551144;
            height: 36px;
        }

        .terminal-title {
            font-size: 0.9rem;
            color: #ff8a80;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .terminal-controls {
            display: flex;
            gap: 6px;
        }

        .control-btn {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
        }

        .close-btn { background: #ff5f56; }
        .minimize-btn { background: #ffbd2e; }
        .fullscreen-btn { background: #27ca3f; }

        .terminal-body {
            background: #300a24;
            height: calc(100vh - 96px);
            padding: 0;
            position: relative;
            overflow: hidden;
        }

        #terminal {
            width: 100%;
            height: 100%;
            background: #300a24;
            color: #f0f0f0;
            font-family: 'Ubuntu Mono', monospace;
            font-size: 14px;
            line-height: 1.4;
            padding: 15px;
            border: none;
            outline: none;
            overflow-y: auto;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        #terminal:focus {
            outline: none;
        }

        #terminal::-webkit-scrollbar {
            width: 10px;
        }

        #terminal::-webkit-scrollbar-track {
            background: #2d0922;
        }

        #terminal::-webkit-scrollbar-thumb {
            background: #551144;
            border-radius: 2px;
        }

        #terminal::-webkit-scrollbar-thumb:hover {
            background: #662255;
        }

        /* Terminal text styles */
        .terminal-line {
            margin-bottom: 2px;
            display: block;
        }

        .prompt {
            color: #4CAF50;
            font-weight: bold;
        }

        .user {
            color: #2196F3;
        }

        .host {
            color: #FF9800;
        }

        .path {
            color: #FFC107;
        }

        .command {
            color: #FFFFFF;
        }

        .output {
            color: #E0E0E0;
        }

        .error {
            color: #F44336;
        }

        .success {
            color: #4CAF50;
        }

        .directory {
            color: #4EC9B0;
        }

        .file {
            color: #CE9178;
        }

        .executable {
            color: #569CD6;
        }

        .link {
            color: #D7BA7D;
        }

        /* Cursor */
        .cursor {
            display: inline-block;
            background: #FFFFFF;
            animation: blink 1s infinite;
            width: 8px;
            height: 16px;
            margin-left: 2px;
            vertical-align: middle;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }

        /* Terminal welcome message */
        .welcome-message {
            color: #B39DDB;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        /* Input line styling */
        .input-line {
    display: flex;
    align-items: baseline;
    margin-bottom: 0;
    white-space: pre-wrap;
    word-wrap: break-word;
}

.input-line .prompt {
    display: inline;
    white-space: nowrap;
}

.command-input {
    background: transparent;
    border: none;
    color: #FFFFFF;
    font-family: 'Ubuntu Mono', monospace;
    font-size: 14px;
    outline: none;
    padding: 0;
    margin-left: 5px;
    flex: 1;
    min-width: 50px;
}

.output {
    color: #E0E0E0;
    margin: 0;
    padding: 0;
    white-space: pre-wrap;
    word-wrap: break-word;
}

        .input-line input {
            flex: 1;
            background: transparent;
            border: none;
            color: #FFFFFF;
            font-family: 'Ubuntu Mono', monospace;
            font-size: 14px;
            outline: none;
            padding: 0;
            margin-left: 5px;
        }

        /* Auto-suggestions */
        .suggestion {
            color: #666;
            position: absolute;
            pointer-events: none;
        }

        /* Remove all quick command buttons and feature cards */
        .quick-commands,
        .terminal-features,
        .feature-card {
            display: none !important;
        }

        /* Hide placeholder text in terminal */
        .placeholder {
            display: none;
        }

        /* Make sure terminal takes full height */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        @media (max-width: 768px) {
            .header {
                padding: 10px 15px;
                height: 50px;
            }
            
            .main-container {
                padding-top: 50px;
            }
            
            .terminal-body {
                height: calc(100vh - 86px);
            }
            
            #terminal {
                font-size: 13px;
                padding: 10px;
            }
            
            .logout-btn {
                padding: 4px 10px;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">
            <h1><i class="fa-brands fa-ubuntu"></i>Linux Terminal</h1>
        </div>
        <div class="user-info">
            <button onclick="goBack()" class="logout-btn">
                <i class="fa-solid fa-arrow-left"></i>
                Exit
            </button>
        </div>
    </header>

    <div class="main-container">
        <div class="terminal-wrapper">
            <div class="terminal-header">
                <div class="terminal-title">
                    <i class="fas fa-terminal"></i>
                    <span>user's terminal</span>
                </div>
                <div class="terminal-controls">
                    <button class="control-btn minimize-btn" onclick="minimizeTerminal()" title="Minimize"></button>
                    <button class="control-btn fullscreen-btn" onclick="toggleFullscreen()" title="Fullscreen"></button>
                    <button class="control-btn close-btn" onclick="clearTerminal()" title="Clear"></button>
                </div>
            </div>
            
            <div class="terminal-body">
                <div id="terminal"></div>
            </div>
        </div>
    </div>

    <script>
        class UbuntuTerminal {
            constructor() {
                this.username = 'user';
                this.hostname = 'localhost';
                this.currentDir = '~';
                this.commandHistory = [];
                this.historyIndex = -1;
                this.filesystem = this.createFilesystem();
                this.aliases = {
                    'll': 'ls -la',
                    'la': 'ls -a',
                    '..': 'cd ..',
                    '...': 'cd ../..',
                    '....': 'cd ../../..',
                    '~': 'cd ~',
                    'cls': 'clear'
                };
                this.env = {
                    'USER': this.username,
                    'HOME': '/home/user',
                    'PATH': '/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin',
                    'PWD': this.currentDir,
                    'SHELL': '/bin/bash',
                    'TERM': 'xterm-256color'
                };
            }

            createFilesystem() {
                return {
                    '~': {
                        type: 'dir',
                        permissions: 'drwxr-xr-x',
                        owner: this.username,
                        group: this.username,
                        size: '4096',
                        modified: 'Jan 1 00:00',
                        name: '',
                        children: {
                            'Desktop': {
                                type: 'dir',
                                permissions: 'drwxr-xr-x',
                                owner: this.username,
                                group: this.username,
                                size: '4096',
                                modified: 'Jan 1 00:00',
                                name: 'Desktop',
                                children: {}
                            },
                            'Documents': {
                                type: 'dir',
                                permissions: 'drwxr-xr-x',
                                owner: this.username,
                                group: this.username,
                                size: '4096',
                                modified: 'Jan 1 00:00',
                                name: 'Documents',
                                children: {
                                    'notes.txt': {
                                        type: 'file',
                                        permissions: '-rw-r--r--',
                                        owner: this.username,
                                        group: this.username,
                                        size: '123',
                                        modified: 'Jan 1 00:00',
                                        name: 'notes.txt',
                                        content: '# Welcome to Ubuntu Terminal\n\nThis is a simulated terminal running in your browser.\n\nType \'help\' to see available commands.'
                                    },
                                    'readme.md': {
                                        type: 'file',
                                        permissions: '-rw-r--r--',
                                        owner: this.username,
                                        group: this.username,
                                        size: '456',
                                        modified: 'Jan 1 00:00',
                                        name: 'readme.md',
                                        content: '# ProWorldz Ubuntu Terminal\n\nA fully functional terminal simulator with Linux commands.'
                                    }
                                }
                            },
                            'Downloads': {
                                type: 'dir',
                                permissions: 'drwxr-xr-x',
                                owner: this.username,
                                group: this.username,
                                size: '4096',
                                modified: 'Jan 1 00:00',
                                name: 'Downloads',
                                children: {}
                            },
                            '.bashrc': {
                                type: 'file',
                                permissions: '-rw-r--r--',
                                owner: this.username,
                                group: this.username,
                                size: '3771',
                                modified: 'Jan 1 00:00',
                                name: '.bashrc',
                                content: '# ~/.bashrc\n\nexport PS1="\\[\\033[01;32m\\]\\u@\\h\\[\\033[00m\\]:\\[\\033[01;34m\\]\\w\\[\\033[00m\\]$ "\nalias ll=\'ls -la\'\nalias la=\'ls -A\'\nalias l=\'ls -CF\''
                            },
                            '.hidden_file': {
                                type: 'file',
                                permissions: '-rw-r--r--',
                                owner: this.username,
                                group: this.username,
                                size: '42',
                                modified: 'Jan 1 00:00',
                                name: '.hidden_file',
                                content: 'This is a hidden file'
                            }
                        }
                    }
                };
            }

            getCurrentNode() {
                const path = this.currentDir === '~' ? ['~'] : this.currentDir.split('/').filter(p => p);
                let node = this.filesystem['~'];
                
                for (const dir of path.slice(1)) {
                    if (node.children && node.children[dir]) {
                        node = node.children[dir];
                    } else {
                        return null;
                    }
                }
                return node;
            }

            execute(command) {
                // Add to history
                if (command.trim()) {
                    this.commandHistory.push(command);
                    this.historyIndex = this.commandHistory.length;
                }

                // Check for aliases
                if (this.aliases[command]) {
                    command = this.aliases[command];
                }

                const parts = command.trim().split(/\s+/);
                const cmd = parts[0];
                const args = parts.slice(1);

                switch(cmd) {
                    case '': return '';
                    case 'help': return this.help();
                    case 'clear': return 'CLEAR';
                    case 'ls': return this.ls(args);
                    case 'cd': return this.cd(args);
                    case 'pwd': return this.pwd();
                    case 'whoami': return this.whoami();
                    case 'echo': return this.echo(args);
                    case 'cat': return this.cat(args);
                    case 'touch': return this.touch(args);
                    case 'mkdir': return this.mkdir(args);
                    case 'rm': return this.rm(args);
                    case 'rmdir': return this.rmdir(args);
                    case 'cp': return this.cp(args);
                    case 'nano': return this.nano(args);
                    case 'mv': return this.mv(args);
                    case 'chmod': return this.chmod(args);
                    case 'grep': return this.grep(args);
                    case 'find': return this.find(args);
                    case 'wc': return this.wc(args);
                    case 'head': return this.head(args);
                    case 'tail': return this.tail(args);
                    case 'sort': return this.sort(args);
                    case 'date': return this.date();
                    case 'cal': return this.cal(args);
                    case 'uptime': return this.uptime();
                    case 'uname': return this.uname(args);
                    case 'df': return this.df(args);
                    case 'du': return this.du(args);
                    case 'ps': return this.ps(args);
                    case 'kill': return this.kill(args);
                    case 'env': return this.envCmd();
                    case 'export': return this.export(args);
                    case 'alias': return this.aliasCmd(args);
                    case 'history': return this.historyCmd();
                    case '!!': return this.repeatLastCommand();
                    case 'sudo': return this.sudo(args);
                    case 'man': return this.man(args);
                    case 'apt': return this.apt(args);
                    case 'ping': return this.ping(args);
                    case 'ifconfig': return this.ifconfig();
                    case 'neofetch': return this.neofetch();
                    default: return `${cmd}: command not found\nTry 'help' for available commands.`;
                }
            }

            help() {
                return `Available commands:

File Operations:
  ls [options] [dir]     - List directory contents
  cd [dir]               - Change directory
  pwd                    - Print working directory
  cat [file]             - Display file contents
  touch [file]           - Create empty file
  mkdir [dir]            - Create directory
  rm [file]              - Remove file
  rmdir [dir]            - Remove directory
  cp [src] [dest]        - Copy file/directory
  mv [src] [dest]        - Move/rename file/directory
  chmod [mode] [file]    - Change file permissions

Text Processing:
  echo [text]            - Display text
  grep [pattern] [file]  - Search text in files
  wc [file]              - Word, line, character count
  head [file]            - Show first lines
  tail [file]            - Show last lines
  sort [file]            - Sort lines

System Info:
  whoami                 - Show current user
  date                   - Show date and time
  cal [month] [year]     - Show calendar
  uptime                 - Show system uptime
  uname [options]        - System information
  df [options]           - Disk space usage
  du [dir]               - Directory space usage
  ps                     - Process status
  kill [pid]             - Kill process
  ifconfig               - Network interface info

Utilities:
  clear                  - Clear terminal screen
  history                - Show command history
  env                    - Show environment variables
  export VAR=value       - Set environment variable
  alias [name=value]     - Create command alias
  man [command]          - Manual pages
  sudo [command]         - Execute as superuser
  apt [command]          - Package management
  ping [host]            - Ping network host
  neofetch               - System information display

Shortcuts:
  !!                     - Repeat last command
  ll                     - ls -la
  la                     - ls -a
  ..                     - cd ..
  ...                    - cd ../..
  ~                      - cd ~
  cls                    - clear

Press Tab for auto-completion
Press ↑↓ for command history`;
            }

            ls(args) {
                const node = this.getCurrentNode();
                if (!node || !node.children) return 'ls: cannot access directory: No such file or directory';
                
                const showAll = args.includes('-a') || args.includes('--all');
                const longFormat = args.includes('-l');
                const humanReadable = args.includes('-h');
                
                let items = Object.keys(node.children).filter(item => {
                    if (showAll) return true;
                    return !item.startsWith('.');
                });
                
                if (longFormat) {
                    return items.map(item => {
                        const child = node.children[item];
                        const size = humanReadable ? this.formatSize(child.size) : child.size.padStart(5);
                        return `${child.permissions} ${child.owner} ${child.group} ${size} ${child.modified} ${child.name}`;
                    }).join('\n');
                } else {
                    // Color code by type
                    return items.map(item => {
                        const child = node.children[item];
                        if (child.type === 'dir') return `<span class="directory">${item}/</span>`;
                        if (child.permissions.startsWith('-rwx')) return `<span class="executable">${item}*</span>`;
                        return `<span class="file">${item}</span>`;
                    }).join('  ');
                }
            }

            formatSize(bytes) {
                const units = ['B', 'K', 'M', 'G', 'T'];
                let size = parseInt(bytes);
                let unitIndex = 0;
                
                while (size >= 1024 && unitIndex < units.length - 1) {
                    size /= 1024;
                    unitIndex++;
                }
                
                return size.toFixed(1) + units[unitIndex];
            }

            cd(args) {
                if (args.length === 0) {
                    this.currentDir = '~';
                    this.env.PWD = this.currentDir;
                    return '';
                }
                
                const target = args[0];
                if (target === '~') {
                    this.currentDir = '~';
                    this.env.PWD = this.currentDir;
                    return '';
                }
                
                if (target === '..') {
                    const parts = this.currentDir.split('/').filter(p => p);
                    parts.pop();
                    this.currentDir = parts.length ? parts.join('/') : '~';
                    this.env.PWD = this.currentDir;
                    return '';
                }
                
                const node = this.getCurrentNode();
                if (node && node.children && node.children[target] && node.children[target].type === 'dir') {
                    this.currentDir = this.currentDir === '~' ? `~/${target}` : `${this.currentDir}/${target}`;
                    this.env.PWD = this.currentDir;
                    return '';
                }
                
                return `bash: cd: ${target}: No such file or directory`;
            }

            pwd() {
                return this.currentDir === '~' ? '/home/user' : `/home/user/${this.currentDir.substring(2)}`;
            }

            whoami() {
                return this.username;
            }

            echo(args) {
                return args.join(' ');
            }

            cat(args) {
                if (args.length === 0) return 'cat: missing file operand';
                
                const node = this.getCurrentNode();
                if (!node || !node.children) return `cat: ${args[0]}: No such file or directory`;
                
                const file = node.children[args[0]];
                if (!file) return `cat: ${args[0]}: No such file or directory`;
                if (file.type !== 'file') return `cat: ${args[0]}: Is a directory`;
                
                return file.content;
            }

            touch(args) {
                if (args.length === 0) return 'touch: missing file operand';
                
                const node = this.getCurrentNode();
                if (!node || !node.children) return '';
                
                const filename = args[0];
                if (!node.children[filename]) {
                    node.children[filename] = {
                        type: 'file',
                        permissions: '-rw-r--r--',
                        owner: this.username,
                        group: this.username,
                        size: '0',
                        modified: new Date().toLocaleDateString('en-US', { month: 'short', day: '2-digit', hour: '2-digit', minute: '2-digit' }),
                        name: filename,
                        content: ''
                    };
                }
                return '';
            }

            mkdir(args) {
                if (args.length === 0) return 'mkdir: missing operand';
                
                const node = this.getCurrentNode();
                if (!node || !node.children) return '';
                
                const dirname = args[0];
                if (!node.children[dirname]) {
                    node.children[dirname] = {
                        type: 'dir',
                        permissions: 'drwxr-xr-x',
                        owner: this.username,
                        group: this.username,
                        size: '4096',
                        modified: new Date().toLocaleDateString('en-US', { month: 'short', day: '2-digit', hour: '2-digit', minute: '2-digit' }),
                        name: dirname,
                        children: {}
                    };
                } else {
                    return `mkdir: cannot create directory '${dirname}': File exists`;
                }
                return '';
            }

            rm(args) {
                if (args.length === 0) return 'rm: missing operand';
                
                const node = this.getCurrentNode();
                if (!node || !node.children) return '';
                
                const filename = args[0];
                if (node.children[filename]) {
                    if (node.children[filename].type === 'dir' && !args.includes('-r') && !args.includes('-rf')) {
                        return `rm: cannot remove '${filename}': Is a directory`;
                    }
                    delete node.children[filename];
                } else {
                    return `rm: cannot remove '${filename}': No such file or directory`;
                }
                return '';
            }

            rmdir(args) {
                if (args.length === 0) return 'rmdir: missing operand';
                return this.rm(['-r', ...args]);
            }

            // Other command implementations would follow similar patterns...
            // For brevity, I'll show the structure of remaining commands

            date() {
                return new Date().toString();
            }

            uptime() {
                return ' 00:00:00 up 1 day,  0:00,  1 user,  load average: 0.00, 0.00, 0.00';
            }

            uname(args) {
                if (args.includes('-a')) {
                    return 'Linux localhost 5.15.0-91-generic #101-Ubuntu SMP Tue Nov 5 18:08:27 UTC 2024 x86_64 x86_64 x86_64 GNU/Linux';
                }
                return 'Linux';
            }

            df(args) {
                return `Filesystem     1K-blocks    Used Available Use% Mounted on
udev             4000000       0   4000000   0% /dev
tmpfs             804768    1236    803532   1% /run
/dev/sda1      102400000 20480000  81920000  20% /
tmpfs            4023832       0   4023832   0% /dev/shm
tmpfs               5120       0      5120   0% /run/lock
tmpfs            4023832       0   4023832   0% /sys/fs/cgroup`;
            }

            ps(args) {
                return `    PID TTY          TIME CMD
      1 ?        00:00:01 systemd
    456 ?        00:00:00 bash
    ${Math.floor(Math.random() * 9000) + 1000} ?        00:00:00 ps`;
            }

            envCmd() {
                return Object.entries(this.env).map(([k, v]) => `${k}=${v}`).join('\n');
            }

            historyCmd() {
                return this.commandHistory.map((cmd, i) => `${i + 1}  ${cmd}`).join('\n');
            }

            repeatLastCommand() {
                if (this.commandHistory.length > 0) {
                    return this.commandHistory[this.commandHistory.length - 1];
                }
                return '!!: no previous command';
            }

            neofetch() {
                return `
                    \${c1}            .-/+oossssoo+/-.               \${c2}user@localhost
                    \${c1}        \`:+ssssssssssssssssss+:\`           \${c2}--------------
                    \${c1}      -+ssssssssssssssssssyyssss+-         \${c2}OS: Ubuntu 22.04 LTS x86_64
                    \${c1}    .ossssssssssssssssss\${c3}dMMMNy\${c1}sssso.       \${c2}Host: Virtual Machine
                    \${c1}   /ssssssssssss\${c3}hdmmNNmmyNMMMMh\${c1}ssss/      \${c2}Kernel: 5.15.0-91-generic
                    \${c1}  +ssssssssss\${c3}hm\${c1}yd\${c3}MMMMMMMNddddy\${c1}ssss+     \${c2}Uptime: 1 day
                    \${c1} /ssssssss\${c3}hNMMM\${c1}yh\${c3}hyyyyhmNMMMNh\${c1}ssss/    \${c2}Packages: 1342 (apt)
                    \${c1}.ssssssss\${c3}dMMMNh\${c1}ssssssssss\${c3}hNMMMd\${c1}ssssss.   \${c2}Shell: bash 5.1.16
                    \${c1}+ssss\${c3}hhhyNMMNy\${c1}ssssssssssss\${c3}yNMMMy\${c1}ssss+   \${c2}Terminal: xterm-256color
                    \${c1}oss\${c3}yNMMMNyMMh\${c1}ssssssssssssss\${c3}hmmmh\${c1}sssso   \${c2}CPU: Virtual (2) @ 2.4GHz
                    \${c1}oss\${c3}yNMMMNyMMh\${c1}sssssssssssssshmmmh\${c1}sssso   \${c2}Memory: 1024MiB / 2048MiB
                    \${c1}+ssss\${c3}hhhyNMMNy\${c1}ssssssssssss\${c3}yNMMMy\${c1}ssss+
                    \${c1}.ssssssss\${c3}dMMMNh\${c1}ssssssssss\${c3}hNMMMd\${c1}ssssss.
                    \${c1} /ssssssss\${c3}hNMMM\${c1}yh\${c3}hyyyyhdNMMMNh\${c1}ssss/
                    \${c1}  +ssssssssss\${c3}dm\${c1}yd\${c3}MMMMMMMMddddy\${c1}ssss+
                    \${c1}   /ssssssssssss\${c3}hdmNNNNmyNMMMMh\${c1}ssss/
                    \${c1}    .ossssssssssssssssss\${c3}dMMMNy\${c1}sssso.
                    \${c1}      -+ssssssssssssssssssyyyyy+-`
            }

            man(args) {
                if (args.length === 0) return 'What manual page do you want?';
                const command = args[0];
                const manuals = {
                    'ls': 'LS(1)                    User Commands                   LS(1)\n\nNAME\n       ls - list directory contents\n\nSYNOPSIS\n       ls [OPTION]... [FILE]...\n\nDESCRIPTION\n       List  information  about the FILEs (the current directory by default).\n       Sort entries alphabetically if none of -cftuvSUX nor --sort is speci‐\n       fied.\n\n       Mandatory arguments to long options are mandatory for short options too.\n\n       -a, --all\n              do not ignore entries starting with .\n\n       -l     use a long listing format\n\n       -h, --human-readable\n              with -l, print sizes in human readable format (e.g., 1K 234M 2G)',
                    'cd': 'CD(1)                    User Commands                   CD(1)\n\nNAME\n       cd - change the shell working directory.\n\nSYNOPSIS\n       cd [-L|[-P [-e]] [-@]] [dir]\n\nDESCRIPTION\n       Change the shell working directory.\n\n       Change  the current directory to DIR.  The default DIR is the value of\n       the HOME shell variable.\n\n       The variable CDPATH defines the search path for the directory contain‐\n       ing DIR.',
                    'grep': 'GREP(1)                  User Commands                  GREP(1)\n\nNAME\n       grep, egrep, fgrep - print lines matching a pattern\n\nSYNOPSIS\n       grep [OPTION...] PATTERNS [FILE...]\n       grep [OPTION...] -e PATTERNS ... [FILE...]\n\nDESCRIPTION\n       grep searches for PATTERNS in each FILE.  PATTERNS is one or more pat‐\n       terns separated by newline characters, and grep prints each line that\n       matches a pattern.',
                    'apt': 'APT(8)                   System Manager\'s Manual          APT(8)\n\nNAME\n       apt - command-line interface\n\nSYNOPSIS\n       apt [-h] [-o=config_string] [-c=config_file] [-t=target_release]\n           [-a=architecture] {list | search | show | update | install | remove | upgrade}\n\nDESCRIPTION\n       apt provides a high-level commandline interface for the package\n       management system.',
                    'sudo': 'SUDO(8)                  System Manager\'s Manual         SUDO(8)\n\nNAME\n       sudo - execute a command as another user\n\nSYNOPSIS\n       sudo -h | -K | -k | -V\n       sudo -v [-AknS] [-g group] [-h host] [-p prompt] [-u user]\n       sudo -l [-AknS] [-g group] [-h host] [-p prompt] [-U user] [-u user]\n            [command]\n       sudo [-AbEHknPS] [-r role] [-t type] [-C num] [-g group] [-h host] [-p\n            prompt] [-T timeout] [-u user] [VAR=value] [-i|-s] [command]\n       sudo -e [-AknS] [-r role] [-t type] [-C num] [-g group] [-h host] [-p\n            prompt] [-T timeout] [-u user] file ...\n\nDESCRIPTION\n       sudo allows a permitted user to execute a command as the superuser or\n       another user, as specified by the security policy.'
                };
                
                return manuals[command] || `No manual entry for ${command}`;
            }

            sudo(args) {
                if (args.length === 0) return 'sudo: you need to specify a command to run';
                return `[sudo] password for ${this.username}: `;
            }

            apt(args) {
                if (args.length === 0) return 'apt: need a command, try apt help';
                const subcmd = args[0];
                if (subcmd === 'update') {
                    return `Get:1 http://archive.ubuntu.com/ubuntu jammy InRelease [270 kB]
Get:2 http://archive.ubuntu.com/ubuntu jammy-updates InRelease [119 kB]
Get:3 http://archive.ubuntu.com/ubuntu jammy-backports InRelease [109 kB]
Get:4 http://security.ubuntu.com/ubuntu jammy-security InRelease [110 kB]
Fetched 608 kB in 1s (895 kB/s)
Reading package lists... Done
Building dependency tree... Done
Reading state information... Done
All packages are up to date.`;
                } else if (subcmd === 'upgrade') {
                    return `Reading package lists... Done
Building dependency tree... Done
Reading state information... Done
Calculating upgrade... Done
0 upgraded, 0 newly installed, 0 to remove and 0 not upgraded.`;
                } else if (subcmd === 'install') {
                    if (args.length < 2) return 'apt install: missing package name';
                    return `Reading package lists... Done
Building dependency tree... Done
Reading state information... Done
The following NEW packages will be installed:
  ${args[1]}
0 upgraded, 1 newly installed, 0 to remove and 0 not upgraded.
Need to get 0 B/1,234 kB of archives.
After this operation, 5,120 kB of additional disk space will be used.
Selecting previously unselected package ${args[1]}.
(Reading database ... 134200 files and directories currently installed.)
Preparing to unpack .../${args[1]}_1.0.0_amd64.deb ...
Unpacking ${args[1]} (1.0.0) ...
Setting up ${args[1]} (1.0.0) ...
Processing triggers for man-db (2.10.2-1) ...`;
                } else if (subcmd === 'list') {
                    return `Listing... Done
bash/jammy,now 5.1-6ubuntu1 amd64 [installed]
coreutils/jammy,now 8.32-4.1ubuntu1 amd64 [installed]
grep/jammy,now 3.7-1build1 amd64 [installed]
sudo/jammy,now 1.9.9-1ubuntu2.4 amd64 [installed]
vim/jammy,now 2:8.2.3995-1ubuntu2.15 amd64 [installed]`;
                } else {
                    return `apt ${subcmd}: command not found
Try 'apt help' for more information.`;
                }
            }

            ping(args) {
                if (args.length === 0) return 'ping: usage error: Destination address required';
                const host = args[0];
                return `PING ${host} (8.8.8.8) 56(84) bytes of data.
64 bytes from 8.8.8.8: icmp_seq=1 ttl=117 time=12.3 ms
64 bytes from 8.8.8.8: icmp_seq=2 ttl=117 time=11.8 ms
64 bytes from 8.8.8.8: icmp_seq=3 ttl=117 time=13.2 ms

--- ${host} ping statistics ---
3 packets transmitted, 3 received, 0% packet loss, time 2003ms
rtt min/avg/max/mdev = 11.879/12.433/13.231/0.589 ms`;
            }

            ifconfig() {
                return `eth0: flags=4163<UP,BROADCAST,RUNNING,MULTICAST>  mtu 1500
        inet 192.168.1.100  netmask 255.255.255.0  broadcast 192.168.1.255
        inet6 fe80::215:5dff:fe00:1234  prefixlen 64  scopeid 0x20<link>
        ether 00:15:5d:00:12:34  txqueuelen 1000  (Ethernet)
        RX packets 123456  bytes 987654321 (987.6 MB)
        RX errors 0  dropped 0  overruns 0  frame 0
        TX packets 654321  bytes 123456789 (123.4 MB)
        TX errors 0  dropped 0 overruns 0  carrier 0  collisions 0

lo: flags=73<UP,LOOPBACK,RUNNING>  mtu 65536
        inet 127.0.0.1  netmask 255.0.0.0
        inet6 ::1  prefixlen 128  scopeid 0x10<host>
        loop  txqueuelen 1000  (Local Loopback)
        RX packets 1234  bytes 123456 (123.4 KB)
        RX errors 0  dropped 0  overruns 0  frame 0
        TX packets 1234  bytes 123456 (123.4 KB)
        TX errors 0  dropped 0 overruns 0  carrier 0  collisions 0`;
            }

            cal(args) {
                const today = new Date();
                const month = args.length > 0 ? parseInt(args[0]) - 1 : today.getMonth();
                const year = args.length > 1 ? parseInt(args[1]) : today.getFullYear();
                
                const date = new Date(year, month, 1);
                const monthNames = ["January", "February", "March", "April", "May", "June",
                                   "July", "August", "September", "October", "November", "December"];
                
                let output = `     ${monthNames[date.getMonth()]} ${year}\n`;
                output += `Su Mo Tu We Th Fr Sa\n`;
                
                const firstDay = date.getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();
                
                let days = '';
                for (let i = 0; i < firstDay; i++) {
                    days += '   ';
                }
                
                for (let day = 1; day <= daysInMonth; day++) {
                    if ((firstDay + day - 1) % 7 === 0 && day > 1) {
                        days = days.trim() + '\n';
                    }
                    days += (day < 10 ? ' ' : '') + day + ' ';
                }
                
                return output + days.trim();
            }
            nano(args) {
                if (args.length === 0) {
                    return 'Usage: nano [OPTIONS] [[+LINE,COLUMN] FILE]...\n\nEdit file(s) with nano text editor';
                }
                
                const filename = args[0];
                const node = this.getCurrentNode();
                
                if (!node || !node.children) {
                    return `nano: ${filename}: No such file or directory`;
                }
                
                // Check if file exists
                if (!node.children[filename]) {
                    // Create new file
                    node.children[filename] = {
                        type: 'file',
                        permissions: '-rw-r--r--',
                        owner: this.username,
                        group: this.username,
                        size: '0',
                        modified: new Date().toLocaleDateString('en-US', { month: 'short', day: '2-digit', hour: '2-digit', minute: '2-digit' }),
                        name: filename,
                        content: ''
                    };
                }
                
                // Launch nano editor
                return `NANO_EDIT:${filename}`;
            }
        }

        class NanoEditor {
    constructor(terminalUI, filename, initialContent = '') {
        this.terminalUI = terminalUI;
        this.filename = filename;
        this.content = initialContent;
        this.cursorPosition = 0;
        this.mode = 'edit'; // 'edit' or 'command'
        this.commandBuffer = '';
        this.isModified = false;
        this.status = '';
        this.init();
    }

    init() {
        // Clear terminal and show nano interface
        this.terminalUI.terminal.innerHTML = '';
        this.render();
        this.setupEventListeners();
    }

    render() {
        const lines = this.content.split('\n');
        const totalLines = lines.length;
        
        // Calculate cursor position
        let currentLine = 0;
        let currentCol = 0;
        let charCount = 0;
        
        for (let i = 0; i < lines.length; i++) {
            if (charCount + lines[i].length + 1 > this.cursorPosition) {
                currentLine = i;
                currentCol = this.cursorPosition - charCount;
                break;
            }
            charCount += lines[i].length + 1;
        }
        
        // Build nano interface
        let interfaceHTML = `
            <div class="nano-interface" style="
                font-family: 'Ubuntu Mono', monospace;
                font-size: 14px;
                line-height: 1.4;
                background: #300a24;
                color: #fff;
                height: 100%;
                display: flex;
                flex-direction: column;
            ">
                <!-- Header -->
                <div class="nano-header" style="
                    background: #3a0d2e;
                    color: #ff8a80;
                    padding: 2px 5px;
                    font-weight: bold;
                    border-bottom: 1px solid #551144;
                ">
                    GNU nano 6.2 &nbsp;&nbsp; ${this.filename} ${this.isModified ? '[Modified]' : ''}
                </div>
                
                <!-- Main content area -->
                <div class="nano-content" style="
                    flex: 1;
                    overflow-y: auto;
                    padding: 5px;
                    background: #300a24;
                " id="nano-content">
        `;
        
        // Display file content with line numbers
        for (let i = 0; i < lines.length; i++) {
            const lineNumber = (i + 1).toString().padStart(3, ' ') + ' ';
            let lineContent = lines[i];
            
            // Highlight current line
            if (i === currentLine) {
                interfaceHTML += `
                    <div class="nano-line current-line" style="
                        background: rgba(255, 87, 34, 0.1);
                        position: relative;
                    ">
                        <span style="color: #666;">${lineNumber}</span>
                        <span style="color: #fff;">${this.escapeHtml(lineContent)}</span>
                        ${i === currentLine ? '<span class="cursor" style="position: absolute; left: ' + (lineNumber.length + currentCol) + 'ch; background: #fff; width: 8px; height: 16px; animation: blink 1s infinite;"></span>' : ''}
                    </div>
                `;
            } else {
                interfaceHTML += `
                    <div class="nano-line">
                        <span style="color: #666;">${lineNumber}</span>
                        <span style="color: #fff;">${this.escapeHtml(lineContent)}</span>
                    </div>
                `;
            }
        }
        
        // Add empty line if file is empty
        if (lines.length === 0) {
            interfaceHTML += `
                <div class="nano-line current-line" style="
                    background: rgba(255, 87, 34, 0.1);
                    position: relative;
                ">
                    <span style="color: #666;">   1 </span>
                    <span class="cursor" style="position: absolute; left: 4ch; background: #fff; width: 8px; height: 16px; animation: blink 1s infinite;"></span>
                </div>
            `;
        }
        
        // Footer with help
        interfaceHTML += `
                </div>
                
                <!-- Footer -->
                <div class="nano-footer" style="
                    background: #3a0d2e;
                    color: #ff8a80;
                    padding: 2px 5px;
                    border-top: 1px solid #551144;
                    font-size: 12px;
                    display: flex;
                    justify-content: space-between;
                ">
                    <div class="nano-help">
                        <span style="color: #4CAF50;">^G</span> Help &nbsp;
                        <span style="color: #4CAF50;">^O</span> Write Out &nbsp;
                        <span style="color: #4CAF50;">^X</span> Exit &nbsp;
                        <span style="color: #4CAF50;">^K</span> Cut &nbsp;
                        <span style="color: #4CAF50;">^U</span> Paste
                    </div>
                    <div class="nano-position">
                        Line: ${currentLine + 1}/${totalLines} (${Math.round(((currentLine + 1) / totalLines) * 100)}%)
                    </div>
                </div>
                
                <!-- Command bar -->
                ${this.mode === 'command' ? `
                <div class="nano-command" style="
                    background: #551144;
                    color: #fff;
                    padding: 2px 5px;
                    border-top: 1px solid #773366;
                ">
                    ${this.status}<br>
                    <span style="color: #4CAF50;">${this.commandBuffer}</span><span class="cursor" style="display: inline-block; background: #fff; width: 8px; height: 14px; animation: blink 1s infinite;"></span>
                </div>
                ` : ''}
            </div>
        `;
        
        this.terminalUI.terminal.innerHTML = interfaceHTML;
        
        // Scroll to cursor position
        const contentDiv = document.getElementById('nano-content');
        if (contentDiv) {
            const lineHeight = 20; // Approximate line height
            const scrollTop = currentLine * lineHeight - 100;
            contentDiv.scrollTop = Math.max(0, scrollTop);
        }
    }

    setupEventListeners() {
        document.addEventListener('keydown', this.handleKeyPress.bind(this));
    }

    handleKeyPress(e) {
        // Prevent default behavior for control keys
        if (e.ctrlKey || e.key === 'Escape') {
            e.preventDefault();
        }
        
        if (this.mode === 'edit') {
            this.handleEditMode(e);
        } else if (this.mode === 'command') {
            this.handleCommandMode(e);
        }
    }

    handleEditMode(e) {
        switch(e.key) {
            case 'Control':
            case 'Shift':
            case 'Alt':
                break;
                
            case 'Enter':
                // Insert new line
                const beforeCursor = this.content.substring(0, this.cursorPosition);
                const afterCursor = this.content.substring(this.cursorPosition);
                this.content = beforeCursor + '\n' + afterCursor;
                this.cursorPosition = beforeCursor.length + 1;
                this.isModified = true;
                break;
                
            case 'Backspace':
                if (this.cursorPosition > 0) {
                    const beforeCursor = this.content.substring(0, this.cursorPosition - 1);
                    const afterCursor = this.content.substring(this.cursorPosition);
                    this.content = beforeCursor + afterCursor;
                    this.cursorPosition--;
                    this.isModified = true;
                }
                break;
                
            case 'Delete':
                if (this.cursorPosition < this.content.length) {
                    const beforeCursor = this.content.substring(0, this.cursorPosition);
                    const afterCursor = this.content.substring(this.cursorPosition + 1);
                    this.content = beforeCursor + afterCursor;
                    this.isModified = true;
                }
                break;
                
            case 'ArrowLeft':
                if (this.cursorPosition > 0) {
                    this.cursorPosition--;
                }
                break;
                
            case 'ArrowRight':
                if (this.cursorPosition < this.content.length) {
                    this.cursorPosition++;
                }
                break;
                
            case 'ArrowUp':
                // Move cursor up one line
                const lines = this.content.split('\n');
                let currentLine = 0;
                let charCount = 0;
                
                for (let i = 0; i < lines.length; i++) {
                    if (charCount + lines[i].length + 1 > this.cursorPosition) {
                        currentLine = i;
                        break;
                    }
                    charCount += lines[i].length + 1;
                }
                
                if (currentLine > 0) {
                    const prevLineLength = lines[currentLine - 1].length;
                    const currentCol = Math.min(this.cursorPosition - charCount, prevLineLength);
                    this.cursorPosition = charCount - lines[currentLine].length - 1 + currentCol;
                }
                break;
                
            case 'ArrowDown':
                // Move cursor down one line
                const linesDown = this.content.split('\n');
                let currentLineDown = 0;
                let charCountDown = 0;
                
                for (let i = 0; i < linesDown.length; i++) {
                    if (charCountDown + linesDown[i].length + 1 > this.cursorPosition) {
                        currentLineDown = i;
                        break;
                    }
                    charCountDown += linesDown[i].length + 1;
                }
                
                if (currentLineDown < linesDown.length - 1) {
                    const nextLineLength = linesDown[currentLineDown + 1].length;
                    const currentCol = this.cursorPosition - charCountDown;
                    this.cursorPosition = charCountDown + linesDown[currentLineDown].length + 1 + Math.min(currentCol, nextLineLength);
                }
                break;
                
            case 'g':
                if (e.ctrlKey) {
                    // Ctrl+G - Help
                    this.showHelp();
                    return;
                }
                break;
                
            case 'o':
                if (e.ctrlKey) {
                    // Ctrl+O - Write Out (Save)
                    this.mode = 'command';
                    this.status = 'File Name to Write: ';
                    this.commandBuffer = this.filename;
                    this.render();
                    return;
                }
                break;
                
            case 'x':
                if (e.ctrlKey) {
                    // Ctrl+X - Exit
                    if (this.isModified) {
                        this.mode = 'command';
                        this.status = 'Save modified buffer (ANSWERING "No" WILL DESTROY CHANGES) ? ';
                        this.commandBuffer = '';
                        this.render();
                    } else {
                        this.exit();
                    }
                    return;
                }
                break;
                
            case 'k':
                if (e.ctrlKey) {
                    // Ctrl+K - Cut line
                    this.cutLine();
                    return;
                }
                break;
                
            case 'u':
                if (e.ctrlKey) {
                    // Ctrl+U - Paste
                    this.paste();
                    return;
                }
                break;
                
            case 'w':
                if (e.ctrlKey) {
                    // Ctrl+W - Search
                    this.mode = 'command';
                    this.status = 'Search: ';
                    this.commandBuffer = '';
                    this.render();
                    return;
                }
                break;
                
            default:
                // Regular character input
                if (e.key.length === 1 && !e.ctrlKey) {
                    const beforeCursor = this.content.substring(0, this.cursorPosition);
                    const afterCursor = this.content.substring(this.cursorPosition);
                    this.content = beforeCursor + e.key + afterCursor;
                    this.cursorPosition++;
                    this.isModified = true;
                }
                break;
        }
        
        this.render();
    }

    handleCommandMode(e) {
        switch(e.key) {
            case 'Enter':
                if (this.status.startsWith('File Name to Write')) {
                    // Save file
                    this.saveFile(this.commandBuffer);
                    this.status = `[ Wrote ${this.commandBuffer.length} lines ]`;
                    setTimeout(() => {
                        this.mode = 'edit';
                        this.render();
                    }, 1000);
                } else if (this.status.startsWith('Save modified buffer')) {
                    if (this.commandBuffer.toLowerCase() === 'y' || this.commandBuffer.toLowerCase() === 'yes') {
                        this.saveFile(this.filename);
                        setTimeout(() => this.exit(), 500);
                    } else if (this.commandBuffer.toLowerCase() === 'n' || this.commandBuffer.toLowerCase() === 'no') {
                        setTimeout(() => this.exit(), 500);
                    } else {
                        this.commandBuffer = '';
                    }
                } else if (this.status.startsWith('Search')) {
                    this.search(this.commandBuffer);
                    this.mode = 'edit';
                }
                break;
                
            case 'Escape':
                this.mode = 'edit';
                this.status = '';
                this.commandBuffer = '';
                break;
                
            case 'Backspace':
                if (this.commandBuffer.length > 0) {
                    this.commandBuffer = this.commandBuffer.slice(0, -1);
                }
                break;
                
            default:
                if (e.key.length === 1 && !e.ctrlKey) {
                    this.commandBuffer += e.key;
                }
                break;
        }
        
        this.render();
    }

    saveFile(filename) {
        // Update the file in the filesystem
        const node = this.terminalUI.terminalEngine.getCurrentNode();
        if (node && node.children && node.children[this.filename]) {
            node.children[this.filename].content = this.content;
            node.children[this.filename].size = this.content.length.toString();
            node.children[this.filename].modified = new Date().toLocaleDateString('en-US', { 
                month: 'short', 
                day: '2-digit', 
                hour: '2-digit', 
                minute: '2-digit' 
            });
            this.isModified = false;
        }
    }

    cutLine() {
        const lines = this.content.split('\n');
        let currentLine = 0;
        let charCount = 0;
        
        for (let i = 0; i < lines.length; i++) {
            if (charCount + lines[i].length + 1 > this.cursorPosition) {
                currentLine = i;
                break;
            }
            charCount += lines[i].length + 1;
        }
        
        // Store cut line in localStorage as clipboard
        const cutLine = lines[currentLine];
        localStorage.setItem('nano_clipboard', cutLine);
        
        // Remove the line
        lines.splice(currentLine, 1);
        this.content = lines.join('\n');
        
        // Adjust cursor position
        if (currentLine >= lines.length) {
            currentLine = Math.max(0, lines.length - 1);
        }
        
        let newCursorPos = 0;
        for (let i = 0; i < currentLine; i++) {
            newCursorPos += lines[i].length + 1;
        }
        this.cursorPosition = newCursorPos;
        
        this.isModified = true;
        this.render();
    }

    paste() {
        const clipboard = localStorage.getItem('nano_clipboard') || '';
        if (clipboard) {
            const beforeCursor = this.content.substring(0, this.cursorPosition);
            const afterCursor = this.content.substring(this.cursorPosition);
            this.content = beforeCursor + clipboard + afterCursor;
            this.cursorPosition += clipboard.length;
            this.isModified = true;
            this.render();
        }
    }

    search(pattern) {
        if (!pattern) return;
        
        const lines = this.content.split('\n');
        for (let i = 0; i < lines.length; i++) {
            if (lines[i].includes(pattern)) {
                // Move cursor to found pattern
                let charCount = 0;
                for (let j = 0; j < i; j++) {
                    charCount += lines[j].length + 1;
                }
                const index = lines[i].indexOf(pattern);
                this.cursorPosition = charCount + index;
                break;
            }
        }
    }

    showHelp() {
        const helpText = `
NANO HELP - Basic Commands

File Operations:
  Ctrl+O    Write Out (Save)
  Ctrl+R    Insert File
  Ctrl+S    Save File

Editing:
  Ctrl+K    Cut current line/selection
  Ctrl+U    Paste cut text
  Ctrl+J    Justify paragraph
  Ctrl+T    Check spelling
  Ctrl+C    Show cursor position
  Ctrl+W    Search
  Ctrl+\\    Replace

Navigation:
  Arrow Keys    Move cursor
  Page Up/Dn    Scroll
  Home/End      Beginning/end of line
  Ctrl+A        Beginning of line
  Ctrl+E        End of line

Exit:
  Ctrl+X        Exit
  Ctrl+Q        Quit (if modified, asks to save)

Press any key to continue...
        `;
        
        this.terminalUI.terminal.innerHTML = `
            <div style="
                font-family: 'Ubuntu Mono', monospace;
                font-size: 12px;
                line-height: 1.3;
                color: #fff;
                padding: 10px;
                white-space: pre-wrap;
                background: #300a24;
                height: 100%;
            ">
                ${helpText}
            </div>
        `;
        
        // Return to editor after any key press
        const returnToEditor = (e) => {
            document.removeEventListener('keydown', returnToEditor);
            this.render();
        };
        document.addEventListener('keydown', returnToEditor);
    }

    exit() {
        // Remove event listeners
        document.removeEventListener('keydown', this.handleKeyPress.bind(this));
        
        // Return to terminal
        this.terminalUI.printWelcome();
        this.terminalUI.printPrompt();
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

        // Terminal UI Manager
        class TerminalUI {
            constructor() {
                this.terminal = document.getElementById('terminal');
                this.terminalEngine = new UbuntuTerminal();
                this.currentInput = '';
                this.inputBuffer = '';
                this.isProcessing = false;
                this.init();
            }

            init() {
                this.printWelcome();
                this.printPrompt();
                this.setupEventListeners();
                this.terminal.focus();
            }

            printWelcome() {
                const welcome = `<div class="welcome-message">
Welcome to Ubuntu 22.04.3 LTS (GNU/Linux 5.15.0-91-generic x86_64)

 * Documentation:  https://help.ubuntu.com
 * Management:     https://landscape.canonical.com
 * Support:        https://ubuntu.com/advantage

  System information as of ${new Date().toLocaleString()}

  System load:  0.08                Processes:             123
  Usage of /:   24.8% of 19.21GB   Users logged in:       1
  Memory usage: 42%                 IPv4 address for eth0: 192.168.1.100
  Swap usage:   0%

 * Strictly confined Kubernetes makes edge and IoT secure. Learn how MicroK8s
   just raised the bar for easy, resilient and secure K8s cluster deployment.

   https://ubuntu.com/engage/secure-kubernetes-at-the-edge

0 updates can be applied immediately.


Last login: ${new Date().toLocaleString()} from 192.168.1.1
</div>`;
                this.terminal.innerHTML += welcome;
            }

            printPrompt() {
                const prompt = `<div class="input-line">
    <span class="prompt">
        <span class="user">${this.terminalEngine.username}</span>@<span class="host">${this.terminalEngine.hostname}</span>:<span class="path">${this.terminalEngine.currentDir}</span>$
    </span>
    <input type="text" class="command-input" autocomplete="off" spellcheck="false">
</div>`;
                this.terminal.innerHTML += prompt;
                
                const input = this.terminal.querySelector('.command-input:last-child');
                input.focus();
                
                input.addEventListener('keydown', (e) => this.handleInput(e, input));
                input.addEventListener('input', (e) => this.handleInputChange(e, input));
            }

            handleInput(e, input) {
                if (this.isProcessing) return;

                if (e.key === 'Enter') {
                    e.preventDefault();
                    const command = input.value.trim();
                    input.disabled = true;
                    this.isProcessing = true;
                    
                    // Remove input line and show command
                    const inputLine = input.closest('.input-line');
                    const promptSpan = inputLine.querySelector('.prompt').cloneNode(true);
                    inputLine.innerHTML = '';
                    inputLine.appendChild(promptSpan);
                    inputLine.innerHTML += ` ${command}`;
                    
                    // Execute command
                    setTimeout(() => {
                        const result = this.terminalEngine.execute(command);
                        
                        if (result === 'CLEAR') {
                            this.terminal.innerHTML = '';
                            this.printPrompt();
                        } else if (result) {
                            // Display result
                            const outputDiv = document.createElement('div');
                            outputDiv.className = 'output';
                            outputDiv.innerHTML = result;
                            this.terminal.appendChild(outputDiv);
                            
                            // Add new prompt
                            this.printPrompt();
                        } else {
                            // Empty result, just add new prompt
                            this.printPrompt();
                        }
                        
                        this.isProcessing = false;
                        this.scrollToBottom();
                    }, 0);
                } else if (e.key === 'Tab') {
                    e.preventDefault();
                    // Auto-completion logic
                    const current = input.value;
                    const commands = ['ls', 'cd', 'pwd', 'whoami', 'clear', 'help', 'cat', 'echo', 
                                     'touch', 'mkdir', 'rm', 'cp', 'mv', 'grep', 'find', 'chmod',
                                     'wc', 'head', 'tail', 'sort', 'date', 'cal', 'uptime', 'uname',
                                     'df', 'du', 'ps', 'kill', 'env', 'export', 'alias', 'history',
                                     'sudo', 'man', 'apt', 'ping', 'ifconfig', 'neofetch'];
                    
                    const matches = commands.filter(cmd => cmd.startsWith(current));
                    if (matches.length === 1) {
                        input.value = matches[0];
                    } else if (matches.length > 1) {
                        // Show possibilities
                        const outputDiv = document.createElement('div');
                        outputDiv.className = 'output';
                        outputDiv.textContent = matches.join('  ');
                        input.insertAdjacentElement('afterend', outputDiv);
                        this.printPrompt();
                    }
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    if (this.terminalEngine.commandHistory.length > 0) {
                        this.terminalEngine.historyIndex = Math.max(0, this.terminalEngine.historyIndex - 1);
                        input.value = this.terminalEngine.commandHistory[this.terminalEngine.historyIndex] || '';
                    }
                } else if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    if (this.terminalEngine.historyIndex < this.terminalEngine.commandHistory.length - 1) {
                        this.terminalEngine.historyIndex++;
                        input.value = this.terminalEngine.commandHistory[this.terminalEngine.historyIndex] || '';
                    } else {
                        this.terminalEngine.historyIndex = this.terminalEngine.commandHistory.length;
                        input.value = '';
                    }
                } else if (e.key === 'c' && e.ctrlKey) {
                    e.preventDefault();
                    input.value = '';
                    this.terminal.innerHTML += '<div class="output">^C</div>';
                    this.printPrompt();
                } else if (e.key === 'l' && e.ctrlKey) {
                    e.preventDefault();
                    this.terminalEngine.execute('clear');
                    this.terminal.innerHTML = '';
                    this.printPrompt();
                }
            }

            handleInputChange(e, input) {
                // Handle input changes for auto-suggestions
                // Could implement more advanced auto-completion here
            }

            scrollToBottom() {
                this.terminal.scrollTop = this.terminal.scrollHeight;
            }
        }

        // Global functions
        function goBack() {
            if (document.referrer && document.referrer.includes(window.location.hostname)) {
                window.history.back();
            } else {
                window.location.href = 'dashboard.php';
            }
            return false;
        }

        function clearTerminal() {
            const terminal = document.getElementById('terminal');
            terminal.innerHTML = '';
            const ui = new TerminalUI();
        }

        function minimizeTerminal() {
            // Toggle terminal size
            const terminal = document.querySelector('.terminal-body');
            const isMinimized = terminal.style.height === '200px';
            terminal.style.height = isMinimized ? 'calc(100vh - 96px)' : '200px';
        }

        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(err => {
                    console.log(`Error attempting to enable fullscreen: ${err.message}`);
                });
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }

        // Initialize terminal when page loads
        document.addEventListener('DOMContentLoaded', () => {
            new TerminalUI();
            
            // Make terminal focusable and scrollable
            const terminal = document.getElementById('terminal');
            terminal.tabIndex = 0;
            terminal.addEventListener('click', () => {
                const input = terminal.querySelector('.command-input:last-child');
                if (input) input.focus();
            });
            
            // Handle fullscreen change
            document.addEventListener('fullscreenchange', () => {
                const btn = document.querySelector('.fullscreen-btn');
                if (document.fullscreenElement) {
                    btn.title = 'Exit Fullscreen';
                } else {
                    btn.title = 'Fullscreen';
                }
            });
        });

        // Handle Ctrl+L for clearing
        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey && e.key === 'l') {
                e.preventDefault();
                clearTerminal();
            }
        });
    </script>
</body>
</html>