<?php

require_once __DIR__ . '/Database.php';

class UsuarioRepository
{
    public function encontrar(string $usuario): ?array
    {
        $db = Database::get();
        $sql = "SELECT id, nombre, email, contrasena, rol, estado, fecha_creacion, fecha_modificacion
                FROM usuarios
                WHERE nombre = ? OR email = ?
                LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('ss', $usuario, $usuario);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc() ?: null;
        $stmt->close();
        return $row;
    }

    public function encontrarID(int $id): ?array
    {
        $db = Database::get();
        $sql = "SELECT id, nombre, email, contrasena, rol, estado, fecha_creacion, fecha_modificacion
                FROM usuarios
                WHERE id = ?
                LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc() ?: null;
        $stmt->close();
        return $row;
    }

    public function crear(string $nombre, string $email, string $hash, string $rol = 'user'): int
    {
        $db = Database::get();
        $sql = "INSERT INTO usuarios (nombre, email, contrasena, rol) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('ssss', $nombre, $email, $hash, $rol);
        $stmt->execute();
        $id = $stmt->insert_id;
        $stmt->close();
        return $id;
    }
}