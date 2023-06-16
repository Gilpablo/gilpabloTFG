<?php require_once RUTA_APP.'/vistas/inc/header.php' ?>

<div class="container">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo RUTA_URL ?>">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Historial de Uso</li>
        </ol>
    </nav>
    

    <div class="row">
        <div class="col-12">
            <h1 class="mb-3 text-primary text-center">HISTORIAL DE USO</h1>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form class="input-group" method="GET" action="">
                    <div class="input-group pb-2">
                        <input type="text" class="form-control" id="busqueda" name="busqueda" placeholder="Buscar...">
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-lg" type="submit" >Buscar</button>
                        </div>
                        <div class="input-group-append">
                            <a href="<?php echo RUTA_URL ?>/historialUso" class="btn btn-warning btn-lg" ><i class="bi bi-arrow-repeat"></i></a>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropTemp" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Elige temporada...
                            </button>
                            <div class="dropdown-menu" id="temp" style="display: none;">
                                <?php foreach ($datos['temporadas'] as $temporada) : ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="<?php echo $temporada->id ?>" value="<?php echo $temporada->id ?>" 
                                        name="filtros[]" <?php if (isset($_GET['filtros']) && in_array($temporada->id, $_GET['filtros'])) { echo 'checked'; } ?>>
                                        <label class="form-check-label" for="<?php echo $temporada->id ?>"><?php echo $temporada->nombre ?></label>
                                    </div>  
                                <?php endforeach?>
                                <button class="btn btn-primary" type="submit">Filtrar</button>
                            </div>
                        </div>
                    </div>
                    
                </form>

            </div>
        </div>


        <table class="table table-hover mt-5">
            <thead>
                <tr>
                <!-- <th scope="col">#</th> -->
                <th scope="col">Evento Uso</th>
                <th scope="col">Última Fecha Uso</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripción</th>
                <th scope="col">Fecha Creación</th>
                <th scope="col" class="text-center">Ver artículo</th>
                </tr>
            </thead>
            <tbody>
                
            
        <?php 

        $totalElementos = count($datos['conjuntosHistorial']);
        $elementosPorPagina = 10;
        $totalPaginas = ceil($totalElementos / $elementosPorPagina);

        $paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
        
        $indiceInicial = ($paginaActual - 1) * $elementosPorPagina;
        $indiceFinal = $indiceInicial + $elementosPorPagina - 1;
        
        for ($i = $indiceInicial; $i <= $indiceFinal && $i < $totalElementos; $i++) {
            $conjuntosHistorial = $datos['conjuntosHistorial'][$i]; ?>
            
            <tr>
                <!-- <th scope="row">1</th> -->
                <td><?php echo $conjuntosHistorial->evento_dia ?></td>
                <td><?php echo $conjuntosHistorial->fecha ?></td>
                <td><?php echo $conjuntosHistorial->nombre ?></td>
                <td><?php echo $conjuntosHistorial->descripcion ?></td>
                <td><?php echo $conjuntosHistorial->fecha_creacion ?></td>
                <td class="text-center"><a class="btn btn-outline-success" href="<?php echo RUTA_URL ?>/conjunto/ver_conjunto/<?php echo $conjuntosHistorial->id_conjunto ?>"><i class="bi bi-eye"></i></a>
                <a class="btn btn-outline-danger" href="<?php echo RUTA_URL ?>/historialUso/borrar_historial/<?php echo $conjuntosHistorial->id_historial?>"><i class="bi bi-trash-fill"></i></a>
                </td>
            </tr>

        <?php } ?>
            </tbody>
        </table>
        <?php if ($totalPaginas > 1) { // Agregar esta condición para mostrar la paginación solo si hay más de una página
            ?>
            <div class="paginacion">
                <?php for ($i = 1; $i <= $totalPaginas; $i++) {
                    // Construir los parámetros de la URL
                    $parametrosURL = $_GET; // Obtener los parámetros actuales
                    $parametrosURL['pagina'] = $i; // Agregar el parámetro de la página

                    $url = '?' . http_build_query($parametrosURL); // Construir la URL con los parámetros

                    // Generar el enlace de paginación
                    ?>
                    <a href="<?php echo $url; ?>" <?php if ($i == $paginaActual) { echo 'class="active"'; } ?>>
                        <?php echo $i; ?>
                    </a>
                <?php } ?>
            </div>
        <?php } ?>
            
    </div>
    
</div>



<script>

    var temp = document.getElementById("temp");
    var dropTemp = document.getElementById("dropTemp");

    dropTemp.addEventListener('click', function() {
        if (temp.style.display === 'block') {
            temp.style.display = 'none';
        } else {
            temp.style.display = 'block';
        }
    });

</script>

<?php require_once RUTA_APP.'/vistas/inc/footer.php' ?>

