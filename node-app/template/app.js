const express = require('express');
const app = express();

// Middleware
app.use(express.json());

// Get details endpoint
app.get('/api/details', (req, res) => {
    // Get user from environment variable, default to "World" if not set
    const user = process.env.USER || 'World';
    
    // Get current date and time
    const now = new Date();
    const timestamp = now.toISOString().replace('T', ' ').substring(0, 19);
    const date = now.toISOString().split('T')[0];
    const time = now.toTimeString().split(' ')[0];
    const day = now.toLocaleDateString('en-US', { weekday: 'long' });
    
    // Return details in JSON format
    res.json({
        message: `Hello ${user}`,
        timestamp: timestamp,
        date: date,
        time: time,
        day: day,
        app: "${{ values.app_name | title }} Application",
        status: "running",
        version: "1.0.0"
    });
});

// Health check endpoint
app.get('/health', (req, res) => {
    res.json({
        status: "healthy",
        app: "${{ values.app_name | title }} Application",
        uptime: process.uptime()
    });
});

// Home endpoint
app.get('/', (req, res) => {
    res.json({
        message: "${{ values.app_name | title }} Application",
        endpoints: [
            "/api/details - Get application details",
            "/health - Health check",
            "/api/stats - Get system statistics"
        ]
    });
});

// System statistics endpoint
app.get('/api/stats', (req, res) => {
    res.json({
        app: "${{ values.app_name | title }} Application",
        nodeVersion: process.version,
        platform: process.platform,
        uptime: process.uptime(),
        memoryUsage: process.memoryUsage(),
        timestamp: new Date().toISOString()
    });
});

// Start server
const port = process.env.PORT || 8085;
app.listen(port, '0.0.0.0', () => {
    console.log(`${{ values.app_name | title }} Application listening on port ${port}`);
    console.log(`Environment: ${process.env.NODE_ENV || 'development'}`);
    console.log(`User: ${process.env.USER || 'World'}`);
}); 