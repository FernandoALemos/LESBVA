<?php
    require_once "database\conectar_db.php";

    #region clase Profesor
    class Profesor{
        #region atributos
        private $profesor_nombre;
        private $profesor_apellido;
        private $profesor_dni;
        private $profesor_email;
        private $profesor_direccion;
        private $profesor_telefono;
        private $profesor_activo;
        #endregion

        #region constructor
        public function __construct($profesor_nombre, $profesor_apellido, $profesor_dni, $profesor_email, $profesor_direccion, $profesor_telefono, $profesor_activo = true) {
            $this->profesor_nombre = $profesor_nombre;
            $this->profesor_apellido = $profesor_apellido;
            $this->profesor_dni = $profesor_dni;
            $this->profesor_email = $profesor_email;
            $this->profesor_direccion = $profesor_direccion;
            $this->profesor_telefono = $profesor_telefono;
            $this->profesor_activo = $profesor_activo;
        }
        #endregion

        #region ABM Profesors
        #region crearProfesor
        public function crearProfesor() {
            $con = conectar_db();
            $sql = "INSERT INTO profesores (profesor_nombre, profesor_apellido, profesor_dni, profesor_email, profesor_direccion, profesor_telefono, profesor_activo) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ssisssi", $this->profesor_nombre, $this->profesor_apellido, $this->profesor_dni, $this->profesor_email, $this->profesor_direccion, $this->profesor_telefono, $this->profesor_activo);
            $stmt->execute();
        }
        
        #endregion

        #region modificarProfesor
        public function modificarProfesor($id) {
            $con = conectar_db();
            $sql = "UPDATE profesores 
                    SET profesor_nombre = ?, profesor_apellido = ?, profesor_dni = ?, profesor_email = ?, profesor_direccion = ?, profesor_telefono = ?, profesor_activo = ?
                    WHERE profesor_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ssisssii", $this->profesor_nombre, $this->profesor_apellido, $this->profesor_dni, $this->profesor_email, $this->profesor_direccion, $this->profesor_telefono, $this->profesor_activo, $id);
            $stmt->execute();
        }
        #endregion

        #endregion
        public static function listarProfesores(){
            $con = conectar_db();
            $data = mysqli_query($con, "SELECT 
                        profesor_id,
                        profesor_nombre, 
                        profesor_apellido, 
                        profesor_dni, 
                        profesor_email, 
                        profesor_direccion, 
                        profesor_telefono, 
                        profesor_activo
                        FROM profesores 
                        ORDER BY profesor_apellido");
            $profesores = [];

            if (mysqli_affected_rows($con) == 0) {
                echo "<tr><td><b class='bold red'>No hay profesores registrados en el sistema</b></td></tr>";
            } else {
                while ($info = mysqli_fetch_assoc($data)) {
                    $profesores[] = $info;
                }
            }

            return $profesores;
        }

        public static function verificarProfesor($profesor_dni, $profesor_id = null) {
            $con = conectar_db();
            $sql = "SELECT profesor_id FROM profesores WHERE profesor_dni = ?";
            
            if ($profesor_id !== null) {
                $sql .= " AND profesor_id <> ?";
            }
            
            $stmt = $con->prepare($sql);
            
            if ($profesor_id !== null) {
                $stmt->bind_param("ii", $profesor_dni, $profesor_id);
            } else {
                $stmt->bind_param("i", $profesor_dni);
            }
            
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows > 0) {
                $row = $resultado->fetch_assoc();
                if ($row['profesor_id'] == $profesor_id) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }

    }
?>