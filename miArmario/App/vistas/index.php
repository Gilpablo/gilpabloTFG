
<?php require_once RUTA_APP.'/vistas/inc/header.php'; ?>


<div class="container">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Home</li>
        </ol>
    </nav>

    <div class="float-end">
        <a class="btn btn-primary me-md-4" href="<?php echo RUTA_URL ?>/asesorias/add_asesoria"><h3>+</h3></a>
    </div>

    <div class="row d-flex justify-content-center text-center mx-0 mt-3">
        <div class="col-12">
            <h1>Asesorias Nuevas o Activas</h1>
        </div>
    </div>


    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Título</th>
                <th scope="col">Datos Personales (Nombre, DNI, teléfono, email)</th>
                <th scope="col">Descripción</th>
                <th scope="col">Domicilio</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

</div>



<!-- ++++++++++++++++++++++++++++++++++++++++ Modal Cerar Accion ++++++++++++++++++ -->

<div class="modal fade" id="modalDelAsesoria" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDelAsesoriaLabel">
                    ¿Estás seguro que quieres eliminar la Asesoría?
                </h5>
            </div>
            <div class="modal-body">
                <p>Se borraran todas las acciones realizadas en la Asesoría.</p>
            </div>
            <div class="modal-footer">
                <form method="post" id="formDelAsesoria" action="javascript:del_asesoria()">
                    <button type="button" class="btn btn-secondary" 
                        data-bs-dismiss="modal">Cancelar
                    </button>
                    <button type="submit" class="btn btn-warning" data-bs-dismiss="modal">
                        Borrar Asesoría
                    </button>
                    <input type="hidden" id="id_asesoria" name="id_asesoria">
                </form>
            </div>
        </div>
    </div>
</div>


<!-- ++++++++++++++++++++++++++++++++++++++++ Toast de Validacion Asincrona ++++++++++++++++++ -->

<div class="toast-container position-fixed bottom-0 end-0 p-3 m-4" style="z-index: 11">
    <div id="toastOK" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false">
                <rect width="100%" height="100%" fill="green">
                </rect>
            </svg>
            <strong class="me-auto">Acción OK</strong>
        </div>
    </div>
</div>

<div class="position-fixed bottom-0 end-0 p-3 m-4" style="z-index: 11">
    <div id="toastKO" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false">
                <rect width="100%" height="100%" fill="red">
                </rect>
            </svg>
            <strong class="me-auto">Error !!!</strong>
        </div>
    </div>
</div>


<script>
    function del_asesoria_modal(id_asesoria) {
        document.getElementById("id_asesoria").value = id_asesoria
    }

    async function del_asesoria(){
        const datosForm = new FormData(document.getElementById("formDelAsesoria"))
        await fetch(`<?php echo RUTA_URL?>/asesorias/del_asesoria`, {
            method: "POST",
            body: datosForm,
        })
            .then((resp) => resp.json())
            .then(function(data) {

                // console.log(data)

                if(data){
                    document.getElementById('asesoria_'+datosForm.get('id_asesoria')).remove()
                    document.getElementById('acciones_'+datosForm.get('id_asesoria')).remove()
                    // Mostamos mensaje de exito
                    const toast = document.getElementById("toastOK")
                    const bootToast = new bootstrap.Toast(toast)
                    bootToast.show()
                } else {
                    // Mostramos mensaje de error
                    const toast = document.getElementById("toastKO")
                    const bootToast = new bootstrap.Toast(toast)
                    bootToast.show()
                }

            })
            .catch((error) => {
                // console.log(error)
                const toast = document.getElementById("toastKO")
                const bootToast = new bootstrap.Toast(toast)
                bootToast.show()
            })
    }
</script>

<?php require_once RUTA_APP.'/vistas/inc/footer.php' ?>

