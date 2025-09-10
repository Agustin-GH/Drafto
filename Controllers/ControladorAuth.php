<?php

require_once __DIR__ . '/../Repositories/UsuarioRepository.php';
require_once __DIR__ . '/../Services/Validacion.php';

class AuthController
{
    private function json($data, int $code = 200): void
    {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    private function readJson(): array
    {
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);
        return is_array($data) ? $data : [];
    }

    public function login(): void
    {
        $body = $this->readJson();
        $usuario = trim($body['usuario'] ?? '');
        $contrasena = (string)($body['contrasena'] ?? '');

        if ($usuario === '' || $contrasena === '') {
            return $this->json(['ok' => false, 'error' => 'faltan_campos'], 422);
        }

        try {
            $repo = new UsuarioRepository();
            $u = $repo->encontrar($usuario);
            if (!$u) return $this->json(['ok' => false, 'error' => 'credenciales_invalidas'], 401);
            if (($u['estado'] ?? 'activo') !== 'activo') return $this->json(['ok' => false, 'error' => 'usuario_no_activo'], 403);

            if (!password_verify($contrasena, $u['contrasena'])) {
                return $this->json(['ok' => false, 'error' => 'credenciales_invalidas'], 401);
            }

            $_SESSION['user_id'] = (int)$u['id'];
            $_SESSION['user_nombre'] = $u['nombre'];
            $_SESSION['user_rol'] = $u['rol'];

            unset($u['contrasena']);
            return $this->json(['ok' => true, 'usuario' => $u], 200);
        } catch (Throwable $e) {
            return $this->json(['ok' => false, 'error' => 'error_servidor'], 500);
        }
    }

    public function register(): void
    {
        $body = $this->readJson();
        $nombre = trim($body['nombre'] ?? '');
        $email = trim($body['email'] ?? '');
        $contrasena = (string)($body['contrasena'] ?? '');
        $contrasena2 = (string)($body['contrasena2'] ?? '');

        if ($nombre === '' || $email === '' || $contrasena === '' || $contrasena2 === '') {
            return $this->json(['ok' => false, 'error' => 'faltan_campos'], 422);
        }
        if ($contrasena !== $contrasena2) {
            return $this->json(['ok' => false, 'error' => 'password_no_coincide'], 422);
        }

        if ($err = Validator::nombre($nombre))  return $this->json(['ok' => false, 'error' => $err], 422);
        if ($err = Validator::email($email))    return $this->json(['ok' => false, 'error' => $err], 422);
        if ($err = Validator::password($contrasena)) return $this->json(['ok' => false, 'error' => $err], 422);

        try {
            $repo = new UsuarioRepository();

            // Duplicados
            if ($repo->encontrar($nombre)) return $this->json(['ok' => false, 'error' => 'nombre_ya_registrado'], 409);
            if ($repo->encontrar($email))  return $this->json(['ok' => false, 'error' => 'email_ya_registrado'], 409);

            $hash = password_hash($contrasena, PASSWORD_DEFAULT);
            $id = $repo->crear($nombre, $email, $hash, 'user');

            $u = $repo->encontrarID($id);
            unset($u['contrasena']);

            return $this->json(['ok' => true, 'usuario' => $u], 201);
        } catch (Throwable $e) {
            if (method_exists($e, 'getCode') && (int)$e->getCode() === 1062) {
                return $this->json(['ok' => false, 'error' => 'duplicado'], 409);
            }
            return $this->json(['ok' => false, 'error' => 'error_servidor'], 500);
        }
    }
}