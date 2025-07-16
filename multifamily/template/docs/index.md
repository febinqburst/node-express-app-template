# ${{ values.app_name | title }} Documentation

Welcome to the ${{ values.app_name | title }} application documentation.

## Overview

This is a beautiful PHP web application that provides both a stunning web interface and REST API endpoints with dynamic data and user greetings. The application features a modern, responsive UI with gradient backgrounds, animations, and the official PHP logo. It's designed to be deployed using Docker containers with Apache HTTP Server and managed through Jenkins CI/CD pipelines.

### 🎨 Visual Features

- **Beautiful Web Interface** - Modern, responsive design with gradient backgrounds
- **Welcome Banner** - Animated banner saying "Welcome to PHP Demo Application"
- **PHP Logo** - Official PHP logo with professional styling
- **Interactive Elements** - Hover effects and smooth transitions
- **Mobile Responsive** - Works perfectly on all devices

## Getting Started

### Prerequisites

- PHP 8.1 or higher
- Composer (for dependency management)
- Docker (for containerization)
- Jenkins (for CI/CD)

### Installation

1. Clone the repository
2. Install dependencies: `composer install`
3. Start the application: `composer start` or `php -S 0.0.0.0:8086 index.php`

## Interface Documentation

### 🌐 Web Interface

#### GET /
Returns a beautiful, responsive web page featuring:
- **Welcome Banner** - Animated banner with "Welcome to PHP Demo Application"
- **PHP Logo** - Official PHP logo with styling effects
- **Application Information** - User greeting, current time, and app status
- **API Documentation** - Interactive endpoint documentation
- **Modern Design** - Gradient backgrounds, cards, and smooth animations
- **Mobile Responsive** - Optimized for all device sizes

### 🔗 API Endpoints

#### GET /api/details
Returns detailed information including:
- Personalized greeting
- Current timestamp
- Date and time information
- Application status

#### GET /health
Returns health check information including:
- Application status
- Uptime information
- PHP version

#### GET /api/stats
Returns system statistics including:
- PHP version
- Platform information
- Architecture details
- Memory usage (current, peak, limit)
- Process uptime

#### GET /api/json
Returns complete application information in JSON format including:
- All data from other endpoints
- Available endpoints list
- Application metadata

## Configuration

### Environment Variables

- `USER`: The name to display in greetings (default: "World")
- `APACHE_DOCUMENT_ROOT`: Document root for Apache (default: "/var/www/html")

## Deployment

### Docker

The application is containerized using Docker with PHP 8.2 and Apache HTTP Server. See the README.md for detailed Docker usage instructions.

### Jenkins CI/CD

The application includes a Jenkins pipeline that automatically:
1. Installs PHP dependencies with Composer
2. Validates PHP syntax
3. Runs tests (if available)
4. Builds the Docker image
5. Pushes to container registry
6. Deploys the application
7. Monitors deployment status

## Development

For development instructions, testing, and contribution guidelines, see the README.md file in the project root.

## Support

For questions or issues, please refer to the project repository or contact the development team. 