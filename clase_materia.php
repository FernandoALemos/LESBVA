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
    public function modificarMateria()
    {
        $con = conectar_db();
        $texto = "";
        mysqli_query($con, "update materias set materia_nombre = '$this->materia_nombre' where id = $this->id");

        (mysqli_affected_rows($con) > 0) ? $texto = "Materia modificada correctamente" : $texto = "No se pudo modificar la materia";

        return $texto;
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

        // $data = mysqli_query($con,"select materias.materia_id, materias.materia_nombre, materias.curso, materias.profesor, materias.situacion_revista, materias.cantidad_alumno, ciclo_lectivo.ciclo, carreras.carrera_nombre from (( materias inner join ciclo_lectivo on materias.ciclo_id = ciclo_lectivo.ciclo_id ) inner join carreras on materias.carrera_id = carreras.carrera_id) order by  materias.curso, materias.materia_nombre;");

        // PROBAR
        $data = mysqli_query($con, "select materias.materia_id, materias.materia_nombre, materias.curso, materias.profesor, materias.situacion_revista, materias.cantidad_alumno, ciclo_lectivo.ciclo, carreras.carrera_nombre from (( materias inner join ciclo_lectivo on materias.ciclo_id = ciclo_lectivo.ciclo_id ) inner join carreras on materias.carrera_id = carreras.carrera_id)  WHERE materias.curso = '{$_POST['curso']}' order by  materias.curso, materias.materia_nombre;");

        if (mysqli_affected_rows($con) == 0) {
            echo "<tr><td><b class='bold red'>No hay materias registradas en el sistema</b></td></tr>";
        } else {
            while ($info = mysqli_fetch_assoc($data)) { ?>
                <tr>
                    <td><?php echo $info['materia_nombre']; ?></td>
                    <td>
                        <p class="acciones">
                            <a class="modificar" href="pantalla_busqueda.php?pan=1 & acc=5 & materia_id=<?php echo $info['materia_id']; ?>">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </p>
                    </td>
                </tr>
<?php   }
        }
    }
    #endregion

}
#endregion

?>