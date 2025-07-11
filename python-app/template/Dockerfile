# Use Python 3.11 slim image as base
FROM python:3.11-slim

# Set working directory inside container
WORKDIR /app

# Copy requirements first for better Docker layer caching
COPY requirements.txt .

# Install system dependencies, Python packages, then cleanup in one layer
RUN apt-get update && apt-get install -y \
    gcc \
    python3-dev \
    --no-install-recommends && \
    pip install --no-cache-dir --upgrade pip && \
    pip install --no-cache-dir -r requirements.txt && \
    apt-get remove -y gcc python3-dev && \
    apt-get autoremove -y && \
    rm -rf /var/lib/apt/lists/*

# Copy the Python application and static files
COPY app.py .
COPY static/ static/

# Set environment variables
ENV PYTHONUNBUFFERED=1
ENV USER=BackstageUser
ENV PORT=8082

# Expose the application port
EXPOSE 8082

# Create a non-root user for security
RUN groupadd -r appuser && useradd -r -g appuser appuser
RUN chown -R appuser:appuser /app
USER appuser

# Run the application
CMD ["python", "app.py"] 
