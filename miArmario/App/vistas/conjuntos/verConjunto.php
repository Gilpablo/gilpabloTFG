<?php require_once RUTA_APP.'/vistas/inc/header.php' ?>

<?php 
    $conjunto = $datos["conjunto"];

?>

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo RUTA_URL ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?php echo RUTA_URL ?>/conjunto">Conjuntos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ver Conjunto</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-12 text-center mb-4">
            <a href="" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modalAddHistorial">Añadir un evento de uso para este conjunto</a>
        </div>

            <!-- ++++++++++++++++++++++++++++++++++++++++ Modal Añadir Historial ++++++++++++++++++ -->

            <div class="modal fade" id="modalAddHistorial" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalAddHistorial">
                                Añade una fecha de uso para este conjunto: "<?php echo $conjunto->nombre ?>"?
                            </h5>
                        </div>
                        <form method="post" action="<?php echo RUTA_URL ?>/historialUso/add_historial/<?php echo $conjunto->id?>">
                            <div class="modal-body">
                                <div class="form-group mb-3">
                                    <label for="nombreHistorial">Nombre:</label>
                                    <input type="text" class="form-control" id="nombreHistorial" name="nombreHistorial" placeholder="Ingresa el nombre del evento">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="fecha_historial">Fecha de evento:</label>
                                    <input type="date" class="form-control" id="fecha_historial" name="fecha_historial">
                                </div>
                              
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" 
                                    data-bs-dismiss="modal">Cancelar
                                </button>
                                <button type="submit" class="btn btn-success">
                                    Añadir
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        
        <div class="col-6">

            <!-- ++++++++++++++++++++++++++++++++++++++++ carrusel prendas del conjunto ++++++++++++++++++ -->
            <?php if (!empty($datos["prendasConjunto"])) : ?>

                <div id="carruselPrendas" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <?php if (!empty($conjunto->imagen_conjunto)) : ?>

                                <img id="imagenActual" src="<?php echo RUTA_URL?>/img_conjuntos/<?php echo $conjunto->id.$conjunto->imagen_conjunto ?>.png" class="d-block w-100" alt="<?php echo $conjunto->nombre?>" class="img-fluid">
                            <?php else : ?>
                                <img id="imagenActual" src="<?php echo RUTA_URL?>/img_conjuntos/maniqui_conjutos.png" class="d-block w-100" alt="<?php echo $conjunto->nombre?>" class="img-fluid">

                            <?php endif ?>
                        </div>
                        <?php foreach ($datos["prendasConjunto"] as $prenda) : ?>
                            <div class="carousel-item">
                                <img src="<?php echo RUTA_URL ?>/img_prendas/<?php echo $prenda->id.$prenda->imagen ?>.png" class="d-block w-100" alt="<?php echo $prenda->nombre?>">
                            </div>
                        <?php endforeach ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carruselPrendas" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carruselPrendas" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

            <?php else : ?>

                <?php if (!empty($conjunto->imagen_conjunto)) : ?>

                    <img id="imagenActual" src="<?php echo RUTA_URL?>/img_conjuntos/<?php echo $conjunto->id.$conjunto->imagen_conjunto ?>.png" class="d-block w-100" alt="<?php echo $conjunto->nombre?>" class="img-fluid">
                <?php else : ?>
                    <img id="imagenActual" src="<?php echo RUTA_URL?>/img_conjuntos/maniqui_conjutos.png" class="d-block w-100" alt="<?php echo $conjunto->nombre?>" class="img-fluid">

                <?php endif ?>

            <?php endif ?>
            

        </div>

        <div class="col-6">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $conjunto->nombre ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="descripcion">Descripción:</label>
                    <textarea class="form-control" id="descripcion" name="descripcion"><?php echo $conjunto->descripcion ?></textarea>
                </div>

                <div class="col-12 mb-3">
                    <div class="form-group">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropRop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Elige ropa
                            </button>
                            <div class="dropdown-menu" id="rop" style="display: none;">
                                <?php foreach ($datos['ropasSubcategorias'] as $ropasSubcat) : ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="<?php echo $ropasSubcat->id ?>" value="<?php echo $ropasSubcat->id ?>">
                                        <label class="form-check-label" for="<?php echo $ropasSubcat->id ?>"><?php echo $ropasSubcat->nombre ?></label>
                                    </div>    
                                <?php endforeach?>
                            </div>
                        </div>
                        
                        <table id="rop-tabla" class="table table-striped">
                            <thead class="d-none">
                                <tr>
                                <th scope="col"></th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Imagen</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        
                    </div>
                </div>
                
                <div class="col-12 mb-3">
                    <div class="form-group">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropZap" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Elige zapato
                            </button>
                            <div class="dropdown-menu" id="zap" style="display: none;">
                                <?php foreach ($datos['zapatosSubcategorias'] as $zapatosSubcat) : ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="<?php echo $zapatosSubcat->id ?>" value="<?php echo $zapatosSubcat->id ?>">
                                        <label class="form-check-label" for="<?php echo $zapatosSubcat->id ?>"><?php echo $zapatosSubcat->nombre ?></label>
                                    </div>    
                                <?php endforeach?>
                            </div>
                        </div>
                        <table id="zap-tabla" class="table table-striped">
                            <thead class="d-none">
                                <tr>
                                <th scope="col"></th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Imagen</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                
                <div class="col-12 mb-3">
                    <div class="form-group">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropComp" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Elige complemento
                            </button>
                            <div class="dropdown-menu" id="comp" style="display: none;">
                                <?php foreach ($datos['complementosSubcategorias'] as $complementosSubcat) : ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="<?php echo $complementosSubcat->id ?>" value="<?php echo $complementosSubcat->id ?>">
                                        <label class="form-check-label" for="<?php echo $complementosSubcat->id ?>"><?php echo $complementosSubcat->nombre ?></label>
                                    </div>    
                                <?php endforeach?>
                            </div>
                        </div>
                        <table id="comp-tabla" class="table table-striped">
                            <thead class="d-none">
                                <tr>
                                <th scope="col"></th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Imagen</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="fecha_creacion">Fecha de inserción:</label>
                    <input type="date" class="form-control" id="fecha_creacion" name="fecha_creacion" value="<?php echo date('Y-m-d', strtotime($conjunto->fecha_creacion)) ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="checkboxes">Elige temporada o temporadas:</label>
                    <?php foreach ($datos["temporadas"] as $temporada) : ?>
                        <div class="form-check">
                            <?php if (in_array($temporada->id, array_column($datos["temporadaConjunto"], 'id_temporada'))) : ?>
                                <input class="form-check-input" type="checkbox" id="temporada-<?php echo $temporada->id ?>" name="temporadas[]" value="<?php echo $temporada->id ?>" checked>
                            <?php else : ?>
                                <input class="form-check-input" type="checkbox" id="temporada-<?php echo $temporada->id ?>" name="temporadas[]" value="<?php echo $temporada->id ?>">
                            <?php endif ?>
                            <label class="form-check-label" for="temporada-<?php echo $temporada->id ?>"><?php echo $temporada->nombre ?></label>
                        </div>
                    <?php endforeach ?>
                </div>
                <div class="form-group mb-3">
                    <input type="file" class="form-control-file hidden" id="imagen" name="imagen" style="display: none;">
                    <?php if (empty($conjunto->imagen_conjunto)) { ?>
                        <button type="button" id="btnModificarImagen" class="btn btn-primary">Subir imagen conjunto</button>
                    <?php } else { ?>
                        <button type="button" id="btnModificarImagen" class="btn btn-primary">Modificar imagen conjunto</button>
                    <?php } ?>

                    
                </div>

                <input type="hidden" id="prendasSeleccionadas" name="prendasSeleccionadas" value="">

                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                <button type="button" data-bs-toggle="modal" data-bs-target="#modalBorrarConjunto" class="btn btn-danger">Borrar <?php echo $conjunto->nombre ?></button>
                
            </form>

            
        </div>
    </div>

    <!-- MODAL IMAGEN  -->
    <div class="modal fade" id="imagen-modal" tabindex="-1" aria-labelledby="imagen-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imagen-modal-label">Imagen de la prenda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <img src="" alt="Imagen de la prenda" class="img-fluid">
            </div>
            </div>
        </div>
    </div>

    
    <!-- ++++++++++++++++++++++++++++++++++++++++ Modal Borrar Conjunto ++++++++++++++++++ -->

    <div class="modal fade" id="modalBorrarConjunto" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalBorrarConjuntoLabel">
                        Estás seguro de que deseas borrar el conjunto "<?php echo $conjunto->nombre ?>"?
                    </h5>
                </div>
                <div class="modal-footer">
                    <form method="post" id="formBorrarConjunto" action="<?php echo RUTA_URL ?>/conjunto/borrar_conjunto/<?php echo $conjunto->id?>">
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


    var rop = document.getElementById("rop");
    var dropRop = document.getElementById("dropRop");

    dropRop.addEventListener('click', function() {
        if (rop.style.display === 'block') {
            rop.style.display = 'none';
        } else {
            rop.style.display = 'block';
        }
    });


    var zap = document.getElementById("zap");
    var dropZap = document.getElementById("dropZap");

    dropZap.addEventListener('click', function() {
        if (zap.style.display === 'block') {
            zap.style.display = 'none';
        } else {
            zap.style.display = 'block';
        }
    });


    var comp = document.getElementById("comp");
    var dropComp = document.getElementById("dropComp");

    dropComp.addEventListener('click', function() {
        if (comp.style.display === 'block') {
            comp.style.display = 'none';
        } else {
            comp.style.display = 'block';
        }
    });


    var ropCheckboxList = document.querySelectorAll('#rop input[type="checkbox"]');
    var zapCheckboxList = document.querySelectorAll('#zap input[type="checkbox"]');
    var compCheckboxList = document.querySelectorAll('#comp input[type="checkbox"]');

    var arrayPrendas = <?php echo json_encode($datos["prendas"]); ?>;
    var arrayPrendasConjunto = <?php echo json_encode($datos["prendasConjunto"]); ?>;

    var ropSeleccionados = [];
    var zapSeleccionados = [];
    var compSeleccionados = [];

    ropCheckboxList.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            if (checkbox.checked) {
            var idSubcategoria = parseInt(checkbox.id);
            ropSeleccionados.push(idSubcategoria);
            } else {
            var index = ropSeleccionados.indexOf(parseInt(checkbox.id));
            if (index > -1) {
                ropSeleccionados.splice(index, 1);
            }
            }
            
            var prendasCoincidentes = arrayPrendas.filter(function(prenda) {
            return ropSeleccionados.includes(prenda.id_subcategoria);
            });
            
            mostrarPrendasTabla(prendasCoincidentes, 'rop');
        });
    });

    zapCheckboxList.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            if (checkbox.checked) {
            var idSubcategoria = parseInt(checkbox.id);
            zapSeleccionados.push(idSubcategoria);
            } else {
            var index = zapSeleccionados.indexOf(parseInt(checkbox.id));
            if (index > -1) {
                zapSeleccionados.splice(index, 1);
            }
            }
            
            var prendasCoincidentes = arrayPrendas.filter(function(prenda) {
            return zapSeleccionados.includes(prenda.id_subcategoria);
            });
            
            mostrarPrendasTabla(prendasCoincidentes, 'zap');
        });
    });

    compCheckboxList.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            if (checkbox.checked) {
            var idSubcategoria = parseInt(checkbox.id);
            compSeleccionados.push(idSubcategoria);
            } else {
            var index = compSeleccionados.indexOf(parseInt(checkbox.id));
            if (index > -1) {
                compSeleccionados.splice(index, 1);
            }
            }
            
            var prendasCoincidentes = arrayPrendas.filter(function(prenda) {
            return compSeleccionados.includes(prenda.id_subcategoria);
            });
            
            mostrarPrendasTabla(prendasCoincidentes, 'comp');
        });
    });

    
    // Objeto para rastrear las prendas seleccionadas
    var prendasSeleccionadas = [];

    var arrayPrendasConjunto = <?php echo json_encode($datos["prendasConjunto"]); ?>;

    function mostrarPrendasTabla(prendas, categoria) {
        var tabla = document.getElementById(categoria + '-tabla');
        var tbody = tabla.getElementsByTagName('tbody')[0];
        var thead = tabla.getElementsByTagName('thead')[0];

        // Limpiar contenido previo del tbody
        while (tbody.firstChild) {
            tbody.removeChild(tbody.firstChild);
        }

        if (prendas.length > 0) {
            // Mostrar el encabezado de la tabla
            thead.classList.remove('d-none');

            // Agregar filas de prendas al tbody
            prendas.forEach(function(prenda) {
            var fila = document.createElement('tr');

            var celdaCheck = document.createElement('td');
            var inputCheck = document.createElement("input");
            inputCheck.type = "checkbox";
            inputCheck.value = prenda.id;
            celdaCheck.appendChild(inputCheck);

            // Comprobar si el valor está presente en el array prendasSeleccionadas
            if (prendasSeleccionadas.includes(inputCheck.value)) {
                inputCheck.checked = true; // Marcar el checkbox si está seleccionado
            }

            // Agregar evento change al checkbox
            inputCheck.addEventListener('change', function() {
                if (inputCheck.checked) {
                prendasSeleccionadas.push(inputCheck.value); // Agregar valor al array cuando el checkbox está seleccionado
                } else {
                var index = prendasSeleccionadas.indexOf(inputCheck.value);
                if (index > -1) {
                    prendasSeleccionadas.splice(index, 1); // Eliminar valor del array cuando el checkbox se deselecciona
                }
                }

                // Actualizar el valor del campo oculto con el array prendasSeleccionadas
                var prendasSeleccionadasInput = document.getElementById('prendasSeleccionadas');
                prendasSeleccionadasInput.value = JSON.stringify(prendasSeleccionadas);

            });

            var celdaNombre = document.createElement('td');
            celdaNombre.textContent = prenda.nombre;

            var celdaMarca = document.createElement('td');
            celdaMarca.textContent = prenda.marca;

            var celdaImagen = document.createElement('td');
            var enlaceImagen = document.createElement('a');
            enlaceImagen.href = "#" + prenda.nombre;
            enlaceImagen.textContent = "Ver imagen";
            enlaceImagen.addEventListener('click', function() {
                var modalImagen = document.getElementById('imagen-modal');
                var imagen = modalImagen.querySelector('.modal-body img');
                imagen.src = "<?php echo RUTA_URL?>/img_prendas/" + prenda.id + prenda.imagen + ".png";
                var bootstrapModal = new bootstrap.Modal(modalImagen);
                bootstrapModal.show();
            });
            celdaImagen.appendChild(enlaceImagen);

            fila.appendChild(celdaCheck);
            fila.appendChild(celdaNombre);
            fila.appendChild(celdaMarca);
            fila.appendChild(celdaImagen);
            tbody.appendChild(fila);
            });
        } else {
            // Ocultar el encabezado de la tabla si no hay prendas
            thead.classList.add('d-none');
        }
    }
    

</script>
 