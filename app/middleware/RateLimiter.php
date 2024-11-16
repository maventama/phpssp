<?php

class RateLimiter {
    private $maxRequests = 100;
    private $timeWindow = 60;
    public function __construct(){
        $config = require __DIR__ . '/../config.php';
        $this->maxRequests = $config['rate_limiter']['max_requests'];
        $this->timeWindow = $config['rate_limiter']['time_window'];
    }

    public function handle($request) {
        $ip = $this->getClientIP();
        $cacheKey = "rate_limit_{$ip}";
        $currentTime = time();
        
        $requests = isset($_SESSION[$cacheKey]) ? $_SESSION[$cacheKey] : [];
        
        $requests = array_filter($requests, function($timestamp) use ($currentTime) {
            return $timestamp > ($currentTime - $this->timeWindow);
        });
        
        $requests[] = $currentTime;
        $_SESSION[$cacheKey] = $requests;
        
        if (count($requests) > $this->maxRequests) {
            http_response_code(429);
            echo "Terlalu banyak permintaan. Silakan coba lagi nanti.";
            exit;
        }
    }

    private function getClientIP() {
        return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    }
}
