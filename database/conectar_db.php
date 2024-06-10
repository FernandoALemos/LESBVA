<?php 
    // function conectar_db (){
    //     $serv="localhost";
    //     $usr="root";
    //     $pss="";
    //     $bd="lesbva";
    //     $c=mysqli_connect($serv, $usr, $pss, $bd);
    //     return $c;
    // }
    function conectar_db (){
        $serv="localhost";
        $usr="root";
        $pss="";
        $bd="gapced";
        $c=mysqli_connect($serv, $usr, $pss, $bd);
        return $c;
    }
?>