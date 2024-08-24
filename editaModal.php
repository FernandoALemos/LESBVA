<?php
require_once "database/conectar_db.php";
require_once "clase_ciclo.php";
require_once "clase_materia.php";
require_once "clase_usuario.php";
require_once "clase_carrera.php";
require_once "clase_curso.php";
require_once "clase_profesores.php";
require_once "clase_materia_carrera.php";
?>

<!-- Modal para Editar Asignatura -->
<div class="modal fade" id="editaModal" tabindex="-1" aria-labelledby="editaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editaModalLabel">Editar Asignatura</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Contenido del modal -->
                <form>
                <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarAsignaturaLabel">Editar Asignatura</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        <!-- Campos del formulario -->
                        <input type="hidden" id="edit_asignatura_id" name="asignatura_id">
                        <!-- Ciclo -->
                        <div class="form-group">
                            <label for="edit_ciclo_id">Ciclo</label>
                            <select class="form-control select2" id="edit_ciclo_id" name="ciclo_id" required>
                                <?php
                                    $ciclos = CicloLectivo::listarrCiclos();
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
                        <!-- Otros campos siguen el mismo formato -->
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
                    <!-- Otros campos de formulario -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>
