<?php
    require_once "database\conectar_db.php";

    #region clase MateriaCarrera clase para asignar
    class MateriaCarrera{

        #region atributos
        private $materia_carrera_id;
        private $materia_id;
        private $carrera_id;
        private $ciclo_id;
        private $curso_id;
        private $turno_id;
        private $profesor_id;
        private $situacion_revista;
        private $inscriptos;
        private $regulares;
        private $atraso_academico;
        private $recursantes;
        private $modulos;
        private $primer_periodo;
        private $segundo_periodo;
        #endregion

        #region constructor
        public function __construct(
        $materia_carrera_id,
        $materia_id,
        $carrera_id,
        $ciclo_id,
        $curso_id,
        $turno_id,
        $profesor_id,
        $situacion_revista,
        $inscriptos,
        $regulares,
        $atraso_academico,
        $recursantes,
        $modulos,
        $primer_periodo,
        $segundo_periodo,
        ){
            $this->materia_carrera_id = $materia_carrera_id;
            $this->materia_id = $materia_id;
            $this->carrera_id = $carrera_id;
            $this->ciclo_id = $ciclo_id;
            $this->curso_id = $curso_id;
            $this->turno_id = $turno_id;
            $this->profesor_id = $profesor_id;
            $this->situacion_revista = $situacion_revista;
            $this->inscriptos = $inscriptos;
            $this->regulares = $regulares;
            $this->atraso_academico = $atraso_academico;
            $this->recursantes = $recursantes;
            $this->modulos = $modulos;
            $this->primer_periodo = $primer_periodo;
            $this->segundo_periodo = $segundo_periodo;
        }
        #endregion

        #region crearMateriasDeCarrera
        public function crearMateriaCarrera(){
            $con = conectar_db();
            $text = "";

            mysqli_query($con, "insert into materias (materia_nombre) values ('$this->materia_nombre')");

            (mysqli_affected_rows($con) > 0) ? $text = "Nueva materia agregada" : $text =" No se pudo generar una nueva materia";

            return $text;
        }
        #endregion

        #region modificarMateriasCarrera
        public function modificarMateriasCarrera(){
            $con = condb();
            $texto = "";
            mysqli_query($con, "update materias set materia_nombre = '$this->materia_nombre' where id = $this->id");

            (mysqli_affected_rows($con) > 0) ? $texto = "Materia modificada correctamente" : $texto = "No se pudo modificar la materia";

            return $texto;
        }
        #endregion

        #region eliminarMateriasCarrera
        public static function eliminarMateriasCarrera($id){
            $con = condb();
            $text = "";

            mysqli_query($con, "delete from materias where id = $id;");

            (mysqli_affected_rows($con) > 0) ? $text = "Materia eliminada correctamente" : $text = "No se pudo eliminar la materia";

            return $text;
        }
        #endregion

        #region listarMateriasDeCarrera
        public static function listarMateriasCarrera(){
            $con = conectar_db();
            $data = mysqli_query($con, "SELECT 
                mc.materia_carrera_id,
                m.materia_nombre,
                c.carrera_nombre,
                cl.ciclo,
                cr.curso,
                t.turno,
                p.profesor_nombre,
                p.profesor_apellido,
                mc.situacion_revista,
                mc.inscriptos,
                mc.regulares,
                mc.atraso_academico,
                mc.recursantes,
                mc.modulos,
                mc.primer_periodo,
                mc.segundo_periodo
            FROM 
                materia_carrera mc
            JOIN 
                materias m ON mc.materia_id = m.materia_id
            JOIN 
                carreras c ON mc.carrera_id = c.carrera_id
            JOIN 
                ciclo_lectivo cl ON mc.ciclo_id = cl.ciclo_id
            JOIN 
                cursos cr ON mc.curso_id = cr.curso_id
            JOIN 
                turnos t ON mc.turno_id = t.turno_id
            JOIN 
                profesores p ON mc.profesor_id = p.profesor_id;
            WHERE
                cl.ciclo = '{$_POST['ciclo']}' AND 
                c.carrera_nombre = '{$_POST['carrera_nombre']}'; OR
                cr.curso = '{$_POST['curso']}' ");

            // MODIFICAR QUERY PARA QUE MUESTRE UNA LISTA CORRECTAMENTE, TRAER POST CARRERA Y CICLO
            // $data = mysqli_query($con,"select materia_carrera.materia_id, materia_carrera.materia_nombre, materia_carrera.curso, materia_carrera.profesor, materia_carrera.situacion_revista, materia_carrera.cantidad_alumno, ciclo_lectivo.ciclo, carreras.carrera_nombre from (( materia_carrera inner join ciclo_lectivo on materia_carrera.ciclo_id = ciclo_lectivo.ciclo_id ) inner join carreras on materia_carrera.carrera_id = carreras.carrera_id)  WHERE 
            // ciclo_lectivo.ciclo = '{$_POST['ciclo']}'
            // carreras.carrera_nombre = '{$_POST['carrera_nombre']}'
            // cursos.curso = '{$_POST['curso']}' 
            // order by  materia_carrera.curso, materia_carrera.materia_nombre;");
            
            if(mysqli_affected_rows($con) == 0){
                echo "<tr><td><b class='bold red'>No hay materia_carrera registradas en el sistema</b></td></tr>";
            }else{
                while ($info = mysqli_fetch_assoc($data)){ ?>
                    <tr>
                        <td><?php echo $info['ciclo']; ?></td>
                        <td><?php echo $info['carrera_nombre']; ?></td>
                        <td><?php echo $info['curso']; ?></td>
                        <td><?php echo $info['materia_nombre']; ?></td>
                        <td><?php echo $info['modulos']; ?></td>
                        <td><?php echo $info['profesor_nombre']." ".$info['profeprofesor_apellidosor']; ?></td> <!--VER PARA QUE SE INGRESE 1 O 2 PROFES -->
                        <td><?php echo $info['situacion_revista']; ?></td> <!--VER PARA QUE SE INGRESE 1 O 2 SITUCICONES SI HAY MAS PROFES -->
                        <td><?php echo $info['inscriptos']; ?></td>
                        <td><?php echo $info['regulares']; ?></td>
                        <td><?php echo $info['atraso_academico']; ?></td>
                        <td><?php echo $info['recursantes']; ?></td>
                        <td><?php echo $info['primer_periodo']; ?></td>
                        <td><?php echo $info['segundo_periodo']; ?></td>
                    </tr>
                <?php   }
            }
        }
        #endregion

        
        
    }
    #endregion

?>
<!-- AGREGAR PARA MODIFICAR? -->
<!-- <td>
    <p class="acciones">
        <a class="modificar" href="pantalla_busqueda.php?pan=1 & acc=5 & materia_id=<?php echo $info['materia_id']; ?>">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
    </p>
</td> -->