<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=UTF-8');

// Manejo de preflight CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Autorización
try {
    $headers = getallheaders();
    if (!isset($headers['Authorization']) || $headers['Authorization'] !== 'Bearer ipss') {
        http_response_code(403);
        echo json_encode(['error' => 'Token no válido o faltante']);
        exit;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error inesperado en la autorización']);
    exit;
}

// Obtener método HTTP
$_method = $_SERVER['REQUEST_METHOD'];

// Obtener recurso e id desde PATH_INFO
if (isset($_SERVER['PATH_INFO'])) {
    $path = trim($_SERVER['PATH_INFO'], '/'); // ejemplo: producto/5
    $parts = explode('/', $path);
    $resource = $parts[0] ?? null;
    $id = $parts[1] ?? null;
} else {
    $resource = null;
    $id = null;
}

// Obtener cuerpo JSON
$body = json_decode(file_get_contents("php://input"), true);

// Cargar controladores
require_once __DIR__ . '/v1/Controller/productosController.php';
require_once __DIR__ . '/v1/Controller/serviciosController.php';

$productosController = new productosController();
$serviciosController = new serviciosController();

// Ruteo principal
switch ($resource) {
    case 'producto':
        switch ($_method) {
            case 'GET':
                echo json_encode(['data' => $productosController->getallProductos()]);
                break;
            case 'POST':
                if (!$body || !isset($body['nombre'], $body['descripcion'], $body['precio'], $body['stock'], $body['tipo'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Datos incompletos']);
                    break;
                }
                $productosController->postProducto($body['nombre'], $body['descripcion'], $body['precio'], $body['stock'], $body['tipo']);
                http_response_code(201);
                echo json_encode(['msg' => 'Producto creado correctamente']);
                break;
            case 'PUT':
                if (!$id || !$body || !isset($body['nombre'], $body['descripcion'], $body['precio'], $body['stock'], $body['tipo'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'ID y datos completos requeridos']);
                    break;
                }
                $productosController->putProducto($id, $body['nombre'], $body['descripcion'], $body['precio'], $body['stock'], $body['tipo']);
                http_response_code(200);
                echo json_encode(['msg' => 'Producto actualizado']);
                break;
            case 'PATCH':
                if (!$id || !$body || !isset($body['stock'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'ID y stock requeridos']);
                    break;
                }
                $productosController->patchProducto($id, $body['stock']);
                http_response_code(200);
                echo json_encode(['msg' => 'Stock actualizado']);
                break;
            case 'DELETE':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(['error' => 'ID requerido para eliminar']);
                    break;
                }
                $productosController->deleteProducto($id);
                http_response_code(200);
                echo json_encode(['msg' => 'Producto eliminado']);
                break;
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido para producto']);
        }
        break;

    case 'servicio':
        switch ($_method) {
            case 'GET':
                echo json_encode(['data' => $serviciosController->getServicios()]);
                break;
            case 'POST':
                if (!$body || !isset($body['titulo'], $body['descripcion'], $body['fecha'], $body['ubicacion'], $body['cupos'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Datos incompletos']);
                    break;
                }
                $serviciosController->postServicio($body['titulo'], $body['descripcion'], $body['fecha'], $body['ubicacion'], $body['cupos']);
                http_response_code(201);
                echo json_encode(['msg' => 'Servicio creado correctamente']);
                break;
            case 'PUT':
                if (!$id || !$body || !isset($body['titulo'], $body['descripcion'], $body['fecha'], $body['ubicacion'], $body['cupos'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'ID y datos completos requeridos']);
                    break;
                }
                $serviciosController->putServicio($id, $body['titulo'], $body['descripcion'], $body['fecha'], $body['ubicacion'], $body['cupos']);
                http_response_code(200);
                echo json_encode(['msg' => 'Servicio actualizado']);
                break;
            case 'PATCH':
                if (!$id || !$body || !isset($body['cupos'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'ID y cupos requeridos']);
                    break;
                }
                $serviciosController->patchServicio($id, $body['cupos']);
                http_response_code(200);
                echo json_encode(['msg' => 'Cupos actualizados']);
                break;
            case 'DELETE':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(['error' => 'ID requerido para eliminar']);
                    break;
                }
                $serviciosController->deleteServicio($id);
                http_response_code(200);
                echo json_encode(['msg' => 'Servicio eliminado']);
                break;
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido para servicio']);
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Recurso no encontrado']);
}
