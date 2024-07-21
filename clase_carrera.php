<?php
    require_once "database\conectar_db.php";

    #region clase Carrera
    class Carrera{

        #region atributos
        private $carrera_id;
        private $carrera_nombre;
        #endregion

        #region constructor
        public function __construct($carrera_nombre){
            // $this->carrera_id = $carrera_id;
            $this->carrera_nombre = $carrera_nombre;
        }
        #endregion
        
        #region crearCarrera
        public function crearCarrera(){
            $con = conectar_db();
            mysqli_query($con, "insert into carreras (carrera_nombre) values ('$this->carrera_nombre');");

            if (mysqli_affected_rows($con) > 0) {
                ?><script>
                    alert("Carrera creada con éxito");
                </script>
            <?php
                } else {
            ?><script>
                alert("No se pudo crear la carrera");
            </script>
            <?php }
        }
        #endregion

        #region modificarCarrera
        public function modificarCarrera($id){
            $con = conectar_db();
            mysqli_query($con, "update carreras set carrera_nombre = '$this->carrera_nombre' where carrera_id = $id");

            if (mysqli_affected_rows($con) > 0) {
                $texto = "Materia modificada correctamente";
            } else {
                $texto = "No se pudo modificar la materia";
            }
    
            echo "<script>alert('$texto');</script>";
        }
        #endregion


        #region listarCarreras
        public static function listarCarreras(){
            $con = conectar_db();
            $data = mysqli_query($con,"SELECT DISTINCT carrera_id, carrera_nombre FROM carreras ORDER BY carrera_nombre;");
            $carreras = [];

            if (mysqli_affected_rows($con) == 0) {
                echo "<tr><td><b class='bold red'>No hay carreras registradas en el sistema</b></td></tr>";
            } else {
                while ($info = mysqli_fetch_assoc($data)) {
                    $carreras[] = $info;
                }
            }
            
            return $carreras;
        }
        #endregion


    
    #endregion


    #region filtrarCarreras y selecionar
    // Método para obtener y mostrar todos los nombres de las carreras desde la base de datos
        public static function filtrarCarreras(){
            $con = conectar_db();
        // Conexión a la base de datos (suponiendo que ya tienes esto configurado)
            $sql = "SELECT carrera_id, carrera_nombre FROM carreras";
            $resultado = $con->query($sql);

            $carrera = array();
            while ($fila = $resultado->fetch_assoc()) {
                $carrera[] = $fila['carrera_nombre'];
                $carreras[$fila['carrera_nombre']][] = array('carrera_id' => $fila['carrera_id']);
            }

            echo "<br> <form action='pantalla_busqueda.php' method='POST'>";
            echo "<label for='carrera_nombre'>Carrera:     </label>";
            echo "<select name='carrera_nombre'>";
            echo "<option value=''>Seleccione una carrera</option>";
            foreach ($carrera as $nombre_carrera) {
                echo "<option value='{$nombre_carrera}'>{$nombre_carrera}</option>";
            }
            echo "</select>";

            // echo "<br><input type='submit' class = 'button' value='Continuar'>";
            // echo "<br><input type='submit' class='button' value='Continuar' onclick='window.location.href = \"pantalla_busqueda.php\";'>";
            echo "</form> <br>";
        }
    #endregion
    }
?>