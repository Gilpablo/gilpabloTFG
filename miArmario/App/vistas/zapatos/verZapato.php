
<?php require_once RUTA_APP.'/vistas/inc/header.php' ?>

<?php 
    $zapato = $datos["zapato"];
    print_r($zapato); 
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
            <img src="<?php echo RUTA_URL?>/img_prendas/<?php echo $zapato->id.$zapato->imagen ?>.png" alt="" class="img-fluid">
        </div>
        <div class="col-6">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group mb-4">
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
                            <input class="form-check-input" type="checkbox" id="temporada-<?php echo $temporada->id ?>" name="temporadas[]" value="<?php echo $temporada->id ?>">
                            <label class="form-check-label" for="temporada-<?php echo $temporada->id ?>"><?php echo $temporada->nombre ?></label>
                        </div>
                    <?php endforeach ?>
                </div>

                <div class="form-group mb-3">
                    <select name="subcategoriaZapato" id="subcategoriaZapato">
                        <option value="0">Elige subcategoria...</option>
                        <?php foreach ($datos['zapatosSubcategoria'] as $zapatosSubcategoria) : ?>
                            <option value="<?php echo $zapatosSubcategoria->id?>"><?php echo $zapatosSubcategoria->nombre?></option>
                        <?php endforeach?> 
                    </select>

                </div>
                
                <div class="form-group mb-3">
                    <label for="imagen">Imagen:</label>
                    <input type="file" class="form-control-file" id="imagen" name="imagen">
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>









</div>
    
<?php require_once RUTA_APP.'/vistas/inc/footer.php' ?>