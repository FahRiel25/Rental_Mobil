<?php
define('APP_NAME', 'Rental Mobil');
define('APP_URL', 'http://localhost/rentalmobil');
define('APP_ROOT', dirname(dirname(__FILE__)));

define('EMAIL_HOST', 'smtp.example.com');
define('EMAIL_USERNAME', 'noreply@rentalmobil.com');
define('EMAIL_PASSWORD', 'passwordemail');
define('EMAIL_PORT', 587);
define('EMAIL_FROM', 'noreply@rentalmobil.com');
define('EMAIL_FROM_NAME', APP_NAME);

define('MAX_LOGIN_ATTEMPTS', 5);
define('UPLOAD_DIR', 'images/cars/');
define('MAX_FILE_SIZE', 2 * 1024 * 1024); // 2MB
define('ALLOWED_FILE_TYPES', ['jpg', 'jpeg', 'png']);
?>