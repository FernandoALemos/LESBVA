<?php
    require_once "database\conectar_db.php";
    #region clase Usuario
    class Usuario {

    #region atributos
        private $usuario_id;
        private $usuario_nombre;
        private $apellido;
        private $rol_id; // 1 para administrador 2, para director 3, para profesor, 4 para alumno
        private $contrasenia;
        private $email;
        private $dni;
    #endregion

    #region constructor
        public function __construct($usuario_id,$usuario_nombre,$apellido,$rol_id,$contrasenia,$email,$dni){
            $this->usuario_id = $usuario_id;
            $this->usuario_nombre = $usuario_nombre;
            $this->apellido = $apellido;
            $this->rol_id = $rol_id;
            $this->contrasenia = $contrasenia;
            $this->email = $email;
            $this->dni = $dni;
        }
    #endregion

    #region crearUsuario
        public function crearUsuario(){
            $con = conectar_db();
            $text = "";

            mysqli_query($con,"insert into usuarios (usuario_nombre,apellido,rol_id,contrasenia,email,dni) values ('$this->usuario_nombre','$this->apellido',$this->rol_id,'$this->contrasenia','$this->email',$this->dni);");

            (mysqli_affected_rows($con) > 0) ? $text = "Nuevo usuario agregado" : $text =" No se pudo generar un nuevo usuario";

            return $text;
        }
    #endregion

    #region modificarUsuario
        public function modificarUsuario(){
            $con = conectar_db();
            $texto = "";

            mysqli_query($con,"update usuarios set usuario_nombre = '$this->usuario_nombre', apellido = '$this->apellido' , rol_id = '$this->rol_id', contrasenia = '$this->contrasenia', email = '$this->email', dni = $this->dni where usuario_id = $this->usuario_id;");

            (mysqli_affected_rows($con) > 0) ? $texto = 'Usuario modificado correctamente' : $texto = 'No se pudo modificar al usuario correctamente';

            return $texto;
        }
    #endregion


    #region VerificarUsuario
    // MODIFICAR PARA QUE EL USUARIO SEA CON EL EMAIL Y SACAR EL DNI
        public static function VerificarUsuario($usuario_nombre,$contrasenia){
            $con = conectar_db();
            
            if ($usuario_nombre != "" && $contrasenia != ""){
                $usu = mysqli_query($con , "select usuario_nombre from usuarios where usuario_nombre = '$usuario_nombre'");
                if(mysqli_affected_rows($con)>0){
                    $contra = mysqli_query($con, " select contrasenia from usuarios where usuario_nombre = '$usuario_nombre'");
                    $contra = mysqli_fetch_assoc($contra);
                    if($contra['contrasenia'] === $contrasenia){
                        $data = mysqli_query($con,"select * from usuarios where usuario_nombre = '$usuario_nombre' ");
                        $info = mysqli_fetch_assoc($data);
                        session_start();
                        $_SESSION['usuario_id'] = $info['usuario_id'];
                        $_SESSION['usuario_nombre'] = $usuario_nombre;
                        $_SESSION['apellido'] = $info['apellido'];
                        $_SESSION['rol_id'] = $info['rol_id'];
                        $_SESSION['email'] = $info['email'];
                        $_SESSION['dni'] = $info['dni'];
                        
                        header("location:pantalla_busqueda.php");
                        //echo "<script> window.location.href='vista.php';</script>";
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
        public static function listarUsuarios(){
            $con = conectar_db();

            $data = mysqli_query($con,"select usuarios.usuario_id, usuarios.usuario_nombre, usuarios.apellido, roles.nombreRol, usuarios.contrasenia, usuarios.email, usuarios.dni, estados.nombreEstado from usuarios inner join roles on usuarios.rol_id = roles.rol_id order by usuario_id;");
            
            while ($info = mysqli_fetch_assoc($data)){ 
                // contraseña cifrada bien, ver si se puede corregir para que se vean solo puntos
                $contrasenia = $info['contrasenia'];
                $contrasenia_cifrada = str_repeat("*", strlen($contrasenia));
                // $contrasenia_cifrada = password_hash($contrasenia, PASSWORD_DEFAULT);
                // $contrasenia_con_puntos = str_repeat("*", strlen($contrasenia_cifrada));?>
                <tr>
                    <td><?php echo $info['usuario_id']; ?></td>
                    <td><?php echo $info['usuario_nombre']; ?></td>
                    <td><?php echo $info['apellido']; ?></td>
                    <td><?php echo $info['dni']; ?></td>
                    <td><?php echo $info['email']; ?></td>
                    <td><?php echo $contrasenia_cifrada; ?></td>
                    <td><?php echo $info['nombreRol']; ?></td>
                    <td><?php echo $info['nombreEstado']; ?></td>
                    <td>
                        <p class="acciones">
                            <!-- ARREGLAR SI ES QUE LO PIDE, MODIFICAR USUARIO -->
                            <a class="modificar" href=".php?pan=1 & acc=1 & usuario_id=<?php echo $info['usuario_id']; ?>">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a class="eliminar" href=".php?pan=1 & acc=2 & usuario_id=<?php echo $info['usuario_id']; ?>">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </p>
                    </td>
                </tr>
        <?php   }
        }
    #endregion

    #region formModificarUsuario por el momento no se usa
        public static function formModificarUsuario($usuario_id){
            $con = conectar_db();

            $data = mysqli_query($con,"select * from usuarios where usuario_id = $usuario_id;");

            $info = mysqli_fetch_assoc($data);

            ?>
            <!-- por el momento sin action, ver si lo quiere -->
            <form class="formVista" method="POST">
                <div class="formVista-inputs">
                    <label for="usuario_id">usuario_id<input type="text" class="inputVista corto" name="usuario_id"  usuario_id="usuario_id" readonly value="<?php echo $info['usuario_id']; ?>"></label>
                    <label for="usuario_nombre">usuario_nombre<input type="text" class="inputVista" name="usuario_nombre" onkeyup="this.value = this.value();" usuario_id="usuario_nombre" value="<?php echo $info['usuario_nombre']; ?>"></label>
                    <label for="apellido">APELLIDO<input type="text" class="inputVista" name="apellido" onkeyup="this.value = this.value();" usuario_id="apellido" value="<?php echo $info['apellido']; ?>"></label>
                    <label for="rol_id">Rol
                        <select class="inputVista" name="rol_id" usuario_id="rol_id">
                            <?php switch($info['rol_id']){
                                case 1: ?>
                                <option value="1">Administrador</option>
                                <option value="2">Director</option>
                                <option value="3">Profesor</option>
                                <option value="4">Alumno</option>
                                    <?php break;
                            }?>
                            
                        </select>
                    </label>
                    <label for="contrasenia">CONTRASEÑA<input type="password" class="inputVista" name="contrasenia" usuario_id="contrasenia" value="<?php echo $info['contrasenia']; ?>"></label>
                    <label for="email">EMAIL<input type="text" class="inputVista" name="email" onkeyup="this.value = this.value();" usuario_id="email" value="<?php echo $info['email']; ?>"></label>
                    <label for="dni">DNI<input type="text" class="inputVista medio" name="dni" usuario_id="dni" value="<?php echo $info['dni']; ?>"></label>
                </div >
                <div>
                    <label for="confirmar_cambios"><input type="checkbox" name="confirmar" usuario_id="confirmar_cambios" value="1" required> Confirmar</label>
                    <input type="hidden" name="pan" value="1"> 
                    <button type="submit" class="btn-ok">Modificar</button>
                    <!-- ARREGLAR SI ES QUE LO PIDE, MODIFICAR USUARIO -->
                    <a href=".php#Usuarios" class="btn-no ancora">Cancelar</a>
                </div>
            </form>

        <?php }

        #endregion

    }
    #endregion

?>