<?php
require_once "database\conectar_db.php";

#region clase Materia
class Materia
{

    #region atributos
    #private $materia_id; Comento porque no se usa
    private $materia_nombre;
    #endregion

    #region constructor
    public function __construct($materia_nombre)
    {
        // $this->materia_id = $materia_id;
        $this->materia_nombre = $materia_nombre;
    }
    #endregion

    #region ABM Materias
    #region crearMateria
    public function crearMateria()
    {
        $con = conectar_db();
        

        mysqli_query($con, "insert into materias (materia_nombre) values ('$this->materia_nombre')");
        
        if (mysqli_affected_rows($con) > 0) {
            ?><script>
                alert("Materia creada con éxito");
            </script>
        <?php
            } else {
        ?><script>
            alert("No se pudo crear la materia");
        </script>
        <?php
    }}
    #endregion

    #region modificarMateria
    public function modificarMateria($id)
    {
        $con = conectar_db();
        $texto = "";
        mysqli_query($con, "update materias set materia_nombre = '$this->materia_nombre' where materia_id = $id");

        if (mysqli_affected_rows($con) > 0) {
            $texto = "Materia modificada correctamente";
        } else {
            $texto = "No se pudo modificar la materia";
        }

        echo "<script>alert('$texto');</script>";
    }
    #endregion

    #region eliminarMateria
    public static function eliminarMateria($id)
    {
        $con = conectar_db();
        $text = "";

        mysqli_query($con, "delete from materias where id = $id;");

        (mysqli_affected_rows($con) > 0) ? $text = "Materia eliminada correctamente" : $text = "No se pudo eliminar la materia";

        return $text;
    }
    #endregion
    #endregion


    #region listarMaterias
    public static function listarMaterias()
    {
        $con = conectar_db();
        $data = mysqli_query($con, "SELECT DISTINCT materia_id, materia_nombre FROM materias ORDER BY materia_nombre");
        $materias = [];
        // icono de modificar
        // <i class="fa-solid fa-pen-to-square"></i>

        if (mysqli_affected_rows($con) == 0) {
            echo "<tr><td><b class='bold red'>No hay materias registradas en el sistema</b></td></tr>";
        } else {
            while ($info = mysqli_fetch_assoc($data)) {
                $materias[] = $info;
            }
        }
        
        return $materias;
    }
    #endregion

}
#endregion

?>