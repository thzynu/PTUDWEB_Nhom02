<?php
// Direct Journalist Panel Access
session_start();

// Configuration
define('BASE_PATH', __DIR__);

// Helper functions
require_once BASE_PATH . '/helpers.php';

// Constants
define('DB_HOST', 'localhost');
define('DB_NAME', 'news-project');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DISPLAY_ERROR', true);

// Error reporting
if (DISPLAY_ERROR) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// Autoloader
require_once BASE_PATH . '/app/Core/Autoloader.php';

try {
    // Check authentication
    if (!isset($_SESSION['user'])) {
        header('Location: ' . url('login'));
        exit;
    }

    $userPermission = $_SESSION['user']['permission'];
    if (!in_array($userPermission, ['journalist', 'admin'])) {
        header('Location: ' . url('/'));
        exit;
    }
    
    // Use router to load journalist dashboard directly
    echo "<!-- DEBUG: Loading JournalistController from journalist.php -->";
    require_once 'app/Controllers/JournalistController.php';
    
    $controller = new \App\Controllers\JournalistController();
    $controller->index();
    exit;
    
} catch (Exception $e) {
    if (DISPLAY_ERROR) {
        echo "<h1>Error</h1>";
        echo "<p>" . $e->getMessage() . "</p>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    } else {
        echo "Đã xảy ra lỗi. Vui lòng thử lại.";
    }
}
?>