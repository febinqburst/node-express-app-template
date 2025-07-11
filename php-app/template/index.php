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
            <title><?= "${{ values.app_name | title }}" ?> - Enterprise PHP Application</title>
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
                
                body {
                    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                    background: #0a0a0a;
                    color: #ffffff;
                    line-height: 1.6;
                    overflow-x: hidden;
                }
                
                .sidebar {
                    position: fixed;
                    left: 0;
                    top: 0;
                    width: 280px;
                    height: 100vh;
                    background: linear-gradient(145deg, #1a1a1a, #2d2d2d);
                    border-right: 1px solid #333;
                    z-index: 1000;
                    overflow-y: auto;
                }
                
                .sidebar-header {
                    padding: 30px 20px;
                    border-bottom: 1px solid #333;
                    text-align: center;
                    background: linear-gradient(135deg, #4f46e5, #7c3aed);
                    position: relative;
                }
                
                .sidebar-header::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
                    animation: slide 3s infinite;
                }
                
                @keyframes slide {
                    0% { transform: translateX(-100%); }
                    100% { transform: translateX(100%); }
                }
                
                .logo {
                    font-size: 24px;
                    font-weight: 800;
                    color: #ffffff;
                    margin-bottom: 8px;
                    position: relative;
                    z-index: 1;
                }
                
                .logo::before {
                    content: '<?';
                    color: #22d3ee;
                    margin-right: 5px;
                }
                
                .logo::after {
                    content: '?>';
                    color: #22d3ee;
                    margin-left: 5px;
                }
                
                .version {
                    font-size: 12px;
                    color: #94a3b8;
                    position: relative;
                    z-index: 1;
                }
                
                .nav-section {
                    padding: 20px;
                }
                
                .nav-title {
                    font-size: 11px;
                    color: #64748b;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                    margin-bottom: 12px;
                    font-weight: 600;
                }
                
                .nav-item {
                    display: flex;
                    align-items: center;
                    padding: 12px 16px;
                    margin-bottom: 6px;
                    border-radius: 8px;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    border: 1px solid transparent;
                }
                
                .nav-item:hover {
                    background: rgba(79, 70, 229, 0.1);
                    border-color: #4f46e5;
                    transform: translateX(5px);
                }
                
                .nav-item.active {
                    background: linear-gradient(135deg, #4f46e5, #7c3aed);
                    border-color: #4f46e5;
                }
                
                .nav-icon {
                    width: 18px;
                    height: 18px;
                    margin-right: 12px;
                    opacity: 0.7;
                }
                
                .nav-text {
                    font-size: 14px;
                    color: #e2e8f0;
                }
                
                .main-content {
                    margin-left: 280px;
                    min-height: 100vh;
                    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
                    position: relative;
                }
                
                .main-content::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="%23334155" stroke-width="0.5" opacity="0.3"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
                    opacity: 0.3;
                    pointer-events: none;
                }
                
                .header {
                    padding: 40px 50px;
                    background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(124, 58, 237, 0.1));
                    border-bottom: 1px solid #334155;
                    position: relative;
                    z-index: 1;
                }
                
                .header-content {
                    max-width: 1200px;
                    margin: 0 auto;
                }
                
                .header-title {
                    font-size: 48px;
                    font-weight: 900;
                    background: linear-gradient(135deg, #22d3ee, #4f46e5);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                    margin-bottom: 12px;
                    letter-spacing: -1px;
                }
                
                .header-subtitle {
                    font-size: 18px;
                    color: #94a3b8;
                    margin-bottom: 24px;
                }
                
                .status-indicator {
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                    padding: 8px 16px;
                    background: rgba(34, 211, 238, 0.1);
                    border: 1px solid #22d3ee;
                    border-radius: 50px;
                    font-size: 14px;
                    font-weight: 600;
                }
                
                .status-dot {
                    width: 8px;
                    height: 8px;
                    background: #22d3ee;
                    border-radius: 50%;
                    animation: pulse-dot 2s infinite;
                }
                
                @keyframes pulse-dot {
                    0% { opacity: 1; transform: scale(1); }
                    50% { opacity: 0.5; transform: scale(1.2); }
                    100% { opacity: 1; transform: scale(1); }
                }
                
                .dashboard {
                    padding: 50px;
                    position: relative;
                    z-index: 1;
                }
                
                .dashboard-grid {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 30px;
                    max-width: 1200px;
                    margin: 0 auto;
                }
                
                .dashboard-card {
                    background: rgba(30, 41, 59, 0.8);
                    backdrop-filter: blur(10px);
                    border: 1px solid #334155;
                    border-radius: 16px;
                    padding: 30px;
                    transition: all 0.3s ease;
                    position: relative;
                    overflow: hidden;
                }
                
                .dashboard-card::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(124, 58, 237, 0.1));
                    opacity: 0;
                    transition: opacity 0.3s ease;
                }
                
                .dashboard-card:hover {
                    transform: translateY(-5px);
                    border-color: #4f46e5;
                    box-shadow: 0 20px 40px rgba(79, 70, 229, 0.2);
                }
                
                .dashboard-card:hover::before {
                    opacity: 1;
                }
                
                .card-header {
                    display: flex;
                    align-items: center;
                    margin-bottom: 20px;
                    position: relative;
                    z-index: 1;
                }
                
                .card-icon {
                    width: 24px;
                    height: 24px;
                    margin-right: 12px;
                }
                
                .card-title {
                    font-size: 20px;
                    font-weight: 700;
                    color: #f1f5f9;
                }
                
                .card-content {
                    position: relative;
                    z-index: 1;
                }
                
                .metric {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 12px 0;
                    border-bottom: 1px solid rgba(51, 65, 85, 0.5);
                }
                
                .metric:last-child {
                    border-bottom: none;
                }
                
                .metric-label {
                    font-size: 14px;
                    color: #94a3b8;
                }
                
                .metric-value {
                    font-size: 16px;
                    font-weight: 600;
                    color: #f1f5f9;
                }
                
                .api-section {
                    grid-column: span 2;
                    background: rgba(30, 41, 59, 0.8);
                    backdrop-filter: blur(10px);
                    border: 1px solid #334155;
                    border-radius: 16px;
                    padding: 30px;
                    position: relative;
                    overflow: hidden;
                }
                
                .api-section::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: linear-gradient(135deg, rgba(34, 211, 238, 0.05), rgba(79, 70, 229, 0.05));
                    opacity: 1;
                }
                
                .api-title {
                    font-size: 24px;
                    font-weight: 700;
                    color: #f1f5f9;
                    margin-bottom: 20px;
                    position: relative;
                    z-index: 1;
                }
                
                .api-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                    gap: 20px;
                    position: relative;
                    z-index: 1;
                }
                
                .api-endpoint {
                    background: rgba(15, 23, 42, 0.8);
                    border: 1px solid #334155;
                    border-radius: 12px;
                    padding: 20px;
                    transition: all 0.3s ease;
                    position: relative;
                    overflow: hidden;
                }
                
                .api-endpoint::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 4px;
                    height: 100%;
                    background: linear-gradient(135deg, #22d3ee, #4f46e5);
                    opacity: 0;
                    transition: opacity 0.3s ease;
                }
                
                .api-endpoint:hover {
                    border-color: #22d3ee;
                    transform: translateY(-2px);
                }
                
                .api-endpoint:hover::before {
                    opacity: 1;
                }
                
                .api-method {
                    display: inline-block;
                    padding: 4px 8px;
                    background: rgba(34, 211, 238, 0.1);
                    border: 1px solid #22d3ee;
                    border-radius: 6px;
                    font-size: 12px;
                    font-weight: 600;
                    color: #22d3ee;
                    margin-bottom: 8px;
                }
                
                .api-path {
                    font-family: 'JetBrains Mono', 'Fira Code', monospace;
                    font-size: 16px;
                    font-weight: 600;
                    color: #f1f5f9;
                    margin-bottom: 8px;
                }
                
                .api-description {
                    font-size: 14px;
                    color: #94a3b8;
                    line-height: 1.5;
                }
                
                .footer {
                    padding: 30px 50px;
                    text-align: center;
                    border-top: 1px solid #334155;
                    color: #64748b;
                    font-size: 14px;
                    position: relative;
                    z-index: 1;
                }
                
                @media (max-width: 768px) {
                    .sidebar {
                        width: 100%;
                        height: auto;
                        position: relative;
                    }
                    
                    .main-content {
                        margin-left: 0;
                    }
                    
                    .dashboard-grid {
                        grid-template-columns: 1fr;
                    }
                    
                    .api-section {
                        grid-column: span 1;
                    }
                    
                    .header {
                        padding: 20px;
                    }
                    
                    .dashboard {
                        padding: 20px;
                    }
                    
                    .header-title {
                        font-size: 32px;
                    }
                }
            </style>
        </head>
        <body>
            <div class="sidebar">
                <div class="sidebar-header">
                    <div class="logo">PHP Pro</div>
                    <div class="version">v<?= phpversion() ?></div>
                </div>
                
                <div class="nav-section">
                    <div class="nav-title">Navigation</div>
                    <div class="nav-item active">
                        <svg class="nav-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                        <span class="nav-text">Dashboard</span>
                    </div>
                    <div class="nav-item">
                        <svg class="nav-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                        </svg>
                        <span class="nav-text">APIs</span>
                    </div>
                    <div class="nav-item">
                        <svg class="nav-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="nav-text">Health Check</span>
                    </div>
                </div>
                
                <div class="nav-section">
                    <div class="nav-title">System</div>
                    <div class="nav-item">
                        <svg class="nav-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                        </svg>
                        <span class="nav-text">Metrics</span>
                    </div>
                    <div class="nav-item">
                        <svg class="nav-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                        </svg>
                        <span class="nav-text">Settings</span>
                    </div>
                </div>
            </div>
            
            <div class="main-content">
                <div class="header">
                    <div class="header-content">
                        <h1 class="header-title"><?= "${{ values.app_name | title }}" ?></h1>
                        <p class="header-subtitle">Enterprise PHP Application Dashboard</p>
                        <div class="status-indicator">
                            <div class="status-dot"></div>
                            <span>System Online</span>
                        </div>
                    </div>
                </div>
                
                <div class="dashboard">
                    <div class="dashboard-grid">
                        <div class="dashboard-card">
                            <div class="card-header">
                                <svg class="card-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                                </svg>
                                <h3 class="card-title">User Information</h3>
                            </div>
                            <div class="card-content">
                                <div class="metric">
                                    <span class="metric-label">Current User</span>
                                    <span class="metric-value"><?= htmlspecialchars($user) ?></span>
                                </div>
                                <div class="metric">
                                    <span class="metric-label">Session Started</span>
                                    <span class="metric-value"><?= htmlspecialchars($timeInfo['time']) ?></span>
                                </div>
                                <div class="metric">
                                    <span class="metric-label">Today</span>
                                    <span class="metric-value"><?= htmlspecialchars($timeInfo['day']) ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="dashboard-card">
                            <div class="card-header">
                                <svg class="card-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                                <h3 class="card-title">System Status</h3>
                            </div>
                            <div class="card-content">
                                <div class="metric">
                                    <span class="metric-label">PHP Version</span>
                                    <span class="metric-value"><?= phpversion() ?></span>
                                </div>
                                <div class="metric">
                                    <span class="metric-label">Server Status</span>
                                    <span class="metric-value">🟢 Online</span>
                                </div>
                                <div class="metric">
                                    <span class="metric-label">Last Updated</span>
                                    <span class="metric-value"><?= htmlspecialchars($timeInfo['date']) ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="api-section">
                            <h2 class="api-title">API Endpoints</h2>
                            <div class="api-grid">
                                <div class="api-endpoint">
                                    <div class="api-method">GET</div>
                                    <div class="api-path">/api/details</div>
                                    <div class="api-description">Retrieve detailed application information including user data, timestamps, and system status.</div>
                                </div>
                                
                                <div class="api-endpoint">
                                    <div class="api-method">GET</div>
                                    <div class="api-path">/health</div>
                                    <div class="api-description">Health check endpoint with uptime monitoring and system diagnostics.</div>
                                </div>
                                
                                <div class="api-endpoint">
                                    <div class="api-method">GET</div>
                                    <div class="api-path">/api/stats</div>
                                    <div class="api-description">System statistics including PHP version, memory usage, and performance metrics.</div>
                                </div>
                                
                                <div class="api-endpoint">
                                    <div class="api-method">GET</div>
                                    <div class="api-path">/api/json</div>
                                    <div class="api-description">Complete application data in JSON format for programmatic access.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="footer">
                    <p>Enterprise PHP Application • Built with PHP <?= phpversion() ?> • Apache Server • Docker Container</p>
                    <p>Powered by Backstage Software Templates • Professional Development Environment</p>
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