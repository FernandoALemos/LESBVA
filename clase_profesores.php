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
        public function __construct($profesor_nombre,$profesor_apellido){
            // $this->profesor_id = $profesor_id;
            $this->profesor_nombre = $profesor_nombre;
            $this->profesor_apellido = $profesor_apellido;
        }
        #endregion

        #region ABM Profesors
        #region crearProfesor
        public function crearProfesor(){
            $con = conectar_db();
           

            mysqli_query($con, "insert into profesores (profesor_nombre, profesor_apellido) values ('$this->profesor_nombre', '$this->profesor_apellido')");

            if (mysqli_affected_rows($con) > 0) {
                ?><script>
                    alert("Profesor creado con éxito");
                </script>
            <?php
                } else {
            ?><script>
                alert("No se pudo crear el profesor");
            </script>
            <?php
        }}
        
        #endregion

        #region modificarProfesor
        public function modificarProfesor(){
            $con = conectar_db();
            $texto = "";
            mysqli_query($con, "update profesores set profesor_nombre = '$this->profesor_nombre', profesor_apellido = '$this->profesor_apellido' where profesor_id = $this->profesor_id");

            (mysqli_affected_rows($con) > 0) ? $texto = "Profesor modificada correctamente" : $texto = "No se pudo modificar el/la profesor/a";

            return $texto;
        }
        #endregion

        #region eliminarProfesor
        public static function eliminarProfesor($profesor_id){
            $con = conectar_db();
            $text = "";

            mysqli_query($con, "delete from profesores where profesor_id = $profesor_id;");

            (mysqli_affected_rows($con) > 0) ? $text = "Profesor eliminado correctamente" : $text = "No se pudo eliminar el/la profesor/a";

            return $text;
        }
        #endregion
        #endregion

    }
?>