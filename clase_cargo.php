<?php
    require_once "database\conectar_db.php";

    #region clase Cargo
    class Cargo{

        #region atributos
        private $cargo_id;
        private $carrera_id;
        private $turno_id;
        private $cargo_nombre;
        #endregion

        #region constructor
        public function __construct($carrera_id,$turno_id,$cargo_nombre){
            $this->carrera_id = $carrera_id;
            $this->turno_id = $turno_id;
            $this->cargo_nombre = $cargo_nombre;
        }
        #endregion

        #region ABM Cargo
        #region crearCargo
        public function crearCargo() {
            $con = conectar_db();

            $stmt = $con->prepare("INSERT INTO cargos (carrera_id, turno_id, cargo_nombre) VALUES (?, ?, ?)");
            $stmt->bind_param('iis', $this->carrera_id, $this->turno_id, $this->cargo_nombre);
    
            if ($stmt->execute()) {
                echo "<script>alert('Cargo creado con éxito');</script>";
            } else {
                echo "<script>alert('No se pudo crear el cargo: " . $stmt->error . "');</script>";
            }
    
            $stmt->close();
            $con->close();
        }
        #endregion

        #region modificarCargo
        public function modificarCargo($id) {
            $con = conectar_db();
            $texto = "";
        
            $sql = "UPDATE cargos SET 
                    carrera_id = '$this->carrera_id', 
                    turno_id = '$this->turno_id', 
                    cargo_nombre = '$this->cargo_nombre'
                    WHERE cargo_id = $id";
        
            mysqli_query($con, $sql);
        
            if (mysqli_affected_rows($con) > 0) {
                $texto = "Se modificó correctamente el cargo.";
            } else {
                $texto = "No se pudo modificar el cargo.";
            }
        
            echo "<script>alert('$texto');</script>";
        }
        #endregion

        #region listarCargos
        public static function listarCargos() {
            $con = conectar_db();
            
            $sql = "SELECT cargos.cargo_id, cargos.cargo_nombre, c.carrera_nombre, t.turno
                    FROM cargos
                    JOIN carreras c ON cargos.carrera_id = c.carrera_id
                    JOIN turnos t ON cargos.turno_id = t.turno_id
                    ORDER BY c.carrera_nombre, t.turno, cargos.cargo_nombre";
    
            $result = $con->query($sql);
            $cargos = [];
    
            if ($result->num_rows == 0) {
                echo "<tr><td colspan='4'><b class='bold red'>No hay cargos registrados en el sistema</b></td></tr>";
            } else {
                while ($info = $result->fetch_assoc()) {
                    $cargos[] = $info;
                }
            }
    
            $con->close();
            return $cargos;
        }
        #endregion

        #region verificarExistenciaCargo
        public static function verificarExistenciaCargo($carrera_id, $turno_id, $cargo_nombre, $cargo_id = null) {
            $con = conectar_db();
            $sql = "SELECT cargo_id FROM cargos 
                    WHERE carrera_id = ? 
                    AND turno_id = ? 
                    AND cargo_nombre = ?";
        
            if ($cargo_id !== null) {
                $sql .= " AND cargo_id <> ?";
            }
            $stmt = $con->prepare($sql);
        
            if ($cargo_id !== null) {
                $stmt->bind_param("iisi", $carrera_id, $turno_id, $cargo_nombre, $cargo_id);
            } else {
                $stmt->bind_param("iis", $carrera_id, $turno_id, $cargo_nombre);
            }
        
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows > 0) {
                return true;
            }
        
            return false;
        }
        #endregion


    #endregion

    }
?>