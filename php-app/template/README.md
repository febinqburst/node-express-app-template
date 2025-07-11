# ${{ values.app_name | title }} Web Application

A beautiful PHP web application for Backstage demo that provides both a stunning web interface and REST API endpoints with dynamic data and user greetings.

## Features

- 🎨 **Beautiful Web Interface** - Modern, responsive UI with gradient backgrounds and animations
- 🚀 **Welcome Banner** - Eye-catching banner with "Welcome to PHP Demo Application"
- 🐘 **PHP Logo** - Official PHP logo with professional styling
- 📱 **Responsive Design** - Mobile-friendly interface that works on all devices
- 🔗 **REST API Endpoints** - Full JSON API support for programmatic access
- ⏰ **Real-time Data** - Live date, time, and system information
- 👋 **Personalized Greeting** - Dynamic user greeting using environment variables
- 💚 **Health Check** - Beautiful status indicators and uptime information
- 📊 **System Statistics** - PHP version, memory usage, and platform info
- 🐳 **Dockerized** - Easy deployment with Docker containerization (Apache + PHP 8.2)
- 🔧 **Jenkins CI/CD** - Automated pipeline with Docker deployment

## Web Interface & API Endpoints

### 🌐 Web Interface
- `GET /` - **Beautiful web dashboard** with PHP logo, welcome banner, and interactive UI

### 🔗 API Endpoints
- `GET /api/details` - Get detailed information including time, date, and user greeting
- `GET /health` - Health check endpoint with uptime information
- `GET /api/stats` - Get system statistics including PHP version and memory usage
- `GET /api/json` - Get all information in JSON format (original API response)

## Running Locally

```bash
# Using PHP built-in server
composer start

# Or manually
php -S 0.0.0.0:8086 index.php

# Set the USER environment variable (optional)
export USER="YourName"
```

The application will start on `http://localhost:8086`

🎉 **Visit the beautiful web interface at:** `http://localhost:8086`

## Using the Application

### 🌐 Web Interface
Simply open your browser and visit:
```
http://localhost:8086
```

Enjoy the beautiful, responsive web interface with:
- 🎨 Gradient background and modern design
- 🚀 Animated welcome banner  
- 🐘 Official PHP logo
- 📊 Real-time application information
- 🔗 Interactive API endpoint documentation

### 🔗 API Testing
```bash
# Beautiful web interface
curl http://localhost:8086/

# Get application details (JSON)
curl http://localhost:8086/api/details

# Health check
curl http://localhost:8086/health

# System statistics
curl http://localhost:8086/api/stats

# Complete JSON response
curl http://localhost:8086/api/json
```

## Running with Docker

### Build the Docker image
```bash
docker build -t ${{ values.app_name }} .
```

### Run the container
```bash
# Run with default user and port binding
docker run -p 8086:80 ${{ values.app_name }}

# Run with custom user
docker run -p 8086:80 -e USER="CustomUser" ${{ values.app_name }}

# Run with custom port
docker run -p 8080:80 -e USER="CustomUser" ${{ values.app_name }}
```

## Environment Variables

- `USER`: The name to display in the greeting (defaults to "${{ values.user_name }}")
- `APACHE_DOCUMENT_ROOT`: Document root for Apache (defaults to /var/www/html)

## Example API Responses

### GET /api/details
```json
{
  "message": "Hello ${{ values.user_name }}",
  "timestamp": "2024-01-15 14:30:25",
  "date": "2024-01-15",
  "time": "14:30:25",
  "day": "Monday",
  "app": "${{ values.app_name | title }} Application",
  "status": "running",
  "version": "1.0.0"
}
```

### GET /health
```json
{
  "status": "healthy",
  "app": "${{ values.app_name | title }} Application",
  "uptime": 123.45,
  "php_version": "8.2.x"
}
```

### GET /api/stats
```json
{
  "app": "${{ values.app_name | title }} Application",
  "php_version": "8.2.x",
  "platform": "Linux",
  "architecture": "x86_64",
  "memory_usage": {
    "current": 2097152,
    "peak": 4194304,
    "limit": "128M"
  },
  "timestamp": "2024-01-15T14:30:25+00:00"
}
```

## CI/CD Pipeline

This application includes a Jenkins CI/CD pipeline that:

1. **Installs** PHP dependencies with Composer
2. **Validates** PHP syntax across all files
3. **Runs** tests (if available)
4. **Builds** the Docker image with the latest code
5. **Pushes** the image to GitHub Container Registry
6. **Deploys** the application using Docker containers
7. **Monitors** the deployment status

The pipeline automatically triggers on code pushes to the main branch.

## Docker Image Details

- Base image: `php:8.2-apache`
- Web server: Apache HTTP Server
- Dependencies: Composer for package management
- Non-root user for security
- Health check endpoint
- Exposes port 80 (mapped to host port 8086)

## Development

```bash
# Install dependencies
composer install

# Run in development mode
composer start

# Run tests (if any)
composer test

# PHP syntax check
find . -name "*.php" -exec php -l {} \;
```

## Technology Stack

- **Language**: PHP 8.2
- **Web Server**: Apache HTTP Server
- **Package Manager**: Composer
- **Containerization**: Docker
- **CI/CD**: Jenkins
- **Registry**: GitHub Container Registry
- **Orchestration**: Backstage 