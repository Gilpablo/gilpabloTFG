<?php require_once RUTA_APP.'/vistas/inc/header.php' ?>

<?php 
    // print_r($datos['conjuntosSubcategoria']);
    // print_r($datos['filtro']);
    // if (!isset($datos['filtro']['estado'])){
    //     $datos['filtro']['estado'] = array_column($datos['estados'], 'id_estado');
    //     print_r($datos['filtro']);
    //     // exit();
    // }
?>

<div class="container">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo RUTA_URL ?>">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Conjuntos</li>
        </ol>
    </nav>

    <?php if (isset($datos['error']) && $datos['error'] == 'error_1' ): ?>
        <div class="alert alert-danger" role="alert">
            ERROR AL GUARDAR LOS DATOS !!!
        </div>
    <?php elseif ($datos['error'] == 'error_2') :?>
        <div class="alert alert-danger" role="alert">
            ERROR AL GUARDAR LA IMAGEN !!!
        </div>
    <?php elseif ($datos['error'] == 'creado') :?>
        <div class="alert alert-success" role="alert">
            GUARDADO CORRECTAMENTE !!!
        </div>
    <?php elseif ($datos['error'] == 'error_3') :?>
        <div class="alert alert-danger" role="alert">
            ERROR AL BORRAR !!!
        </div>
    <?php elseif ($datos['error'] == 'borrado') :?>
        <div class="alert alert-success" role="alert">
            BORRADO CORRECTAMENTE !!!
        </div>
    <?php endif ?>
    

    <div class="row">
        <div class="col-12">
            <h1 class="mb-3 text-primary text-center">CONJUNTOS</h1>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form class="input-group" method="GET" action="">
                    <div class="input-group pb-2">
                        <div class="input-group-prepend">
                            <a href="<?php echo RUTA_URL ?>/conjunto/add_conjunto" class="btn btn-success btn-lg" type="button">Añadir Conjunto</a>
                        </div>
                        <input type="text" class="form-control" id="busqueda" name="busqueda" placeholder="Buscar...">
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-lg" type="submit" >Buscar</button>
                        </div>
                        <div class="input-group-append">
                            <a href="<?php echo RUTA_URL ?>/conjunto" class="btn btn-warning btn-lg" ><i class="bi bi-arrow-repeat"></i></a>
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
                                        <input class="form-check-input" type="checkbox" id="<?php echo $temporada->id ?>" name="filtros[]" value="<?php echo $temporada->id ?>">
                                        <label class="form-check-label" for="<?php echo $temporada->id ?>"><?php echo $temporada->nombre ?></label>
                                    </div>    
                                <?php endforeach?>
                                <button class="btn btn-primary" name="temp" type="submit">Filtrar</button>
                            </div>
                        </div>
                    </div>
                    
                </form>

            </div>
        </div>


        <?php 

        // if (!empty($_GET['resultados'])) {
        //     $datos['conjuntosPrenda'] = json_decode($_GET['resultados']);
        // }


        $totalElementos = count($datos['conjuntosPrenda']);
        $elementosPorPagina = 9;
        $totalPaginas = ceil($totalElementos / $elementosPorPagina);

        $paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
        
        $indiceInicial = ($paginaActual - 1) * $elementosPorPagina;
        $indiceFinal = $indiceInicial + $elementosPorPagina - 1;
        
        for ($i = $indiceInicial; $i <= $indiceFinal && $i < $totalElementos; $i++) {
            $conjuntosPrenda = $datos['conjuntosPrenda'][$i]; ?>
            
            
            <div class="col-12 col-md-6 col-lg-4 pt-5">
                <a href="<?php echo RUTA_URL ?>/conjunto/ver_conjunto/<?php echo $conjuntosPrenda->id ?>" style="text-decoration: none;">
                    <div class="card my-3" style="background-color: #545454;">
                        <img id="imgPrendas" style="height: 400px;" src="<?php echo RUTA_URL?>/img_conjuntos/<?php echo $conjuntosPrenda->id.$conjuntosPrenda->imagen_conjunto ?>.png" class="card-image-top" alt="thumbnail">
                        <div class="card-body">
                            <h4 class="card-title" style="color: #A6A6A6;"><?php echo $conjuntosPrenda->nombre ?></h4>
                            
                        </div>
                    </div>
                </a>
            </div>


        <?php } ?>
        
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

