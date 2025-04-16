<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">  
</head>
<body>

  <div class="container">
    <div class="card mt-3">
      <div class="card-header">
        <div class="row">
          <div class="col"><strong>Lista de productos</strong></div>
          <div class="col text-end">
            <a href="registrar.php" class="btn btn-sm btn-success">Registrar</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-striped table-sm" id="tabla-productos">
          <thead>
            <tr>
              <th>ID</th>
              <th>Marca</th>
              <th>Tipo</th>
              <th>Descripción</th>
              <th>Precio</th>
              <th>Garantía</th>
              <th>Nuevo</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>

    <div class="text-center mt-4">
      <?php $baseURL = ""; ?>
      <a href="<?= $baseURL ?>/index.php" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Volver al Dashboard
      </a>
    </div>
  </div>

  <script>
    const tabla = document.querySelector("#tabla-productos tbody");
    let enlace = null;

    function obtenerDatos() {
      fetch(`../../app/controllers/ProductoController.php?task=getAll`)
        .then(response => response.json())
        .then(data => {
          tabla.innerHTML = ""; // Limpiar contenido anterior
          if (Array.isArray(data)) {
            data.forEach(element => {
              tabla.innerHTML += `
                <tr>
                  <td>${element.id}</td>
                  <td>${element.marca}</td>
                  <td>${element.tipo}</td>
                  <td>${element.descripcion}</td>
                  <td>${element.precio}</td>
                  <td>${element.garantia}</td>
                  <td>${element.esnuevo}</td>
                  <td>
                    <a href='editar.php?id=${element.id}' class='btn btn-sm btn-info'>
                      <i class="fa-solid fa-pen"></i>
                    </a>
                    <a href='#' data-idproducto='${element.id}' class='btn btn-sm btn-danger delete'>
                      <i class="fa-solid fa-trash"></i>
                    </a>
                  </td>
                </tr>
              `;
            });
          } else {
            tabla.innerHTML = "<tr><td colspan='8'>No hay productos disponibles.</td></tr>";
          }
        })
        .catch(error => {
          console.error("Error al obtener productos:", error);
        });
    }

    function eliminarProducto(idEliminar) {
      fetch(`../../app/controllers/ProductoController.php/${idEliminar}`, {
        method: 'DELETE'
      })
        .then(response => response.json())
        .then(data => {
          if (data.rows > 0) {
            const fila = enlace.closest('tr');
            if (fila) fila.remove();
          } else {
            alert("No se pudo eliminar el registro");
          }
        })
        .catch(error => {
          console.error("Error al eliminar producto:", error);
        });
    }

    document.addEventListener("DOMContentLoaded", () => {
      obtenerDatos();

      tabla.addEventListener("click", (event) => {
        enlace = event.target.closest("a");

        if (enlace && enlace.classList.contains("delete")) {
          event.preventDefault();
          const idproducto = parseInt(enlace.getAttribute("data-idproducto"));

          if (confirm("¿Está seguro de eliminar el registro?")) {
            eliminarProducto(idproducto);
          }
        }
      });
    });
  </script>

</body>
</html>