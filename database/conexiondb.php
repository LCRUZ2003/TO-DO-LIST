<?php
// Lisbeth De La Cruz Toribio 2024 - 0642 
// Conexion a la base de datos  - - -  dbname=xedolist


//conexion a la db
try{
$conn = new PDO('mysql:host=127.0.0.1;dbname=xedolist','root','');
echo "conectado";
}catch(PDOException $e){
    echo "Error de conexion";
}

//actualiza si es completado o no
if(isset($_POST['id'])){
    $id=$_POST['id'];
    $completado=(isset($_POST['completado']))?1:0;
    $sql="UPDATE tareas SET completado=? WHERE id=?";
    $sentencia=$conn->prepare($sql);
    $sentencia->execute([$completado,$id]);

}

//agregar tarea
if(isset($_POST['agregar tarea'])){
    $tarea=($_POST['tarea']);
    $sql='INSERT INTO tareas (tarea) VALUE (?)';
    $sentencia=$conn->prepare($sql);
    $sentencia->execute([$tarea]);
}

//para elimirar tarea de la tabla
if(isset($_GET['id'])){ 
    $id=$_GET['id'];
    $sql="DELETE FROM tareas WHERE id=?";
    $sentencia=$conn->prepare($sql);
    $sentencia->execute([$id]);
}

//para mostrar registro
$sql="SELECT * FROM tareas";
$registros=$conn->query($sql);

?>