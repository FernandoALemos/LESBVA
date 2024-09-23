<?php
    require_once "database\conectar_db.php";
    #region clase Usuario
    class Usuario {

    #region atributos
        private $usuario_nombre;
        private $usuario_apellido;
        private $email;
        private $contrasenia;
        private $rol_id; // 1 para administrador 2, para director 3, para profesor, 4 para alumno
        private $cargo_id; // uso para los usuarios no admin, tendran a cargo una carrera y turno
        private $usuario_suspendido;
        private $primer_ingreso;
    #endregion

    #region constructor
    public function __construct($usuario_nombre, $usuario_apellido, $email, $contrasenia, $rol_id, $cargo_id, $usuario_suspendido = 0, $primer_ingreso = 0) {
        $this->usuario_nombre = $usuario_nombre;
        $this->usuario_apellido = $usuario_apellido;
        $this->email = $email;
        $this->contrasenia = $contrasenia;
        $this->rol_id = $rol_id;
        $this->cargo_id = $cargo_id;
        $this->usuario_suspendido = $usuario_suspendido;
        $this->primer_ingreso = $primer_ingreso;
    }
    #endregion

    #region crearUsuario
    public function crearUsuario() {
        $con = conectar_db();
        $sql = "INSERT INTO usuarios (usuario_nombre, usuario_apellido, email, contrasenia, rol_id, cargo_id, usuario_suspendido, primer_ingreso) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssiiii", $this->usuario_nombre, $this->usuario_apellido, $this->email, $this->contrasenia, $this->rol_id, $this->cargo_id, $this->usuario_suspendido, $this->primer_ingreso);
        $stmt->execute();
    }
    #endregion

    #region modificarUsuario
    public function modificarUsuario($usuario_id) {
        $con = conectar_db();
        $sql = "UPDATE usuarios 
                SET usuario_nombre = ?, usuario_apellido = ?, email = ?, contrasenia = ?, rol_id = ?, cargo_id = ?, usuario_suspendido = ?
                WHERE usuario_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssssii", $this->usuario_nombre, $this->usuario_apellido, $this->email, $this->contrasenia, $this->rol_id, $this->cargo_id, $this->usuario_suspendido, $usuario_id);
        $stmt->execute();
    }
    #endregion

    public static function verificarExistenciaEmail($email, $usuario_id = null) {
        $con = conectar_db();
        $sql = "SELECT usuario_id FROM usuarios WHERE email = ?";
        
        if ($usuario_id !== null) {
            $sql .= " AND usuario_id <> ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("si", $email, $usuario_id);
        } else {
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $email);
        }
        
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $email_existente = $fila['email'];

            if (strtolower($email_existente) !== strtolower($email)){
                return false;
            }
            else{
                return true;
            }
        }
        else{
            return false;
        }
    }


    #region VerificarUsuario
    public static function VerificarUsuario($email,$contrasenia){
        $con = conectar_db();
        
        if ($email != "" && $contrasenia != ""){
            $usu = mysqli_query($con , "select email from usuarios where email = '$email'");
            if(mysqli_affected_rows($con)>0){
                $contra = mysqli_query($con, " select contrasenia from usuarios where email = '$email'");
                $contra = mysqli_fetch_assoc($contra);
                if($contra['contrasenia'] === $contrasenia){
                    $data = mysqli_query($con,"select * from usuarios where email = '$email' ");
                    $info = mysqli_fetch_assoc($data);
                    session_start();
                    $_SESSION['usuario_id'] = $info['usuario_id'];
                    $_SESSION['usuario_nombre'] = $info['usuario_nombre'];
                    $_SESSION['usuario_apellido'] = $info['usuario_apellido'];
                    $_SESSION['rol_id'] = $info['rol_id'];
                    $_SESSION['cargo_id'] = $info['cargo_id'];
                    $_SESSION['email'] = $email;
                    $_SESSION['usuario_suspendido'] = $info['usuario_suspendido'];
                    $cargo_id = $info['cargo_id'];
                    $cargo_data = mysqli_query($con, "SELECT c.carrera_id, t.turno_id
                        FROM cargos ca
                        JOIN carreras c ON ca.carrera_id = c.carrera_id
                        JOIN turnos t ON ca.turno_id = t.turno_id
                        WHERE ca.cargo_id = '$cargo_id'");

                    if ($cargo_info = mysqli_fetch_assoc($cargo_data)) {
                        $_SESSION['carrera_id'] = $cargo_info['carrera_id'];
                        $_SESSION['turno_id'] = $cargo_info['turno_id'];
                    }

                    
                    header("location:index.php");
                }else{
                    ?>
                    <script>alert("Contraseña invalida");</script>
                    <?php
                }
            }else{?>
                <script>alert ("Usuario invalido");</script>
                <?php
            }
        }
    }
    #endregion



    #region listarUsuarios
    public static function listarUsuarios() {
        // contraseña cifrada bien, ver si se puede corregir para que se vean solo puntos
        // $contrasenia = $info['contrasenia'];
        // $contrasenia_cifrada = str_repeat("*", strlen($contrasenia));
        // $contrasenia_cifrada = password_hash($contrasenia, PASSWORD_DEFAULT);
        // $contrasenia_con_puntos = str_repeat("*", strlen($contrasenia_cifrada))

        $con = conectar_db();
        $sql = "SELECT 
                    u.usuario_id, 
                    u.usuario_nombre, 
                    u.usuario_apellido, 
                    u.email,
                    u.rol_id,
                    r.rol_nombre, 
                    c.cargo_nombre,
                    u.usuario_suspendido,
                    u.primer_ingreso
                FROM 
                    usuarios u
                JOIN 
                    roles r ON u.rol_id = r.rol_id
                JOIN 
                    cargos c ON u.cargo_id = c.cargo_id
                ORDER BY 
                    u.rol_id, u.usuario_apellido, u.usuario_nombre";
    
        $resultado = $con->query($sql);
        $usuarios = [];
    
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $usuarios[] = $fila;
            }
        }
        return $usuarios;
    }
    #endregion


    }
    #endregion
    class Rol{

        #region atributos
        private $rol_id;
        private $rol_nombre;
        #endregion

        #region constructor
        public function __construct($turno){
            $this->turno = $turno;
        }
        #endregion
        #region listarRoles
        public static function listarRoles()
        {
            $con = conectar_db();
            $data = mysqli_query($con, "SELECT DISTINCT rol_id, rol_nombre FROM roles ORDER BY rol_nombre");
            $roles = [];

            if (mysqli_affected_rows($con) == 0) {
                echo "<tr><td><b class='bold red'>No hay roles registrados en el sistema</b></td></tr>";
            } else {
                while ($info = mysqli_fetch_assoc($data)) {
                    $roles[] = $info;
                }
            }
            
            return $roles;
        }
        #endregion
    }

?>