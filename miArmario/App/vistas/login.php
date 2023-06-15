<?php require_once RUTA_APP.'/vistas/inc/header_no_login.php'; ?>


<div class="container">

    

    <h1 class="h3 m-3 fw-normal">Log In</h1>

    <form method="post" class="card-body">
        <div class="form-floating mb-3">
            <input type="text" name="usuario" class="form-control" placeholder="" required>
            <label for="floatingInput">Usuario</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" name="pass" class="form-control" placeholder="" required>
            <label for="floatingInput">Contraseña</label>
        </div>
        <input type="submit" class="btn btn-success" value="Login">
        <a class="btn btn-primary me-md-4" href="<?php echo RUTA_URL ?>/login/add_usuario">Crear cuenta</a>

    </form>

    <?php if (isset($datos['error']) && $datos['error'] == 'error_1' ): ?>
        <div class="alert alert-danger" role="alert">
            ERROR DE LOGIN !!!
        </div>
    <?php elseif ($datos['error'] == 'creado') :?>
        <div class="alert alert-success" role="alert">
            USUARIO CREADO CORRECTAMENTE !!!
        </div>
    <?php endif ?>

    
    <!-- <img src="<?php echo RUTA_URL?>/img/fondoLogin.png" alt=""> -->
</div>


<?php require_once RUTA_APP.'/vistas/inc/footer.php' ?>