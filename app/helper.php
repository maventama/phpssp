<?php
// app/helper.php

// Escape output untuk menghindari XSS
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
