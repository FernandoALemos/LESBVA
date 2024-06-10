<?php
    require_once "database\conectar_db.php";

    #region clase Carrera
    class Carrera{

        #region atributos
        private $carrera_id;
        private $carrera_nombre;
        #endregion

        #region constructor
        public function __construct($carrera_id,$carrera_nombre){
            $this->carrera_id = $carrera_id;
            $this->carrera_nombre = $carrera_nombre;
        }
        #endregion
        
        #region crearCarrera
        public function crearCarrera(){
            $con = conectar_db();
            $text = "";

            mysqli_query($con, "insert into carreras (carrera_nombre) values ('$this->carrera_nombre');");

            (mysqli_affected_rows($con) > 0) ? $text = "Nueva carrera agregada" : $text = "No se pudo agregar una nueva carrera al sistema";

            return $text;
        }
        #endregion

        #region modificarCarrera
        public function modificarCarrera(){
            $con = conectar_db();
            $text = "";

            mysqli_query($con, "update carreras set carrera_nombre = '$this->carrera_nombre' where id = $this->carrera_id;");
            
            (mysqli_affected_rows($con) > 0) ? $text = "Carrera modificada correctamente" : $text = "No se pudo modificar la carrera";

            return $text;
        }
        #endregion


        #region listarCarreras
        public static function listarCarreras(){
            $con = conectar_db();

            $data = mysqli_query($con,"select * from carreras;");
            
            if(mysqli_affected_rows($con) == 0){
                echo "<tr><td><b class='bold red'>No hay carreras registradas en el sistema</b></tr></td>";
            }else{
                while ($info = mysqli_fetch_assoc($data)){ ?>
                    <tr>
                        <td><?php echo $info['carrera_nombre']; ?></td>
                        <td>
                            <p class="acciones">
                                <a class="modificar" href="pantalla_carreras.php?pan=1 & acc=8 & carrera_id=<?php echo $info['carrera_id']; ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a class="eliminar" href="pantalla_carreras.php?pan=1 & acc=9 & carrera_id=<?php echo $info['carrera_id']; ?>">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </p>
                        </td>
                    </tr>
                <?php   }
            }
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