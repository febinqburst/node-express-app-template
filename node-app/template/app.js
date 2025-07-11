const express = require('express');
const path = require('path');
const app = express();

// Middleware
app.use(express.json());
app.use(express.static('public'));

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

// Home endpoint - HTML page
app.get('/', (req, res) => {
    const user = process.env.USER || 'World';
    const now = new Date();
    const timestamp = now.toISOString().replace('T', ' ').substring(0, 19);
    
    const html = `
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>${"${{ values.app_name | title }}"} - Node.js Express Demo</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                color: #333;
            }
            
            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
            }
            
            .banner {
                background: linear-gradient(45deg, #2c5530, #68b36b);
                color: white;
                text-align: center;
                padding: 30px 20px;
                border-radius: 15px;
                margin-bottom: 30px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
                position: relative;
                overflow: hidden;
            }
            
            .banner::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                animation: shine 3s infinite;
            }
            
            @keyframes shine {
                0% { left: -100%; }
                100% { left: 100%; }
            }
            
            .banner h1 {
                font-size: 2.5rem;
                margin-bottom: 10px;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
                position: relative;
                z-index: 1;
            }
            
            .banner p {
                font-size: 1.2rem;
                opacity: 0.9;
                position: relative;
                z-index: 1;
            }
            
            .main-content {
                background: white;
                border-radius: 15px;
                padding: 40px;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
                margin-bottom: 30px;
            }
            
            .node-logo {
                text-align: center;
                margin-bottom: 30px;
            }
            
            .node-logo svg {
                width: 120px;
                height: 120px;
                margin-bottom: 20px;
                filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.2));
            }
            
            .app-info {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 30px;
                margin-bottom: 40px;
            }
            
            .info-card {
                background: linear-gradient(145deg, #f0f0f0, #e6e6e6);
                padding: 25px;
                border-radius: 12px;
                text-align: center;
                box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease;
            }
            
            .info-card:hover {
                transform: translateY(-5px);
            }
            
            .info-card h3 {
                color: #2c5530;
                margin-bottom: 15px;
                font-size: 1.3rem;
            }
            
            .info-card p {
                color: #666;
                line-height: 1.6;
            }
            
            .api-endpoints {
                background: #f8f9fa;
                padding: 30px;
                border-radius: 12px;
                margin-bottom: 30px;
            }
            
            .api-endpoints h2 {
                color: #2c5530;
                margin-bottom: 20px;
                text-align: center;
                font-size: 1.8rem;
            }
            
            .endpoint-list {
                display: grid;
                gap: 15px;
            }
            
            .endpoint {
                background: white;
                padding: 20px;
                border-radius: 8px;
                border-left: 4px solid #68b36b;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
                transition: all 0.3s ease;
            }
            
            .endpoint:hover {
                transform: translateX(10px);
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            }
            
            .endpoint-url {
                font-family: 'Courier New', monospace;
                background: #e9ecef;
                padding: 8px 12px;
                border-radius: 4px;
                display: inline-block;
                margin-bottom: 8px;
                color: #2c5530;
                font-weight: bold;
            }
            
            .endpoint-desc {
                color: #666;
                font-size: 0.95rem;
            }
            
            .footer {
                text-align: center;
                color: white;
                opacity: 0.8;
                margin-top: 40px;
            }
            
            .status-badge {
                background: linear-gradient(45deg, #28a745, #20c997);
                color: white;
                padding: 8px 16px;
                border-radius: 20px;
                font-size: 0.9rem;
                font-weight: bold;
                display: inline-block;
                margin-top: 10px;
                box-shadow: 0 3px 10px rgba(40, 167, 69, 0.3);
            }
            
            @media (max-width: 768px) {
                .banner h1 {
                    font-size: 1.8rem;
                }
                
                .main-content {
                    padding: 20px;
                }
                
                .container {
                    padding: 10px;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="banner">
                <h1>🚀 Welcome to Node Express Demo Application</h1>
                <p>Powered by Node.js & Express.js | Built with ❤️</p>
            </div>
            
            <div class="main-content">
                <div class="node-logo">
                    <svg viewBox="0 0 256 289" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#539E43" d="M128 288.464c-3.975 0-7.685-1.06-11.061-2.121l-35.098-20.632c-5.3-2.652-2.652-3.975-.531-4.243 3.975-.531 4.506-.531 8.48-1.326 .531-.266 1.06-.266 1.592.266l26.887 15.857c.796.531 2.121.531 2.918 0l105.475-60.773c.796-.53 1.326-1.591 1.326-2.652V84.485c0-1.06-.53-2.121-1.326-2.652L126.91 21.06c-.796-.53-2.122-.53-2.918 0L18.517 81.833c-.796.53-1.326 1.591-1.326 2.652V214.62c0 1.061.53 2.122 1.326 2.653l28.746 16.916c15.592 7.95 25.224.266 25.224-6.625V93.762c0-1.592 1.326-2.918 2.918-2.918h12.455c1.591 0 2.917 1.326 2.917 2.918v133.204c0 23.224-12.189 36.744-33.356 36.744-6.36 0-11.326 0-25.49-7.155L4.24 239.308C1.326 237.717 0 234.535 0 231.353V84.485C0 81.303 1.326 78.121 4.24 76.53L109.715 15.756C112.628 14.165 116.339 14.165 119.252 15.756L224.727 76.53C227.641 78.121 228.967 81.303 228.967 84.485V231.353c0 3.182-1.326 6.364-4.24 7.955L119.252 300.082c-2.913 1.591-6.624 1.591-11.061-.53z"/>
                        <path fill="#539E43" d="M161.503 213.293c-46.08 0-55.712-21.368-55.712-39.221 0-1.591 1.326-2.917 2.917-2.917h12.72c1.591 0 2.917 1.06 2.917 2.652 2.121 14.165 8.216 21.103 37.158 21.103 22.634 0 32.266-5.035 32.266-17.49 0-7.155-2.652-12.19-38.249-15.857-29.807-3.182-48.201-9.812-48.201-34.187 0-22.634 19.513-36.214 52.604-36.214 37.158 0 55.712 12.985 57.833 40.547 0 .796-.265 1.591-.796 2.122-.53.53-1.326.796-2.121.796h-12.72c-1.326 0-2.652-1.061-2.917-2.387-3.182-14.43-11.326-19.248-39.221-19.248-28.746 0-32.266 10.078-32.266 17.755 0 8.216 3.975 10.602 37.158 15.107 32.796 4.506 49.292 10.872 49.292 34.452-.265 24.375-20.103 38.514-55.712 38.514z"/>
                    </svg>
                    <h2 style="color: #539E43; margin-top: 10px;">Node.js Express Application</h2>
                    <div class="status-badge">🟢 Application Running</div>
                </div>
                
                <div class="app-info">
                    <div class="info-card">
                        <h3>👋 Hello ${user}!</h3>
                        <p>Welcome to your Node.js Express application. This app is running successfully and ready to serve your requests.</p>
                    </div>
                    
                    <div class="info-card">
                        <h3>⏰ Current Time</h3>
                        <p>${timestamp}</p>
                        <p>Server timezone and current timestamp</p>
                    </div>
                    
                    <div class="info-card">
                        <h3>🚀 App Status</h3>
                        <p>Application: <strong>${"${{ values.app_name | title }}"}</strong></p>
                        <p>Status: <span style="color: #28a745;">✅ Healthy</span></p>
                    </div>
                </div>
                
                <div class="api-endpoints">
                    <h2>🔗 API Endpoints</h2>
                    <div class="endpoint-list">
                        <div class="endpoint">
                            <div class="endpoint-url">GET /api/details</div>
                            <div class="endpoint-desc">Get detailed application information including time, date, and user greeting</div>
                        </div>
                        
                        <div class="endpoint">
                            <div class="endpoint-url">GET /health</div>
                            <div class="endpoint-desc">Health check endpoint with uptime information</div>
                        </div>
                        
                        <div class="endpoint">
                            <div class="endpoint-url">GET /api/stats</div>
                            <div class="endpoint-desc">Get system statistics including Node.js version and memory usage</div>
                        </div>
                        
                        <div class="endpoint">
                            <div class="endpoint-url">GET /api/json</div>
                            <div class="endpoint-desc">Get all information in JSON format (original API response)</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="footer">
                <p>💻 Built with Node.js ${process.version} • Express.js • Docker 🐳</p>
                <p>🌟 Powered by Backstage Software Templates</p>
            </div>
        </div>
    </body>
    </html>
    `;
    
    res.send(html);
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

// JSON endpoint for backward compatibility
app.get('/api/json', (req, res) => {
    const user = process.env.USER || 'World';
    const now = new Date();
    const timestamp = now.toISOString().replace('T', ' ').substring(0, 19);
    const date = now.toISOString().split('T')[0];
    const time = now.toTimeString().split(' ')[0];
    const day = now.toLocaleDateString('en-US', { weekday: 'long' });
    
    res.json({
        message: "${{ values.app_name | title }} Application",
        greeting: `Hello ${user}`,
        timestamp: timestamp,
        date: date,
        time: time,
        day: day,
        status: "running",
        version: "1.0.0",
        endpoints: [
            "/ - Beautiful web interface",
            "/api/details - Get application details",
            "/health - Health check",
            "/api/stats - Get system statistics",
            "/api/json - JSON response (this endpoint)"
        ]
    });
});

// Start server
const port = process.env.PORT || 8085;
app.listen(port, '0.0.0.0', () => {
    console.log(`${{ values.app_name | title }} Application listening on port ${port}`);
    console.log(`Environment: ${process.env.NODE_ENV || 'development'}`);
    console.log(`User: ${process.env.USER || 'World'}`);
}); 