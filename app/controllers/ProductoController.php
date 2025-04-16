<?php

// Habilitar CORS y definir cabeceras JSON
header('Access-Control-Allow-Origin: https://ws1438421-hxe8h7hqehh8gjac.canadacentral-01.azurewebsites.net');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=utf-8');

// Mostrar errores para debugging (desactívalo en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Manejar preflight CORS (peticiones OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit;
}

// Verificar si existe el modelo Producto
$modelPath = realpath(__DIR__ . '/../models/Producto.php');
if (!$modelPath || !file_exists($modelPath)) {
  echo json_encode(["error" => "No se encuentra Producto.php"]);
  exit;
}

require_once $modelPath;
$producto = new Producto();

$requestMethod = $_SERVER['REQUEST_METHOD'];
$task = $_GET['task'] ?? null;

switch ($requestMethod) {
  case 'GET':
    if ($task === 'getAll') {
      echo json_encode($producto->getAll());
    } elseif ($task === 'getById' && isset($_GET['idproducto'])) {
      echo json_encode($producto->getById($_GET['idproducto']));
    } else {
      echo json_encode(["error" => "Tarea GET no válida o faltan parámetros"]);
    }
    break;

  case 'POST':
    $input = json_decode(file_get_contents('php://input'), true);
    if (is_array($input)) {
      $registro = [
        'idmarca'     => htmlspecialchars($input['idmarca'] ?? ''),
        'tipo'        => htmlspecialchars($input['tipo'] ?? ''),
        'descripcion' => htmlspecialchars($input['descripcion'] ?? ''),
        'precio'      => htmlspecialchars($input['precio'] ?? ''),
        'garantia'    => htmlspecialchars($input['garantia'] ?? ''),
        'esnuevo'     => htmlspecialchars($input['esnuevo'] ?? '')
      ];
      $n = $producto->add($registro);
      echo json_encode(["rows" => $n]);
    } else {
      echo json_encode(["error" => "Datos JSON inválidos"]);
    }
    break;

  case 'DELETE':
    // Extraer ID de la URL
    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $parts = explode('/', rtrim($url, '/'));
    $idproducto = end($parts);

    if (is_numeric($idproducto)) {
      $n = $producto->delete(["idproducto" => $idproducto]);
      echo json_encode(['rows' => $n]);
    } else {
      echo json_encode(['error' => 'ID inválido']);
    }
    break;

  default:
    echo json_encode(['error' => 'Método HTTP no soportado']);
    break;
}