#!/usr/bin/env python3

import os
import platform
import psutil
import time
from datetime import datetime
from flask import Flask, jsonify, render_template_string, request

app = Flask(__name__)

# Store start time for uptime calculation
start_time = time.time()

# Color themes configuration
THEMES = {
    'aurora': {
        'name': 'Aurora',
        'primary': '#667eea',
        'secondary': '#764ba2', 
        'accent': '#f093fb',
        'background': 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
        'card_bg': 'rgba(102, 126, 234, 0.1)',
        'description': 'Northern lights inspired theme'
    },
    'sunset': {
        'name': 'Sunset',
        'primary': '#ff7e5f',
        'secondary': '#feb47b',
        'accent': '#ff6b6b',
        'background': 'linear-gradient(135deg, #ff7e5f 0%, #feb47b 100%)',
        'card_bg': 'rgba(255, 126, 95, 0.1)',
        'description': 'Warm sunset colors'
    },
    'ocean': {
        'name': 'Ocean',
        'primary': '#1e3c72',
        'secondary': '#2a5298',
        'accent': '#00d4ff',
        'background': 'linear-gradient(135deg, #1e3c72 0%, #2a5298 100%)',
        'card_bg': 'rgba(30, 60, 114, 0.1)',
        'description': 'Deep ocean blues'
    },
    'forest': {
        'name': 'Forest',
        'primary': '#134e5e',
        'secondary': '#71b280',
        'accent': '#4ecdc4',
        'background': 'linear-gradient(135deg, #134e5e 0%, #71b280 100%)',
        'card_bg': 'rgba(19, 78, 94, 0.1)',
        'description': 'Nature forest greens'
    },
    'cosmic': {
        'name': 'Cosmic',
        'primary': '#8360c3',
        'secondary': '#2ebf91',
        'accent': '#ffd93d',
        'background': 'linear-gradient(135deg, #8360c3 0%, #2ebf91 100%)',
        'card_bg': 'rgba(131, 96, 195, 0.1)',
        'description': 'Space cosmic colors'
    },
    'cherry': {
        'name': 'Cherry',
        'primary': '#eb3349',
        'secondary': '#f45c43',
        'accent': '#fa709a',
        'background': 'linear-gradient(135deg, #eb3349 0%, #f45c43 100%)',
        'card_bg': 'rgba(235, 51, 73, 0.1)',
        'description': 'Cherry blossom pink'
    }
}

def get_user():
    """Get user from environment variable"""
    return os.getenv('USER', os.getenv('USERNAME', 'World'))

def get_time_info():
    """Get current date and time information"""
    now = datetime.now()
    return {
        'timestamp': now.strftime('%Y-%m-%d %H:%M:%S'),
        'date': now.strftime('%Y-%m-%d'),
        'time': now.strftime('%H:%M:%S'),
        'day': now.strftime('%A')
    }

def get_system_info():
    """Get system information"""
    try:
        memory = psutil.virtual_memory()
        return {
            'python_version': platform.python_version(),
            'platform': platform.system(),
            'architecture': platform.machine(),
            'memory_usage': {
                'total': memory.total,
                'available': memory.available,
                'percent': memory.percent
            }
        }
    except:
        return {
            'python_version': platform.python_version(),
            'platform': platform.system(),
            'architecture': platform.machine(),
            'memory_usage': {
                'total': 'N/A',
                'available': 'N/A',
                'percent': 'N/A'
            }
        }

