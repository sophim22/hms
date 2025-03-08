<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$useEnv = false;
if (getenv('APP_ENV') === 'production') {
    if (file_exists(__DIR__ . '/../../vendor/autoload.php')) {
        require_once __DIR__ . '/../../vendor/autoload.php';
        try {
            $useEnv = true;
        } catch (Exception $e) {
            die("Failed to load environment variables: " . $e->getMessage());
        }
    } else {
        die("Vendor autoloader not found. Please run 'composer install' in the project root.");
    }
}

define('DB_SERVER', $useEnv ? ($_ENV['DB_SERVER'] ?? '127.0.0.1') : '127.0.0.1');
define('DB_USER', $useEnv ? ($_ENV['DB_USER'] ?? 'root') : 'root');
define('DB_PASS', $useEnv ? ($_ENV['DB_PASS'] ?? 'hms_password') : '');
define('DB_NAME', $useEnv ? ($_ENV['DB_NAME'] ?? 'hms_db') : 'hms_db');

$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if (!$con) {
    die("Failed to connect to MySQL: " . mysqli_connect_error() . " (Error #" . mysqli_connect_errno() . ")");
}

mysqli_set_charset($con, "utf8mb4") or die("Failed to set charset: " . mysqli_error($con));
?>