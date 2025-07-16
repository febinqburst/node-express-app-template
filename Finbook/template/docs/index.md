# ${{ values.app_name | title }} Web Application

A simple Flask web application for Backstage demo that provides API endpoints with dynamic data and user greetings.

## Features

- REST API endpoints with JSON responses
- Real-time date and time data
- Personalized greeting using environment variable
- Health check endpoint
- Dockerized for easy deployment
- Jenkins CI/CD pipeline with Docker deployment

## API Endpoints

- `GET /` - Application info and available endpoints
- `GET /api/details` - Get detailed information including time, date, and user greeting
- `GET /health` - Health check endpoint

## Running Locally

```bash
# Install dependencies
pip install -r requirements.txt

# Set the USER environment variable (optional)
export USER="YourName"

# Run the application
python app.py
```

The application will start on `http://localhost:8082`

## Testing the API

```bash
# Get application details
curl http://localhost:8082/api/details

# Health check
curl http://localhost:8082/health

# Application info
curl http://localhost:8082/
```

## Running with Docker

### Build the Docker image
```bash
docker build -t ${{ values.app_name }} .
```

### Run the container
```bash
# Run with default user and port binding
docker run -p 8082:8082 ${{ values.app_name }}

# Run with custom user
docker run -p 8082:8082 -e USER="CustomUser" ${{ values.app_name }}

# Run with custom port
docker run -p 3000:8082 -e USER="CustomUser" ${{ values.app_name }}
```

## Environment Variables

- `USER`: The name to display in the greeting (defaults to "${{ values.user_name }}")
- `PORT`: The port to run the application on (defaults to 8082)

## Example API Response

```json
{
  "message": "Hello ${{ values.user_name }}",
  "timestamp": "2024-01-15 14:30:25",
  "date": "2024-01-15",
  "time": "14:30:25",
  "day": "Monday",
  "app": "${{ values.app_name | title }} Application",
  "status": "running"
}
```

## CI/CD Pipeline

This application includes a Jenkins CI/CD pipeline that:

1. **Builds** the Docker image with the latest code
2. **Pushes** the image to GitHub Container Registry
3. **Deploys** the application using Docker containers
4. **Monitors** the deployment status

The pipeline automatically triggers on code pushes to the main branch.

## Docker Image Details

- Base image: `python:3.11-slim`
- Dependencies: Flask 3.0.0
- Non-root user for security
- Exposes port 8082 