# Enhanced colorful dashboard template
COLORFUL_TEMPLATE = """
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ app_name }} - Modern Python Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: {{ theme.primary }};
            --secondary-color: {{ theme.secondary }};
            --accent-color: {{ theme.accent }};
            --background: {{ theme.background }};
            --card-bg: {{ theme.card_bg }};
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: var(--background);
            background-attachment: fixed;
            color: #ffffff;
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header */
        .header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 20px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 28px;
            font-weight: 800;
            color: #ffffff;
        }
        
        .logo-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }
        
        .theme-selector {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .theme-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 255, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .theme-btn:hover {
            transform: scale(1.1);
            border-color: rgba(255, 255, 255, 0.8);
        }
        
        .theme-btn.active {
            border-color: #ffffff;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
        }
        
        /* Hero Section */
        .hero {
            padding: 80px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100%" height="100%" fill="url(%23dots)"/></svg>');
            animation: move 20s linear infinite;
        }
        
        @keyframes move {
            0% { transform: translateX(0) translateY(0); }
            100% { transform: translateX(-20px) translateY(-20px); }
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 20px;
            background: linear-gradient(45deg, #ffffff, rgba(255,255,255,0.8));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: glow 2s ease-in-out infinite alternate;
        }
        
        @keyframes glow {
            from { text-shadow: 0 0 10px rgba(255,255,255,0.5); }
            to { text-shadow: 0 0 20px rgba(255,255,255,0.8); }
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.2);
            padding: 15px 30px;
            border-radius: 50px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 40px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(255, 255, 255, 0); }
            100% { box-shadow: 0 0 0 0 rgba(255, 255, 255, 0); }
        }
        
        .status-dot {
            width: 12px;
            height: 12px;
            background: #00ff88;
            border-radius: 50%;
            animation: blink 1.5s infinite;
        }
        
        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0.3; }
        }
        
        /* Dashboard Grid */
        .dashboard {
            padding: 60px 0;
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }
        
        .dashboard-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            padding: 35px;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        
        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--card-bg);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .dashboard-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            border-color: rgba(255, 255, 255, 0.4);
        }
        
        .dashboard-card:hover::before {
            opacity: 1;
        }
        
        .card-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            position: relative;
            z-index: 1;
        }
        
        .card-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-right: 20px;
            animation: rotate 4s linear infinite;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .card-title {
            font-size: 22px;
            font-weight: 700;
            color: #ffffff;
        }
        
        .card-content {
            position: relative;
            z-index: 1;
        }
        
        .metric {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .metric:hover {
            padding-left: 10px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }
        
        .metric:last-child {
            border-bottom: none;
        }
        
        .metric-label {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }
        
        .metric-value {
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.1);
            padding: 5px 15px;
            border-radius: 15px;
        }
        
        /* API Section */
        .api-showcase {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            padding: 50px;
            margin-bottom: 60px;
            position: relative;
            overflow: hidden;
        }
        
        .api-showcase::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 0deg, var(--accent-color), var(--primary-color), var(--secondary-color), var(--accent-color));
            animation: spin 10s linear infinite;
            opacity: 0.1;
        }
        
        @keyframes spin {
            100% { transform: rotate(360deg); }
        }
        
        .api-title {
            font-size: 2.5rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
            background: linear-gradient(45deg, #ffffff, var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .api-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            position: relative;
            z-index: 1;
        }
        
        .api-card {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 25px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .api-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        
        .api-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }
        
        .api-card:hover::before {
            transform: scaleX(1);
        }
        
        .api-method {
            display: inline-block;
            background: var(--accent-color);
            color: #ffffff;
            padding: 8px 16px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .api-path {
            font-family: 'Courier New', monospace;
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 10px;
            background: rgba(0, 0, 0, 0.2);
            padding: 10px 15px;
            border-radius: 10px;
        }
        
        .api-description {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
        }
        
        /* Gallery Section */
        .gallery-section {
            padding: 60px 0;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 50px;
            background: linear-gradient(45deg, #ffffff, var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .gallery-item {
            aspect-ratio: 16/9;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .gallery-item:hover {
            transform: scale(1.05);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        
        .gallery-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="waves" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M0 50 Q25 25 50 50 T100 50 V100 H0 Z" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100%" height="100%" fill="url(%23waves)"/></svg>');
            animation: wave 3s ease-in-out infinite;
        }
        
        @keyframes wave {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .gallery-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 25px;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
            color: #ffffff;
        }
        
        .gallery-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .gallery-desc {
            opacity: 0.8;
        }
        
        /* Footer */
        .footer {
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(20px);
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding: 40px 0;
            text-align: center;
            margin-top: 80px;
        }
        
        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
        }
        
        .social-link {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 20px;
        }
        
        .social-link:hover {
            background: var(--accent-color);
            transform: translateY(-5px) scale(1.1);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            
            .footer-content {
                flex-direction: column;
                text-align: center;
            }
            
            .theme-selector {
                flex-wrap: wrap;
            }
        }
        
        /* Animations */
        .fade-in {
            animation: fadeIn 1s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .slide-in {
            animation: slideIn 0.8s ease-out;
        }
        
        @keyframes slideIn {
            from { transform: translateX(-100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <div class="logo-icon">🐍</div>
                    <span>Python Pro</span>
                </div>
                <div class="theme-selector">
                    {% for theme_key, theme_data in themes.items() %}
                    <div class="theme-btn {{ 'active' if theme_key == current_theme else '' }}" 
                         style="background: {{ theme_data.background }}"
                         onclick="changeTheme('{{ theme_key }}')"
                         title="{{ theme_data.name }} - {{ theme_data.description }}">
                    </div>
                    {% endfor %}
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content fade-in">
                <h1 class="hero-title">{{ app_name }}</h1>
                <p class="hero-subtitle">Modern Python Application Dashboard</p>
                <div class="status-badge">
                    <div class="status-dot"></div>
                    <span>System Online • Python {{ python_version }}</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard -->
    <section class="dashboard">
        <div class="container">
            <div class="dashboard-grid">
                <div class="dashboard-card slide-in">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <h3 class="card-title">User Information</h3>
                    </div>
                    <div class="card-content">
                        <div class="metric">
                            <span class="metric-label">Current User</span>
                            <span class="metric-value">{{ user }}</span>
                        </div>
                        <div class="metric">
                            <span class="metric-label">Session Started</span>
                            <span class="metric-value">{{ time_info.time }}</span>
                        </div>
                        <div class="metric">
                            <span class="metric-label">Today</span>
                            <span class="metric-value">{{ time_info.day }}</span>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card slide-in">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-server"></i>
                        </div>
                        <h3 class="card-title">System Status</h3>
                    </div>
                    <div class="card-content">
                        <div class="metric">
                            <span class="metric-label">Python Version</span>
                            <span class="metric-value">{{ python_version }}</span>
                        </div>
                        <div class="metric">
                            <span class="metric-label">Platform</span>
                            <span class="metric-value">{{ platform }}</span>
                        </div>
                        <div class="metric">
                            <span class="metric-label">Status</span>
                            <span class="metric-value">🟢 Online</span>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card slide-in">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="card-title">Performance</h3>
                    </div>
                    <div class="card-content">
                        <div class="metric">
                            <span class="metric-label">Memory Usage</span>
                            <span class="metric-value">{{ memory_percent }}%</span>
                        </div>
                        <div class="metric">
                            <span class="metric-label">Uptime</span>
                            <span class="metric-value">{{ uptime }}s</span>
                        </div>
                        <div class="metric">
                            <span class="metric-label">Theme</span>
                            <span class="metric-value">{{ theme.name }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- API Showcase -->
            <div class="api-showcase fade-in">
                <h2 class="api-title">API Endpoints</h2>
                <div class="api-grid">
                    <div class="api-card">
                        <div class="api-method">GET</div>
                        <div class="api-path">/api/details</div>
                        <p class="api-description">Retrieve detailed application information including user data and timestamps.</p>
                    </div>
                    <div class="api-card">
                        <div class="api-method">GET</div>
                        <div class="api-path">/health</div>
                        <p class="api-description">Health check endpoint with uptime monitoring and system diagnostics.</p>
                    </div>
                    <div class="api-card">
                        <div class="api-method">GET</div>
                        <div class="api-path">/api/stats</div>
                        <p class="api-description">System statistics including memory usage and performance metrics.</p>
                    </div>
                    <div class="api-card">
                        <div class="api-method">GET</div>
                        <div class="api-path">/api/json</div>
                        <p class="api-description">Complete application data in JSON format for programmatic access.</p>
                    </div>
                </div>
            </div>

            <!-- Gallery Section -->
            <div class="gallery-section">
                <h2 class="section-title">Visual Gallery</h2>
                <div class="gallery-grid">
                    <div class="gallery-item">
                        <div class="gallery-content">
                            <h3 class="gallery-title">Dashboard Analytics</h3>
                            <p class="gallery-desc">Real-time system monitoring</p>
                        </div>
                    </div>
                    <div class="gallery-item">
                        <div class="gallery-content">
                            <h3 class="gallery-title">API Documentation</h3>
                            <p class="gallery-desc">Comprehensive endpoint guide</p>
                        </div>
                    </div>
                    <div class="gallery-item">
                        <div class="gallery-content">
                            <h3 class="gallery-title">Performance Metrics</h3>
                            <p class="gallery-desc">System performance tracking</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div>
                    <p>&copy; 2024 {{ app_name }} • Built with Python {{ python_version }}</p>
                    <p>Powered by Flask • Modern Dashboard Design</p>
                </div>
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-github"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-python"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function changeTheme(theme) {
            window.location.href = '/?theme=' + theme;
        }

        // Add scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all cards for animations
        document.querySelectorAll('.dashboard-card, .api-card, .gallery-item').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });

        // Add floating animation to cards
        document.querySelectorAll('.dashboard-card').forEach((card, index) => {
            card.style.animationDelay = `${index * 0.2}s`;
            card.classList.add('fade-in');
        });
    </script>
</body>
</html>
"""

