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
        public function __construct($cargo_id,$carrera_id,$turno_id,$cargo_nombre){
            $this->cargo_id = $cargo_id;
            $this->carrera_id = $carrera_id;
            $this->turno_id = $turno_id;
            $this->cargo_nombre = $cargo_nombre;
        }
        #endregion

        #region ABM Cargo
        #region crearCargo
        public function crearCargo(){
            $con = conectar_db();
            $text = "";

            mysqli_query($con, "insert into cargos (carrera_id,turno_id,cargo_nombre) values ('$this->carrera_id', '$this->turno_id','$this->cargo_nombre')");

            (mysqli_affected_rows($con) > 0) ? $text = "Nueva cargo agregada" : $text =" No se pudo generar el cargo";

            return $text;
        }
        #endregion

        #region modificarCargo
        public function modificarCargo(){
            $con = condb();
            $texto = "";
            mysqli_query($con, "update cargos set 
            carrera_id = '$this->carrera_id', 
            turno_id = '$this->turno_id',
            cargo_nombre = '$this->cargo_nombre' 
            where 
            cargo_id = $this->cargo_id");

            (mysqli_affected_rows($con) > 0) ? $texto = "Cargo modificada correctamente" : $texto = "No se pudo modificar el cargo";

            return $texto;
        }
        #endregion

        #region eliminarCargo
        public static function eliminarCargo($cargo_id){
            $con = condb();
            $text = "";

            mysqli_query($con, "delete from cargos where cargo_id = $cargo_id;");

            (mysqli_affected_rows($con) > 0) ? $text = "Cargo eliminado correctamente" : $text = "No se pudo eliminar el cargo";

            return $text;
        }
        #endregion

        #region buscarCargo
        public static function buscarCargo($cargo_id){
            $con = condb();
            
            $info = mysqli_query($con, "SELECT");

            $data = mysqli_fetch_assoc($info);

            return $data;
        }
        #endregion

        #endregion

    }
?>