<?php
    require_once "database\conectar_db.php";
    require_once "clase_materia.php";
    require_once "clase_usuario.php";
    require_once "clase_carrera.php";

    #region clase MateriaUsuario
    class MateriaUsuario{

        #region atributos
        private $materia_usuario_id;
        private $usuario_id;
        private $materia_id;
        private $estado_activo;
        #endregion

        #region constructor
        public function __construct($materia_usuario_id,$usuario_id,$materia_id,$estado_activo){
            $this->materia_usuario_id = $materia_usuario_id;
            $this->usuario_id = $usuario_id;
            $this->materia_id = $materia_id;
            $this->estado_activo = $estado_activo;
        }
        #endregion

        #region crearUsuarioAMateria
        public function asignarMateriaUsuario(){
            $con = conectar_db();
            $text = "";
            $a = mysqli_fetch_assoc(mysqli_query($con,"select count(id) from materias where carrera = $this->carrera;"));
            $totalMaterias = $a['count(id)'];
            $contador = 0;
            $agregar = array();

            $materias = mysqli_query($con,"select id from materias where carrera = $this->carrera");

            while($cargar = mysqli_fetch_assoc($materias)){
                if($contador == $totalMaterias - 1){
                    $dato = "(" .$this->usuario ."," .$cargar['id'] ."," .$this->nota ."," .$this->nota ."," .$this->nota .")";
                    array_push($agregar,$dato);
                }else {
                    $dato = "(" .$this->usuario ."," .$cargar['id'] ."," .$this->nota ."," .$this->nota ."," .$this->nota ."),";
                    array_push($agregar,$dato);
                }
                $contador ++;
            }

            $valores = implode($agregar);

            mysqli_query($con,"insert into materia_usuario (idUsuario,idMateria,notaParcial1,notaParcial2,notaFinal) values $valores");

            (mysqli_affected_rows($con) >0) ? $text = "Carrera asignada correctamente" : $text = "No se pudo asignar la carrera correctamente";

            return $text;
        }
        #endregion

        #region listarNotas
        public static function listarNotas(){
            $con = conectar_db();


            $data = mysqli_query($con,"select materia_usuario.idUsuario,materia_usuario.idMateria, usuarios.nombre, usuarios.apellido, materias.materia, carreras.nombreCarrera ,materia_usuario.notaParcial1,materia_usuario.notaParcial2,materia_usuario.notaFinal from (((usuarios inner join materia_usuario on usuarios.id = materia_usuario.idUsuario) inner join materias on materia_usuario.idMateria = materias.id) inner join carreras on carreras.id = materias.carrera );");

            if(mysqli_affected_rows($con) == 0){
                echo "<tr><td><b class='bold red'>No hay asignaturas registradas en el sistema</b></tr></td>";
            }else{
                while ($info = mysqli_fetch_assoc($data)){ 
                    $nombre = $info['nombre'] ." " .$info['apellido'];?>
                    <tr>
                        <td><?php echo $nombre ?></td>
                        <td><?php echo $info['materia']; ?></td>
                        <td><?php echo $info['nombreCarrera']; ?></td>
                        <td><?php echo $info['notaParcial1']?></td>
                        <td><?php echo $info['notaParcial2']?></td>
                        <td><?php echo $info['notaFinal']?></td>
                        <td>
                            <p class="acciones">
                                <a class="eliminar" href="pantalla_busqueda.php?pan=1 & acc=11 & idU=<?php echo $info['idUsuario']; ?> & alumno=<?php echo $nombre ?> & carrera=<?php echo $info['nombreCarrera']; ?>">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </p>
                        </td>
                    </tr>
                <?php   }
            }
        }
        #endregion

    #region listarNotasAlumno
        public static function listarNotasAlumno($id){
            $con = conectar_db();


            $data = mysqli_query($con,"select materia_usuario.idMateria,materia_usuario.notaParcial1,materia_usuario.notaParcial2,materia_usuario.notaFinal, materias.materia,materias.profesor,materias.carrera,usuarios.nombre,usuarios.apellido, carreras.nombreCarrera from (((materia_usuario inner join materias on materia_usuario.idMateria = materias.id) inner join usuarios on usuarios.id = materias.profesor) inner join carreras on carreras.id = materias.carrera) where materia_usuario.idUsuario = $id;");

            if(mysqli_affected_rows($con) == 0){
                echo "<tr><td><b class='bold red'>No hay asignaturas registradas en el sistema</b></tr></td>";
            }else{
                while ($info = mysqli_fetch_assoc($data)){ 
                    $nombre = $info['nombre'] ." " .$info['apellido'];?>
                    <tr>
                        <td><?php echo $nombre ?></td>
                        <td><?php echo $info['materia']; ?></td>
                        <td><?php echo $info['nombreCarrera']; ?></td>
                        <td><?php echo $info['notaParcial1']?></td>
                        <td><?php echo $info['notaParcial2']?></td>
                        <td><?php echo $info['notaFinal']?></td>
                    </tr>
                <?php   }
            }
        }
        #endregion

        #region eliminarNotas
        // VER SI FUNCIONA QUE ELEMINE SOLO LA ASIGNATURA DESEADA
        // public static function eliminarNotas($id){
        //     $con = conectar_db();
        //     $text = "";

        //     mysqli_query($con, "delete from materia_usuario where id = $id;");

        //     (mysqli_affected_rows($con) >0) ? $text = "Cursada eliminada correctamente." : $text = "No se pudo eliminar la asignatura correctamente.";

        //     return $text;
        // }
        public function eliminarNotas(){
            $con = conectar_db();
            $text = "";

            mysqli_query($con,"delete from materia_usuario where idUsuario = $this->usuario");

            (mysqli_affected_rows($con) >0) ? $text = "Asignatura eliminada correctamente." : $text = "No se pudo eliminar la asignatura correctamente.";

            return $text;
        }
        #endregion

        #region listarNotasEditables
        public static function listarNotasEditables($id){
            $con = conectar_db();

            $data = mysqli_query($con,"select materia_usuario.idUsuario,materia_usuario.idMateria, usuarios.nombre, usuarios.apellido, materias.materia, carreras.nombreCarrera ,materia_usuario.notaParcial1,materia_usuario.notaParcial2,materia_usuario.notaFinal from (((usuarios inner join materia_usuario on usuarios.id = materia_usuario.idUsuario) inner join materias on materia_usuario.idMateria = materias.id) inner join carreras on carreras.id = materias.carrera) where materias.profesor = $id;");

            

            if(mysqli_affected_rows($con) == 0){
                echo "<tr><td><b class='bold red'>No hay carreras registradas en el sistema</b></tr></td>";
            }else{
                while ($info = mysqli_fetch_assoc($data)){ 
                    $nombre = $info['nombre'] ." " .$info['apellido']?>
                    <tr>
                        <td><?php echo $nombre; ?></td>
                        <td><?php echo $info['nombreCarrera']; ?></td>
                        <td><?php echo $info['materia']; ?></td>
                        <td><?php echo $info['notaParcial1']; ?></td>
                        <td><?php echo $info['notaParcial2']; ?></td>
                        <td><?php echo $info['notaFinal']; ?></td>
                        <td>
                            <p class="acciones">
                                <a class="modificar" href="pantalla_busqueda.php?pan=1 & acc=12 & alumno=<?php echo $info['idUsuario']; ?> & idmateria=<?php echo $info['idMateria']; ?> & nombre=<?php echo $nombre; ?> & materia=<?php echo $info['materia'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </p>
                        </td>
                    </tr>
                <?php   }
            }
        }
        #endregion

        #region modificarNotas
        public function modificarNotas(){
            $con = conectar_db();
            $text = "";

            mysqli_query($con,"update materia_usuario set notaParcial1 = $this->parcial1, notaParcial2 = $this->parcial2 , notaFinal = $this->final where idUsuario = $this->usuario and idMateria = $this->carrera;");

            (mysqli_affected_rows($con) >0) ? $text = "Nota/s modificadas correctamente" : $text = "No se pudo modificar las materia_usuario correctamente";

            return $text;
        }
        #endregion

    }
    #endregion

?>