<?php
// Load Config
require_once 'config/config.php';

// Load Database Connection (Must load before Models)
require_once 'config/Database.php';

// Load helpers
require_once 'helpers/session_helper.php';
require_once 'helpers/time_helper.php';
require_once 'helpers/notification_helper.php';

// Autoload Core Libraries
spl_autoload_register(function ($className) {
    require_once 'libraries/' . $className . '.php';
});
