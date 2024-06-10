<?php
    require_once "database\conectar_db.php";

    #region clase Curso
    class Curso{

        #region atributos
        private $curso_id;
        private $curso;
        #endregion

        #region constructor
        public function __construct($curso_id,$curso){
            $this->curso_id = $curso_id;
            $this->curso = $curso;
        }
        #endregion

        #region ABM Cursos
        #region crearCurso
        public function crearCurso(){
            $con = conectar_db();
            $text = "";

            mysqli_query($con, "insert into cursos (curso) values ('$this->curso')");

            (mysqli_affected_rows($con) > 0) ? $text = "Nueva curso agregada" : $text =" No se pudo generar una nueva curso";

            return $text;
        }
        #endregion

        #region modificarCurso
        public function modificarCurso(){
            $con = condb();
            $texto = "";
            mysqli_query($con, "update cursos set curso = '$this->curso' where curso_id = $this->curso_id");

            (mysqli_affected_rows($con) > 0) ? $texto = "Curso modificada correctamente" : $texto = "No se pudo modificar la curso";

            return $texto;
        }
        #endregion

        #region eliminarCurso
        public static function eliminarCurso($curso_id){
            $con = condb();
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
        public static function listarCursos(){
            $con = conectar_db();
            // PROBAR
            $data = mysqli_query($con,"select cursos.curso order by  cursos.curso;");
            
            if(mysqli_affected_rows($con) == 0){
                echo "<tr><td><b class='bold red'>No hay curos registrados en el sistema</b></td></tr>";
            }else{
                while ($info = mysqli_fetch_assoc($data)){ ?>
                    <tr>
                        <td><?php echo $info['curso']; ?></td>
                        <td>
                            <p class="acciones">
                                <a class="modificar" href="pantalla_busqueda.php?pan=1 & acc=5 & curso_id=<?php echo $info['curso_id']; ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </p>
                        </td>
                    </tr>
                <?php   }
            }
        }
        #endregion
    }
?>