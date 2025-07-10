# ${{ values.app_name | title }} Web Application

A Node.js Express web application for Backstage demo that provides REST API endpoints with dynamic data and user greetings.

## Features

- REST API endpoints with JSON responses
- Real-time date and time data
- Personalized greeting using environment variable
- Health check endpoint with uptime information
- System statistics endpoint
- Dockerized for easy deployment
- Jenkins CI/CD pipeline with Docker deployment

## API Endpoints

- `GET /` - Application info and available endpoints
- `GET /api/details` - Get detailed information including time, date, and user greeting
- `GET /health` - Health check endpoint with uptime
- `GET /api/stats` - Get system statistics and Node.js info

## Running Locally

```bash
# Install dependencies
npm install

# Set the USER environment variable (optional)
export USER="YourName"

# Run the application
npm start

# Or run in development mode with nodemon
npm run dev
```

The application will start on `http://localhost:3000`

## Testing the API

```bash
# Get application details
curl http://localhost:3000/api/details

# Health check
curl http://localhost:3000/health

# Application info
curl http://localhost:3000/

# System statistics
curl http://localhost:3000/api/stats
```

## Running with Docker

### Build the Docker image
```bash
docker build -t ${{ values.app_name }} .
```

### Run the container
```bash
# Run with default user and port binding
docker run -p 3000:3000 ${{ values.app_name }}

# Run with custom user
docker run -p 3000:3000 -e USER="CustomUser" ${{ values.app_name }}

# Run with custom port
docker run -p 8080:3000 -e USER="CustomUser" ${{ values.app_name }}
```

## Environment Variables

- `USER`: The name to display in the greeting (defaults to "${{ values.user_name }}")
- `PORT`: The port to run the application on (defaults to 3000)
- `NODE_ENV`: The Node.js environment (defaults to production in Docker)

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
  "uptime": 123.45
}
```

### GET /api/stats
```json
{
  "app": "${{ values.app_name | title }} Application",
  "nodeVersion": "v18.17.0",
  "platform": "linux",
  "uptime": 123.45,
  "memoryUsage": {
    "rss": 50331648,
    "heapTotal": 20971520,
    "heapUsed": 18874368,
    "external": 1089024
  },
  "timestamp": "2024-01-15T14:30:25.123Z"
}
```

## CI/CD Pipeline

This application includes a Jenkins CI/CD pipeline that:

1. **Installs** Node.js dependencies
2. **Builds** the Docker image with the latest code
3. **Pushes** the image to GitHub Container Registry
4. **Deploys** the application using Docker containers
5. **Monitors** the deployment status

The pipeline automatically triggers on code pushes to the main branch.

## Docker Image Details

- Base image: `node:18-alpine`
- Dependencies: Express.js 4.18.2
- Non-root user for security
- Health check endpoint
- Exposes port 3000

## Development

```bash
# Install dependencies
npm install

# Run in development mode with auto-reload
npm run dev

# Run tests (if any)
npm test
```

## Technology Stack

- **Runtime**: Node.js 18
- **Framework**: Express.js
- **Containerization**: Docker
- **CI/CD**: Jenkins
- **Registry**: GitHub Container Registry
- **Orchestration**: Backstage 