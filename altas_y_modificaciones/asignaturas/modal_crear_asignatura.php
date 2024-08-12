<!-- Modal para Crear Asignatura -->
<div class="modal fade" id="modalCrearAsignatura" tabindex="-1" role="dialog" aria-labelledby="modalCrearAsignaturaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="crear_asignatura.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCrearAsignaturaLabel">Nueva Asignatura</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Campo Ciclo -->
                    <div class="form-group">
                        <label for="ciclo_id">Ciclo</label>
                        <select class="form-control select2" id="ciclo_id" name="ciclo_id" required>
                            <?php
                            $ciclos = CicloLectivo::listarCiclos();
                            foreach ($ciclos as $ciclo) {
                                echo "<option value='{$ciclo['ciclo_id']}'>{$ciclo['ciclo']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Campo Turno -->
                    <div class="form-group">
                        <label for="turno_id">Turno</label>
                        <select class="form-control select2" id="turno_id" name="turno_id" required>
                            <?php
                            $turnos = Turno::listarTurnos();
                            foreach ($turnos as $turno) {
                                echo "<option value='{$turno['turno_id']}'>{$turno['turno']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Campo Carrera -->
                    <div class="form-group">
                        <label for="carrera_id">Carrera</label>
                        <select class="form-control select2" id="carrera_id" name="carrera_id" required>
                            <?php
                            $carreras = Carrera::listarCarreras();
                            foreach ($carreras as $carrera) {
                                echo "<option value='{$carrera['carrera_id']}'>{$carrera['carrera_nombre']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Campo Curso -->
                    <div class="form-group">
                        <label for="curso_id">Curso</label>
                        <select class="form-control select2" id="curso_id" name="curso_id" required>
                            <?php
                            $cursos = Curso::listar_Cursos();
                            foreach ($cursos as $curso) {
                                echo "<option value='{$curso['curso_id']}'>{$curso['curso']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Campo Materia -->
                    <div class="form-group">
                        <label for="materia_id">Materia</label>
                        <select class="form-control select2" id="materia_id" name="materia_id" required>
                            <?php
                            $materias = Materia::listarMaterias();
                            foreach ($materias as $materia) {
                                echo "<option value='{$materia['materia_id']}'>{$materia['materia_nombre']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Campo Profesor -->
                    <div class="form-group">
                        <label for="profesor_id">Profesor</label>
                        <select class="form-control select2" id="profesor_id" name="profesor_id" required>
                            <?php
                            $profesores = Profesor::listarProfesores();
                            foreach ($profesores as $profesor) {
                                echo "<option value='{$profesor['profesor_id']}'>{$profesor['profesor_apellido']} {$profesor['profesor_nombre']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Campo Situación de Revista -->
                    <div class="form-group">
                        <label for="situacion_revista">Situación de Revista</label>
                        <input type="text" class="form-control" id="situacion_revista" name="situacion_revista" required>
                    </div>
                    <!-- Campo Inscriptos -->
                    <div class="form-group">
                        <label for="inscriptos">Inscriptos</label>
                        <input type="number" class="form-control" id="inscriptos" name="inscriptos" required>
                    </div>
                    <!-- Campo Regulares -->
                    <div class="form-group">
                        <label for="regulares">Regulares</label>
                        <input type="number" class="form-control" id="regulares" name="regulares" required>
                    </div>
                    <!-- Campo Atraso Académico -->
                    <div class="form-group">
                        <label for="atraso_academico">Atraso Académico</label>
                        <input type="number" class="form-control" id="atraso_academico" name="atraso_academico" required>
                    </div>
                    <!-- Campo Recursantes -->
                    <div class="form-group">
                        <label for="recursantes">Recursantes</label>
                        <input type="number" class="form-control" id="recursantes" name="recursantes" required>
                    </div>
                    <!-- Campo Módulos -->
                    <div class="form-group">
                        <label for="modulos">Módulos</label>
                        <input type="number" class="form-control" id="modulos" name="modulos" required>
                    </div>
                    <!-- Campo 1° Período -->
                    <div class="form-group">
                        <label for="primer_periodo">1° Período</label>
                        <input type="number" class="form-control" id="primer_periodo" name="primer_periodo" required>
                    </div>
                    <!-- Campo 2° Período -->
                    <div class="form-group">
                        <label for="segundo_periodo">2° Período</label>
                        <input type="number" class="form-control" id="segundo_periodo" name="segundo_periodo" required>
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