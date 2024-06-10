<?php
    require_once "database\conectar_db.php";
    #region clase Usuario
    class Usuario {

    #region atributos
        private $usuario_id;
        private $usuario_nombre;
        private $usuario_apellido;
        private $rol_id; // 1 para administrador 2, para director 3, para profesor, 4 para alumno
        private $cargo_id; // uso para los usuarios no admin, tendran a cargo una carrera y turno
        private $contrasenia;
        private $email;
        private $usuario_suspendido;
    #endregion

    #region constructor
        public function __construct($usuario_id,$usuario_nombre,$usuario_apellido,$rol_id,$cargo_id,$contrasenia,$email,$usuario_suspendido){
            $this->usuario_id = $usuario_id;
            $this->usuario_nombre = $usuario_nombre;
            $this->usuario_apellido = $usuario_apellido;
            $this->rol_id = $rol_id;
            $this->cargo_id = $cargo_id;
            $this->contrasenia = $contrasenia;
            $this->email = $email;
            $this->usuario_suspendido = $usuario_suspendido;
        }
    #endregion

    #region crearUsuario
        public function crearUsuario(){
            $con = conectar_db();
            $text = "";

            mysqli_query($con,"insert into usuarios (usuario_nombre,usuario_apellido,rol_id,cargo_id,contrasenia,email,usuario_suspendido) values ('$this->usuario_nombre','$this->usuario_apellido',$this->rol_id,'$this->cargo_id',
            '$this->contrasenia','$this->email',$this->usuario_suspendido);");

            (mysqli_affected_rows($con) > 0) ? $text = "Nuevo usuario agregado" : $text =" No se pudo generar un nuevo usuario";

            return $text;
        }
    #endregion

    #region modificarUsuario
        public function modificarUsuario(){
            $con = conectar_db();
            $texto = "";

            mysqli_query($con,"update usuarios set usuario_nombre = '$this->usuario_nombre', usuario_apellido = '$this->usuario_apellido' , rol_id = '$this->rol_id',cargo_id = '$this->cargo_id', contrasenia = '$this->contrasenia', email = '$this->email', usuario_suspendido = $this->usuario_suspendido where usuario_id = $this->usuario_id;");

            (mysqli_affected_rows($con) > 0) ? $texto = 'Usuario modificado correctamente' : $texto = 'No se pudo modificar al usuario correctamente';

            return $texto;
        }
    #endregion


    #region VerificarUsuario
    // MODIFICAR PARA QUE EL USUARIO SEA CON EL EMAIL Y SACAR EL DNI
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

            $data = mysqli_query($con,"select usuarios.usuario_id, usuarios.usuario_nombre, usuarios.usuario_apellido, roles.rol_nombre, cargos.cargo_nombre, usuarios.contrasenia, usuarios.email, usuarios.usuario_suspendido from usuarios inner join roles on usuarios.rol_id = roles.rol_id inner join cargos on usuarios.cargo_id = cargos.cargo_id order by usuario_id;");
            
            while ($info = mysqli_fetch_assoc($data)){ 
                // contraseña cifrada bien, ver si se puede corregir para que se vean solo puntos
                $contrasenia = $info['contrasenia'];
                $contrasenia_cifrada = str_repeat("*", strlen($contrasenia));
                // $contrasenia_cifrada = password_hash($contrasenia, PASSWORD_DEFAULT);
                // $contrasenia_con_puntos = str_repeat("*", strlen($contrasenia_cifrada));?>
                <tr>
                    <td><?php echo $info['usuario_id']; ?></td>
                    <td><?php echo $info['usuario_nombre']; ?></td>
                    <td><?php echo $info['usuario_apellido']; ?></td>
                    <td><?php echo $info['email']; ?></td>
                    <td><?php echo $contrasenia_cifrada; ?></td>
                    <td><?php echo $info['rol_nombre']; ?></td>
                    <td><?php echo $info['cargo_nombre']; ?></td>
                    <td><?php echo $info['usuario_suspendido']; ?></td>
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
                    <label for="usuario_nombre">Nombre<input type="text" class="inputVista" name="usuario_nombre" onkeyup="this.value = this.value();" usuario_id="usuario_nombre" value="<?php echo $info['usuario_nombre']; ?>"></label>
                    <label for="usuario_apellido">Apellido<input type="text" class="inputVista" name="usuario_apellido" onkeyup="this.value = this.value();" usuario_id="usuario_apellido" value="<?php echo $info['usuario_apellido']; ?>"></label>
                    <label for="rol_id">Rol
                        <select class="inputVista" name="rol_id" usuario_id="rol_id">
                            <?php switch($info['rol_id']){
                                case 1: ?>
                                <option value="1">Directivo</option>
                                <option value="2">Regencia</option>
                                <option value="3">Preceptoria</option>
                                <option value="4">Secretaria</option>
                                    <?php break;
                            }?>
                            
                        </select>
                    </label>
                    <!-- CREAR CARGO Y VER QUE EL FILTRO AGREGUE LAS AGREGUE CUANDO EL USUARIO LAS CREE -->
                    <label for="cargo_id">Cargo
                        <select class="inputVista" name="cargo_id" usuario_id="cargo_id">
                            <?php switch($info['cargo_id']){
                                case 1: ?>
                                <option value="1">Sistemas</option>
                                    <?php break;
                            }?>
                            
                        </select>
                    </label>
                    <!-- NO DEBE MODIFICAR CONTRASEÑA y NO TIENE PORQUE MODIFICARLA-->
                    <label for="email">Email<input type="text" class="inputVista" name="email" onkeyup="this.value = this.value();" usuario_id="email" value="<?php echo $info['email']; ?>"></label>
                    <label for="usuario_suspendido">Suspendido<input type="text" class="inputVista medio" name="usuario_suspendido" usuario_id="usuario_suspendido" value="<?php echo $info['usuario_suspendido']; ?>"></label>
                </div >
                <div>
                    <label for="confirmar_cambios"><input type="checkbox" name="confirmar" usuario_id="confirmar_cambios" value="1" required> Confirmar</label>
                    <input type="hidden" name="pan" value="1"> 
                    <button type="submit" class="btn-ok">Modificar</button>
                    <!-- MODIFICAR USUARIO -->
                    <a href=".php#Usuarios" class="btn-no ancora">Cancelar</a>
                </div>
            </form>

        <?php }

        #endregion

    }
    #endregion

?>