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
            // $this->ciclo_id = $ciclo_id;
            $this->ciclo = $ciclo;
        }
        #endregion

        #region ABM Ciclos
        #region crearCiclo
        public function crearCiclo(){
            $con = conectar_db();
            mysqli_query($con, "insert into ciclo_lectivo (ciclo) values ('$this->ciclo')");

            if (mysqli_affected_rows($con) > 0) {
                ?><script>
                    alert("Ciclo creado con éxito");
                </script>
            <?php
                } else {
            ?><script>
                alert("No se pudo crear el ciclo");
            </script>
            <?php }
        }
        #endregion

        #region modificarCiclo
        public function modificarCiclo($id){
            $con = conectar_db();
            mysqli_query($con, "update ciclo_lectivo set ciclo = '$this->ciclo' where ciclo_id = $id");

            if (mysqli_affected_rows($con) > 0) {
                $texto = "Ciclo modificado correctamente";
            } else {
                $texto = "No se pudo modificar el ciclo";
            }
    
            echo "<script>alert('$texto');</script>";
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
            $data = mysqli_query($con, "SELECT DISTINCT ciclo_id, ciclo FROM ciclo_lectivo ORDER BY ciclo");
            $ciclos = [];

            if (mysqli_affected_rows($con) == 0) {
                echo "<tr><td><b class='bold red'>No hay cicloes registrados en el sistema</b></td></tr>";
            } else {
                while ($info = mysqli_fetch_assoc($data)) {
                    $ciclos[] = $info;
                }
            }
            
            return $ciclos;
        }
        #endregion

        #endregion

    }
    #endregion
?>