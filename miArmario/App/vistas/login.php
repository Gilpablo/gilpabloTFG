<?php require_once RUTA_APP.'/vistas/inc/header_no_login.php'; ?>


<div class="container-fluid d-flex justify-content-center align-items-center" style="height: 90vh;">
    <div class="text-center p-5" style="background-image: url(<?php echo RUTA_URL?>/img/fondoLogin.png); background-size: cover; background-position: center;">
        <h1 class="h3 m-3 fw-normal d-inline-block text-light pt-5">Log In</h1>

        <form method="post" class="card-body p-5">
            <div class="form-floating mb-3">
                <input type="text" name="usuario" class="form-control" placeholder="" required>
                <label for="floatingInput">Usuario</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" name="pass" class="form-control" placeholder="" required>
                <label for="floatingInput">Contraseña</label>
            </div>
            <input type="submit" class="btn btn-success mb-5" value="Login">
            <a class="btn btn-primary me-md-4 mb-5" href="<?php echo RUTA_URL ?>/login/add_usuario">Crear cuenta</a>
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
    </div>
</div>










<?php require_once RUTA_APP.'/vistas/inc/footer.php' ?>