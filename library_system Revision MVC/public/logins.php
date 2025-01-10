<?php
require_once '../config/database.php';
require_once '../app/models/Book.php';

// Fungsi untuk membersihkan input dari parameter GET
if (!function_exists('sanitizeInput')) {
    function sanitizeInput($input) {
        return htmlspecialchars(strip_tags(trim($input)));
    }
}

// Ambil controller dan action dari URL
$controller = isset($_GET['controller']) ? sanitizeInput($_GET['controller']) : 'Book';
$action = isset($_GET['action']) ? sanitizeInput($_GET['action']) : 'login';

// Lokasi file controller
//$controllerFile = __DIR__ . '/../controllers/' . ucfirst($controller) . 'Controller.php';
$controllerFile = __DIR__ . '/../controllers/' . 'Book' . 'Controller.php';
try {
    // Cek apakah file controller ada
    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        $controllerClass = 'BookController';

        // Cek apakah kelas controller ada
        if (class_exists($controllerClass)) {
            // Jika controller membutuhkan parameter database, tambahkan koneksi
            $controllerInstance = new $controllerClass($koneksi);

            // Cek apakah metode dalam kelas controller ada
            if (method_exists($controllerInstance, $action)) {
                // Panggil metode dalam controller
                $controllerInstance->$action();
            } else {
                throw new Exception("Action '$action' tidak ditemukan di dalam controller '$controllerClass'.");
            }
        } else {
            throw new Exception("Controller class '$controllerClass' tidak ditemukan.");
        }
    } else {
        throw new Exception("File controller untuk '$controller' tidak ditemukan di $controllerFile.");
    }
} catch (Exception $e) {
    // Log error ke file log jika folder logs tersedia
    $logDir = __DIR__ . '/../logs';
    $logFile = $logDir . '/error.log';
    if (is_writable($logDir)) {
        error_log($e->getMessage(), 3, $logFile);
    }

    // Tampilkan pesan error (bisa diganti dengan halaman custom)
    http_response_code(404);
    echo "Terjadi kesalahan: " . $e->getMessage();
}
?>
