<?php 
    function conectar_db (){
        $serv="localhost";
        $usr="root";
        $pss="";
        $bd="gapced";
        $c=mysqli_connect($serv, $usr, $pss, $bd);
        return $c;
    }
?>