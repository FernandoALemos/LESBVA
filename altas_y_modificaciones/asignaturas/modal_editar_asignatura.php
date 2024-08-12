    <!-- Modal para Editar Asignatura -->
    <div class="modal fade" id="modalEditarAsignatura" tabindex="-1" role="dialog" aria-labelledby="modalEditarAsignaturaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="formEditarAsignatura" action="altas_y_modificaciones\asignaturas\editar_asignatura.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarAsignaturaLabel">Editar Asignatura</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Campos del formulario -->
                        <input type="hidden" id="edit_asignatura_id" name="materia_carrera_id">
                        <!-- Ciclo -->
                        <div class="form-group">
                            <label for="edit_ciclo_id">Ciclo</label>
                            <select class="form-control select2" id="edit_ciclo_id" name="ciclo_id" required>
                                <?php
                                    $ciclos = CicloLectivo::listarCiclos();
                                    foreach ($ciclos as $ciclo) {
                                        echo "<option value='{$ciclo['ciclo_id']}'>{$ciclo['ciclo']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <!-- Turno -->
                        <div class="form-group">
                            <label for="edit_turno_id">Turno</label>
                            <select class="form-control select2" id="edit_turno_id" name="turno_id" required>
                                <?php
                                    $turnos = Turno::listarTurnos();
                                    foreach ($turnos as $turno) {
                                        echo "<option value='{$turno['turno_id']}'>{$turno['turno']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <!-- Carrera -->
                        <div class="form-group">
                            <label for="edit_carrera_id">Carrera</label>
                            <select class="form-control select2" id="edit_carrera_id" name="carrera_id" required>
                                <?php
                                    $carreras = Carrera::listarCarreras();
                                    foreach ($carreras as $carrera) {
                                        echo "<option value='{$carrera['carrera_id']}'>{$carrera['carrera_nombre']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <!-- Curso -->
                        <div class="form-group">
                            <label for="edit_curso_id">Curso</label>
                            <select class="form-control select2" id="edit_curso_id" name="curso_id" required>
                                <?php
                                    $cursos = Curso::listar_Cursos();
                                    foreach ($cursos as $curso) {
                                        echo "<option value='{$curso['curso_id']}'>{$curso['curso']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <!-- Materia -->
                        <div class="form-group">
                            <label for="edit_materia_id">Materia</label>
                            <select class="form-control select2" id="edit_materia_id" name="materia_id" required>
                                <?php
                                    $materias = Materia::listarMaterias();
                                    foreach ($materias as $materia) {
                                        echo "<option value='{$materia['materia_id']}'>{$materia['materia_nombre']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <!-- Profesor -->
                        <div class="form-group">
                            <label for="edit_profesor_id">Profesor</label>
                            <select class="form-control select2" id="edit_profesor_id" name="profesor_id" required>
                                <?php
                                    $profesores = Profesor::listarProfesores();
                                    foreach ($profesores as $profesor) {
                                        echo "<option value='{$profesor['profesor_id']}'>{$profesor['profesor_apellido']} {$profesor['profesor_nombre']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <!-- Situación de Revista -->
                        <div class="form-group">
                            <label for="edit_situacion_revista">Situación de Revista</label>
                            <input type="text" class="form-control" id="edit_situacion_revista" name="situacion_revista" required>
                        </div>
                        <!-- Inscriptos -->
                        <div class="form-group">
                            <label for="edit_inscriptos">Inscriptos</label>
                            <input type="number" class="form-control" id="edit_inscriptos" name="inscriptos" required>
                        </div>
                        <!-- Regulares -->
                        <div class="form-group">
                            <label for="edit_regulares">Regulares</label>
                            <input type="number" class="form-control" id="edit_regulares" name="regulares" required>
                        </div>
                        <!-- Atraso Académico -->
                        <div class="form-group">
                            <label for="edit_atraso_academico">Atraso Académico</label>
                            <input type="number" class="form-control" id="edit_atraso_academico" name="atraso_academico" required>
                        </div>
                        <!-- Recursantes -->
                        <div class="form-group">
                            <label for="edit_recursantes">Recursantes</label>
                            <input type="number" class="form-control" id="edit_recursantes" name="recursantes" required>
                        </div>
                        <!-- Módulos -->
                        <div class="form-group">
                            <label for="edit_modulos">Módulos</label>
                            <input type="number" class="form-control" id="edit_modulos" name="modulos" required>
                        </div>
                        <!-- 1° Período -->
                        <div class="form-group">
                            <label for="edit_primer_periodo">1° Período</label>
                            <input type="number" class="form-control" id="edit_primer_periodo" name="primer_periodo" required>
                        </div>
                        <!-- 2° Período -->
                        <div class="form-group">
                            <label for="edit_segundo_periodo">2° Período</label>
                            <input type="number" class="form-control" id="edit_segundo_periodo" name="segundo_periodo" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <script>
$(document).ready(function() {
    $('.btnEditarAsignatura').on('click', function() {
        var asignatura_id = $(this).data('id');
        console.log("ID de asignatura: " + asignatura_id);

        // Asigna el ID de la asignatura al campo oculto en el formulario del modal
        $('#edit_asignatura_id').val(asignatura_id);

        $.ajax({
            url: 'implementation.php',
            type: 'GET',
            data: { id: asignatura_id },
            success: function(response) {
                console.log("Respuesta del servidor: ", response);
                var asignatura = JSON.parse(response);

                // Cargar select con select2
                $('#edit_ciclo_id').select2({
                    data: [{ id: asignatura.ciclo_id, text: asignatura.ciclo }]
                }).trigger('change');

                $('#edit_turno_id').select2({
                    data: [{ id: asignatura.turno_id, text: asignatura.turno_nombre }]
                }).trigger('change');

                $('#edit_carrera_id').select2({
                    data: [{ id: asignatura.carrera_id, text: asignatura.carrera_nombre }]
                }).trigger('change');

                $('#edit_curso_id').select2({
                    data: [{ id: asignatura.curso_id, text: asignatura.curso }]
                }).trigger('change');

                $('#edit_materia_id').select2({
                    data: [{ id: asignatura.materia_id, text: asignatura.materia_nombre }]
                }).trigger('change');

                $('#edit_profesor_id').select2({
                    data: [{ id: asignatura.profesor_id, text: asignatura.profesor_apellido + ' ' + asignatura.profesor_nombre }]
                }).trigger('change');

                $('#edit_situacion_revista').val(asignatura.situacion_revista);
                $('#edit_inscriptos').val(asignatura.inscriptos);
                $('#edit_regulares').val(asignatura.regulares);
                $('#edit_atraso_academico').val(asignatura.atraso_academico);
                $('#edit_recursantes').val(asignatura.recursantes);
                $('#edit_modulos').val(asignatura.modulos);
                $('#edit_primer_periodo').val(asignatura.primer_periodo);
                $('#edit_segundo_periodo').val(asignatura.segundo_periodo);

                $('#modalEditarAsignatura').modal('show');
            },
            error: function(error) {
                console.error("Error en la solicitud AJAX", error);
            }
        });
    });
});
</script>