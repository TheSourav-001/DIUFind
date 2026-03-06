<?php
// Load Config
require_once __DIR__ . '/config/config.php';

// Load Libraries
require_once __DIR__ . '/libraries/Core.php';
require_once __DIR__ . '/libraries/Controller.php';
require_once __DIR__ . '/config/Database.php';

// Load Helpers
require_once __DIR__ . '/helpers/session_helper.php';
require_once __DIR__ . '/helpers/notification_helper.php';

// Instantiate Core Class
$init = new Core();
