<?php
// Configure session cookie parameters for security
session_set_cookie_params([
    'lifetime' => $_ENV['SESSION_LIFETIME'] ?? 1800,
    'path' => '/',
    'domain' => '', // Use appropriate domain in production
    'secure' => isset($_SERVER['HTTPS']), // True if using HTTPS
    'httponly' => true,
    'samesite' => 'Strict'
]);

session_start();

// Check for session timeout
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > ($_ENV['SESSION_LIFETIME'] ?? 1800))) {
    session_unset();
    session_destroy();
    session_start();
}
$_SESSION['LAST_ACTIVITY'] = time();

// CSRF Protection Helpers
function generateCsrfToken()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCsrfToken($token)
{
    if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        return false;
    }
    return true;
}

function csrfField()
{
    $token = generateCsrfToken();
    echo '<input type="hidden" name="csrf_token" value="' . $token . '">';
}

// Flash message helper
function flash($name = '', $message = '', $class = 'alert-success')
{
    if (!empty($name)) {
        if (!empty($message) && empty($_SESSION[$name])) {
            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        } elseif (empty($message) && !empty($_SESSION[$name])) {
            $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
            echo '<div class="alert ' . $class . ' alert-dismissible fade show" role="alert">';
            echo $_SESSION[$name];
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
            echo '</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }
    }
}

// Check if user is logged in
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

// Redirect helper
function redirect($page)
{
    header('location: ' . URLROOT . '/' . $page);
    exit();
}
