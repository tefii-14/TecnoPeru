// Detecta automáticamente si estás en local o Azure
const BASE_URL = window.location.hostname.includes("localhost")
  ? "http://localhost/tecnoperu/app/controllers/ProductoController.php"
  : "https://ws1438421-hxe8h7hqehh8gjac.canadacentral-01.azurewebsites.net/app/controllers/ProductoController.php";