@app.route('/')
def dashboard():
    """Beautiful colorful web interface dashboard"""
    user = get_user()
    time_info = get_time_info()
    system_info = get_system_info()
    
    # Get theme from query parameter
    current_theme = request.args.get('theme', 'aurora')
    if current_theme not in THEMES:
        current_theme = 'aurora'
    
    theme = THEMES[current_theme]
    uptime = round(time.time() - start_time, 1)
    
    return render_template_string(COLORFUL_TEMPLATE,
                                app_name="${{ values.app_name | title }}",
                                user=user,
                                time_info=time_info,
                                python_version=system_info['python_version'],
                                platform=system_info['platform'],
                                memory_percent=system_info['memory_usage'].get('percent', 'N/A'),
                                uptime=uptime,
                                theme=theme,
                                themes=THEMES,
                                current_theme=current_theme)

@app.route('/api/details', methods=['GET'])
def get_details():
    """Retrieve detailed application information"""
    user = get_user()
    time_info = get_time_info()
    
    return jsonify({
        'message': f"Hello {user}",
        'timestamp': time_info['timestamp'],
        'date': time_info['date'],
        'time': time_info['time'],
        'day': time_info['day'],
        'app': "${{ values.app_name | title }} Application",
        'status': 'running',
        'version': '1.0.0'
    })

