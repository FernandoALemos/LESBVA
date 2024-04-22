<?php
    require_once "database\conectar_db.php";

    #region clase Materia
    class Materia{

        #region atributos
        private $materia_id;
        private $materia_nombre;
        private $anio_materia;
        private $ciclo_id;
        private $carrera_id;
        #endregion

        #region constructor
        public function __construct($materia_id,$materia_nombre,$anio_materia,$ciclo_id,$carrera_id){
            $this->materia_id = $materia_id;
            $this->materia_nombre = $materia_nombre;
            $this->anio_materia = $anio_materia;
            $this->ciclo_id = $ciclo_id;
            $this->carrera_id = $carrera_id;
        }
        #endregion

        #region crearMateria
        public function crearMateria(){
            $con = conectar_db();
            $text = "";

            mysqli_query($con, "insert into materias (materia_nombre,anio_materia,ciclo_id,carrera_id) values ('$this->materia_nombre', $this->anio_materia, $this->ciclo_id, $this->carrera_id)");

            (mysqli_affected_rows($con) > 0) ? $text = "Nueva materia agregada" : $text =" No se pudo generar una nueva materia";

            return $text;
        }
        #endregion

        #region modificarMateria
        public function modificarMateria(){
            $con = conectar_db();
            $texto = "";
            mysqli_query($con, "update materias set materia_nombre = '$this->materia_nombre', anio_materia = $this->anio_materia, ciclo_id = $this->ciclo_id, carrera_id = $this->carrera_id where materia_id = $this->materia_id");

            (mysqli_affected_rows($con) > 0) ? $texto = "Materia modificada correctamente" : $texto = "No se pudo modificar la materia";

            return $texto;
        }
        #endregion

        #region eliminarMateria
        public static function eliminarMateria($materia_id){
            $con = conectar_db();
            $text = "";

            mysqli_query($con, "delete from materias where materia_id = $materia_id;");

            (mysqli_affected_rows($con) > 0) ? $text = "Materia eliminada correctamente" : $text = "No se pudo eliminar la materia";

            return $text;
        }
        #endregion

        #region listarMaterias
        public static function listarMaterias(){
            $con = conectar_db();

            $data = mysqli_query($con,"select materias.materia_id, materias.materia_nombre, materias.anio_materia, ciclo_lectivo.anio_lectivo, carreras.carrera_nombre from (( materias inner join ciclo_lectivo on materias.ciclo_id = ciclo_lectivo.ciclo_id ) inner join carreras on materias.carrera_id = carreras.carrera_id);");
            
            if(mysqli_affected_rows($con) == 0){
                echo "<tr><td><b class='bold red'>No hay materias registradas en el sistema</b></td></tr>";
            }else{
                while ($info = mysqli_fetch_assoc($data)){ ?>
                    <tr>
                        <td><?php echo $info['materia_nombre']; ?></td>
                        <td><?php echo $info['anio_materia']; ?></td>
                        <td><?php echo $info['anio_lectivo']; ?></td>
                        <td><?php echo $info['carrera_nombre']; ?></td>
                        <td>
                            <p class="acciones">
                                <a class="modificar" href="pantalla_busqueda.php?pan=1 & acc=5 & materia_id=<?php echo $info['materia_id']; ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a class="eliminar" href="pantalla_busqueda.php?pan=1 & acc=6 & materia_id=<?php echo $info['materia_id']; ?>">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </p>
                        </td>
                    </tr>
                <?php   }
            }
        }
        #endregion

        #region buscarMateria
        public static function buscarMateria($materia_id){
            $con = conectar_db();
            
            $info = mysqli_query($con, "select materias.materia_id, materias.materia_nombre, materias.anio_materia,
            ciclo_lectivo.anio_lectivo, carreras.carrera_nombre from (( materias inner join ciclo_lectivo on materias.ciclo_id = ciclo_lectivo.ciclo_id ) inner join carreras on materias.carrera_id = carreras.carrera_id) where materias.materia_id = $materia_id;");

            $data = mysqli_fetch_assoc($info);

            return $data;
        }
        #endregion

        
        #region mostrarMaterias y selecionar
        // Método para obtener y mostrar todos los nombres de las materias desde la base de datos
        public static function filterMateria(){
            // Conexión a la base de datos (suponiendo que ya tienes esto configurado)
                $con = conectar_db();
                // Consulta SQL para obtener los nombres de las materias
                $sql = "SELECT materia_id, materia_nombre ,anio_materia FROM materias";
                $resultado = $con->query($sql);

                // Mostrar los nombres de las materias y permitir al usuario seleccionar una
                echo "<form action='pantalla_busqueda.php' method='POST'>"; // Formulario para enviar la selección a otra pantalla
                echo "<select name='materia_id'>"; // Lista desplegable para mostrar los nombres de las materias
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<option value='{$fila['materia_id']}'>{$fila['materia_nombre']}</option>";
                }
                echo "</select>";
                echo "<input type='submit' value='Seleccionar'>";
                echo "</form>";
            }
        #endregion
        public static function filterAñoMateria(){
            $con = conectar_db();
            
            // Consulta SQL para obtener los nombres de las materias y los años
            $sql = "SELECT materia_id, materia_nombre, anio_materia FROM materias";
            $resultado = $con->query($sql);
            
            // Mostrar los nombres de las materias y permitir al usuario seleccionar una
            echo "<form action='pantalla_busqueda.php' method='POST'>"; // Formulario para enviar la selección a otra pantalla
            echo "<br><label for='anio_materia'>Año de la materia:</label>";
            echo "<select name='anio_materia'>";
            echo "<option value=''>Selecciona un año</option>";
            while ($fila = $resultado->fetch_assoc()) {
                echo "<option value='{$fila['anio_materia']}'>{$fila['anio_materia']}</option>";
            }
            echo "</select>";
            
            // Mostrar los años de las materias y permitir al usuario seleccionar uno
            $resultado->data_seek(0); // Reiniciar el puntero del resultado
            echo "<label for='materia_nombre'>Nombre de la materia:</label>";
            echo "<select name='materia_nombre'>";
            echo "<option value=''>Selecciona una materia</option>";
            while ($fila = $resultado->fetch_assoc()) {
                echo "<option value='{$fila['materia_id']}'>{$fila['materia_nombre']}</option>";
            }
            echo "</select>";
            echo "<br><input type='submit' value='Filtrar'>";

            // Procesar la selección del usuario y llamar a la función mostrarMateriasFiltradas
            // if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //     $materia_id = $_POST['materia_nombre'];
            //     $anio_materia = $_POST['anio_materia'];
            //     // Llamar a la función mostrarMateriasFiltradas con los valores seleccionados
            //     mostrarMateriasFiltradas($materia_id, $anio_materia);
            // }
            echo "</form>";
        }

        public static function mostrarMateriasFiltradas($materia_id, $anio_materia){
            // Conexión a la base de datos (suponiendo que ya tienes esto configurado)
            $con = conectar_db();
            
            // Consulta SQL para obtener las materias filtradas por nombre y año
            $sql = "SELECT materia_nombre, anio_materia FROM materias WHERE materia_id = '{$materia_id}' AND anio_materia = '{$anio_materia}'";
            $resultado = $con->query($sql);
            
            // Mostrar el listado de materias filtradas
            echo "<h2>Materias filtradas:</h2>";
            echo "<ul>";
            while ($fila = $resultado->fetch_assoc()) {
                echo "<li>{$fila['materia_nombre']} - Año: {$fila['anio_materia']}</li>";
            }
            echo "</ul>";
        }
    }
    #endregion

?>