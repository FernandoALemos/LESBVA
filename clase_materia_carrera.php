<?php
    require_once "database\conectar_db.php";

    #region clase MateriaCarrera clase para asignar
    class MateriaCarrera{

        #region atributos
        private $materia_carrera_id;
        private $materia_id;
        private $carrera_id;
        private $ciclo_id;
        private $curso_id;
        private $turno_id;
        private $profesor_id;
        private $situacion_revista;
        private $inscriptos;
        private $regulares;
        private $atraso_academico;
        private $recursantes;
        private $modulos;
        private $primer_periodo;
        private $segundo_periodo;
        #endregion

        #region constructor
        public function __construct(
        $materia_id,
        $carrera_id,
        $ciclo_id,
        $curso_id,
        $turno_id,
        $profesor_id,
        $situacion_revista,
        $inscriptos,
        $regulares,
        $atraso_academico,
        $recursantes,
        $modulos,
        $primer_periodo,
        $segundo_periodo,
        ){
            $this->materia_id = $materia_id;
            $this->carrera_id = $carrera_id;
            $this->ciclo_id = $ciclo_id;
            $this->curso_id = $curso_id;
            $this->turno_id = $turno_id;
            $this->profesor_id = $profesor_id;
            $this->situacion_revista = $situacion_revista;
            $this->inscriptos = $inscriptos;
            $this->regulares = $regulares;
            $this->atraso_academico = $atraso_academico;
            $this->recursantes = $recursantes;
            $this->modulos = $modulos;
            $this->primer_periodo = $primer_periodo;
            $this->segundo_periodo = $segundo_periodo;
        }
        #endregion

        #region crearMateriasDeCarrera
        public static function crearAsignatura($ciclo_id, $carrera_id, $turno_id, $curso_id, $materia_id, $profesor_id, $situacion_revista, $modulos, $inscriptos, $regulares, $atraso_academico, $recursantes, $primer_periodo, $segundo_periodo) {
            $con = conectar_db();
            $sql = "INSERT INTO materia_carrera 
                    (ciclo_id, carrera_id, turno_id, curso_id, materia_id, profesor_id, situacion_revista, modulos, inscriptos, regulares, atraso_academico, recursantes, primer_periodo, segundo_periodo)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
            $stmt = $con->prepare($sql);
            if (!$stmt) {
                die('Error en la preparación de la consulta: ' . $con->error);
            }
    
            $stmt->bind_param(
                'iiiiiisiiiiiii', 
                $ciclo_id, $carrera_id, $turno_id, $curso_id, $materia_id, $profesor_id, 
                $situacion_revista, $modulos, $inscriptos, $regulares, 
                $atraso_academico, $recursantes, $primer_periodo, $segundo_periodo
            );
    
            if ($stmt->execute()) {
                echo "Asignatura creada con éxito.";
            } else {
                echo "Error al crear la asignatura: " . $stmt->error;
            }
    
            $stmt->close();
            $con->close();
        }
        #endregion

        #region modificarAsignatura
        public static function modificarAsignatura($asignatura_id, $ciclo_id, $carrera_id, $turno_id, $curso_id, $materia_id, $profesor_id, $situacion_revista, $modulos, $inscriptos, $regulares, $atraso_academico, $recursantes, $primer_periodo, $segundo_periodo) {
            $con = conectar_db();

            $sql = "UPDATE materia_carrera 
                    SET ciclo_id = ?, 
                        carrera_id = ?, 
                        turno_id = ?, 
                        curso_id = ?, 
                        materia_id = ?, 
                        profesor_id = ?, 
                        situacion_revista = ?, 
                        modulos = ?, 
                        inscriptos = ?, 
                        regulares = ?, 
                        atraso_academico = ?, 
                        recursantes = ?, 
                        primer_periodo = ?, 
                        segundo_periodo = ?
                    WHERE materia_carrera_id = ?";
        
            $stmt = $con->prepare($sql);
        
            if ($stmt === false) {
                return ['success' => false, 'message' => 'Error preparando la consulta.'];
            }
        
            $stmt->bind_param(
                "iiiiiisiiiiiiii", 
                $ciclo_id, $carrera_id, $turno_id, $curso_id, $materia_id, $profesor_id, 
                $situacion_revista, $modulos, $inscriptos, $regulares, $atraso_academico, 
                $recursantes, $primer_periodo, $segundo_periodo, $asignatura_id
            );
        
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Asignatura actualizada exitosamente.'];
            } else {
                return ['success' => false, 'message' => 'Error actualizando la asignatura.'];
            }
        }
        #endregion


        #region obtenerAsignaturasPorIds
        public static function obtenerAsignaturasPorIds($data) {
            $con = conectar_db();
            
            // convertir el array de IDs en una cadena separada por comas
            $data_list = implode(",", $data);
            
            $sql = "SELECT mc.*, 
                            m.materia_nombre, 
                            c.carrera_nombre, 
                            cl.ciclo, 
                            cr.curso, 
                            t.turno, 
                            p.profesor_nombre, 
                            p.profesor_apellido,
                            mc.situacion_revista,
                            mc.inscriptos,
                            mc.regulares,
                            mc.atraso_academico,
                            mc.recursantes,
                            mc.modulos,
                            mc.primer_periodo,
                            mc.segundo_periodo
                    FROM materia_carrera mc
                    JOIN materias m ON mc.materia_id = m.materia_id
                    JOIN carreras c ON mc.carrera_id = c.carrera_id
                    JOIN ciclo_lectivo cl ON mc.ciclo_id = cl.ciclo_id
                    JOIN cursos cr ON mc.curso_id = cr.curso_id
                    JOIN turnos t ON mc.turno_id = t.turno_id
                    JOIN profesores p ON mc.profesor_id = p.profesor_id
                    WHERE mc.materia_carrera_id IN ($data_list)
                    ORDER BY cl.ciclo,
                            c.carrera_nombre, 
                            cr.curso, 
                            m.materia_nombre, 
                            p.profesor_apellido";
            
            $result = $con->query($sql);
            
            $asignaturas = [];
            while ($fila = $result->fetch_assoc()) {
                $asignaturas[] = $fila;
            }
            
            $con->close();
            return $asignaturas;
        }
        #endregion

        #region obtenerAsignaturaPorId
        public static function obtenerAsignaturaPorId($id) {
            $con = conectar_db();
            $query = "SELECT mc.*, 
                            m.materia_nombre, 
                            c.carrera_nombre, 
                            cl.ciclo, 
                            cr.curso, 
                            t.turno, 
                            p.profesor_nombre, 
                            p.profesor_apellido,
                            mc.situacion_revista,
                            mc.inscriptos,
                            mc.regulares,
                            mc.atraso_academico,
                            mc.recursantes,
                            mc.modulos,
                            mc.primer_periodo,
                            mc.segundo_periodo
                    FROM materia_carrera mc
                    JOIN materias m ON mc.materia_id = m.materia_id
                    JOIN carreras c ON mc.carrera_id = c.carrera_id
                    JOIN ciclo_lectivo cl ON mc.ciclo_id = cl.ciclo_id
                    JOIN cursos cr ON mc.curso_id = cr.curso_id
                    JOIN turnos t ON mc.turno_id = t.turno_id
                    JOIN profesores p ON mc.profesor_id = p.profesor_id
                    WHERE mc.materia_carrera_id = :id";
            $stmt = $conexion->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        #endregion

        public static function verificarExistenciaAsignatura($ciclo_id, $carrera_id, $turno_id, $curso_id, $materia_id, $profesor_id, $asignatura_id = null) {
            $con = conectar_db();
            
            // Primera consulta: verificar si ya existen dos asignaturas con los mismos ciclo_id, carrera_id, turno_id, curso_id y materia_id
            $sql = "SELECT COUNT(*) as total 
                    FROM materia_carrera 
                    WHERE ciclo_id = ? AND carrera_id = ? AND turno_id = ? AND curso_id = ? AND materia_id = ?";
        
            $params = [$ciclo_id, $carrera_id, $turno_id, $curso_id, $materia_id];
            $types = "iiiii"; 
        
            // Si es una edición (asignatura_id no es null), excluimos la asignatura actual
            if ($asignatura_id !== null) {
                $sql .= " AND materia_carrera_id <> ?";
                $params[] = $asignatura_id;
                $types .= "i";
            }
        
            // Ejecutar la primera consulta
            $stmt = $con->prepare($sql);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
        
            // Si ya hay dos asignaturas con los mismos ciclo_id, carrera_id, turno_id, curso_id y materia_id, devolvemos true
            if ($row['total'] >= 2) {
                return true;
            }
        
            // Segunda consulta: verificar si el profesor ya está asignado a esta materia en este ciclo, carrera, turno, curso y materia
            $sql_profesor = "SELECT COUNT(*) as total 
                    FROM materia_carrera 
                    WHERE ciclo_id = ? AND carrera_id = ? AND turno_id = ? AND curso_id = ? AND materia_id = ? AND profesor_id = ?";
        
            $params_profesor = [$ciclo_id, $carrera_id, $turno_id, $curso_id, $materia_id, $profesor_id];
            $types_profesor = "iiiiii";
        
            // Si estamos editando (asignatura_id no es null), también excluimos la asignatura actual
            if ($asignatura_id !== null) {
                $sql_profesor .= " AND materia_carrera_id <> ?";
                $params_profesor[] = $asignatura_id;
                $types_profesor .= "i";
            }
        
            // Ejecutar la segunda consulta
            $stmt_profesor = $con->prepare($sql_profesor);
            $stmt_profesor->bind_param($types_profesor, ...$params_profesor);
            $stmt_profesor->execute();
            $result_profesor = $stmt_profesor->get_result();
            $row_profesor = $result_profesor->fetch_assoc();
        
            // Si el profesor ya está asignado, devolvemos true
            if ($row_profesor['total'] >= 1) {
                return true;
            }
        
            // Si no hay conflictos, devolvemos false
            return false;
        }
    }
    #endregion

    class Turno{

        #region atributos
        private $turno_id;
        private $turno;
        #endregion

        #region constructor
        public function __construct($turno){
            // $this->turno_id = $turno_id;
            $this->turno = $turno;
        }
        #endregion
        #region listarTurnos
        public static function listarTurnos()
        {
            $con = conectar_db();
            $data = mysqli_query($con, "SELECT DISTINCT turno_id, turno FROM turnos ORDER BY turno");
            $turnos = [];

            if (mysqli_affected_rows($con) == 0) {
                echo "<tr><td><b class='bold red'>No hay turnos registrados en el sistema</b></td></tr>";
            } else {
                while ($info = mysqli_fetch_assoc($data)) {
                    $turnos[] = $info;
                }
            }
            
            return $turnos;
        }
        #endregion
    }

?>