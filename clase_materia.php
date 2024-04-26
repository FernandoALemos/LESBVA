<?php
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

        // DEJAR Y VER SI SE USARA
        // #region crearMateria
        // public function crearMateria(){
        //     $con = conectar_db();
        //     $text = "";

        //     mysqli_query($con, "insert into materias (materia_nombre,anio_materia,ciclo_id,carrera_id) values ('$this->materia_nombre', $this->anio_materia, $this->ciclo_id, $this->carrera_id)");

        //     (mysqli_affected_rows($con) > 0) ? $text = "Nueva materia agregada" : $text =" No se pudo generar una nueva materia";

        //     return $text;
        // }
        // #endregion



        #region listarMaterias
        public static function listarMaterias(){
            $con = conectar_db();

            $data = mysqli_query($con,"select materias.materia_id, materias.materia_nombre, materias.anio_materia, materias.cantidad_alumno, ciclo_lectivo.anio_lectivo, carreras.carrera_nombre from (( materias inner join ciclo_lectivo on materias.ciclo_id = ciclo_lectivo.ciclo_id ) inner join carreras on materias.carrera_id = carreras.carrera_id);");
            
            if(mysqli_affected_rows($con) == 0){
                echo "<tr><td><b class='bold red'>No hay materias registradas en el sistema</b></td></tr>";
            }else{
                while ($info = mysqli_fetch_assoc($data)){ ?>
                    <tr>
                        <td><?php echo $info['materia_nombre']; ?></td>
                        <td><?php echo $info['anio_materia']; ?></td>
                        <td><?php echo $info['cantidad_alumno']; ?></td>
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

        #region buscarMateria
        public static function buscarMateria($materia_id){
            $con = conectar_db();
            
            $info = mysqli_query($con, "select materias.materia_id, materias.materia_nombre, materias.anio_materia,
            ciclo_lectivo.anio_lectivo, carreras.carrera_nombre from (( materias inner join ciclo_lectivo on materias.ciclo_id = ciclo_lectivo.ciclo_id ) inner join carreras on materias.carrera_id = carreras.carrera_id) where materias.materia_id = $materia_id;");

            $data = mysqli_fetch_assoc($info);

            return $data;
        }
        #endregion

        public static function filterAño(){
            $con = conectar_db();
            
            // Consulta SQL para obtener los nombres de las materias y los años
            $sql = "SELECT anio_materia, materia_id, materia_nombre FROM materias";
            $resultado = $con->query($sql);
            
            // Almacenar los años de materias en un array asociativo
            $anios_materias = array();
            while ($fila = $resultado->fetch_assoc()) {
                $anios_materias[] = $fila['anio_materia'];
                $materias[$fila['anio_materia']][] = array('materia_id' => $fila['materia_id'], 'materia_nombre' => $fila['materia_nombre']);
            }
            
            // Mostrar el formulario con las opciones
            echo "<form action='pantalla_listar_materia.php' method='POST'>";
            echo "<br><label for='anio_materia'>Año de la materia:      </label>";
            echo "<select name='anio_materia'>";
            echo "<option value=''>Selecciona un año</option>";
            foreach ($anios_materias as $anio) {
                echo "<option value='{$anio}'>{$anio}</option>";
            }
            echo "</select>";

            //echo "<br><input type='submit' class = 'button' value='Continuar'>";
            echo "</form>";
        }


        public static function filterMateria(){
            $con = conectar_db();
            
            // Consulta SQL para obtener los nombres de las materias y los años
            $sql = "SELECT anio_materia, materia_id, materia_nombre FROM materias";
            $resultado = $con->query($sql);
            
            // Almacenar los años de materias en un array asociativo
            $materia = array();
            while ($fila = $resultado->fetch_assoc()) {
                $materia[] = $fila['materia_nombre'];
                $materias[$fila['materia_nombre']][] = array('materia_id' => $fila['materia_id'], 'anio_materia' => $fila['anio_materia']);
            }
            
            // Mostrar el formulario con las opciones
            echo "<br> <form action='pantalla_listar_materia.php' method='POST'>";
            echo "<label for='materia_nombre'>Nombre de la materia:     </label>";
            echo "<select name='materia_nombre'>";
            echo "<option value=''>Selecciona un año</option>";
            foreach ($materia as $nombre_materia) {
                echo "<option value='{$nombre_materia}'>{$nombre_materia}</option>";
            }
            echo "</select>";
            
            // echo "<br><input type='submit' class = 'button' value='Continuar'>";
            echo "<br><input type='submit' class='button' value='Continuar' onclick='window.location.href = \"pantalla_listar_materia.php\";'>";
            echo "</form>";
        }

        // PROBAR
        // echo <<<HTML
        //     <script>
        //     document.addEventListener('DOMContentLoaded', function() {
        //         const anioSelect = document.querySelector('select[name="anio_materia"]');
        //         const materiaSelect = document.querySelector('select[name="materia_nombre"]');
                
        //         const materias = JSON.parse('{$materias}');
                
        //         anioSelect.addEventListener('change', function() {
        //             const anioSeleccionado = this.value;
                    
        //             materiaSelect.innerHTML = '<option value="">Selecciona una materia</option>';
                    
        //             if (anioSeleccionado in materias) {
        //                 materias[anioSeleccionado].forEach(materia => {
        //                     const option = document.createElement('option');
        //                     option.value = materia.materia_id;
        //                     option.textContent = materia.materia_nombre;
        //                     materiaSelect.appendChild(option);
        //                 });
        //             }
                    
        //             // Enviar el año seleccionado al servidor mediante AJAX
        //             const xhr = new XMLHttpRequest();
        //             xhr.open('POST', 'procesar_filtro.php', true);
        //             xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        //             xhr.onreadystatechange = function() {
        //                 if (xhr.readyState === 4 && xhr.status === 200) {
        //                     // Actualizar la lista de materias con la respuesta del servidor
        //                     const response = JSON.parse(xhr.responseText);
        //                     materiaSelect.innerHTML = '<option value="">Selecciona una materia</option>';
        //                     response.forEach(materia => {
        //                         const option = document.createElement('option');
        //                         option.value = materia.materia_id;
        //                         option.textContent = materia.materia_nombre;
        //                         materiaSelect.appendChild(option);
        //                     });
        //                 }
        //             };
        //             xhr.send('anio=' + anioSeleccionado);
        //         });
        //     });
        //     </script>
        //     HTML>>>;
    }
    #endregion

?>
