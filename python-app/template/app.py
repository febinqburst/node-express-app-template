#!/usr/bin/env python3

import os
from datetime import datetime
from flask import Flask, jsonify, render_template, request, url_for

app = Flask(__name__)

# Sample data for different pages
GALLERY_IMAGES = [
    {'name': 'Nature Scene', 'filename': 'nature1.jpg', 'description': 'Beautiful landscape with mountains'},
    {'name': 'Ocean View', 'filename': 'ocean1.jpg', 'description': 'Peaceful ocean waves'},
    {'name': 'City Life', 'filename': 'city1.jpg', 'description': 'Modern city skyline'},
    {'name': 'Forest Path', 'filename': 'forest1.jpg', 'description': 'Serene forest walkway'},
    {'name': 'Desert Sunset', 'filename': 'desert1.jpg', 'description': 'Golden desert landscape'},
    {'name': 'Mountain Peak', 'filename': 'mountain1.jpg', 'description': 'Snow-capped mountain summit'}
]

THEMES = {
    'default': {'name': 'Default', 'description': 'Clean and modern design'},
    'dark': {'name': 'Dark Mode', 'description': 'Elegant dark theme'},
    'nature': {'name': 'Nature', 'description': 'Green and earthy tones'},
    'ocean': {'name': 'Ocean', 'description': 'Blue and aquatic vibes'},
    'sunset': {'name': 'Sunset', 'description': 'Warm orange and pink colors'},
    'minimal': {'name': 'Minimal', 'description': 'Clean and simple'}
}

@app.route('/')
def home():
    user = os.getenv('USER', 'World')
    theme = request.args.get('theme', 'default')
    return render_template('home.html', user=user, theme=theme, themes=THEMES)

@app.route('/gallery')
def gallery():
    theme = request.args.get('theme', 'default')
    return render_template('gallery.html', images=GALLERY_IMAGES, theme=theme, themes=THEMES)

@app.route('/about')
def about():
    theme = request.args.get('theme', 'default')
    user = os.getenv('USER', 'World')
    return render_template('about.html', user=user, theme=theme, themes=THEMES)

@app.route('/portfolio')
def portfolio():
    theme = request.args.get('theme', 'default')
    projects = [
        {
            'name': 'Project Alpha',
            'description': 'A modern web application built with Flask',
            'image': 'project1.jpg',
            'tech': ['Python', 'Flask', 'HTML5', 'CSS3']
        },
        {
            'name': 'Project Beta',
            'description': 'Mobile-first responsive design showcase',
            'image': 'project2.jpg',
            'tech': ['JavaScript', 'React', 'Node.js', 'MongoDB']
        },
        {
            'name': 'Project Gamma',
            'description': 'AI-powered data visualization tool',
            'image': 'project3.jpg',
            'tech': ['Python', 'TensorFlow', 'D3.js', 'PostgreSQL']
        }
    ]
    return render_template('portfolio.html', projects=projects, theme=theme, themes=THEMES)

@app.route('/contact')
def contact():
    theme = request.args.get('theme', 'default')
    return render_template('contact.html', theme=theme, themes=THEMES)

@app.route('/themes')
def themes():
    current_theme = request.args.get('theme', 'default')
    return render_template('themes.html', themes=THEMES, current_theme=current_theme)

# API endpoints (keeping for backward compatibility)
@app.route('/api/details', methods=['GET'])
def get_details():
    user = os.getenv('USER', 'World')
    now = datetime.now()
    current_time = now.strftime("%Y-%m-%d %H:%M:%S")
    current_day = now.strftime("%A")
    current_date = now.strftime("%Y-%m-%d")
    current_time_only = now.strftime("%H:%M:%S")
    
    return jsonify({
        "message": f"Hello {user}",
        "timestamp": current_time,
        "date": current_date,
        "time": current_time_only,
        "day": current_day,
        "app": "${{ values.app_name | title }} Application",
        "status": "running"
    })

@app.route('/health', methods=['GET'])
def health_check():
    return jsonify({
        "status": "healthy",
        "app": "${{ values.app_name | title }} Application"
    })

if __name__ == "__main__":
    port = int(os.getenv('PORT', 8082))
    app.run(host='0.0.0.0', port=port, debug=False) 
