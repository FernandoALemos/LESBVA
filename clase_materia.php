<?php
    require_once "database\conectar_db.php";

    #region clase Materia
    class Materia{

        #region atributos
        private $materia_id;
        private $materia_nombre;
        private $curso;
        private $ciclo_id;
        private $carrera_id;
        #endregion

        #region constructor
        public function __construct($materia_id,$materia_nombre,$curso,$ciclo_id,$carrera_id){
            $this->materia_id = $materia_id;
            $this->materia_nombre = $materia_nombre;
            $this->curso = $curso;
            $this->ciclo_id = $ciclo_id;
            $this->carrera_id = $carrera_id;
        }
        #endregion

        // DEJAR Y VER SI SE USARA
        // #region crearMateria
        // public function crearMateria(){
        //     $con = conectar_db();
        //     $text = "";

        //     mysqli_query($con, "insert into materias (materia_nombre,curso,ciclo_id,carrera_id) values ('$this->materia_nombre', $this->curso, $this->ciclo_id, $this->carrera_id)");

        //     (mysqli_affected_rows($con) > 0) ? $text = "Nueva materia agregada" : $text =" No se pudo generar una nueva materia";

        //     return $text;
        // }
        // #endregion



        #region listarMaterias
        public static function listarMaterias(){
            $con = conectar_db();

            // $data = mysqli_query($con,"select materias.materia_id, materias.materia_nombre, materias.curso, materias.profesor, materias.situacion_revista, materias.cantidad_alumno, ciclo_lectivo.anio_lectivo, carreras.carrera_nombre from (( materias inner join ciclo_lectivo on materias.ciclo_id = ciclo_lectivo.ciclo_id ) inner join carreras on materias.carrera_id = carreras.carrera_id) order by  materias.curso, materias.materia_nombre;");

            // PROBAR
            $data = mysqli_query($con,"select materias.materia_id, materias.materia_nombre, materias.curso, materias.profesor, materias.situacion_revista, materias.cantidad_alumno, ciclo_lectivo.anio_lectivo, carreras.carrera_nombre from (( materias inner join ciclo_lectivo on materias.ciclo_id = ciclo_lectivo.ciclo_id ) inner join carreras on materias.carrera_id = carreras.carrera_id)  WHERE materias.curso = '{$_POST['curso']}' order by  materias.curso, materias.materia_nombre;");
            
            if(mysqli_affected_rows($con) == 0){
                echo "<tr><td><b class='bold red'>No hay materias registradas en el sistema</b></td></tr>";
            }else{
                while ($info = mysqli_fetch_assoc($data)){ ?>
                    <tr>
                        <td><?php echo (2024); ?></td>
                        <td><?php echo $info['curso']; ?></td>
                        <td><?php echo $info['materia_nombre']; ?></td>
                        <td><?php echo $info['profesor']; ?></td>
                        <td><?php echo $info['situacion_revista']; ?></td>
                        <td><?php echo $info['cantidad_alumno']; ?></td>
                        <td></td>
                        <td>
                            <p class="acciones">
                                <a class="modificar" href="pantalla_busqueda.php?pan=1 & acc=5 & materia_id=<?php echo $info['materia_id']; ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </p>
                        </td>
                    </tr>
                <?php   }
            }
        }
        #endregion

        // filtrar curso HACER QUE FUNCIONE EL FILTRO PARA EL CURSO
        public static function filtrarCurso(){
            $con = conectar_db();
            
            // Consulta SQL para obtener los nombres de las materias y los años
            // $_POST['curso'] rompe si se llama directamente sin usar
            // No es necesario tomar $_POST['curso'] dado que al enviar el form, lo toma la funcion porque ya obtiene ese dato
            $sql = "SELECT DISTINCT curso FROM materias";
            $resultado = $con->query($sql);
            
            // Almacenar los años de materias en un array asociativo
            $cursos_materias = array();
            while ($fila = $resultado->fetch_assoc()) {
                $cursos_materias[] = $fila['curso'];
            }
            
            // Mostrar el formulario con las opciones
            echo "<form action='pantalla_listar_materia.php' method='POST'>";
            echo "<br><label for='curso'>Curso:      </label>";
            echo "<select name='curso'>";
            echo "<option value=''>Seleccione un curso</option>";
            foreach ($cursos_materias as $curso) {
                echo "<option value='{$curso}'>{$curso}</option>";
            }
            echo "</select>";

            echo "<br><input type='submit' class='button' value='Continuar' onclick='window.location.href = \"pantalla_listar_materia.php\";'>";
            echo "</form>";
        }
    }
    #endregion

?>
