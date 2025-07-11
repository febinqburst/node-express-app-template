<?php
// Get the request URI and method
$request_uri = $_SERVER['REQUEST_URI'];
$request_method = $_SERVER['REQUEST_METHOD'];

// Parse the URI to get the path
$uri_parts = parse_url($request_uri);
$path = $uri_parts['path'] ?? '/';

// Remove query parameters for routing
$path = strtok($path, '?');

// Set JSON header for API endpoints
function setJsonHeader() {
    header('Content-Type: application/json');
}

// Get user from environment variable
function getUser() {
    return $_ENV['USER'] ?? $_SERVER['USER'] ?? 'World';
}

// Get current date and time information
function getTimeInfo() {
    $now = new DateTime();
    return [
        'timestamp' => $now->format('Y-m-d H:i:s'),
        'date' => $now->format('Y-m-d'),
        'time' => $now->format('H:i:s'),
        'day' => $now->format('l')
    ];
}

// Route handling
switch ($path) {
    case '/':
        // Beautiful web interface
        $user = getUser();
        $timeInfo = getTimeInfo();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?= "${{ values.app_name | title }}" ?> - PHP Demo Application</title>
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
                
                body {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    background: linear-gradient(135deg, #ff6b6b 0%, #ffa726 25%, #26a69a 75%, #42a5f5 100%);
                    min-height: 100vh;
                    color: #333;
                }
                
                .container {
                    max-width: 1200px;
                    margin: 0 auto;
                    padding: 20px;
                }
                
                .banner {
                    background: linear-gradient(45deg, #ff5722, #ff6b6b, #26a69a);
                    color: white;
                    text-align: center;
                    padding: 30px 20px;
                    border-radius: 15px;
                    margin-bottom: 30px;
                    box-shadow: 0 10px 30px rgba(255, 107, 107, 0.4);
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
                
                @keyframes pulse {
                    0% { transform: scale(1); }
                    50% { transform: scale(1.05); }
                    100% { transform: scale(1); }
                }
                
                @keyframes glow {
                    0% { box-shadow: 0 0 5px rgba(255, 107, 107, 0.5); }
                    50% { box-shadow: 0 0 20px rgba(255, 107, 107, 0.8), 0 0 30px rgba(38, 166, 154, 0.3); }
                    100% { box-shadow: 0 0 5px rgba(255, 107, 107, 0.5); }
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
                    background: linear-gradient(145deg, #ffffff, #fafafa);
                    border-radius: 15px;
                    padding: 40px;
                    box-shadow: 0 15px 35px rgba(255, 107, 107, 0.15);
                    margin-bottom: 30px;
                    border: 1px solid rgba(255, 107, 107, 0.1);
                }
                
                .php-logo {
                    text-align: center;
                    margin-bottom: 30px;
                }
                
                .php-logo svg {
                    width: 120px;
                    height: 120px;
                    margin-bottom: 20px;
                    filter: drop-shadow(0 5px 15px rgba(255, 107, 107, 0.3));
                    animation: pulse 2s infinite;
                    transition: all 0.3s ease;
                }
                
                .php-logo svg:hover {
                    animation: glow 1s infinite;
                    transform: scale(1.1);
                }
                
                .app-info {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                    gap: 30px;
                    margin-bottom: 40px;
                }
                
                .info-card {
                    background: linear-gradient(145deg, #fff3e0, #fce4ec);
                    padding: 25px;
                    border-radius: 12px;
                    text-align: center;
                    box-shadow: 5px 5px 15px rgba(255, 107, 107, 0.2);
                    transition: transform 0.3s ease;
                    border: 2px solid transparent;
                }
                
                .info-card:hover {
                    transform: translateY(-5px);
                    border: 2px solid #ff6b6b;
                    box-shadow: 5px 5px 20px rgba(255, 107, 107, 0.3);
                }
                
                .info-card h3 {
                    color: #ff5722;
                    margin-bottom: 15px;
                    font-size: 1.3rem;
                }
                
                .info-card p {
                    color: #666;
                    line-height: 1.6;
                }
                
                .api-endpoints {
                    background: linear-gradient(135deg, #e8f5e8, #f3e5f5);
                    padding: 30px;
                    border-radius: 12px;
                    margin-bottom: 30px;
                    border: 2px solid rgba(38, 166, 154, 0.2);
                }
                
                .api-endpoints h2 {
                    color: #26a69a;
                    margin-bottom: 20px;
                    text-align: center;
                    font-size: 1.8rem;
                    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
                }
                
                .endpoint-list {
                    display: grid;
                    gap: 15px;
                }
                
                .endpoint {
                    background: white;
                    padding: 20px;
                    border-radius: 8px;
                    border-left: 4px solid #ff6b6b;
                    box-shadow: 0 2px 10px rgba(255, 107, 107, 0.1);
                    transition: all 0.3s ease;
                }
                
                .endpoint:hover {
                    transform: translateX(10px);
                    box-shadow: 0 5px 20px rgba(255, 107, 107, 0.2);
                    border-left: 4px solid #26a69a;
                }
                
                .endpoint-url {
                    font-family: 'Courier New', monospace;
                    background: linear-gradient(135deg, #ffebee, #e8f5e8);
                    padding: 8px 12px;
                    border-radius: 4px;
                    display: inline-block;
                    margin-bottom: 8px;
                    color: #26a69a;
                    font-weight: bold;
                    border: 1px solid rgba(38, 166, 154, 0.2);
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
                    background: linear-gradient(45deg, #ff6b6b, #26a69a, #ff6b6b);
                    background-size: 300% 100%;
                    color: white;
                    padding: 8px 16px;
                    border-radius: 20px;
                    font-size: 0.9rem;
                    font-weight: bold;
                    display: inline-block;
                    margin-top: 10px;
                    box-shadow: 0 3px 10px rgba(255, 107, 107, 0.4);
                    border: 2px solid rgba(255, 255, 255, 0.2);
                    animation: gradient-shift 3s ease infinite;
                }
                
                @keyframes gradient-shift {
                    0% { background-position: 0% 50%; }
                    50% { background-position: 100% 50%; }
                    100% { background-position: 0% 50%; }
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
                    <h1>🎉 Welcome to PHP Demo Application</h1>
                    <p>✨ Powered by PHP & Apache | Built with 💖 & Modern Design</p>
                </div>
                
                <div class="main-content">
                    <div class="php-logo">
                        <svg viewBox="0 0 256 134" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="phpGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#ff6b6b;stop-opacity:1" />
                                    <stop offset="50%" style="stop-color:#ffa726;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#26a69a;stop-opacity:1" />
                                </linearGradient>
                            </defs>
                            <path fill="url(#phpGradient)" d="M128 0C57.308 0 0 30.135 0 67.333C0 104.531 57.308 134.667 128 134.667C198.692 134.667 256 104.531 256 67.333C256 30.135 198.692 0 128 0Z"/>
                            <path fill="#FFF" d="M32.305 84.044c-1.724 9.014-8.262 9.014-14.928 9.014H13.63l3.448-17.802h3.78c7.772 0 12.062 0 14.11 3.862c1.434 2.706 1.026 4.926-2.663 4.926zm7.31-14.486c-2.768-4.618-7.93-6.522-14.694-6.522H9.423c-1.26 0-2.34.906-2.58 2.147L.234 100.051c-.21 1.084.541 2.081 1.659 2.081h7.54c1.26 0 2.34-.906 2.58-2.147l1.713-8.842h5.932c10.617 0 18.486-3.129 21.618-14.19C43.205 71.032 42.593 67.104 39.615 69.558z"/>
                            <path fill="#FFF" d="M74.089 84.044c-1.724 9.014-8.262 9.014-14.928 9.014H55.414l3.448-17.802h3.78c7.772 0 12.062 0 14.11 3.862c1.434 2.706 1.026 4.926-2.663 4.926zm7.31-14.486c-2.768-4.618-7.93-6.522-14.694-6.522H51.207c-1.26 0-2.34.906-2.58 2.147L42.018 100.051c-.21 1.084.541 2.081 1.659 2.081h7.54c1.26 0 2.34-.906 2.58-2.147l1.713-8.842h5.932c10.617 0 18.486-3.129 21.618-14.19C84.989 71.032 84.377 67.104 81.399 69.558z"/>
                            <path fill="#FFF" d="M134.906 102.132h-7.54c-1.118 0-1.869-.997-1.659-2.081l6.609-34.868c.24-1.241 1.32-2.147 2.58-2.147h7.54c1.118 0 1.869.997 1.659 2.081l-1.378 7.276h5.932c10.617 0 18.486 3.129 21.618 14.19c2.929 10.421 2.317 14.349-.661 11.895c-2.768 4.618-7.93 6.522-14.694 6.522h-14.498c-1.26 0-2.34-.906-2.58-2.147l-1.378-7.276h-5.932c-7.772 0-12.062 0-14.11-3.862c-1.434-2.706-1.026-4.926 2.663-4.926c1.724-9.014 8.262-9.014 14.928-9.014h3.747l-3.448 17.802h-3.78z"/>
                        </svg>
                        <h2 style="color: #ff5722; margin-top: 10px; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);">PHP Web Application</h2>
                        <div class="status-badge">🟢 Application Running</div>
                    </div>
                    
                    <div class="app-info">
                        <div class="info-card">
                            <h3>👋 Hello <?= htmlspecialchars($user) ?>!</h3>
                            <p>Welcome to your PHP web application. This app is running successfully and ready to serve your requests.</p>
                        </div>
                        
                        <div class="info-card">
                            <h3>⏰ Current Time</h3>
                            <p><?= htmlspecialchars($timeInfo['timestamp']) ?></p>
                            <p>Server timezone and current timestamp</p>
                        </div>
                        
                        <div class="info-card">
                            <h3>🚀 App Status</h3>
                            <p>Application: <strong><?= "${{ values.app_name | title }}" ?></strong></p>
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
                                <div class="endpoint-desc">Get system statistics including PHP version and memory usage</div>
                            </div>
                            
                            <div class="endpoint">
                                <div class="endpoint-url">GET /api/json</div>
                                <div class="endpoint-desc">Get all information in JSON format (original API response)</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="footer">
                    <p>💻 Built with PHP <?= phpversion() ?> • Apache • Docker 🐳</p>
                    <p>🌟 Powered by Backstage Software Templates</p>
                </div>
            </div>
        </body>
        </html>
        <?php
        break;

    case '/api/details':
        setJsonHeader();
        $user = getUser();
        $timeInfo = getTimeInfo();
        
        echo json_encode([
            'message' => "Hello " . $user,
            'timestamp' => $timeInfo['timestamp'],
            'date' => $timeInfo['date'],
            'time' => $timeInfo['time'],
            'day' => $timeInfo['day'],
            'app' => "${{ values.app_name | title }} Application",
            'status' => 'running',
            'version' => '1.0.0'
        ], JSON_PRETTY_PRINT);
        break;

    case '/health':
        setJsonHeader();
        $uptime = (time() - $_SERVER['REQUEST_TIME_FLOAT']);
        
        echo json_encode([
            'status' => 'healthy',
            'app' => "${{ values.app_name | title }} Application",
            'uptime' => round($uptime, 2),
            'php_version' => phpversion()
        ], JSON_PRETTY_PRINT);
        break;

    case '/api/stats':
        setJsonHeader();
        echo json_encode([
            'app' => "${{ values.app_name | title }} Application",
            'php_version' => phpversion(),
            'platform' => php_uname('s'),
            'architecture' => php_uname('m'),
            'memory_usage' => [
                'current' => memory_get_usage(true),
                'peak' => memory_get_peak_usage(true),
                'limit' => ini_get('memory_limit')
            ],
            'timestamp' => (new DateTime())->format(DateTime::ISO8601)
        ], JSON_PRETTY_PRINT);
        break;

    case '/api/json':
        setJsonHeader();
        $user = getUser();
        $timeInfo = getTimeInfo();
        
        echo json_encode([
            'message' => "${{ values.app_name | title }} Application",
            'greeting' => "Hello " . $user,
            'timestamp' => $timeInfo['timestamp'],
            'date' => $timeInfo['date'],
            'time' => $timeInfo['time'],
            'day' => $timeInfo['day'],
            'status' => 'running',
            'version' => '1.0.0',
            'endpoints' => [
                '/ - Beautiful web interface',
                '/api/details - Get application details',
                '/health - Health check',
                '/api/stats - Get system statistics',
                '/api/json - JSON response (this endpoint)'
            ]
        ], JSON_PRETTY_PRINT);
        break;

    default:
        // 404 Page
        http_response_code(404);
        setJsonHeader();
        echo json_encode([
            'error' => 'Not Found',
            'message' => 'The requested endpoint does not exist',
            'available_endpoints' => [
                '/ - Beautiful web interface',
                '/api/details - Get application details',
                '/health - Health check',
                '/api/stats - Get system statistics',
                '/api/json - JSON response'
            ]
        ], JSON_PRETTY_PRINT);
        break;
}
?> 