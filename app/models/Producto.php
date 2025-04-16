<?php

require_once "../config/Database.php";

class Producto {

  private $conexion;

  public function __construct() {
    $this->conexion = Database::getConexion();
  }

  public function getAll(): array {
    try {
      $sql = "SELECT * FROM vs_productos_todos ORDER BY id";
      $stmt = $this->conexion->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Error al obtener productos: " . $e->getMessage());
    }
  }

  public function getById($id): array {
    try {
      $sql = "SELECT * FROM productos WHERE id = ?";
      $stmt = $this->conexion->prepare($sql);
      $stmt->execute([$id]);
      return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    } catch (PDOException $e) {
      throw new Exception("Error al obtener producto por ID: " . $e->getMessage());
    }
  }

  public function add(array $params): int {
    try {
      $sql = "INSERT INTO productos (idmarca, tipo, descripcion, precio, garantia, esnuevo) 
              VALUES (:idmarca, :tipo, :descripcion, :precio, :garantia, :esnuevo)";
      $stmt = $this->conexion->prepare($sql);
      $stmt->execute([
        ':idmarca'     => $params['idmarca'],
        ':tipo'        => $params['tipo'],
        ':descripcion' => $params['descripcion'],
        ':precio'      => $params['precio'],
        ':garantia'    => $params['garantia'],
        ':esnuevo'     => $params['esnuevo']
      ]);
      return $stmt->rowCount();
    } catch (PDOException $e) {
      throw new Exception("Error al insertar producto: " . $e->getMessage());
    }
  }

  public function delete(array $params): int {
    try {
      $sql = "DELETE FROM productos WHERE id = :idproducto";
      $stmt = $this->conexion->prepare($sql);
      $stmt->execute([':idproducto' => $params['idproducto']]);
      return $stmt->rowCount();
    } catch (PDOException $e) {
      throw new Exception("Error al eliminar producto: " . $e->getMessage());
    }
  }

  public function edit(array $params): int {
    // Placeholder para futura implementación
    return 0;
  }
}