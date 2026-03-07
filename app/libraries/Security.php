<?php
/**
 * Security Library
 * Handles Security Headers, Rate Limiting, and XSS
 */
class Security
{
    /**
     * Set standard security headers
     */
    public static function setSecurityHeaders()
    {
        // Prevent Clickjacking
        header("X-Frame-Options: DENY");
        
        // Prevent MIME-sniffing
        header("X-Content-Type-Options: nosniff");
        
        // XSS Protection for older browsers
        header("X-XSS-Protection: 1; mode=block");
        
        // Referrer Policy
        header("Referrer-Policy: strict-origin-when-cross-origin");
        
        // HSTS (Enable in production with HTTPS)
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
        }

        // Content Security Policy (Broadened for maximum compatibility during debug)
        $csp = "default-src 'self' https:; ";
        $csp .= "script-src 'self' 'unsafe-inline' 'unsafe-eval' https:; ";
        $csp .= "style-src 'self' 'unsafe-inline' https:; ";
        $csp .= "font-src 'self' data: https:; ";
        $csp .= "img-src 'self' data: https:; ";
        $csp .= "connect-src 'self' https:; ";
        header("Content-Security-Policy: " . $csp);
    }

    /**
     * Basic Rate Limiting
     * @param string $key Unique key for the action (e.g., 'login_127.0.0.1')
     * @param int $maxAttempts
     * @param int $decaySeconds
     * @return bool
     */
    public static function checkRateLimit($key, $maxAttempts = 5, $decaySeconds = 60)
    {
        $sessionKey = 'rate_limit_' . md5($key);
        
        if (!isset($_SESSION[$sessionKey])) {
            $_SESSION[$sessionKey] = ['attempts' => 1, 'first_attempt' => time()];
            return true;
        }

        $data = $_SESSION[$sessionKey];
        
        // Reset if decay time passed
        if (time() - $data['first_attempt'] > $decaySeconds) {
            $_SESSION[$sessionKey] = ['attempts' => 1, 'first_attempt' => time()];
            return true;
        }

        if ($data['attempts'] >= $maxAttempts) {
            return false;
        }

        $_SESSION[$sessionKey]['attempts']++;
        return true;
    }

    /**
     * Escape output for XSS prevention
     */
    public static function h($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}
