<?php require_once RUTA_APP.'/vistas/inc/header.php' ?>

<?php 
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
    <?php print_r($datos['zapatosSubcategoria']); ?> 

    <div class="row">
        <div class="col-12">
            <h1 class="mb-3 text-primary text-center">ZAPATOS</h1>
        </div>
        <!-- <a class="btn btn-outline-success btn-sm"  data-bs-toggle="modal" data-bs-target="#addZapato">
                  <i class="bi-eye"></i>
                </a> -->
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form class="input-group">
                    <div class="input-group-append">
                        <a class="btn btn-success"  data-bs-toggle="modal" data-bs-target="#addZapato">Añadir Zapato</a>
                    </div>
                    <input type="text" class="form-control" placeholder="Buscar...">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Buscar</button>
                    </div>
                </form>
            </div>
        </div>

        <?php foreach ($datos['zapatosPrenda'] as $zapatosPrenda) : ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card my-3">
        
                    <img src="<?php echo RUTA_URL?>/img_prendas/<?php echo $zapatosPrenda->imagen
                    ?>" class="card-image-top" alt="thumbnail">
        
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
        <?php endforeach ?>

        
        
        <div class="modal fade" id="addZapato" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDelAsesoriaLabel">
                            AÑADIR ZAPATO
                        </h5>
                    </div>
                    
                    <form method="post" enctype="multipart/form-data">

                        <div class="modal-body">

                            <div class="container">

                                <div class="row">

                                    <div class="col-12">
                                        <select name="subcategoriaZapato" id="subcategoriaZapato">
                                            <option value="0">Elige subcategoria...</option>
                                            <?php foreach ($datos['zapatosSubcategoria'] as $zapatosSubcategoria) : ?>
                                                <option value="<?php echo $zapatosSubcategoria->id?>"><?php echo $zapatosSubcategoria->nombre?></option>
                                            <?php endforeach?> 
                                        </select>
                                    </div>

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
                                        <div class="form-group">
                                            <label for="checkboxes">Elige subcategoria:</label>
                                            <?php foreach ($datos['zapatosSubcategoria'] as $zapatosSubcategoria) : ?>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="zapatosSubcategoria-<?php echo $zapatosSubcategoria->id ?>" name="zapatosSubcategorias[]" value="<?php echo $zapatosSubcategoria->id ?>">
                                                    <label class="form-check-label" for="zapatosSubcategoria-<?php echo $zapatosSubcategoria->id ?>"><?php echo $zapatosSubcategoria->nombre ?></label>
                                                </div>
                                            <?php endforeach ?>
                                        </div>

                                    </div>
                                    
                                    
                                    <div class="col-12">
                                        <label for="imagen">Cargar imagen</label>
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



<?php require_once RUTA_APP.'/vistas/inc/footer.php' ?>

