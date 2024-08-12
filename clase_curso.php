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
            // $this->curso_id = $curso_id;
            $this->curso = $curso;
        }
        #endregion

        #region ABM Cursos
        #region crearCurso
        public function crearCurso(){
            $con = conectar_db();
            mysqli_query($con, "insert into cursos (curso) values ('$this->curso')");

            if (mysqli_affected_rows($con) > 0) {
                ?><script>
                    alert("Curso creado con éxito");
                </script>
            <?php
                } else {
            ?><script>
                alert("No se pudo crear el curso");
            </script>
            <?php }
        }
        #endregion

        #region modificarCurso
        public function modificarCurso($id){
            $con = conectar_db();
            mysqli_query($con, "update cursos set curso = '$this->curso' where curso_id = $id");

            if (mysqli_affected_rows($con) > 0) {
                $texto = "Curso modificado correctamente";
            } else {
                $texto = "No se pudo modificar el curso";
            }
    
            echo "<script>alert('$texto');</script>";
        }
        #endregion

        #region eliminarCurso
        public static function eliminarCurso($curso_id){
            $con = conectar_db();
            $text = "";

            mysqli_query($con, "delete from cursos where curso_id = $curso_id;");

            (mysqli_affected_rows($con) > 0) ? $text = "Curso eliminada correctamente" : $text = "No se pudo eliminar la curso";

            return $text;
        }
        #endregion
        #endregion

        //filtrar curso HACER QUE FUNCIONE EL FILTRO PARA EL CURSO
        public static function filtrarCurso(){
            $con = conectar_db();
            
            // Consulta SQL para obtener los nombres de las cursos y los años
            // $_POST['curso'] rompe si se llama directamente sin usar
            // No es necesario tomar $_POST['curso'] dado que al enviar el form, lo toma la funcion porque ya obtiene ese dato
            $sql = "SELECT DISTINCT curso FROM cursos";
            $resultado = $con->query($sql);
            
            // Almacenar los años de cursos en un array asociativo
            $cursos_cursos = array();
            while ($fila = $resultado->fetch_assoc()) {
                $cursos_cursos[] = $fila['curso'];
            }
            
            // Mostrar el formulario con las opciones
            echo "<form action='pantalla_listar_materia.php' method='POST'>";
            echo "<br><label for='curso'>Curso:      </label>";
            echo "<select name='curso'>";
            echo "<option value=''>Seleccione un curso</option>";
            foreach ($cursos_cursos as $curso) {
                echo "<option value='{$curso}'>{$curso}</option>";
            }
            echo "</select>";

            // VER SI ESTO HACE QUE TENGA POST PARA ESTE QUERY (VER EN CICLO Y CARRERAS)
            echo "<br><input type='submit' class='button' value='Continuar' onclick='window.location.href = \"pantalla_listar_materia.php\";'>";
            echo "</form>";
        }

        #region listarCuros
        // public static function listarCursos(){
        //     $con = conectar_db();
        //     $data = mysqli_query($con,"SELECT DISTINCT cursos_id, curso FROM cursos ORDER BY curso");
        //     $cursos = [];
            
        //     if (mysqli_affected_rows($con) == 0) {
        //         echo "<tr><td><b class='bold red'>No hay cursos registrados en el sistema</b></td></tr>";
        //     } else {
        //         while ($info = mysqli_fetch_assoc($data)) {
        //             $cursos[] = $info;
        //         }
        //     }
            
        //     return $cursos;
        // }
        #endregion


        public static function listar_Cursos() {
            $con = conectar_db();
            $data = mysqli_query($con, "SELECT curso_id, curso FROM cursos ORDER BY curso");
        
            // Verificar si la consulta fue exitosa
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
    }
?>