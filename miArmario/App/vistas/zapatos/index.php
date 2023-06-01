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

    <!-- <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo RUTA_URL ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Asesorias</li>
        </ol>
    </nav> -->
    <!-- <?php echo RUTA_PUBLIC; ?>  -->

    <?php if (isset($datos['error']) && $datos['error'] == 'error_1' ): ?>
        <div class="alert alert-danger" role="alert">
            ERROR AL GUARDAR LOS DATOS !!!
        </div>
    <?php elseif ($datos['error'] == 'error_2') :?>
        <div class="alert alert-success" role="alert">
        ERROR AL GUARDAR LA IMAGEN !!!
        </div>
    <?php elseif ($datos['error'] == 'creado') :?>
        <div class="alert alert-success" role="alert">
            GUARDADO CORRECTAMENTE !!!
        </div>
    <?php endif ?>

    <div class="row">
        <div class="col-12">
            <h1 class="mb-3 text-primary text-center">ZAPATOS</h1>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form class="input-group" method="GET" action="">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#addZapato">Añadir Zapato</button>
                        </div>
                        <input type="text" class="form-control" id="busqueda" name="busqueda" placeholder="Buscar...">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Buscar</button>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Elige subcategoria...
                            </button>
                            <div class="dropdown-menu" id="subcat" style="display: none;">
                                <?php foreach ($datos['zapatosSubcategoria'] as $zapatosSubcategoria) : ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="<?php echo $zapatosSubcategoria->id ?>" name="zapatosSubcategorias[]" value="<?php echo $zapatosSubcategoria->id ?>">
                                        <label class="form-check-label" for="<?php echo $zapatosSubcategoria->id ?>"><?php echo $zapatosSubcategoria->nombre ?></label>
                                    </div>    
                                <?php endforeach?>
                            </div>
                        </div>
                    </div>
                    
                </form>

            </div>
        </div>


        <?php 

        // $totalElementos = count($datos['zapatosPrenda']);
        // $elementosPorPagina = 1;
        // $totalPaginas = ceil($totalElementos / $elementosPorPagina);

        // $paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
        
        // $indiceInicial = ($paginaActual - 1) * $elementosPorPagina;
        // $indiceFinal = $indiceInicial + $elementosPorPagina - 1;
        
        // for ($i = $indiceInicial; $i <= $indiceFinal && $i < $totalElementos; $i++) {
            // $zapatosPrenda = $datos['zapatosPrenda'][$i]; 
            
            
            foreach ($datos['zapatosPrenda'] as $zapatosPrenda) : ?>
            
            
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card my-3">
        
                    <img src="<?php echo RUTA_URL?>/img_prendas/<?php echo $zapatosPrenda->id.$zapatosPrenda->imagen
                    ?>.png" class="card-image-top" alt="thumbnail">
        
                    <div class="card-body">
                        <h3 class="card-title"><a href="#" class="text-secondary"><?php echo $zapatosPrenda->nombre ?></a></h3>
                        <p class="card-text"><?php foreach ($datos['zapatosSubcategoria'] as $zapatosSubcategoria) {
                                    if ($zapatosPrenda->id_subcategoria == $zapatosSubcategoria->id) {
                                        echo "<h5>".$zapatosSubcategoria->nombre."</h5>";
                                    }
                                }
                                echo $zapatosPrenda->descripcion;
                            ?>

                        </p>
                        <a href="#" class="btn btn-primary"></a>
                    </div>
                </div>
            </div>
        <?php endforeach // } ?>

        <nav aria-label="Paginacion">
            <ul class="pagination py-3" id="ulPaginacion">

            </ul>
        </nav>
        
        <!-- <div class="paginacion">
            <?php
            // for ($i = 1; $i <= $totalPaginas; $i++) { ?>
                <a href="?pagina=<?php echo $i; ?>" 
                    <?php if ($i == $paginaActual){
                        echo 'class="active"';
                        } ?>>
                        <?php echo $i; ?>
                </a>
            <?php //} ?>
        </div> -->
        
        
        
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
                                            <label for="nombre">Nombre</label>
                                            <input type="text" class="form-control" name="nombreZapato" id="nombreZapato" placeholder="Ingresa el nombre">
                                        </div>
                                        <div class="col-6">
                                            <label for="talla">Talla</label>
                                            <input type="text" class="form-control" name="tallaZapato" id="tallaZapato" placeholder="Ingresa la talla">
                                        </div>
                                        <div class="col-6">
                                            <label for="color">Color</label>
                                            <input type="text" class="form-control" name="colorZapato" id="colorZapato" placeholder="Ingresa el color">
                                        </div>
                                        <div class="col-6">
                                            <label for="marca">Marca</label>
                                            <input type="text" class="form-control" name="marcaZapato" id="marcaZapato" placeholder="Ingresa la marca">
                                        </div>
                                        <div class="col-12">
                                            <label for="descripcion">Descripcion</label>
                                            <input type="text" class="form-control" name="descripcionZapato" id="descripcionZapato" placeholder="Descripcion...">
                                        </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="checkboxes">Elige temporada o temporadas:</label>
                                            <?php foreach ($datos["temporadas"] as $temporada) : ?>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="temporada-<?php echo $temporada->id ?>" name="temporadas[]" value="<?php echo $temporada->id ?>">
                                                    <label class="form-check-label" for="temporada-<?php echo $temporada->id ?>"><?php echo $temporada->nombre ?></label>
                                                </div>
                                            <?php endforeach ?>
                                        </div>

                                    </div>
                                    <div class="col-6">
                                        <select name="subcategoriaZapato" id="subcategoriaZapato">
                                            <option value="0">Elige subcategoria...</option>
                                            <?php foreach ($datos['zapatosSubcategoria'] as $zapatosSubcategoria) : ?>
                                                <option value="<?php echo $zapatosSubcategoria->id?>"><?php echo $zapatosSubcategoria->nombre?></option>
                                            <?php endforeach?> 
                                        </select>

                                    </div>
                                    
                                    
                                    <div class="col-12">
                                        <label for="imagenZapato">Cargar imagen</label>
                                        <input type="file" class="form-control-file" name="imagenZapato" id="imagenZapato">
                                        
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
    var dropdownButton = document.getElementById("dropdownMenuButton");

    dropdownButton.addEventListener('click', function() {
        if (subcat.style.display === 'block') {
            subcat.style.display = 'none';
        } else {
            subcat.style.display = 'block';
        }
    });


    let elementosPorPagina = 9;
    let paginas;

    function setPaginaActiva(pagina) {
        pagina > 0 ? paginaActiva = pagina : paginaActiva = 1;
        pagina <= paginas ? paginaActiva = pagina : paginaActiva = paginas;
        dibujarPaginacion();
    }
    
    dibujarPaginacion();
    
    function dibujarPaginacion() {

        let ulPaginacion = document.getElementById("ulPaginacion");
        let vPaginas = [];

        var vZapatos = <?php echo json_encode($datos["zapatosPrenda"])?>;

        /* Calcula el número de páginas que tendrá la tabla a partir del número de registros y el número de elementos por página */
        if (typeof (vUsers) !== 'undefined') {
            paginas = Math.ceil(vUsers.length / elementosPorPagina)
        }
        if (typeof (vEmps) !== 'undefined') {
            paginas = Math.ceil(vEmps.length / elementosPorPagina)
        }
        if (typeof (vZapatos) !== 'undefined') {
            paginas = Math.ceil(vZapatos.length / elementosPorPagina)
        }
        if (typeof (vRecs) !== 'undefined') {
            paginas = Math.ceil(vRecs.length / elementosPorPagina)
        }
        if (typeof (vPrems) !== 'undefined') {
            paginas = Math.ceil(vPrems.length / elementosPorPagina)
        }

        /* Reinicia el contenido de la paginación */
        ulPaginacion.innerHTML = "";

        /* BOTÓN PRIMERA PÁGINA */
        let liPrimera = document.createElement("li");
        let buttonPrimera = document.createElement("a");
        let spanPrimera = document.createElement("span");
        liPrimera.setAttribute("class", paginaActiva <= 0 ? "page-item disabled" : "page-item");
        liPrimera.setAttribute("onclick", `setPaginaActiva(${0})`);
        buttonPrimera.setAttribute("class", "page-link color-principal");
        buttonPrimera.setAttribute("aria-label", "Anterior");
        buttonPrimera.setAttribute("onclick", `actualizarURL("pag", ${(1)})`);
        buttonPrimera.style = "cursor: pointer;";
        spanPrimera.setAttribute("aria-hidden", "true");
        spanPrimera.innerHTML = "Primera";
        buttonPrimera.appendChild(spanPrimera);
        liPrimera.appendChild(buttonPrimera);

        /* BOTÓN ÚLTIMA PÁGINA */
        let liUltima = document.createElement("li");
        let buttonUltima = document.createElement("a");
        let spanUltima = document.createElement("span");
        liUltima.setAttribute("class", paginaActiva == paginas - 1 ? "page-item disabled" : "page-item");
        liUltima.setAttribute("onclick", `setPaginaActiva(${paginas-1})`);
        buttonUltima.setAttribute("class", "page-link color-principal");
        buttonUltima.setAttribute("aria-label", "Anterior");
        buttonUltima.setAttribute("onclick", `actualizarURL("pag", ${paginas})`);
        buttonUltima.style = "cursor: pointer;";
        spanUltima.setAttribute("aria-hidden", "true");
        spanUltima.innerHTML = "Última";
        buttonUltima.appendChild(spanUltima);
        liUltima.appendChild(buttonUltima);

        /* BOTÓN PÁGINA ANTERIOR */
        let liAnterior = document.createElement("li");
        let buttonAnterior = document.createElement("a");
        let spanAnterior = document.createElement("span");
        liAnterior.setAttribute("class", paginaActiva <= 0 ? "page-item disabled" : "page-item");
        liAnterior.setAttribute("onclick", `setPaginaActiva(${paginaActiva - 1})`);
        buttonAnterior.setAttribute("class", "page-link color-principal");
        buttonAnterior.setAttribute("aria-label", "Anterior");
        // buttonAnterior.setAttribute("href", "#");
        buttonAnterior.setAttribute("onclick", `actualizarURL("pag", ${paginaActiva})`);
        buttonAnterior.style = "cursor: pointer;";
        spanAnterior.setAttribute("aria-hidden", "true");
        spanAnterior.innerHTML = "&laquo;";
        buttonAnterior.appendChild(spanAnterior);
        liAnterior.appendChild(buttonAnterior);

        /* BOTÓN PÁGINA SIGUIENTE */
        let liSiguiente = document.createElement("li");
        let buttonSiguiente = document.createElement("a");
        let spanSiguiente = document.createElement("span");
        liSiguiente.setAttribute("class", paginaActiva + 1 >= paginas ? `page-item disabled` : `page-item`);
        liSiguiente.setAttribute("onclick", `setPaginaActiva(${paginaActiva + 1})`);
        buttonSiguiente.setAttribute("class", `page-link color-principal`);
        buttonSiguiente.setAttribute("onclick", `actualizarURL("pag", ${paginaActiva+2})`);
        buttonSiguiente.style = "cursor: pointer;";
        buttonSiguiente.setAttribute("aria-label", "Siguiente");
        spanSiguiente.setAttribute("aria-hidden", "true");
        spanSiguiente.innerHTML = "&raquo;";
        buttonSiguiente.appendChild(spanSiguiente);
        liSiguiente.appendChild(buttonSiguiente);

        
            if (paginaActiva == 0 || paginaActiva == (paginas-1)) {
                $numPags = 4;
            }else if (paginaActiva == 1 || paginaActiva == (paginas-2)) {
                $numPags = 3;
            }
            else if (paginaActiva >= 2 || paginaActiva <= (paginas-3)) {
                $numPags = 2;
            }
            
            for (let i = paginaActiva - $numPags; i <= paginaActiva + $numPags; i++) {
                if (i >= 0 && i < paginas) {
                    let li = document.createElement("li");
                    li.setAttribute("onclick", `setPaginaActiva(${i})`);
                    li.setAttribute("class", paginaActiva == i ? "page-item active" : "page-item color-principal");
                    let button = document.createElement(paginaActiva == i ? "span" : "a");
                    button.setAttribute("class", `page-link color-principal ${(paginaActiva == i ? `paginaSeleccionada` : ``)}`);
                    // button.setAttribute("onclick", `setPaginaActiva(${i})`);
                    button.setAttribute("aria-label", i + 1);
                    // button.setAttribute("href", `#`);
                    button.setAttribute("onclick", `actualizarURL("pag", ${i+1})`);
                    button.style = "cursor: pointer;";
                    let span = document.createElement("span");
                    span.setAttribute("aria-hidden", "true");
                    span.appendChild(document.createTextNode(`${i + 1}`));
                    button.appendChild(span);
                    li.appendChild(button);
                    //vPaginas.push(li);
                    if (paginas - i >= 2 || i - 0 >= 1) {
                        vPaginas.push(li);
                    }
                }
            }
        
        
        /* Insertar números de página */
        if (paginaActiva > 0) {
            if (paginaActiva > 1) {
                ulPaginacion.appendChild(liPrimera);
            }
            ulPaginacion.appendChild(liAnterior);
        }

        vPaginas.forEach(pagina => {
            ulPaginacion.appendChild(pagina);
        });

        if (paginaActiva < paginas - 1) {
            ulPaginacion.appendChild(liSiguiente);

            if (paginaActiva < paginas - 2) {
                ulPaginacion.appendChild(liUltima);
            }
        }

        actualizarURL("pag", parseInt(paginaActiva) + 1);
    }

    // var arrayDatos = <?php echo json_encode($datos["zapatosPrenda"])?>;

    // console.log(arrayDatos);

    // function buscar() {
    //     var buscado = document.getElementById('busqueda');
    //     var filtroBusqueda = buscado.value.toLowerCase();
    //     var resultados = [];

    //     for (var i = 0; i < arrayDatos.length; i++) {
    //         var datos = arrayDatos[i].toLowerCase();
    //         if (datos.includes(filtroBusqueda)) {
    //             resultados.push(arrayDatos[i]);
    //         }
    //     }

    //     console.log(resultados);
    // }
    
</script>

<?php require_once RUTA_APP.'/vistas/inc/footer.php' ?>

