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
        public function crearMateriaCarrera(){
            $con = conectar_db();
            $text = "";

            mysqli_query($con, "insert into materias (materia_nombre) values ('$this->materia_nombre')");

            (mysqli_affected_rows($con) > 0) ? $text = "Nueva materia agregada" : $text =" No se pudo generar una nueva materia";

            return $text;
        }
        #endregion

        #region modificarMateriasCarrera
        public function modificarMateriasCarrera(){
            $con = conectar_db();
            $texto = "";
            mysqli_query($con, "update materias set materia_nombre = '$this->materia_nombre' where id = $this->id");

            (mysqli_affected_rows($con) > 0) ? $texto = "Materia modificada correctamente" : $texto = "No se pudo modificar la materia";

            return $texto;
        }
        #endregion

        #region eliminarMateriasCarrera
        public static function eliminarMateriasCarrera($id){
            $con = conectar_db();
            $text = "";

            mysqli_query($con, "delete from materias where id = $id;");

            (mysqli_affected_rows($con) > 0) ? $text = "Materia eliminada correctamente" : $text = "No se pudo eliminar la materia";

            return $text;
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