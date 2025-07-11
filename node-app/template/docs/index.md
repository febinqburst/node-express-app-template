# ${{ values.app_name | title }} Documentation

Welcome to the ${{ values.app_name | title }} application documentation.

## Overview

This is a beautiful Node.js Express web application that provides both a stunning web interface and REST API endpoints with dynamic data and user greetings. The application features a modern, responsive UI with gradient backgrounds, animations, and the official Node.js logo. It's designed to be deployed using Docker containers and managed through Jenkins CI/CD pipelines.

### 🎨 Visual Features

- **Beautiful Web Interface** - Modern, responsive design with gradient backgrounds
- **Welcome Banner** - Animated banner saying "Welcome to Node Express Demo Application"
- **Node.js Logo** - Official Node.js logo with professional styling
- **Interactive Elements** - Hover effects and smooth transitions
- **Mobile Responsive** - Works perfectly on all devices

## Getting Started

### Prerequisites

- Node.js 18 or higher
- npm (Node Package Manager)
- Docker (for containerization)
- Jenkins (for CI/CD)

### Installation

1. Clone the repository
2. Install dependencies: `npm install`
3. Start the application: `npm start`

## Interface Documentation

### 🌐 Web Interface

#### GET /
Returns a beautiful, responsive web page featuring:
- **Welcome Banner** - Animated banner with "Welcome to Node Express Demo Application"
- **Node.js Logo** - Official Node.js logo with styling effects
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

#### GET /api/stats
Returns system statistics including:
- Node.js version
- Platform information
- Memory usage
- Process uptime

#### GET /api/json
Returns complete application information in JSON format including:
- All data from other endpoints
- Available endpoints list
- Application metadata

## Configuration

### Environment Variables

- `USER`: The name to display in greetings (default: "World")
- `PORT`: The port to run the application on (default: 8085)
- `NODE_ENV`: The Node.js environment (default: "development")

## Deployment

### Docker

The application is containerized using Docker. See the README.md for detailed Docker usage instructions.

### Jenkins CI/CD

The application includes a Jenkins pipeline that automatically:
1. Installs dependencies
2. Builds the Docker image
3. Pushes to container registry
4. Deploys the application
5. Monitors deployment status

## Development

For development instructions, testing, and contribution guidelines, see the README.md file in the project root.

## Support

For questions or issues, please refer to the project repository or contact the development team. 