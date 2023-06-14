<?php require_once RUTA_APP.'/vistas/inc/header.php' ?>

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo RUTA_URL ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?php echo RUTA_URL ?>/conjunto">Conjuntos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Añadir Conjunto</li>
        </ol>
    </nav>

    <div class="col-12">
        <h1 class="mb-3 text-primary text-center">AÑADIR CONJUNTO</h1>
    </div>
        
    <form method="post" enctype="multipart/form-data">

        <div class="row">
            
            <div class="col-6">
                <label for="imagenConjunto" style="font-weight: bold; color: #333;">Cargar imagen</label>
                <input type="file" class="form-control-file" name="imagenConjunto" id="imagenConjunto" style="border: 1px solid #ccc; padding: 5px; width: 100%;">
                <img id="cargarImagen" src="" alt="" class="img-fluid">
            </div>

            <div class="col-6">

                <div class="row">

                    <div class="col-12 mb-3">
                        <label for="nombre" style="font-weight: bold; color: #333;">Nombre</label>
                        <input type="text" class="form-control" name="nombreConjunto" id="nombreConjunto" placeholder="Ingresa el nombre">
                    </div>
        
                    
                    <div class="col-12 mb-3">
                        <label for="descripcion" style="font-weight: bold; color: #333;">Descripcion</label>
                        <textarea class="form-control" id="descripcionConjunto" name="descripcionConjunto"></textarea>
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
                    
                    <div class="col-6 mb-3">
                        <div class="form-group">
                            <label for="checkboxes" style="font-weight: bold; color: #333;">Elige temporada o temporadas:</label>
                            <?php foreach ($datos["temporadas"] as $temporada) : ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="temporada-<?php echo $temporada->id ?>" name="temporadas[]" value="<?php echo $temporada->id ?>">
                                    <label class="form-check-label" for="temporada-<?php echo $temporada->id ?>"><?php echo $temporada->nombre ?></label>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                    
                    <div class="col-6 mb-3">
                        <label for="fecha_creacionConjunto" style="font-weight: bold; color: #333;">Fecha Creación</label>
                        <input type="date" class="form-control" id="fecha_creacionConjunto" name="fecha_creacionConjunto">
                    </div>

                    <input type="hidden" id="prendasSeleccionadas" name="prendasSeleccionadas" value="">

                    <div class="col-12">
                
                        <button type="submit" class="btn btn-success" data-bs-dismiss="modal">
                            Añadir
                        </button>   
                        <a href="<?php echo RUTA_URL ?>/conjunto" class="btn btn-secondary">Cancelar</a>

                    </div>

                </div>

            </div>

        </div>

    </form>
                        
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

</div>
    
<?php require_once RUTA_APP.'/vistas/inc/footer.php' ?>

<script>
    
    // Obtener referencia al elemento de carga de imagen
    var inputImagen = document.getElementById('imagenConjunto');

    // Escuchar el evento de cambio en el elemento de carga de imagen
    inputImagen.addEventListener('change', function(event) {
        // Obtener el archivo seleccionado
        var archivo = event.target.files[0];

        // Crear un objeto de tipo FileReader
        var lector = new FileReader();

        // Configurar la función de carga completada del lector de archivos
        lector.onload = function(e) {
            // Obtener la URL de la imagen cargada
            var imagenURL = e.target.result;

            // Mostrar la imagen en el elemento con el ID "cargarImagen"
            var imagenElemento = document.getElementById('cargarImagen');
            imagenElemento.src = imagenURL;
        };

        // Leer el contenido del archivo como una URL de datos
        lector.readAsDataURL(archivo);
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
            enlaceImagen.href = "#";
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
 