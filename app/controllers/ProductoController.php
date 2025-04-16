<?php

if (isset($_SERVER['REQUEST_METHOD'])) {

  // CORS y configuración de errores
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: POST, GET, DELETE, OPTIONS');
  header('Access-Control-Allow-Headers: Content-Type');
  header('Content-Type: application/json; charset=utf-8');

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  // Validar que el archivo exista
  if (!file_exists("../models/Producto.php")) {
    echo json_encode(["error" => "No se encuentra Producto.php"]);
    exit;
  }

  require_once "../models/Producto.php";
  $producto = new Producto();

  switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
      if ($_GET['task'] == 'getAll') { echo json_encode($producto->getAll()); }
      if ($_GET['task'] == 'getById') { echo json_encode($producto->getById($_GET['idproducto'])); }
      break;

    case 'POST':
      $input = file_get_contents('php://input');
      $dataJSON = json_decode($input, true);

      $registro = [
        'idmarca'     => htmlspecialchars($dataJSON['idmarca']),
        'tipo'        => htmlspecialchars($dataJSON['tipo']),
        'descripcion' => htmlspecialchars($dataJSON['descripcion']),
        'precio'      => htmlspecialchars($dataJSON['precio']),
        'garantia'    => htmlspecialchars($dataJSON['garantia']),
        'esnuevo'     => htmlspecialchars($dataJSON['esnuevo'])
      ];

      $n = $producto->add($registro);
      echo json_encode(["rows" => $n]);
      break;

    case "DELETE":
      $url = $_SERVER['REQUEST_URI'];
      $arrayUrl = explode('/', $url);
      $id = end($arrayUrl);

      $n = $producto->delete(["idproducto" => $id]);
      echo json_encode(['rows' => $n]);
      break;
  }

}
