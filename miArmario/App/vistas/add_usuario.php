<?php require_once RUTA_APP.'/vistas/inc/header_no_login.php'; ?>


<div class="container">

    

    <h1 class="h3 m-3 fw-normal">CREAR CUENTA NUEVA</h1>

    <form method="post" class="card-body">
        <div class="form-floating mb-3">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
            <label for="floatingInput">Nombre</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="apellidos" class="form-control" placeholder="Apellidos" required>
            <label for="floatingInput">Apellidos</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="correo" class="form-control" placeholder="Correo" required>
            <label for="floatingInput">Correo</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="usuario" class="form-control" placeholder="Usuario" required>
            <label for="floatingInput">Usuario</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" name="pass" class="form-control" placeholder="Contraseña" required>
            <label for="floatingInput">Contraseña</label>
        </div>
        <input type="submit" class="btn btn-success" value="Crear Cuenta">

    </form>

    <?php if (isset($datos['error']) && $datos['error'] == 'error_1' ): ?>
        <div class="alert alert-danger" role="alert">
            ERROR DE LOGIN !!!
        </div>
    <?php endif ?>

</div>


<?php require_once RUTA_APP.'/vistas/inc/footer.php' ?>