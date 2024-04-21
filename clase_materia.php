<?php
    require_once "database\conectar_db.php";
    require_once "database\conectar_db.php";

    #region clase Materia
    class Materia{

        #region atributos
        private $materia_id;
        private $materia_nombre;
        private $anio_materia;
        private $ciclo_id;
        private $carrera_id;
        #endregion

        #region constructor
        public function __construct($materia_id,$materia_nombre,$anio_materia,$ciclo_id,$carrera_id){
            $this->materia_id = $materia_id;
            $this->materia_nombre = $materia_nombre;
            $this->anio_materia = $anio_materia;
            $this->ciclo_id = $ciclo_id;
            $this->carrera_id = $carrera_id;
        }
        #endregion

        #region crearMateria
        public function crearMateria(){
            $con = conectar_db();
            $text = "";

            mysqli_query($con, "insert into materias (materia_nombre,anio_materia,ciclo_id,carrera_id) values ('$this->materia_nombre', $this->anio_materia, $this->ciclo_id, $this->carrera_id)");

            (mysqli_affected_rows($con) > 0) ? $text = "Nueva materia agregada" : $text =" No se pudo generar una nueva materia";

            return $text;
        }
        #endregion

        #region modificarMateria
        public function modificarMateria(){
            $con = conectar_db();
            $texto = "";
            mysqli_query($con, "update materias set materia_nombre = '$this->materia_nombre', anio_materia = $this->anio_materia, ciclo_id = $this->ciclo_id, carrera_id = $this->carrera_id where materia_id = $this->materia_id");

            (mysqli_affected_rows($con) > 0) ? $texto = "Materia modificada correctamente" : $texto = "No se pudo modificar la materia";

            return $texto;
        }
        #endregion

        #region eliminarMateria
        public static function eliminarMateria($materia_id){
            $con = conectar_db();
            $text = "";

            mysqli_query($con, "delete from materias where materia_id = $materia_id;");

            (mysqli_affected_rows($con) > 0) ? $text = "Materia eliminada correctamente" : $text = "No se pudo eliminar la materia";

            return $text;
        }
        #endregion

        #region listarMaterias
        public static function listarMaterias(){
            $con = conectar_db();

            $data = mysqli_query($con,"select materias.materia_id, materias.materia_nombre, materias.anio_materia, ciclo_lectivo.anio_lectivo, carreras.carrera_nombre from (( materias inner join ciclo_lectivo on materias.ciclo_id = ciclo_lectivo.ciclo_id ) inner join carreras on materias.carrera_id = carreras.carrera_id);");
            
            if(mysqli_affected_rows($con) == 0){
                echo "<tr><td><b class='bold red'>No hay materias registradas en el sistema</b></td></tr>";
            }else{
                while ($info = mysqli_fetch_assoc($data)){ ?>
                    <tr>
                        <td><?php echo $info['materia_nombre']; ?></td>
                        <td><?php echo $info['anio_materia']; ?></td>
                        <td><?php echo $info['anio_lectivo']; ?></td>
                        <td><?php echo $info['carrera_nombre']; ?></td>
                        <td>
                            <p class="acciones">
                                <a class="modificar" href="pantalla_busqueda.php?pan=1 & acc=5 & materia_id=<?php echo $info['materia_id']; ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a class="eliminar" href="pantalla_busqueda.php?pan=1 & acc=6 & materia_id=<?php echo $info['materia_id']; ?>">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </p>
                        </td>
                    </tr>
                <?php   }
            }
        }
        #endregion

        #region buscarMateria
        public static function buscarMateria($materia_id){
            $con = conectar_db();
            
            $info = mysqli_query($con, "select materias.materia_id, materias.materia_nombre, materias.anio_materia,
            ciclo_lectivo.anio_lectivo, carreras.carrera_nombre from (( materias inner join ciclo_lectivo on materias.ciclo_id = ciclo_lectivo.ciclo_id ) inner join carreras on materias.carrera_id = carreras.carrera_id) where materias.materia_id = $materia_id;");

            $data = mysqli_fetch_assoc($info);

            return $data;
        }
        #endregion

    }
    #endregion

?>