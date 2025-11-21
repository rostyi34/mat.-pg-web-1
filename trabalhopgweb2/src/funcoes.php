<?php
// src/funcoes.php

function sanitize_text(string $s): string {
    // remove control chars, trim, e limita tamanho
    $s = trim($s);
    $s = preg_replace('/[\x00-\x1F\x7F]/u', '', $s);
    if (mb_strlen($s) > 2000) {
        $s = mb_substr($s, 0, 2000);
    }
    return $s;
}

function validate_score($v): bool {
    if (!is_numeric($v)) return false;
    $i = (int)$v;
    return ($i >= 0 && $i <= 10);
}
