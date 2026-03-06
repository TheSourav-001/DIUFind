<?php
// App Configuration
define('APP_NAME', 'DIUfind');
define('APP_VERSION', '1.0.0');

// URL Configuration
define('URLROOT', 'http://localhost/DIUfind/public');
define('SITENAME', 'DIU Smart Lost & Found');

// App Root
define('APPROOT', dirname(dirname(__FILE__)));

// Upload Directory
define('UPLOAD_DIR', dirname(APPROOT) . '/public/uploads/');
define('UPLOAD_URL', URLROOT . '/uploads/');

// Session
define('SESSION_NAME', 'diufind_session');
define('SESSION_LIFETIME', 86400); // 24 hours
