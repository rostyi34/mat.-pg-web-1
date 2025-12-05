<?php
// config.php
define('DB_HOST', 'localhost');
define('DB_PORT', '5432');
define('DB_NAME', 'avaliacao');
define('DB_USER', 'postgres');
define('DB_PASS', '1234');

define('DB_DSN', 'pgsql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';');