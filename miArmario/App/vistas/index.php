<?php require_once RUTA_APP.'/vistas/inc/header.php'; ?>


<div class="container">

    <!-- <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">INCIO</li>
        </ol>
    </nav> -->

    <!-- <?php print_r($datos['usuarioSesion']);?> -->
    <div class="row d-flex justify-content-center text-center mx-0 mt-3">
        <div class="col-12">
            <h1>¡BIENVENIDO/A <?php  echo $datos['usuarioSesion']->nombre?>!</h1>
        </div>

        <div class="p-5">
            <p>
            La función principal de esta aplicación es ayudar al usuario a organizar su armario de ropa de una manera más efectiva y eficiente. 
            La aplicación permite al usuario categorizar su ropa en diferentes categorías, lo que facilita la búsqueda de prendas específicas.
            </p>
            <p>
            Además, la aplicación también permite al usuario crear sus propios conjuntos de ropa para diferentes ocasiones, como trabajo, 
            eventos sociales o deportes. Esto significa que el usuario puede planificar su ropa con anticipación y asegurarse de tener los conjuntos adecuados para cada ocasión.
            </p>
            <p>
            La aplicación también tiene una función de historial de uso, con lo que el usuario puede realizar un seguimiento de las veces que ha usado una determinada prenda o conjunto. 
            Esto puede ser útil para aquellos que quieren asegurarse de que están usando todas sus prendas con regularidad o para aquellos que desean seguir un régimen de moda específico. 
            </p>
            <p>
            En resumen, esta aplicación ayuda al usuario a organizar su armario y hacer un uso más efectivo de su ropa.
            </p>
        </div>
    </div>



<?php require_once RUTA_APP.'/vistas/inc/footer.php' ?>



