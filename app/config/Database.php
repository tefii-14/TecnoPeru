<?php

class Database {

  // Parámetros de conexión
  private static string $host     = "localhost";
  private static string $dbname   = "tecnoperu";
  private static string $username = "root";
  private static string $password = "";
  private static string $charset  = "utf8mb4";
  private static ?PDO $conexion   = null; // Objeto de conexión (tipo seguro)

  // Método estático para obtener conexión
  public static function getConexion(): PDO {
    if (self::$conexion === null) {
      try {
        $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=" . self::$charset;
        $opciones = [
          PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        self::$conexion = new PDO($dsn, self::$username, self::$password, $opciones);

      } catch (PDOException $e) {
        throw new Exception("Error al conectar a la base de datos: " . $e->getMessage());
      }
    }

    return self::$conexion;
  }

  // Método para cerrar la conexión
  public static function desconectar(): void {
    self::$conexion = null;
  }

}