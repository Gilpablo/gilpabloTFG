<?php require_once RUTA_APP.'/vistas/inc/header.php' ?>

<?php 
    $user = $datos["cliente"]
?>

<div class="container">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo RUTA_URL ?>">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Usuario</li>
        </ol>
    </nav>
    
    <div class="row">
        <div class="col-12">
            <h1 class="mb-3 text-primary text-center">EDITAR USUARIO</h1>
        </div>
        
        <form action="" method="post">
            <div class="form-group mb-3">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $user->nombre ?>">
            </div>
            <div class="form-group mb-3">
                <label for="apellidos">Apellidos:</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $user->apellidos ?>">
            </div>
            <div class="form-group mb-3">
                <label for="correo">Correo:</label>
                <input type="text" class="form-control" id="correo" name="correo" value="<?php echo $user->correo ?>">
            </div>
            <div class="form-group mb-3">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $user->username ?>">
            </div>
            <div class="form-group mb-3">
                <label for="contra">Contraseña:</label>
                <input type="password" class="form-control" id="contra" name="contra" placeholder="***********************************************************">
            </div>
            <div class="form-group mb-3">
                <label for="rol">Subcategorias:</label>
                <select name="rol" id="rol" class="form-control">
                    <?php foreach ($datos['roles'] as $roles) : ?>
                        <?php if ($roles->id == $datos['rolCliente']->id) : ?>
                            <option value="<?php echo $roles->id ?>" selected><?php echo $roles->nombre ?></option>
                        <?php else : ?>
                            <option value="<?php echo $roles->id ?>"><?php echo $roles->nombre ?></option>
                        <?php endif ?>
                    <?php endforeach ?> 
                </select>
            </div>
            <button type="submit" class="btn btn-success">Guardar Cambios</button>

        </form>
            
    </div>
    
</div>


<?php require_once RUTA_APP.'/vistas/inc/footer.php' ?>

