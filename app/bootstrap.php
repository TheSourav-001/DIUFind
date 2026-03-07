<?php
// Load Environment Variables (.env)
if (file_exists(dirname(dirname(__FILE__)) . '/.env')) {
    $lines = file(dirname(dirname(__FILE__)) . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        
        // Split by the first '='
        $parts = explode('=', $line, 2);
        if (count($parts) !== 2) continue;
        
        $name = trim($parts[0]);
        $value = trim($parts[1]);
        
        // Strip inline comments
        if (strpos($value, '#') !== false) {
            $value = trim(explode('#', $value)[0]);
        }
        
        // Remove quotes if present
        $value = trim($value, '"\'');
        
        if (!array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
        }
    }
}

// Load Config
require_once __DIR__ . '/config/config.php';

// Load Database Connection (Must load before Models)
require_once __DIR__ . '/config/Database.php';

// Load helpers
require_once __DIR__ . '/helpers/session_helper.php';
require_once __DIR__ . '/helpers/time_helper.php';
require_once __DIR__ . '/helpers/notification_helper.php';

// Autoload Core Libraries
spl_autoload_register(function ($className) {
    $file = __DIR__ . '/libraries/' . $className . '.php';
    if (file_exists($file)) {
        require_once $file;
    } else {
        // Fallback for case sensitivity or other issues
        $fileLower = __DIR__ . '/libraries/' . strtolower($className) . '.php';
        if (file_exists($fileLower)) {
            require_once $fileLower;
        }
    }
});
