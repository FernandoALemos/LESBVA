<?php
    require_once "database\conectar_db.php";

    #region clase Profesor
    class Profesor{

        #region atributos
        private $profesor_id;
        private $profesor_nombre;
        private $profesor_apellido;
        #endregion

        #region constructor
        public function __construct($profesor_id,$profesor_nombre,$profesor_apellido){
            $this->profesor_id = $profesor_id;
            $this->profesor_nombre = $profesor_nombre;
            $this->profesor_apellido = $profesor_apellido;
        }
        #endregion

        #region ABM Profesors
        #region crearProfesor
        public function crearProfesor(){
            $con = conectar_db();
            $text = "";

            mysqli_query($con, "insert into profesores (profesor_nombre, profesor_apellido) values ('$this->profesor_nombre', '$this->profesor_apellido')");

            (mysqli_affected_rows($con) > 0) ? $text = "Nueva profesor agregada" : $text =" No se pudo generar el/la profesor/a";

            return $text;
        }
        #endregion

        #region modificarProfesor
        public function modificarProfesor(){
            $con = condb();
            $texto = "";
            mysqli_query($con, "update profesores set profesor_nombre = '$this->profesor_nombre', profesor_apellido = '$this->profesor_apellido' where profesor_id = $this->profesor_id");

            (mysqli_affected_rows($con) > 0) ? $texto = "Profesor modificada correctamente" : $texto = "No se pudo modificar el/la profesor/a";

            return $texto;
        }
        #endregion

        #region eliminarProfesor
        public static function eliminarProfesor($profesor_id){
            $con = condb();
            $text = "";

            mysqli_query($con, "delete from profesores where profesor_id = $profesor_id;");

            (mysqli_affected_rows($con) > 0) ? $text = "Profesor eliminado correctamente" : $text = "No se pudo eliminar el/la profesor/a";

            return $text;
        }
        #endregion
        #endregion

    }
?>