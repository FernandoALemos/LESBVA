<?php
    require_once "database\conectar_db.php";

    #region clase Ciclo
    class CicloLectivo{

        #region atributos
        private $ciclo_id;
        private $ciclo;
        #endregion

        #region constructor
        public function __construct($ciclo){
            $this->ciclo = $ciclo;
        }
        #endregion

        #region ABM Ciclos
        #region crearCiclo
        public function crearCiclo(){
            $con = conectar_db();
            $sql = "INSERT INTO ciclo_lectivo (ciclo) 
                    VALUES (?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $this->ciclo);
            $stmt->execute();
        }
        #endregion

        #region modificarCiclo
        public function modificarCiclo($ciclo_id){
            $con = conectar_db();
            $sql = "UPDATE ciclo_lectivo 
                    SET ciclo = ?
                    WHERE ciclo_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("si", $this->ciclo, $ciclo_id);
            $stmt->execute();
        }
        #endregion

        #region eliminarCiclo
        public static function eliminarCiclo($ciclo_id){
            
            $con = condb();
            $text = "";

            mysqli_query($con, "delete from ciclo_lectivo where ciclo_id = $ciclo_id;");

            (mysqli_affected_rows($con) > 0) ? $text = "Ciclo eliminado correctamente" : $text = "No se pudo eliminar la ciclo";

            return $text;
        }
        #endregion
        
        #region listarCiclos
        public static function listarCiclos()
        {
            $con = conectar_db();
            $data = mysqli_query($con, "SELECT DISTINCT ciclo_id, ciclo FROM ciclo_lectivo ORDER BY ciclo DESC");
            $ciclos = [];

            if (mysqli_affected_rows($con) == 0) {
                echo "<tr><td><b class='bold red'>No hay ciclos registrados en el sistema</b></td></tr>";
            } else {
                while ($info = mysqli_fetch_assoc($data)) {
                    $ciclos[] = $info;
                }
            }
            
            return $ciclos;
        }
        #endregion

        #endregion

        public static function verificarCiclo($ciclo, $ciclo_id = null) {
            $con = conectar_db();
            $sql = "SELECT ciclo_id, ciclo FROM ciclo_lectivo
            WHERE ciclo = ?";
            
            if ($ciclo_id !== null) {
                $sql .= " AND ciclo_id <> ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("si", $ciclo, $ciclo_id);
            } else {
                $stmt = $con->prepare($sql);
                $stmt->bind_param("s", $ciclo);
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
    #endregion
?>