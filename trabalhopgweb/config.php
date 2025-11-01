<?php
// config.php
// Ajuste as constantes abaixo conforme seu ambiente
define('DB_HOST', 'localhost');
define('DB_PORT', '5432');
define('DB_NAME', 'ProgWeb');
define('DB_USER', 'rostyi');
define('DB_PASS', '1234');

// Charset / options
define('DB_DSN', 'pgsql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';');
