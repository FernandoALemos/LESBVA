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
            $this->carrera_nombre = $carrera_nombre;
        }
        #endregion
        
        #region crearCarrera
        public function crearCarrera(){
            $con = conectar_db();
            $sql = "INSERT INTO carreras (carrera_nombre) 
                    VALUES (?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $this->carrera_nombre);
            $stmt->execute();
        }
        #endregion

        #region modificarCarrera
        public function modificarCarrera($carrera_id){
            $con = conectar_db();
            $sql = "UPDATE carreras 
                    SET carrera_nombre = ?
                    WHERE carrera_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("si", $this->carrera_nombre, $carrera_id);
            $stmt->execute();
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
    public static function filtrarCarreras(){
        $con = conectar_db();
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
        echo "</form> <br>";
    }
    #endregion

    public static function verificarCarrera($carrera_nombre, $carrera_id = null) {
        $con = conectar_db();
        $sql = "SELECT carrera_id, carrera_nombre FROM carreras
        WHERE carrera_nombre = ?";
        
        if ($carrera_id !== null) {
            $sql .= " AND carrera_id <> ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("si", $carrera_nombre, $carrera_id);
        } else {
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $carrera_nombre);
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