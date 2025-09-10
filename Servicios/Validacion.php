<?php

final class Validacion
{
    public static function nombre(string $v): ?string
    {
        $v = trim($v);
        if ($v === '' || mb_strlen($v) < 3 || mb_strlen($v) > 30) return 'nombre_longitud_invalida';
        if (!preg_match('/^[A-Za-z0-9_\-]+$/', $v)) return 'nombre_caracteres_invalidos';
        return null;
    }

    public static function email(string $v): ?string
    {
        $v = trim($v);
        if (mb_strlen($v) > 50) return 'email_longitud_invalida';
        if (!filter_var($v, FILTER_VALIDATE_EMAIL)) return 'email_invalido';
        return null;
    }

    public static function password(string $v): ?string
    {
        if (strlen($v) < 8) return 'password_muy_corta';
        if (strlen($v) > 72) return 'password_muy_larga';
        if (!preg_match('/[A-Za-z]/', $v) || !preg_match('/\d/', $v)) return 'password_debil';
        return null;
    }
}