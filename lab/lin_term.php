<?php 
session_start(); 
// Include your DBconfig class
require_once '../api/dbconf.php'; // Adjust the path if needed

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['id'];

// Create database connection
$db = new DBconfig();

// Check connection
if (!$db->check_con()) {
    die("Database connection failed");
}

// Get only the user's name
$userInfo = $db->getUserInfo($userId, ['name']);
$userName = isset($userInfo['name']) ? $userInfo['name'] : 'User';
?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terminal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
            min-width: 1280px;
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
            --pop: rgba(255, 255, 255, 0.025);
            --input: rgba(255, 255, 255, 0.15);
            --ring: rgba(148, 163, 184, 0.5);
            
            --success: #10b981;
            --destructive: #ef4444;
            --warning: #f59e0b;
            
            --chart-1: #6366f1;
            --chart-2: #10b981;
            --chart-3: #f59e0b;
            --chart-4: #8b5cf6;
            --chart-5: #ec4899;
            
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
            --header-mobile: 3.8rem;
            
            /* Terminal specific colors */
            --terminal-bg: #0a0a0f;
            --terminal-text: #e0e0ff;
            --terminal-prompt: #10b981;
            --terminal-user: #6366f1;
            --terminal-host: #8b5cf6;
            --terminal-path: #f59e0b;
            --terminal-error: #ef4444;
            --terminal-success: #10b981;
            --terminal-directory: #569cd6;
            --terminal-file: #ce9178;
            --terminal-executable: #d7ba7d;
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
        .hidden {
            display: none !important;
        }

        .block {
            display: block;
        }

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

        .sticky {
            position: sticky;
        }

        .inset-0 {
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        .w-full {
            width: 100%;
        }

        .h-full {
            height: 100%;
        }

        .h-screen {
            height: 100vh;
        }

        .min-h-screen {
            min-height: 100vh;
        }

        .size-full {
            width: 100%;
            height: 100%;
        }

        .rounded-lg {
            border-radius: var(--radius);
        }

        .rounded-md {
            border-radius: calc(var(--radius) - 2px);
        }

        .rounded-sm {
            border-radius: calc(var(--radius) - 4px);
        }

        .rounded-full {
            border-radius: 9999px;
        }

        .border {
            border-width: 1px;
        }

        .border-2 {
            border-width: 2px;
        }

        .border-b {
            border-bottom-width: 1px;
        }

        .border-t {
            border-top-width: 1px;
        }

        .ring-2 {
            box-shadow: 0 0 0 2px var(--ring);
        }

        .ring-pop {
            box-shadow: 0 0 0 2px var(--pop);
        }

        .bg-background {
            background-color: var(--background);
        }

        .bg-foreground {
            background-color: var(--foreground);
        }

        .bg-primary {
            background-color: var(--primary);
        }

        .bg-secondary {
            background-color: var(--secondary);
        }

        .bg-muted {
            background-color: var(--muted);
        }

        .bg-accent {
            background-color: var(--accent);
        }

        .bg-card {
            background-color: var(--card);
        }

        .bg-success {
            background-color: var(--success);
        }

        .bg-warning {
            background-color: var(--warning);
        }

        .bg-destructive {
            background-color: var(--destructive);
        }

        .bg-sidebar {
            background-color: var(--sidebar);
        }

        .bg-sidebar-primary {
            background-color: var(--sidebar-primary);
        }

        .bg-sidebar-accent {
            background-color: var(--sidebar-accent);
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

        .text-secondary {
            color: var(--secondary);
        }

        .text-secondary-foreground {
            color: var(--secondary-foreground);
        }

        .text-muted {
            color: var(--muted);
        }

        .text-muted-foreground {
            color: var(--muted-foreground);
        }

        .text-success {
            color: var(--success);
        }

        .text-warning {
            color: var(--warning);
        }

        .text-destructive {
            color: var(--destructive);
        }

        .text-sidebar-foreground {
            color: var(--sidebar-foreground);
        }

        .text-sidebar-primary {
            color: var(--sidebar-primary);
        }

        .text-sidebar-primary-foreground {
            color: var(--sidebar-primary-foreground);
        }

        .text-sidebar-accent-foreground {
            color: var(--sidebar-accent-foreground);
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

        .text-4xl {
            font-size: 2.25rem;
            line-height: 2.5rem;
        }

        .text-5xl {
            font-size: 3rem;
            line-height: 1;
        }

        .font-normal {
            font-weight: 400;
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

        .italic {
            font-style: italic;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .opacity-0 {
            opacity: 0;
        }

        .opacity-10 {
            opacity: 0.1;
        }

        .opacity-20 {
            opacity: 0.2;
        }

        .opacity-30 {
            opacity: 0.3;
        }

        .opacity-40 {
            opacity: 0.4;
        }

        .opacity-50 {
            opacity: 0.5;
        }

        .opacity-60 {
            opacity: 0.6;
        }

        .opacity-70 {
            opacity: 0.7;
        }

        .opacity-80 {
            opacity: 0.8;
        }

        .opacity-90 {
            opacity: 0.9;
        }

        .opacity-100 {
            opacity: 1;
        }

        .grayscale {
            filter: grayscale(100%);
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .cursor-grab {
            cursor: grab;
        }

        .cursor-grabbing {
            cursor: grabbing;
        }

        .select-none {
            user-select: none;
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        .transition-colors {
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }

        .transition-opacity {
            transition: opacity 0.3s ease;
        }

        .transition-transform {
            transition: transform 0.3s ease;
        }

        .duration-200 {
            transition-duration: 0.2s;
        }

        .duration-300 {
            transition-duration: 0.3s;
        }

        .duration-500 {
            transition-duration: 0.5s;
        }

        .ease-out {
            transition-timing-function: cubic-bezier(0, 0, 0.2, 1);
        }

        .ease-in-out {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        .group:hover .group-hover\:opacity-100 {
            opacity: 1 !important;
        }

        .group:hover .group-hover\:scale-105 {
            transform: scale(1.05);
        }

        .group:hover .group-hover\:brightness-110 {
            filter: brightness(1.1);
        }

        /* ===== LAYOUT GRID ===== */
        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }

        .grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .grid-cols-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .grid-cols-12 {
            grid-template-columns: repeat(12, minmax(0, 1fr));
        }

        .col-span-1 {
            grid-column: span 1 / span 1;
        }

        .col-span-2 {
            grid-column: span 2 / span 2;
        }

        .col-span-3 {
            grid-column: span 3 / span 3;
        }

        .col-span-7 {
            grid-column: span 7 / span 7;
        }

        .gap-1 {
            gap: 0.25rem;
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

        .gap-10 {
            gap: 2.5rem;
        }

        .gap-gap {
            gap: var(--gap);
        }

        .p-0 {
            padding: 0;
        }

        .p-1 {
            padding: 0.25rem;
        }

        .p-2 {
            padding: 0.5rem;
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

        .px-2 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .py-1 {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
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

        .py-8 {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        .py-10 {
            padding-top: 2.5rem;
            padding-bottom: 2.5rem;
        }

        .py-sides {
            padding-top: var(--sides);
            padding-bottom: var(--sides);
        }

        .px-sides {
            padding-left: var(--sides);
            padding-right: var(--sides);
        }

        .pt-1 {
            padding-top: 0.25rem;
        }

        .pt-2 {
            padding-top: 0.5rem;
        }

        .pt-4 {
            padding-top: 1rem;
        }

        .pb-1 {
            padding-bottom: 0.25rem;
        }

        .pb-4 {
            padding-bottom: 1rem;
        }

        .pl-2 {
            padding-left: 0.5rem;
        }

        .pl-3 {
            padding-left: 0.75rem;
        }

        .pl-4 {
            padding-left: 1rem;
        }

        .pr-1 {
            padding-right: 0.25rem;
        }

        .pr-2 {
            padding-right: 0.5rem;
        }

        .pr-3 {
            padding-right: 0.75rem;
        }

        .pr-4 {
            padding-right: 1rem;
        }

        .mt-1 {
            margin-top: 0.25rem;
        }

        .mt-2 {
            margin-top: 0.5rem;
        }

        .mt-auto {
            margin-top: auto;
        }

        .mb-1 {
            margin-bottom: 0.25rem;
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

        .ml-auto {
            margin-left: auto;
        }

        .mr-1 {
            margin-right: 0.25rem;
        }

        .mr-2 {
            margin-right: 0.5rem;
        }

        .mr-3 {
            margin-right: 0.75rem;
        }

        .space-y-1 > * + * {
            margin-top: 0.25rem;
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

        .space-y-6 > * + * {
            margin-top: 1.5rem;
        }

        .flex-1 {
            flex: 1 1 0%;
        }

        .flex-col {
            flex-direction: column;
        }

        .flex-row {
            flex-direction: row;
        }

        .items-start {
            align-items: flex-start;
        }

        .items-center {
            align-items: center;
        }

        .items-baseline {
            align-items: baseline;
        }

        .items-stretch {
            align-items: stretch;
        }

        .justify-start {
            justify-content: flex-start;
        }

        .justify-center {
            justify-content: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .justify-end {
            justify-content: flex-end;
        }

        .min-w-0 {
            min-width: 0;
        }

        .max-w-xs {
            max-width: 20rem;
        }

        .max-w-sm {
            max-width: 24rem;
        }

        .max-w-md {
            max-width: 28rem;
        }

        .max-w-max {
            max-width: max-content;
        }

        .w-1\/4 {
            width: 25%;
        }

        .w-14 {
            width: 3.5rem;
        }

        .w-16 {
            width: 4rem;
        }

        .w-56 {
            width: 14rem;
        }

        .w-80 {
            width: 20rem;
        }

        .h-5 {
            height: 1.25rem;
        }

        .h-6 {
            height: 1.5rem;
        }

        .h-7 {
            height: 1.75rem;
        }

        .h-8 {
            height: 2rem;
        }

        .h-10 {
            height: 2.5rem;
        }

        .h-12 {
            height: 3rem;
        }

        .h-14 {
            height: 3.5rem;
        }

        .h-32 {
            height: 8rem;
        }

        .h-header-mobile {
            height: var(--header-mobile);
        }

        .size-3 {
            width: 0.75rem;
            height: 0.75rem;
        }

        .size-4 {
            width: 1rem;
            height: 1rem;
        }

        .size-5 {
            width: 1.25rem;
            height: 1.25rem;
        }

        .size-6 {
            width: 1.5rem;
            height: 1.5rem;
        }

        .size-7 {
            width: 1.75rem;
            height: 1.75rem;
        }

        .size-9 {
            width: 2.25rem;
            height: 2.25rem;
        }

        .size-10 {
            width: 2.5rem;
            height: 2.5rem;
        }

        .size-12 {
            width: 3rem;
            height: 3rem;
        }

        .size-14 {
            width: 3.5rem;
            height: 3.5rem;
        }

        .size-16 {
            width: 4rem;
            height: 4rem;
        }

        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }

        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
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

        .badge-default {
            background-color: var(--primary);
            color: var(--primary-foreground);
            border-color: var(--primary);
        }

        .badge-secondary {
            background-color: var(--secondary);
            color: var(--secondary-foreground);
            border-color: var(--border);
        }

        .badge-outline {
            background-color: transparent;
            color: currentColor;
            border-color: currentColor;
        }

        .badge-outline-success {
            background-color: transparent;
            color: var(--success);
            border-color: var(--success);
        }

        .badge-outline-warning {
            background-color: transparent;
            color: var(--warning);
            border-color: var(--warning);
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

        .button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .button-default {
            background-color: var(--primary);
            color: var(--primary-foreground);
        }

        .button-default:hover:not(:disabled) {
            background-color: color-mix(in srgb, var(--primary) 90%, black);
        }

        .button-secondary {
            background-color: var(--secondary);
            color: var(--secondary-foreground);
            border-color: var(--border);
        }

        .button-secondary:hover:not(:disabled) {
            background-color: color-mix(in srgb, var(--secondary) 90%, black);
        }

        .button-ghost {
            background-color: transparent;
            color: currentColor;
        }

        .button-ghost:hover:not(:disabled) {
            background-color: var(--accent);
        }

        .button-outline {
            background-color: transparent;
            color: currentColor;
            border-color: currentColor;
        }

        .button-outline:hover:not(:disabled) {
            background-color: var(--accent);
        }

        .button-sm {
            height: 2rem;
            padding: 0 0.75rem;
            font-size: 0.875rem;
        }

        .button-md {
            height: 2.5rem;
            padding: 0 1rem;
            font-size: 0.875rem;
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

        .button-icon {
            width: 2.5rem;
            height: 2.5rem;
            padding: 0;
        }

        .input {
            width: 100%;
            height: 2.5rem;
            padding: 0 0.75rem;
            background-color: var(--input);
            border: 1px solid var(--border);
            border-radius: calc(var(--radius) - 2px);
            color: var(--foreground);
            font-family: inherit;
            font-size: 0.875rem;
            transition: border-color 0.2s;
        }

        .input:focus {
            outline: none;
            border-color: var(--ring);
        }

        .input::placeholder {
            color: var(--muted-foreground);
            opacity: 0.7;
        }

        .separator {
            width: 100%;
            height: 1px;
            background-color: var(--border);
        }

        .bullet {
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 50%;
            background-color: var(--muted-foreground);
        }

        .bullet-success {
            background-color: var(--success);
        }

        .bullet-warning {
            background-color: var(--warning);
        }

        .bullet-destructive {
            background-color: var(--destructive);
        }

        .bullet-sm {
            width: 0.375rem;
            height: 0.375rem;
        }

        .sheet {
            position: fixed;
            z-index: 50;
            background-color: var(--background);
            transition: transform 0.3s ease;
        }

        .sheet-bottom {
            bottom: 0;
            left: 0;
            right: 0;
            transform: translateY(100%);
        }

        .sheet-bottom.open {
            transform: translateY(0);
        }

        .sheet-right {
            top: 0;
            right: 0;
            bottom: 0;
            transform: translateX(100%);
        }

        .sheet-right.open {
            transform: translateX(0);
        }

        .tooltip {
            position: relative;
        }

        .tooltip-content {
            position: absolute;
            z-index: 50;
            padding: 0.5rem 0.75rem;
            background-color: var(--popover);
            color: var(--popover-foreground);
            border: 1px solid var(--border);
            border-radius: calc(var(--radius) - 2px);
            font-size: 0.875rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
        }

        .tooltip:hover .tooltip-content {
            opacity: 1;
        }

        .tabs-list {
            display: flex;
            gap: 0.5rem;
            border-bottom: 1px solid var(--border);
            padding-bottom: 0.5rem;
        }

        .tabs-trigger {
            padding: 0.5rem 1rem;
            background: transparent;
            border: none;
            color: var(--muted-foreground);
            font-family: inherit;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            cursor: pointer;
            transition: color 0.2s;
            position: relative;
        }

        .tabs-trigger:hover {
            color: var(--foreground);
        }

        .tabs-trigger.active {
            color: var(--foreground);
        }

        .tabs-trigger.active::after {
            content: '';
            position: absolute;
            bottom: -0.5rem;
            left: 0;
            right: 0;
            height: 2px;
            background-color: var(--primary);
        }

        /* ===== TERMINAL SPECIFIC STYLES ===== */
        .terminal-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
            background-color: var(--card);
        }

        .terminal-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: var(--terminal-bg);
            border-radius: var(--radius);
            overflow: hidden;
            border: 1px solid var(--border);
        }

        .terminal-controls {
            padding: 0.75rem 1rem;
            background-color: var(--secondary);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .control-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .control-btn {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .control-btn:hover {
            opacity: 0.8;
        }

        .control-btn.close {
            background-color: var(--destructive);
        }

        .control-btn.minimize {
            background-color: var(--warning);
        }

        .control-btn.maximize {
            background-color: var(--success);
        }

        .terminal-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 0.75rem;
            color: var(--muted-foreground);
        }

        .terminal-body {
            flex: 1;
            overflow: auto;
            padding: 1rem;
            font-family: 'Roboto Mono', monospace;
            font-size: 14px;
            line-height: 1.4;
        }

        #terminal {
            height: 100%;
            color: var(--terminal-text);
            white-space: pre-wrap;
            word-wrap: break-word;
            outline: none;
        }

        #terminal:focus {
            outline: none;
        }

        /* Terminal text styles */
        .terminal-line {
            margin-bottom: 2px;
            display: flex;
            flex-wrap: wrap;
            align-items: baseline;
        }

        .prompt {
            color: var(--terminal-prompt);
            font-weight: bold;
        }

        .user {
            color: var(--terminal-user);
        }

        .host {
            color: var(--terminal-host);
        }

        .path {
            color: var(--terminal-path);
        }

        .command {
            color: var(--terminal-text);
        }

        .output {
            color: var(--terminal-text);
            opacity: 0.9;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .error {
            color: var(--terminal-error);
        }

        .success {
            color: var(--terminal-success);
        }

        .directory {
            color: var(--terminal-directory);
        }

        .file {
            color: var(--terminal-file);
        }

        .executable {
            color: var(--terminal-executable);
        }

        .link {
            color: #d7ba7d;
        }

        .welcome-message {
            color: var(--muted-foreground);
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .input-line {
            display: flex;
            align-items: baseline;
            margin-bottom: 0;
        }

        .command-input {
            background: transparent;
            border: none;
            color: var(--terminal-text);
            font-family: 'Roboto Mono', monospace;
            font-size: 14px;
            outline: none;
            padding: 0;
            margin-left: 0.5rem;
            flex: 1;
            caret-color: var(--terminal-text);
        }

        .command-input:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .cursor {
            display: inline-block;
            background: var(--terminal-text);
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

        /* ===== ANIMATIONS ===== */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes slideDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }

        .animate-slideUp {
            animation: slideUp 0.3s ease-out;
        }

        .animate-slideDown {
            animation: slideDown 0.3s ease-out;
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

        /* ===== FULLSCREEN STYLES ===== */
        .fullscreen {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1000;
            background-color: var(--terminal-bg);
            padding: 0;
            margin: 0;
            border-radius: 0;
        }

        .fullscreen .terminal-body {
            height: calc(100vh - 60px);
        }

        /* ===== TV NOISE EFFECT ===== */
        .tv-noise {
            position: absolute;
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
            opacity: 0.1;
            pointer-events: none;
            z-index: 1;
        }

        /* ===== MOBILE RESPONSIVE ===== */
        @media (max-width: 768px) {
            body {
                min-width: 100%;
                overflow-x: auto;
            }
            
            .desktop-container {
                grid-template-columns: 1fr;
                padding: 1rem;
                min-width: 100%;
            }
            
            .desktop-sidebar {
                display: none;
            }
            
            .terminal-body {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="desktop-container">
        <!-- Main Content Area -->
        <div class="desktop-main">
            <!-- Terminal Header -->
            <div class="card animate-fadeIn">
                <div class="terminal-header">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="size-9 rounded bg-primary flex items-center justify-center">
                                <i class="fas fa-terminal text-primary-foreground text-lg"></i>
                            </div>
                            <div>
                                <h1 class="text-3xl font-display">Proworldz Terminal</h1>
                                <div class="text-sm text-muted-foreground">Ubuntu 22.04 LTS - Interactive Shell</div>
                                <div class="text-sm text-muted-foreground">Warning : Refresh this can loss your command line data</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button class="button button-secondary button-sm" onclick="goBack()">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Back to Dashboard
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Terminal Container -->
            <div class="terminal-container animate-slideUp" style="animation-delay: 0.1s">
                <!-- Terminal Controls -->
                <div class="terminal-controls">
                    <div class="control-buttons">
                        <button class="control-btn close" onclick="clearTerminal()" title="Clear Terminal"></button>
                        <button class="control-btn minimize" onclick="minimizeTerminal()" title="Minimize"></button>
                        <button class="control-btn maximize" onclick="toggleFullscreen()" title="Fullscreen"></button>
                    </div>
                    <div class="terminal-info">
                        <span><i class="fas fa-microchip"></i> Ubuntu 22.04 LTS</span>
                        <span><i class="fas fa-user"></i> <?= $userName;?></span>
                        <span><i class="fas fa-folder"></i> ~</span>
                    </div>
                </div>

                <!-- Terminal Body -->
                <div class="terminal-body">
                    <div id="terminal" tabindex="0"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Ubuntu Terminal Engine
        class UbuntuTerminal {
            constructor() {
                this.username = <?= json_encode($userName); ?>;
                this.hostname = 'root';
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
                                        content: '# Welcome to Proworldz OS Terminal\n\nThis is a simulated Linux terminal with full command support.\n\nType \'help\' to see available commands.\nType \'neofetch\' for system information.'
                                    },
                                    'readme.md': {
                                        type: 'file',
                                        permissions: '-rw-r--r--',
                                        owner: this.username,
                                        group: this.username,
                                        size: '456',
                                        modified: 'Jan 1 00:00',
                                        name: 'readme.md',
                                        content: '# Proworldz OS Ubuntu Terminal\n\nA fully functional terminal simulator with Linux commands.\n\nFeatures:\n- File system navigation\n- File operations\n- Text processing\n- System commands\n- Package management simulation'
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
                            'Projects': {
                                type: 'dir',
                                permissions: 'drwxr-xr-x',
                                owner: this.username,
                                group: this.username,
                                size: '4096',
                                modified: 'Jan 1 00:00',
                                name: 'Projects',
                                children: {
                                    'web_app': {
                                        type: 'dir',
                                        permissions: 'drwxr-xr-x',
                                        owner: this.username,
                                        group: this.username,
                                        size: '4096',
                                        modified: 'Jan 1 00:00',
                                        name: 'web_app',
                                        children: {
                                            'index.html': {
                                                type: 'file',
                                                permissions: '-rw-r--r--',
                                                owner: this.username,
                                                group: this.username,
                                                size: '1024',
                                                modified: 'Jan 1 00:00',
                                                name: 'index.html',
                                                content: '<!DOCTYPE html>\n<html>\n<head>\n    <title>Proworldz OS</title>\n</head>\n<body>\n    <h1>Welcome to Proworldz OS</h1>\n</body>\n</html>'
                                            }
                                        }
                                    }
                                }
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
                    case 'nano': return this.nano(args);
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
  nano [file]            - Text editor

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
                }).sort();
                
                if (longFormat) {
                    return items.map(item => {
                        const child = node.children[item];
                        const size = humanReadable ? this.formatSize(child.size) : child.size.padStart(5);
                        return `${child.permissions} ${child.owner} ${child.group} ${size} ${child.modified} ${child.name}`;
                    }).join(' ');
                } else {
                    // Color code by type
                    return items.map(item => {
                        const child = node.children[item];
                        if (child.type === 'dir') return `<span class="directory">${item}/</span>`;
                        if (child.permissions.startsWith('-rwx')) return `<span class="executable">${item}*</span>`;
                        return `<span class="file">${item}</span>`;
                    }).join('&nbsp;&nbsp;&nbsp;&nbsp;');
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

            cp(args) {
                if (args.length < 2) return 'cp: missing file operand';
                
                const node = this.getCurrentNode();
                if (!node || !node.children) return '';
                
                const src = args[0];
                const dest = args[1];
                
                if (!node.children[src]) {
                    return `cp: cannot stat '${src}': No such file or directory`;
                }
                
                const srcObj = JSON.parse(JSON.stringify(node.children[src]));
                srcObj.modified = new Date().toLocaleDateString('en-US', { 
                    month: 'short', 
                    day: '2-digit', 
                    hour: '2-digit', 
                    minute: '2-digit' 
                });
                
                node.children[dest] = srcObj;
                node.children[dest].name = dest;
                
                return '';
            }

            mv(args) {
                if (args.length < 2) return 'mv: missing file operand';
                
                const node = this.getCurrentNode();
                if (!node || !node.children) return '';
                
                const src = args[0];
                const dest = args[1];
                
                if (!node.children[src]) {
                    return `mv: cannot stat '${src}': No such file or directory`;
                }
                
                const srcObj = node.children[src];
                srcObj.modified = new Date().toLocaleDateString('en-US', { 
                    month: 'short', 
                    day: '2-digit', 
                    hour: '2-digit', 
                    minute: '2-digit' 
                });
                
                node.children[dest] = srcObj;
                node.children[dest].name = dest;
                delete node.children[src];
                
                return '';
            }

            chmod(args) {
                if (args.length < 2) return 'chmod: missing operand';
                return '';
            }

            grep(args) {
                if (args.length < 2) return 'grep: missing pattern or file';
                
                const pattern = args[0];
                const filename = args[1];
                const node = this.getCurrentNode();
                
                if (!node || !node.children || !node.children[filename]) {
                    return `grep: ${filename}: No such file or directory`;
                }
                
                const file = node.children[filename];
                if (file.type !== 'file') {
                    return `grep: ${filename}: Is a directory`;
                }
                
                const lines = file.content.split('\n');
                const results = lines.filter(line => line.toLowerCase().includes(pattern.toLowerCase()));
                
                if (results.length === 0) {
                    return '';
                }
                
                return results.map(line => {
                    const matchIndex = line.toLowerCase().indexOf(pattern.toLowerCase());
                    if (matchIndex >= 0) {
                        const before = line.substring(0, matchIndex);
                        const match = line.substring(matchIndex, matchIndex + pattern.length);
                        const after = line.substring(matchIndex + pattern.length);
                        return before + '\x1b[1;31m' + match + '\x1b[0m' + after;
                    }
                    return line;
                }).join('\n');
            }

            find(args) {
                if (args.length === 0) return 'find: missing path';
                return '.';
            }

            wc(args) {
                if (args.length === 0) return 'wc: missing file operand';
                
                const node = this.getCurrentNode();
                if (!node || !node.children) return '';
                
                const filename = args[0];
                if (!node.children[filename]) {
                    return `wc: ${filename}: No such file or directory`;
                }
                
                const file = node.children[filename];
                if (file.type !== 'file') {
                    return `wc: ${filename}: Is a directory`;
                }
                
                const lines = file.content.split('\n').filter(line => line !== '');
                const words = file.content.split(/\s+/).filter(word => word !== '');
                const chars = file.content.length;
                
                return `  ${lines.length}  ${words.length} ${chars} ${filename}`;
            }

            head(args) {
                if (args.length === 0) return 'head: missing file operand';
                
                const node = this.getCurrentNode();
                if (!node || !node.children) return '';
                
                const filename = args[0];
                const n = args.includes('-n') ? parseInt(args[args.indexOf('-n') + 1]) : 10;
                
                if (!node.children[filename]) {
                    return `head: cannot open '${filename}' for reading: No such file or directory`;
                }
                
                const file = node.children[filename];
                if (file.type !== 'file') {
                    return `head: error reading '${filename}': Is a directory`;
                }
                
                const lines = file.content.split('\n');
                return lines.slice(0, n).join('\n');
            }

            tail(args) {
                if (args.length === 0) return 'tail: missing file operand';
                
                const node = this.getCurrentNode();
                if (!node || !node.children) return '';
                
                const filename = args[0];
                const n = args.includes('-n') ? parseInt(args[args.indexOf('-n') + 1]) : 10;
                
                if (!node.children[filename]) {
                    return `tail: cannot open '${filename}' for reading: No such file or directory`;
                }
                
                const file = node.children[filename];
                if (file.type !== 'file') {
                    return `tail: error reading '${filename}': Is a directory`;
                }
                
                const lines = file.content.split('\n');
                return lines.slice(-n).join('\n');
            }

            sort(args) {
                if (args.length === 0) return 'sort: missing file operand';
                
                const node = this.getCurrentNode();
                if (!node || !node.children) return '';
                
                const filename = args[0];
                if (!node.children[filename]) {
                    return `sort: cannot read: ${filename}: No such file or directory`;
                }
                
                const file = node.children[filename];
                if (file.type !== 'file') {
                    return `sort: read failed: ${filename}: Is a directory`;
                }
                
                const lines = file.content.split('\n').filter(line => line !== '');
                const reversed = args.includes('-r');
                const sorted = lines.sort();
                
                if (reversed) {
                    sorted.reverse();
                }
                
                return sorted.join('\n');
            }

            date() {
                return new Date().toString();
            }

            cal(args) {
                const now = new Date();
                const month = args.length > 0 ? parseInt(args[0]) - 1 : now.getMonth();
                const year = args.length > 1 ? parseInt(args[1]) : now.getFullYear();
                
                const date = new Date(year, month, 1);
                const monthNames = [
                    'January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'October', 'November', 'December'
                ];
                
                let result = `     ${monthNames[date.getMonth()]} ${date.getFullYear()}\n`;
                result += `Su Mo Tu We Th Fr Sa\n`;
                
                const firstDay = date.getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();
                
                let calendar = '';
                for (let i = 0; i < firstDay; i++) {
                    calendar += '   ';
                }
                
                for (let day = 1; day <= daysInMonth; day++) {
                    const formattedDay = day.toString().padStart(2);
                    calendar += `${formattedDay} `;
                    if ((day + firstDay) % 7 === 0) {
                        calendar += '\n';
                    }
                }
                
                return result + calendar;
            }

            uptime() {
                return ' 00:00:00 up 1 day,  0:00,  1 user,  load average: 0.00, 0.00, 0.00';
            }

            uname(args) {
                if (args.includes('-a')) {
                    return 'Linux monkey-os 5.15.0-91-generic #101-Ubuntu SMP Tue Nov 5 18:08:27 UTC 2024 x86_64 x86_64 x86_64 GNU/Linux';
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

            du(args) {
                const dir = args.length > 0 ? args[0] : '.';
                return `4096\t${dir}`;
            }

            ps(args) {
                return `    PID TTY          TIME CMD
      1 ?        00:00:01 systemd
    456 ?        00:00:00 bash
    ${Math.floor(Math.random() * 9000) + 1000} ?        00:00:00 ps`;
            }

            kill(args) {
                if (args.length === 0) return 'kill: usage: kill [-s sigspec | -n signum | -sigspec] pid | jobspec ... or kill -l [sigspec]';
                return '';
            }

            envCmd() {
                return Object.entries(this.env).map(([k, v]) => `${k}=${v}`).join('\n');
            }

            export(args) {
                if (args.length === 0) {
                    return this.envCmd();
                }
                
                const parts = args.join(' ').split('=');
                if (parts.length >= 2) {
                    const varName = parts[0].trim();
                    const value = parts.slice(1).join('=').trim();
                    this.env[varName] = value;
                }
                return '';
            }

            aliasCmd(args) {
                if (args.length === 0) {
                    return Object.entries(this.aliases)
                        .map(([name, value]) => `alias ${name}='${value}'`)
                        .join('\n');
                }
                
                const arg = args.join(' ');
                if (arg.includes('=')) {
                    const parts = arg.split('=');
                    const name = parts[0];
                    const value = parts.slice(1).join('=').replace(/'/g, '');
                    this.aliases[name] = value;
                }
                return '';
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

            sudo(args) {
                if (args.length === 0) return 'sudo: missing command';
                
                if (args[0] === 'apt') {
                    return this.apt(args.slice(1), true);
                }
                
                return `[sudo] password for ${this.username}: `;
            }

            man(args) {
                if (args.length === 0) return 'What manual page do you want?';
                
                const cmd = args[0];
                const manuals = {
                    'ls': 'LS(1) - list directory contents\n\nSYNOPSIS\n     ls [OPTION]... [FILE]...\n\nDESCRIPTION\n     List information about the FILEs (the current directory by default).',
                    'cd': 'CD(1) - change directory\n\nSYNOPSIS\n     cd [DIRECTORY]\n\nDESCRIPTION\n     Change the current directory to DIRECTORY.',
                    'cat': 'CAT(1) - concatenate files and print on the standard output\n\nSYNOPSIS\n     cat [FILE]...\n\nDESCRIPTION\n     Concatenate FILE(s) to standard output.',
                    'grep': 'GREP(1) - print lines matching a pattern\n\nSYNOPSIS\n     grep [OPTIONS] PATTERN [FILE]...\n\nDESCRIPTION\n     grep searches for PATTERN in each FILE.',
                    'sudo': 'SUDO(8) - execute a command as another user\n\nSYNOPSIS\n     sudo [OPTIONS] COMMAND\n\nDESCRIPTION\n     sudo allows a permitted user to execute a command as the superuser.'
                };
                
                return manuals[cmd] || `No manual entry for ${cmd}`;
            }

            apt(args, sudo = false) {
                if (args.length === 0) {
                    return 'apt 2.4.9 (amd64)\nUsage: apt [options] command';
                }
                
                const cmd = args[0];
                switch(cmd) {
                    case 'update':
                        if (!sudo) {
                            return 'E: Could not open lock file /var/lib/apt/lists/lock - open (13: Permission denied)\nE: Unable to lock directory /var/lib/apt/lists/\nW: Problem unlinking the file /var/cache/apt/pkgcache.bin - RemoveCaches (13: Permission denied)\nW: Problem unlinking the file /var/cache/apt/srcpkgcache.bin - RemoveCaches (13: Permission denied)';
                        }
                        return `Get:1 http://archive.ubuntu.com/ubuntu jammy InRelease [270 kB]
Get:2 http://archive.ubuntu.com/ubuntu jammy-updates InRelease [119 kB]
Get:3 http://archive.ubuntu.com/ubuntu jammy-backports InRelease [109 kB]
Fetched 498 kB in 1s (456 kB/s)
Reading package lists... Done`;
                        
                    case 'upgrade':
                        if (!sudo) {
                            return 'Reading package lists... Done\nE: Could not open lock file /var/lib/dpkg/lock-frontend - open (13: Permission denied)\nE: Unable to acquire the dpkg frontend lock (/var/lib/dpkg/lock-frontend), are you root?';
                        }
                        return `Reading package lists... Done
Building dependency tree... Done
Reading state information... Done
Calculating upgrade... Done
0 upgraded, 0 newly installed, 0 to remove and 0 not upgraded.`;
                        
                    case 'install':
                        if (args.length < 2) return 'E: Invalid operation install';
                        if (!sudo) return 'E: Could not open lock file /var/lib/dpkg/lock-frontend - open (13: Permission denied)';
                        return `Reading package lists... Done
Building dependency tree... Done
Reading state information... Done
The following NEW packages will be installed:
  ${args[1]}
0 upgraded, 1 newly installed, 0 to remove and 0 not upgraded.
Need to get 0 B/1,234 kB of archives.
After this operation, 4,096 B of additional disk space will be used.
Selecting previously unselected package ${args[1]}.
(Reading database ... 123456 files and directories currently installed.)
Preparing to unpack .../${args[1]}_1.0.0_amd64.deb ...
Unpacking ${args[1]} (1.0.0) ...
Setting up ${args[1]} (1.0.0) ...`;
                        
                    default:
                        return `E: Invalid operation ${cmd}`;
                }
            }

            ping(args) {
                if (args.length === 0) return 'ping: missing host operand';
                
                const host = args[0].replace('-c', '').trim();
                const count = args.includes('-c') ? parseInt(args[args.indexOf('-c') + 1]) : 3;
                
                if (host === 'google.com' || host === '8.8.8.8') {
                    let result = `PING ${host} (8.8.8.8) 56(84) bytes of data.\n`;
                    for (let i = 1; i <= count; i++) {
                        const time = (Math.random() * 30 + 10).toFixed(1);
                        result += `64 bytes from 8.8.8.8: icmp_seq=${i} ttl=117 time=${time} ms\n`;
                    }
                    result += `\n--- ${host} ping statistics ---\n`;
                    result += `${count} packets transmitted, ${count} received, 0% packet loss, time ${count * 1000}ms\n`;
                    result += `rtt min/avg/max/mdev = 10.123/15.456/30.789/5.678 ms`;
                    return result;
                }
                
                return `ping: ${host}: Name or service not known`;
            }

            ifconfig() {
                return `eth0: flags=4163<UP,BROADCAST,RUNNING,MULTICAST>  mtu 1500
        inet 192.168.1.100  netmask 255.255.255.0  broadcast 192.168.1.255
        inet6 fe80::20c:29ff:fea1:bcd2  prefixlen 64  scopeid 0x20<link>
        ether 00:0c:29:a1:bc:d2  txqueuelen 1000  (Ethernet)
        RX packets 123456  bytes 123456789 (117.7 MiB)
        RX errors 0  dropped 0  overruns 0  frame 0
        TX packets 98765  bytes 98765432 (94.2 MiB)
        TX errors 0  dropped 0 overruns 0  carrier 0  collisions 0

lo: flags=73<UP,LOOPBACK,RUNNING>  mtu 65536
        inet 127.0.0.1  netmask 255.0.0.0
        inet6 ::1  prefixlen 128  scopeid 0x10<host>
        loop  txqueuelen 1000  (Local Loopback)
        RX packets 1234  bytes 123456 (120.5 KiB)
        RX errors 0  dropped 0  overruns 0  frame 0
        TX packets 1234  bytes 123456 (120.5 KiB)
        TX errors 0  dropped 0 overruns 0  carrier 0  collisions 0`;
            }

            nano(args) {
                if (args.length === 0) return 'Usage: nano [OPTIONS] [[+LINE,COLUMN] FILE]...';
                
                const filename = args[0];
                return `GNU nano 6.2 - ${filename}

${' '.repeat(80)}
${' '.repeat(80)}
${' '.repeat(80)}

^G Get Help    ^O Write Out   ^W Where Is    ^K Cut Text   ^J Justify     ^C Cur Pos
^X Exit        ^R Read File   ^\\ Replace     ^U Paste Text ^T To Spell    ^_ Go To Line`;
            }

            neofetch() {
                return `
${' '.repeat(20)}.-\`\`\`\`\`-.,           \x1b[1;34muser\x1b[0m@\x1b[1;34mmonkey-os\x1b[0m
${' '.repeat(18)}/` + '`' + `${' '.repeat(11)}.-\`\`-.        \x1b[1;30m----------------\x1b[0m
${' '.repeat(18)}/` + '`' + `${' '.repeat(10)}/` + '`' + `${' '.repeat(11)}.      \x1b[1;34mOS\x1b[0m: Proworldz OS 22.04.3 LTS x86_64
${' '.repeat(19)}|` + '`' + `${' '.repeat(10)}/` + '`' + `${' '.repeat(13)}|     \x1b[1;34mHost\x1b[0m: Proworldz OS Virtual Machine
${' '.repeat(19)}|` + '`' + `${' '.repeat(10)}|` + '`' + `${' '.repeat(13)}|     \x1b[1;34mKernel\x1b[0m: 5.15.0-91-generic
${' '.repeat(18)}\\` + '`' + `.` + '`' + `${' '.repeat(9)}/` + '`' + `${' '.repeat(12)}/      \x1b[1;34mUptime\x1b[0m: 1 day, 0 hours
${' '.repeat(17)}\\` + '`' + `${' '.repeat(10)}/` + '`' + `${' '.repeat(12)}.      \x1b[1;34mPackages\x1b[0m: 1234 (dpkg)
${' '.repeat(18)}/` + '`' + `${' '.repeat(12)}/` + '`' + `${' '.repeat(12)}|     \x1b[1;34mShell\x1b[0m: bash 5.1.16
${' '.repeat(19)}/` + '`' + `${' '.repeat(12)}/` + '`' + `${' '.repeat(12)}|     \x1b[1;34mResolution\x1b[0m: 1920x1080
${' '.repeat(19)}|` + '`' + `${' '.repeat(12)}|` + '`' + `${' '.repeat(12)}|     \x1b[1;34mDE\x1b[0m: GNOME 42.9
${' '.repeat(19)}|` + '`' + `${' '.repeat(12)}|` + '`' + `${' '.repeat(12)}|     \x1b[1;34mWM\x1b[0m: Mutter
${' '.repeat(18)}\\` + '`' + `${' '.repeat(12)}|` + '`' + `${' '.repeat(12)}|     \x1b[1;34mWM Theme\x1b[0m: Adwaita
${' '.repeat(17)}/` + '`' + `${' '.repeat(12)}/` + '`' + `${' '.repeat(12)}|     \x1b[1;34mTheme\x1b[0m: Yaru-dark [GTK2/3]
${' '.repeat(16)}/` + '`' + `${' '.repeat(13)}/_\\` + '`' + `${' '.repeat(11)}|     \x1b[1;34mIcons\x1b[0m: Yaru [GTK2/3]
${' '.repeat(14)}/` + '`' + `${' '.repeat(14)}/` + '`' + `${' '.repeat(14)}|     \x1b[1;34mTerminal\x1b[0m: Proworldz Terminal
${' '.repeat(13)}|` + '`' + `${' '.repeat(15)}|` + '`' + `${' '.repeat(15)}|     \x1b[1;34mCPU\x1b[0m: Intel i7-12700K (16) @ 4.90GHz
${' '.repeat(13)}|` + '`' + `${' '.repeat(15)}|` + '`' + `${' '.repeat(15)}|     \x1b[1;34mGPU\x1b[0m: NVIDIA GeForce RTX 3080
${' '.repeat(13)}|` + '`' + `${' '.repeat(15)}|` + '`' + `${' '.repeat(15)}|     \x1b[1;34mMemory\x1b[0m: 1284MiB / 15937MiB`;
            }
        }

        // Terminal UI Controller
        const terminal = new UbuntuTerminal();
        let commandBuffer = '';
        let isProcessing = false;

        // Initialize terminal
        document.addEventListener('DOMContentLoaded', function() {
            initTerminal();
            setupEventListeners();
            showWelcomeMessage();
        });

        function initTerminal() {
            const terminalElement = document.getElementById('terminal');
            if (!terminalElement) return;
            
            terminalElement.innerHTML = '';
            terminalElement.setAttribute('tabindex', '0');
        }

        function setupEventListeners() {
    const terminalElement = document.getElementById('terminal');
    
    terminalElement.addEventListener('click', function() {
        this.focus();
    });
    
    terminalElement.addEventListener('keydown', function(e) {
        // Handle Ctrl combinations first
        if (e.ctrlKey) {
            switch(e.key.toLowerCase()) {
                case 'c':
                    e.preventDefault();
                    addOutput('^C');
                    commandBuffer = '';
                    updatePrompt();
                    return;
                case 'l':
                    e.preventDefault();
                    clearTerminal();
                    return;
                case 'u':
                    e.preventDefault();
                    commandBuffer = '';
                    updatePrompt();
                    return;
                case 'k':
                    e.preventDefault();
                    commandBuffer = commandBuffer.slice(0, -1);
                    updatePrompt();
                    return;
            }
        }
        
        // Handle other special keys
        switch(e.key) {
            case 'Enter':
                e.preventDefault();
                processCommand();
                break;
            case 'Backspace':
                e.preventDefault();
                if (commandBuffer.length > 0) {
                    commandBuffer = commandBuffer.slice(0, -1);
                    updatePrompt();
                }
                break;
            case 'Tab':
                e.preventDefault();
                autoComplete();
                break;
            case 'ArrowUp':
                e.preventDefault();
                navigateHistory(-1);
                break;
            case 'ArrowDown':
                e.preventDefault();
                navigateHistory(1);
                break;
            case 'ArrowLeft':
            case 'ArrowRight':
            case 'Shift':
            case 'Alt':
            case 'Meta':
            case 'Control':
            case 'Escape':
                // Allow default behavior for these keys
                break;
            default:
                // Only prevent default for single character keys
                // Check if it's a single character (not a special key)
                if (e.key.length === 1 && !e.ctrlKey && !e.altKey && !e.metaKey) {
                    e.preventDefault();
                    commandBuffer += e.key;
                    updatePrompt();
                }
                break;
        }
    });
    
    // Focus terminal on page load
    terminalElement.focus();
}

        function showWelcomeMessage() {
            const welcome = `Welcome to Proworldz OS Ubuntu Terminal 22.04 LTS

This is a simulated Linux terminal with full command support.
Type 'help' to see available commands.

`;
            addOutput(welcome);
            updatePrompt();
        }

        function updatePrompt() {
            const terminalElement = document.getElementById('terminal');
            const promptLine = `<div class="terminal-line input-line">
                <span class="prompt">[</span><span class="user">${terminal.username}</span><span class="prompt">@</span><span class="host">${terminal.hostname}</span><span class="prompt">:</span><span class="path">${terminal.currentDir}</span><span class="prompt">]$ </span>
                <span class="command">${commandBuffer}</span>
                <span class="cursor"></span>
            </div>`;
            
            // Find and replace the last input line
            const lines = terminalElement.querySelectorAll('.input-line');
            if (lines.length > 0) {
                lines[lines.length - 1].outerHTML = promptLine;
            } else {
                terminalElement.innerHTML += promptLine;
            }
            
            // Scroll to bottom
            terminalElement.scrollTop = terminalElement.scrollHeight;
        }

        function addOutput(text) {
            const terminalElement = document.getElementById('terminal');
            
            if (text === 'CLEAR') {
                terminalElement.innerHTML = '';
                return;
            }
            
            if (text.trim()) {
                const outputLine = `<div class="terminal-line output">${text}</div>`;
                terminalElement.innerHTML += outputLine;
            }
            
            terminalElement.scrollTop = terminalElement.scrollHeight;
        }

        function processCommand() {
            if (commandBuffer.trim() === '') {
                addOutput('');
                updatePrompt();
                return;
            }
            
            isProcessing = true;
            addOutput(commandBuffer);
            
            setTimeout(() => {
                const result = terminal.execute(commandBuffer);
                if (result) {
                    addOutput(result);
                }
                
                commandBuffer = '';
                isProcessing = false;
                updatePrompt();
            }, 50);
        }

        function navigateHistory(direction) {
            if (terminal.commandHistory.length === 0) return;
            
            terminal.historyIndex = Math.max(0, Math.min(terminal.commandHistory.length, terminal.historyIndex + direction));
            
            if (terminal.historyIndex >= 0 && terminal.historyIndex < terminal.commandHistory.length) {
                commandBuffer = terminal.commandHistory[terminal.historyIndex];
            } else {
                commandBuffer = '';
            }
            
            updatePrompt();
        }

        function autoComplete() {
            const commands = ['ls', 'cd', 'pwd', 'cat', 'touch', 'mkdir', 'rm', 'cp', 'mv', 
                            'chmod', 'grep', 'find', 'wc', 'head', 'tail', 'sort', 'echo',
                            'whoami', 'date', 'cal', 'uptime', 'uname', 'df', 'du', 'ps',
                            'kill', 'env', 'export', 'alias', 'history', 'sudo', 'man',
                            'apt', 'ping', 'ifconfig', 'neofetch', 'nano', 'clear', 'help'];
            
            const matches = commands.filter(cmd => cmd.startsWith(commandBuffer));
            
            if (matches.length === 1) {
                commandBuffer = matches[0] + ' ';
                updatePrompt();
            } else if (matches.length > 1) {
                addOutput(matches.join('  '));
                updatePrompt();
            }
        }

        // UI Functions
        function goBack() {
            window.history.back();
        }

        function clearTerminal() {
            const terminalElement = document.getElementById('terminal');
            terminalElement.innerHTML = '';
            updatePrompt();
        }

        function minimizeTerminal() {
            alert('Minimize simulated - this would minimize the terminal in a real application.');
        }

        function toggleFullscreen() {
            const terminalContainer = document.querySelector('.terminal-container');
            terminalContainer.classList.toggle('fullscreen');
            
            // Focus terminal after fullscreen toggle
            document.getElementById('terminal').focus();
        }
    </script>
</body>
</html>