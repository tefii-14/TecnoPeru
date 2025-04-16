<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listar</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">  

</head>

<body>

  <!-- ALT + SHIFT + F = ordenar código -->
  <!-- ALT + SHIFT + A = comentar código -->

  <div class="container">
    <div class="card mt-3">
      <div class="card-header">
        <div class="row">
          <div class="col"><strong>Lista de productos</strong></div>
          <div class="col text-end"><a href="registrar.php" class="btn btn-sm btn-success" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Registrar</a></div>
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
          <tbody>
            <!-- Contenido dinámico -->
          </tbody>
        </table>
      </div> <!-- ./card-body -->
    </div> <!-- ./card --> 
    <!-- Botón volver -->
    <div class="text-center mt-4">
      <?php $baseURL = ""; ?>
      <a href="<?= $baseURL ?>/index.php" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Volver al Dashboard
      </a>
    </div>

  </div> <!-- ./container -->

  <script>

    /* 
    Consideraciones
      1. Nunca devolver TODAS las filas de la tabla
      2. Mostrar solo los campos relevantes
      3. Agregar comandos(botones)
    */

    const tabla = document.querySelector("#tabla-productos tbody");
    let enlace = null;

    function obtenerDatos(){
      //fetch(URL_CONTROLADOR).then(JSON).then(DATOS).catch(ERROR)
      fetch(`../../app/controllers/ProductoController.php?task=getAll`, {
        method: 'GET'
      })
        .then(response => { return response.json() })
        .then(data => { 
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
                  <a href='editar.php?id=${element.id}' class='btn btn-sm btn-info'><i class="fa-solid fa-pen"></i> </a>
                  <a href='#' data-idproducto='${element.id}' class='btn btn-sm btn-danger delete'><i class="fa-solid fa-trash"></i> </a>
                </td>
              </tr>
            `;
          });
         })
        .catch(error => { console.error(error) });
    }

    function eliminarProducto(ideliminar ){
      fetch(`../../app/controllers/ProductoController.php/${ideliminar}`, { method: 'DELETE'})
        .then(response => { return response.json() })
        .then(data => {
          if (data.rows > 0){
            const fila = enlace.closet('tr');
            if (fila) { fila.remove(); }
          }else{
            alert("No se pudo eliminar el registro")
          }
        })
        .catch(error => { console.error(error) });
    }

    document.addEventListener("DOMContentLoaded", () => {
      //documento la pagina esta lista, renderiza los datos
      obtenerDatos()

      // ¿Se puede asociar el evento a un objeto que no existe? =>¡NO!
      // sOLUCCION => DELEGACION DE EVENTOS
      tabla.addEventListener("clik", (event) => {
        // enlace (boton eliminar)
        enlace = event.target.closest("a"); //busca la etiqueta "a" proxima
        
        if (enlace && enlace.classList.contains("delete")){
            event.preventDefault();
            const idproducto = parseInt(enlace.getAtribute("data-idproducto"));

            if (confirm("¿Esta seguro de eliminar el registro")){
              eliminarProducto(idproducto);
            }
          }
      });
    });
  </script>

</body>

</html>