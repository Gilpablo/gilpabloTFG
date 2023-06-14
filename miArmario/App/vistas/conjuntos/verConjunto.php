<?php require_once RUTA_APP.'/vistas/inc/header.php' ?>

<?php 
    $conjunto = $datos["conjunto"];

    print_r($conjunto);
?>

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo RUTA_URL ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?php echo RUTA_URL ?>/conjunto">Conjuntos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ver Conjunto</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-6">

            <!-- ++++++++++++++++++++++++++++++++++++++++ carrusel prendas del conjunto ++++++++++++++++++ -->
            <?php if (!empty($datos["prendasConjunto"])) : ?>

                <div id="carruselPrendas" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <?php if (!empty($conjunto->imagen_conjunto)) : ?>

                                <img id="imagenActual" src="<?php echo RUTA_URL?>/img_conjuntos/<?php echo $conjunto->id.$conjunto->imagen_conjunto ?>.png" class="d-block w-100" alt="<?php echo $conjunto->nombre?>" class="img-fluid">
                            <?php else : ?>
                                <img id="imagenActual" src="<?php echo RUTA_URL?>/img_conjuntos/maniqui_conjutos.png" class="d-block w-100" alt="<?php echo $conjunto->nombre?>" class="img-fluid">

                            <?php endif ?>
                        </div>
                        <?php foreach ($datos["prendasConjunto"] as $prenda) : ?>
                            <div class="carousel-item">
                                <img src="<?php echo RUTA_URL ?>/img_prendas/<?php echo $prenda->id.$prenda->imagen ?>.png" class="d-block w-100" alt="<?php echo $prenda->nombre?>">
                            </div>
                        <?php endforeach ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carruselPrendas" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carruselPrendas" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

            <?php else : ?>

                <?php if (!empty($conjunto->imagen_conjunto)) : ?>

                    <img id="imagenActual" src="<?php echo RUTA_URL?>/img_conjuntos/<?php echo $conjunto->id.$conjunto->imagen_conjunto ?>.png" class="d-block w-100" alt="<?php echo $conjunto->nombre?>" class="img-fluid">
                <?php else : ?>
                    <img id="imagenActual" src="<?php echo RUTA_URL?>/img_conjuntos/maniqui_conjutos.png" class="d-block w-100" alt="<?php echo $conjunto->nombre?>" class="img-fluid">

                <?php endif ?>

            <?php endif ?>
            

        </div>

        <div class="col-6">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $conjunto->nombre ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="descripcion">Descripción:</label>
                    <textarea class="form-control" id="descripcion" name="descripcion"><?php echo $conjunto->descripcion ?></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="fecha_creacion">Fecha de inserción:</label>
                    <input type="date" class="form-control" id="fecha_creacion" name="fecha_creacion" value="<?php echo date('Y-m-d', strtotime($conjunto->fecha_creacion)) ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="checkboxes">Elige temporada o temporadas:</label>
                    <?php foreach ($datos["temporadas"] as $temporada) : ?>
                        <div class="form-check">
                            <?php if (in_array($temporada->id, array_column($datos["temporadaConjunto"], 'id_temporada'))) : ?>
                                <input class="form-check-input" type="checkbox" id="temporada-<?php echo $temporada->id ?>" name="temporadas[]" value="<?php echo $temporada->id ?>" checked>
                            <?php else : ?>
                                <input class="form-check-input" type="checkbox" id="temporada-<?php echo $temporada->id ?>" name="temporadas[]" value="<?php echo $temporada->id ?>">
                            <?php endif ?>
                            <label class="form-check-label" for="temporada-<?php echo $temporada->id ?>"><?php echo $temporada->nombre ?></label>
                        </div>
                    <?php endforeach ?>
                </div>
                <div class="form-group mb-3">
                    <input type="file" class="form-control-file hidden" id="imagen" name="imagen" style="display: none;">
                    <?php if (empty($conjunto->imagen_conjunto)) { ?>
                        <button type="button" id="btnModificarImagen" class="btn btn-primary">Subir imagen conjunto</button>
                    <?php } else { ?>
                        <button type="button" id="btnModificarImagen" class="btn btn-primary">Modificar imagen conjunto</button>
                    <?php } ?>

                    
                </div>
                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                <button type="button" data-bs-toggle="modal" data-bs-target="#modalBorrarConjunto" class="btn btn-danger">Borrar <?php echo $conjunto->nombre ?></button>
                
            </form>

            
        </div>
    </div>

    
    <!-- ++++++++++++++++++++++++++++++++++++++++ Modal Borrar Conjunto ++++++++++++++++++ -->

    <div class="modal fade" id="modalBorrarConjunto" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalBorrarConjuntoLabel">
                        Estás seguro de que deseas borrar el conjunto "<?php echo $conjunto->nombre ?>"?
                    </h5>
                </div>
                <div class="modal-footer">
                    <form method="post" id="formBorrarConjunto" action="<?php echo RUTA_URL ?>/conjunto/borrar_conjunto/<?php echo $conjunto->id?>">
                        <button type="button" class="btn btn-secondary" 
                            data-bs-dismiss="modal">Cancelar
                        </button>
                        <button type="submit" class="btn btn-danger">
                            Borrar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
    
<?php require_once RUTA_APP.'/vistas/inc/footer.php' ?>

<script>
    document.getElementById('btnModificarImagen').addEventListener('click', function() {
        document.getElementById('imagen').click();
    });

    document.getElementById('imagen').addEventListener('change', function() {
        var file = this.files[0];
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagenActual').src = e.target.result;
        };
        reader.readAsDataURL(file);
    });

</script>
 