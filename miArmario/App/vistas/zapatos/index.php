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
        
        <?php foreach ($datos['zapatosPrenda'] as $zapatosPrenda) : ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card my-3">
        
                    <img src="<?php echo RUTA_URL?>/img_prendas/<?php echo $zapatosPrenda->imagen?>" class="card-image-top" alt="thumbnail">
        
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
        
        <!-- <div class="col-12 col-md-6 col-lg-4">
            <div class="card my-3">
    
                <img src="https://images.pexels.com/photos/325185/pexels-photo-325185.jpeg" class="card-image-top" alt="thumbnail">
    
                <div class="card-body">
                    <h3 class="card-title"><a href="#" class="text-secondary">titulo prenda 1</a></h3>
                    <a href="#" class="btn btn-primary">Read More</a>
                </div>
            </div>
        </div> -->
            
    </div>
</div>



<?php require_once RUTA_APP.'/vistas/inc/footer.php' ?>

