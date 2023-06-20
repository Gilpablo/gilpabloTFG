<?php require_once RUTA_APP.'/vistas/inc/header.php' ?>

<div class="container">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo RUTA_URL ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?php echo RUTA_URL ?>/verCliente">Listado de usuarios</a></li>
            <li class="breadcrumb-item active" aria-current="page">Añadir Usuario</li>
        </ol>
    </nav>
    
    <div class="row">
        <div class="col-12">
            <h1 class="mb-3 text-primary text-center">AÑADIR USUARIO</h1>
        </div>
        
        <form action="" method="post">
            <div class="form-group mb-3">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del usuario">
            </div>
            <div class="form-group mb-3">
                <label for="apellidos">Apellidos:</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos del usuario">
            </div>
            <div class="form-group mb-3">
                <label for="correo">Correo:</label>
                <input type="text" class="form-control" id="correo" name="correo" placeholder="Correo del usuario">
            </div>
            <div class="form-group mb-3">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username del usuario">
            </div>
            <div class="form-group mb-3">
                <label for="contra">Contraseña:</label>
                <input type="password" class="form-control" id="contra" name="contra" placeholder="***********************************************************">
            </div>
            <div class="form-group mb-3">
                <label for="rol">Roles:</label>
                <select name="rol" id="rol" class="form-control">
                        <option value="0">Elige rol para el usuario....</option>
                    <?php foreach ($datos['roles'] as $roles) : ?>
                        <option value="<?php echo $roles->id ?>"><?php echo $roles->nombre ?></option>
                    <?php endforeach ?> 
                </select>
            </div>
            <button type="submit" class="btn btn-success">Guardar Cambios</button>

        </form>
            
    </div>
    
</div>


<?php require_once RUTA_APP.'/vistas/inc/footer.php' ?>

