<?php

class RateLimiter {
    // Tentukan jumlah request maksimum per IP dalam periode waktu tertentu (misalnya 100 request per 60 detik)
    private $maxRequests = 100;
    private $timeWindow = 60; // dalam detik

    public function handle($request) {
        $ip = $this->getClientIP();
        $cacheKey = "rate_limit_{$ip}";
        $currentTime = time();

        // Cek jumlah request yang sudah dilakukan oleh IP ini dalam periode waktu
        $requests = isset($_SESSION[$cacheKey]) ? $_SESSION[$cacheKey] : [];

        // Hapus request yang sudah lewat waktunya
        $requests = array_filter($requests, function($timestamp) use ($currentTime) {
            return $timestamp > ($currentTime - $this->timeWindow);
        });

        // Simpan request terbaru
        $requests[] = $currentTime;
        $_SESSION[$cacheKey] = $requests;

        // Jika jumlah request melebihi batas, tolak request
        if (count($requests) > $this->maxRequests) {
            http_response_code(429); // Too Many Requests
            echo "Terlalu banyak permintaan. Silakan coba lagi nanti.";
            exit;
        }
    }

    private function getClientIP() {
        return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    }
}
