<?php
    require_once "database\conectar_db.php";

    #region clase Curso
    class Curso{

        #region atributos
        private $curso_id;
        private $curso;
        #endregion

        #region constructor
        public function __construct($curso){
            $this->curso = $curso;
        }
        #endregion

        #region ABM Cursos
        #region crearCurso
        public function crearCurso(){
            $con = conectar_db();
            $sql = "INSERT INTO cursos (curso) 
                    VALUES (?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $this->curso);
            $stmt->execute();
        }
        #endregion

        #region modificarCurso
        public function modificarCurso($curso_id){
            $con = conectar_db();
            $sql = "UPDATE cursos 
                    SET curso = ?
                    WHERE curso_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("si", $this->curso, $curso_id);
            $stmt->execute();
        }
        #endregion

        #endregion

        public static function filtrarCurso(){
            $con = conectar_db();
            
            $sql = "SELECT DISTINCT curso FROM cursos";
            $resultado = $con->query($sql);
            
            // Almacenar los años de cursos en un array asociativo
            $cursos_cursos = array();
            while ($fila = $resultado->fetch_assoc()) {
                $cursos_cursos[] = $fila['curso'];
            }
            
            echo "<form action='pantalla_listar_materia.php' method='POST'>";
            echo "<br><label for='curso'>Curso:      </label>";
            echo "<select name='curso'>";
            echo "<option value=''>Seleccione un curso</option>";
            foreach ($cursos_cursos as $curso) {
                echo "<option value='{$curso}'>{$curso}</option>";
            }
            echo "</select>";

            echo "<br><input type='submit' class='button' value='Continuar' onclick='window.location.href = \"pantalla_listar_materia.php\";'>";
            echo "</form>";
        }


        public static function listar_Cursos() {
            $con = conectar_db();
            $data = mysqli_query($con, "SELECT curso_id, curso FROM cursos ORDER BY curso");
            if (!$data) {
                echo "Error en la consulta: " . mysqli_error($con);
                return [];
            }
        
            $cursos = [];
        
            if (mysqli_affected_rows($con) == 0) {
                echo "<tr><td><b class='bold red'>No hay cursos registrados en el sistema</b></td></tr>";
            } else {
                while ($info = mysqli_fetch_assoc($data)) {
                    $cursos[] = $info;
                }
            }
        
            return $cursos;
        }

        public static function verificarCurso($curso, $curso_id = null) {
            $con = conectar_db();
            $sql = "SELECT curso_id, curso FROM cursos
            WHERE curso = ?";
            
            if ($curso_id !== null) {
                $sql .= " AND curso_id <> ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("si", $curso, $curso_id);
            } else {
                $stmt = $con->prepare($sql);
                $stmt->bind_param("s", $curso);
            }
            
            $stmt->execute();
            $resultado = $stmt->get_result();
    
            if ($resultado->num_rows > 0) {
                return true;
            }
            else{
                return false;
            }
        }

    }
?>