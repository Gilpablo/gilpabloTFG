<?php require_once RUTA_APP.'/vistas/inc/header.php' ?>

<?php 
    // print_r($datos['zapatosSubcategoria']);
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
            <li class="breadcrumb-item active" aria-current="page">Zapatos</li>
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
            <h1 class="mb-3 text-primary text-center">ZAPATOS</h1>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form class="input-group" method="GET" action="">
                    <div class="input-group pb-2">
                        <div class="input-group-prepend">
                            <button class="btn btn-success btn-lg" type="button" data-bs-toggle="modal" data-bs-target="#addZapato">Añadir Zapato</button>
                        </div>
                        <input type="text" class="form-control" id="busqueda" name="busqueda" placeholder="Buscar...">
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-lg" type="submit" >Buscar</button>
                        </div>
                        <div class="input-group-append">
                            <a href="<?php echo RUTA_URL ?>/zapato" class="btn btn-warning btn-lg" ><i class="bi bi-arrow-repeat"></i></a>
                        </div>
                    </div>
                    <!-- <input type="hidden" id="resultados" name="resultados" value=""> -->

                    <div class="form-group">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropSubcat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Elige subcategoria...
                            </button>
                            <div class="dropdown-menu" id="subcat" style="display: none;">
                                <?php foreach ($datos['zapatosSubcategoria'] as $zapatosSubcategoria) : ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="<?php echo $zapatosSubcategoria->id ?>" value="<?php echo $zapatosSubcategoria->id ?>" 
                                        name="filtros[]" <?php if (isset($_GET['filtros']) && in_array($zapatosSubcategoria->id, $_GET['filtros'])) { echo 'checked'; } ?>>
                                        <label class="form-check-label" for="<?php echo $zapatosSubcategoria->id ?>"><?php echo $zapatosSubcategoria->nombre ?></label>
                                    </div>    
                                <?php endforeach?>
                                <button class="btn btn-primary" type="submit">Filtrar</button>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="form-group">
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
                    </div> -->
                    
                </form>

            </div>
        </div>


        <?php 

        // if (!empty($_GET['resultados'])) {
        //     $datos['zapatosPrenda'] = json_decode($_GET['resultados']);
        // }


        $totalElementos = count($datos['zapatosPrenda']);
        $elementosPorPagina = 3;
        $totalPaginas = ceil($totalElementos / $elementosPorPagina);

        $paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
        
        $indiceInicial = ($paginaActual - 1) * $elementosPorPagina;
        $indiceFinal = $indiceInicial + $elementosPorPagina - 1;
        
        for ($i = $indiceInicial; $i <= $indiceFinal && $i < $totalElementos; $i++) {
            $zapatosPrenda = $datos['zapatosPrenda'][$i]; ?>
            
            
            <div class="col-12 col-md-6 col-lg-4 pt-5">
                <a href="<?php echo RUTA_URL ?>/zapato/ver_zapato/<?php echo $zapatosPrenda->id ?>" style="text-decoration: none;">
                    <div class="card my-3" style="background-color: #545454;">
                        <img id="imgPrendas" style="height: 400px;" src="<?php echo RUTA_URL?>/img_prendas/<?php echo $zapatosPrenda->id.$zapatosPrenda->imagen ?>.png" class="card-image-top" alt="thumbnail">
                        <div class="card-body">
                            <h4 class="card-title" style="color: #A6A6A6;"><?php echo $zapatosPrenda->nombre ?></h4>
                            <p class="card-text">
                                <h5 style="color: #EDD0BA;"><?php echo $zapatosPrenda->marca?></h5>
                                <?php foreach ($datos['zapatosSubcategoria'] as $zapatosSubcategoria) {
                                    if ($zapatosPrenda->id_subcategoria == $zapatosSubcategoria->id) {
                                        echo "<h6 style='color: #F6F0EB;'>".$zapatosSubcategoria->nombre."</h6>";
                                    }
                                } ?>
                            </p>
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

        
        
        
        <div class="modal fade" id="addZapato" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modaladdZapatoLabel">
                            AÑADIR ZAPATO
                        </h5>
                    </div>
                    
                    <form method="post" enctype="multipart/form-data">

                        <div class="modal-body">

                            <div class="container">

                                <div class="row">

                                        <div class="col-6">
                                            <label for="nombre" style="font-weight: bold; color: #333;">Nombre</label>
                                            <input type="text" class="form-control" name="nombreZapato" id="nombreZapato" placeholder="Ingresa el nombre">
                                        </div>
                                        <div class="col-6">
                                            <label for="talla" style="font-weight: bold; color: #333;">Talla</label>
                                            <input type="text" class="form-control" name="tallaZapato" id="tallaZapato" placeholder="Ingresa la talla">
                                        </div>
                                        <div class="col-6">
                                            <label for="color" style="font-weight: bold; color: #333;">Color</label>
                                            <input type="text" class="form-control" name="colorZapato" id="colorZapato" placeholder="Ingresa el color">
                                        </div>
                                        <div class="col-6">
                                            <label for="marca" style="font-weight: bold; color: #333;">Marca</label>
                                            <input type="text" class="form-control" name="marcaZapato" id="marcaZapato" placeholder="Ingresa la marca">
                                        </div>
                                        <div class="col-12">
                                            <label for="descripcion" style="font-weight: bold; color: #333;">Descripcion</label>
                                            <input type="text" class="form-control" name="descripcionZapato" id="descripcionZapato" placeholder="Descripcion...">
                                        </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="checkboxes" style="font-weight: bold; color: #333;">Elige temporada o temporadas:</label>
                                            <?php foreach ($datos["temporadas"] as $temporada) : ?>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="temporada-<?php echo $temporada->id ?>" name="temporadas[]" value="<?php echo $temporada->id ?>">
                                                    <label class="form-check-label" for="temporada-<?php echo $temporada->id ?>"><?php echo $temporada->nombre ?></label>
                                                </div>
                                            <?php endforeach ?>
                                        </div>
                                    </div>

                                    <div class="col-6 pt-1">
                                        <select name="subcategoriaZapato" id="subcategoriaZapato" class="form-control">
                                            <option value="0">Elige subcategoría...</option>
                                            <?php foreach ($datos['zapatosSubcategoria'] as $zapatosSubcategoria) : ?>
                                                <option value="<?php echo $zapatosSubcategoria->id ?>"><?php echo $zapatosSubcategoria->nombre ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>

                                    
                                    <div class="col-6">
                                        <label for="imagenZapato" style="font-weight: bold; color: #333;">Cargar imagen</label>
                                        <input type="file" class="form-control-file" name="imagenZapato" id="imagenZapato" style="border: 1px solid #ccc; padding: 5px; width: 100%;">
                                    </div>


                                    <div class="col-6">
                                        <label for="fecha_insercionZapato" style="font-weight: bold; color: #333;">Fecha Adquisición</label>
                                        <input type="date" class="form-control" id="fecha_insercionZapato" name="fecha_insercionZapato">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" 
                                data-bs-dismiss="modal">Cancelar
                            </button>
                            <button type="submit" class="btn btn-success" data-bs-dismiss="modal">
                                Añadir
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>


        
            
    </div>
    
</div>



<script>

    var subcat = document.getElementById("subcat");
    var dropSubcat = document.getElementById("dropSubcat");

    dropSubcat.addEventListener('click', function() {
        if (subcat.style.display === 'block') {
            subcat.style.display = 'none';
        } else {
            subcat.style.display = 'block';
        }
    });

    // var temp = document.getElementById("temp");
    // var dropTemp = document.getElementById("dropTemp");

    // dropTemp.addEventListener('click', function() {
    //     if (temp.style.display === 'block') {
    //         temp.style.display = 'none';
    //     } else {
    //         temp.style.display = 'block';
    //     }
    // });

    // function realizarBusqueda() {
        
    //     // Obtener el valor de búsqueda
    //     var busqueda = document.getElementById('busqueda').value;

    //     // Obtener los datos de zapatos desde PHP y convertirlos en un array JavaScript
    //     var arrayDatos = <?php echo json_encode($datos["zapatosPrenda"]); ?>;
        
    //     // Realizar la lógica de búsqueda
    //     var resultados = arrayDatos.filter(function(zapato) {
    //         // Aplicar los criterios de búsqueda
    //         return zapato.nombre.toLowerCase().includes(busqueda.toLowerCase())
    //             || zapato.descripcion.toLowerCase().includes(busqueda.toLowerCase())
    //             || zapato.talla.toLowerCase().includes(busqueda.toLowerCase())
    //             || zapato.color.toLowerCase().includes(busqueda.toLowerCase())
    //             || zapato.marca.toLowerCase().includes(busqueda.toLowerCase())
    //             || zapato.imagen.toLowerCase().includes(busqueda.toLowerCase());
    //     });
        
    //     // Actualizar el campo oculto con los resultados de búsqueda
    //     document.getElementById('resultados').value = JSON.stringify(resultados);
        
    //     // Enviar el formulario para actualizar el array $datos["zapatosPrenda"]
    //     document.forms[0].submit();
    // }


</script>

<?php require_once RUTA_APP.'/vistas/inc/footer.php' ?>

