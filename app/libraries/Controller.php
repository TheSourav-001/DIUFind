<?php
/**
 * Core Controller
 * Loads models and views
 */
class Controller
{
    public function __construct()
    {
        // 1. Set Security Headers
        Security::setSecurityHeaders();

        // 2. Global CSRF Protection for POST requests
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = null;

            // Check standard POST
            if (isset($_POST['csrf_token'])) {
                $token = $_POST['csrf_token'];
            }
            // Check JSON body
            else {
                $rawInput = file_get_contents('php://input');
                $decoded = json_decode($rawInput, true);
                if (isset($decoded['csrf_token'])) {
                    $token = $decoded['csrf_token'];
                }
            }

            if (!validateCsrfToken($token)) {
                http_response_code(403);
                if ($this->isAjaxRequest()) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'CSRF token validation failed.']);
                    exit;
                }
                die('CSRF token validation failed.');
            }
        }
    }

    private function isAjaxRequest()
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ||
               (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) ||
               (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false);
    }

    // Load model
    public function model($model)
    {
        $file = APPROOT . '/models/' . $model . '.php';
        if (file_exists($file)) {
            require_once $file;
            return new $model();
        }
        return null;
    }

    // Load view
    public function view($view, $data = [])
    {
        $file = APPROOT . '/views/' . $view . '.php';
        if (file_exists($file)) {
            require_once $file;
        } else {
            die('View does not exist: ' . $file);
        }
    }

    // XSS Helper
    protected function h($string)
    {
        return Security::h($string);
    }
}
