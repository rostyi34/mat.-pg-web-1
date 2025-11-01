<?php
require_once __DIR__ . '/includes/config.php';

try {
    $pdo = getPDO();
    echo "✅ Conexão bem-sucedida com o banco '" . DB_NAME . "'!";
} catch (Exception $e) {
    echo "❌ Falha na conexão: " . $e->getMessage();
}
