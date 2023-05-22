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
                    
                    <form method="post">

                        <div class="modal-body">
                                
                            <select name="subcategoriaZapato" id="subcategoriaZapato">
                                <option value="0">Elige subcategoria...</option>
                                <?php foreach ($datos['zapatosSubcategoria'] as $zapatosSubcategoria) : ?>
                                    <option value="<?php echo $zapatosSubcategoria->id?>"><?php echo $zapatosSubcategoria->nombre?></option>
                                <?php endforeach?> 
                            </select>


                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" 
                                data-bs-dismiss="modal">Cancelar
                            </button>
                            <button type="submit" class="btn btn-success" data-bs-dismiss="modal">
                                Añadir
                            </button>
                            <input type="hidden" id="id_asesoria" name="id_asesoria">
                        </div>
                    </form>

                </div>
            </div>
        </div>


        
            
    </div>
</div>



<?php require_once RUTA_APP.'/vistas/inc/footer.php' ?>

