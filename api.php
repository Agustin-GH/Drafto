<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/Repositories/ReglasRepository.php';
require_once __DIR__ . '/Controllers/ControladorUsuario.php';

try {
    $route = $_GET['r'] ?? ($_SERVER['PATH_INFO'] ?? '/');
    if (!is_string($route)) { $route = '/'; }
    $route = strtok($route, '?');

    switch ($route) {
        case '/health':
            echo json_encode([
                'ok' => true,
                'ts' => gmdate('c'),
                'version' => '0.2.0',
            ]);
            break;

        case '/reglas':
        case '/reglas/base':
            $data = ReglasRepository::getReglas();
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            break;

        case '/auth/register':
            (new ControladorUsuario())->register();
            break;

        case '/auth/login':
            (new ControladorUsuario())->login();
            break;

        default:
            http_response_code(404);
            echo json_encode(['error' => 'ruta_no_encontrada', 'ruta' => $route]);
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'error_interno',
        'mensaje' => $e->getMessage(),
    ]);
}