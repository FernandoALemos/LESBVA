<?php
    require_once "database\conectar_db.php";

    #region clase Ciclo
    class CicloLectivo{

        #region atributos
        private $ciclo_id;
        private $ciclo;
        #endregion

        #region constructor
        public function __construct($ciclo_id,$ciclo){
            $this->ciclo_id = $ciclo_id;
            $this->ciclo = $ciclo;
        }
        #endregion

        #region ABM Ciclos
        #region crearCiclo
        public function crearCiclo(){
            $con = conectar_db();
            $text = "";

            mysqli_query($con, "insert into ciclo_lectivo (ciclo) values ('$this->ciclo')");

            (mysqli_affected_rows($con) > 0) ? $text = "Nueva ciclo agregada" : $text =" No se pudo generar una nueva ciclo";

            return $text;
        }
        #endregion

        #region modificarCiclo
        public function modificarCiclo(){
            $con = condb();
            $texto = "";
            mysqli_query($con, "update ciclo_lectivo set ciclo = '$this->ciclo' where ciclo_id = $this->ciclo_id");

            (mysqli_affected_rows($con) > 0) ? $texto = "Ciclo modificada correctamente" : $texto = "No se pudo modificar la ciclo";

            return $texto;
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
        #endregion

    }
?>