@app.route('/health', methods=['GET'])
def health_check():
    """Health check endpoint with uptime monitoring"""
    uptime = time.time() - start_time
    system_info = get_system_info()
    
    return jsonify({
        'status': 'healthy',
        'app': "${{ values.app_name | title }} Application",
        'uptime': round(uptime, 2),
        'python_version': system_info['python_version']
    })

@app.route('/api/stats', methods=['GET'])
def get_stats():
    """System statistics including Python version and performance metrics"""
    system_info = get_system_info()
    
    return jsonify({
        'app': "${{ values.app_name | title }} Application",
        'python_version': system_info['python_version'],
        'platform': system_info['platform'],
        'architecture': system_info['architecture'],
        'memory_usage': system_info['memory_usage'],
        'timestamp': datetime.now().isoformat()
    })

@app.route('/api/json', methods=['GET'])
def get_json():
    """Complete application data in JSON format"""
    user = get_user()
    time_info = get_time_info()
    
    return jsonify({
        'message': "${{ values.app_name | title }} Application",
        'greeting': f"Hello {user}",
        'timestamp': time_info['timestamp'],
        'date': time_info['date'],
        'time': time_info['time'],
        'day': time_info['day'],
        'status': 'running',
        'version': '1.0.0',
        'themes': list(THEMES.keys()),
        'endpoints': [
            '/ - Beautiful colorful web interface',
            '/api/details - Get application details',
            '/health - Health check',
            '/api/stats - Get system statistics',
            '/api/json - JSON response (this endpoint)'
        ]
    })

@app.errorhandler(404)
def not_found(error):
    """404 error handler"""
    return jsonify({
        'error': 'Not Found',
        'message': 'The requested endpoint does not exist',
        'available_endpoints': [
            '/ - Beautiful colorful web interface',
            '/api/details - Get application details',
            '/health - Health check',
            '/api/stats - Get system statistics',
            '/api/json - JSON response'
        ]
    }), 404

if __name__ == "__main__":
    port = int(os.getenv('PORT', 8082))
    app.run(host='0.0.0.0', port=port, debug=False) 
