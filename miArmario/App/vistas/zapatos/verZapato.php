<?php require_once RUTA_APP.'/vistas/inc/header.php' ?>

<?php 
    $zapato = $datos["zapato"];
?>

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo RUTA_URL ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?php echo RUTA_URL ?>/zapato">Zapatos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ver Zapato</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-6">
            <img id="imagenActual" src="<?php echo RUTA_URL?>/img_prendas/<?php echo $zapato->id.$zapato->imagen ?>.png" alt="" class="img-fluid">

            <div class="text-center pt-5">
                <h5>Listado de conjuntos con esta prenda</h5>
                
                <?php foreach ($datos["conjuntosPrenda"] as $conjunto) : ?>
                    <div class="pb-2">
                        <a href="<?php echo RUTA_URL ?>/conjunto/ver_conjunto/<?php echo $conjunto->id?>" class="btn btn-outline-primary"><?php echo $conjunto->nombre?></a>
                    </div>                
                <?php endforeach ?>
            </div>


        </div>
        <div class="col-6">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $zapato->nombre ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="descripcion">Descripción:</label>
                    <textarea class="form-control" id="descripcion" name="descripcion"><?php echo $zapato->descripcion ?></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="talla">Talla:</label>
                    <input type="text" class="form-control" id="talla" name="talla" value="<?php echo $zapato->talla ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="color">Color:</label>
                    <input type="text" class="form-control" id="color" name="color" value="<?php echo $zapato->color ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="marca">Marca:</label>
                    <input type="text" class="form-control" id="marca" name="marca" value="<?php echo $zapato->marca ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="fecha_insercion">Fecha de inserción:</label>
                    <input type="date" class="form-control" id="fecha_insercion" name="fecha_insercion" value="<?php echo date('Y-m-d', strtotime($zapato->fecha_insercion)) ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="checkboxes">Elige temporada o temporadas:</label>
                    <?php foreach ($datos["temporadas"] as $temporada) : ?>
                        <div class="form-check">
                            <?php if (in_array($temporada->id, array_column($datos["temporadaZapato"], 'id_temporada'))) : ?>
                                <input class="form-check-input" type="checkbox" id="temporada-<?php echo $temporada->id ?>" name="temporadas[]" value="<?php echo $temporada->id ?>" checked>
                            <?php else : ?>
                                <input class="form-check-input" type="checkbox" id="temporada-<?php echo $temporada->id ?>" name="temporadas[]" value="<?php echo $temporada->id ?>">
                            <?php endif ?>
                            <label class="form-check-label" for="temporada-<?php echo $temporada->id ?>"><?php echo $temporada->nombre ?></label>
                        </div>
                    <?php endforeach ?>
                </div>
                <div class="form-group mb-3">
                    <label for="subcategoriaZapato">Subcategorias:</label>
                    <select name="subcategoriaZapato" id="subcategoriaZapato" class="form-control">
                        <?php foreach ($datos['zapatosSubcategoria'] as $zapatosSubcategoria) : ?>
                            <?php if ($zapatosSubcategoria->id == $zapato->id_subcategoria) : ?>
                                <option value="<?php echo $zapatosSubcategoria->id ?>" selected><?php echo $zapatosSubcategoria->nombre ?></option>
                            <?php else : ?>
                                <option value="<?php echo $zapatosSubcategoria->id ?>"><?php echo $zapatosSubcategoria->nombre ?></option>
                            <?php endif ?>
                        <?php endforeach ?> 
                    </select>
                </div>
                <div class="form-group mb-3">
                    <input type="file" class="form-control-file hidden" id="imagen" name="imagen" style="display: none;">
                    <button type="button" id="btnModificarImagen" class="btn btn-primary">Modificar imagen</button>
                </div>
                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                <button type="button" data-bs-toggle="modal" data-bs-target="#modalBorrarZapato" class="btn btn-danger">Borrar <?php echo $zapato->nombre ?></button>
                
            </form>
        </div>
    </div>

    
    <!-- ++++++++++++++++++++++++++++++++++++++++ Modal Borrar Zapato ++++++++++++++++++ -->

    <div class="modal fade" id="modalBorrarZapato" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalBorrarZapatoLabel">
                        Estás seguro de que deseas borrar el zapato "<?php echo $zapato->nombre ?>"?
                    </h5>
                </div>
                <div class="modal-footer">
                    <form method="post" id="formBorrarZapato" action="<?php echo RUTA_URL ?>/zapato/borrar_zapato/<?php echo $zapato->id?>">
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
