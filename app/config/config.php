<?php
// App Configuration
define('APP_NAME', $_ENV['APP_NAME'] ?? 'DIUfind');
define('APP_VERSION', '1.0.0');

// URL Configuration
define('URLROOT', $_ENV['APP_URL'] ?? 'http://localhost/DIUfind/public');
define('SITENAME', 'DIU Smart Lost & Found');

// App Secret for CSRF and other security features
define('APP_SECRET', $_ENV['APP_SECRET'] ?? 'default_secret_key_change_me');

// App Root
define('APPROOT', dirname(dirname(__FILE__)));

// Upload Directory
define('UPLOAD_DIR', dirname(APPROOT) . '/public/uploads/');
define('UPLOAD_URL', URLROOT . '/uploads/');

// Session
define('SESSION_NAME', 'diufind_session');
define('SESSION_LIFETIME', 86400); // 24 hours
