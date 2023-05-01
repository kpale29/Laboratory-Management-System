<?php
$con=mysqli_connect("localhost","root","","myhmsdb2");

if(isset($_POST['update_data']))
{
 $contact=$_POST['contact'];
 $status=$_POST['status'];
 $query="update cita set payment='$status' where contact='$contact';";
 $result=mysqli_query($con,$query);
 if($result)
  header("Location:updated.php");
}


function display_specs() {
  global $con;
  $query="select distinct(especialidad) spec from doctor";
  $result=mysqli_query($con,$query);
  while($row=mysqli_fetch_array($result))
  {
    $spec=$row['spec'];
    echo '<option data-value="'.$spec.'">'.$spec.'</option>';
  }
}

function display_examen() {
  global $con;
  $query="select * from examen";
  $result=mysqli_query($con,$query);
  while($row=mysqli_fetch_array($result))
  {
    $id=$row['id'];
    $examen=$row['examen'];
    $price=$row['precio'];
    echo '<option value="'.$id.'" data-value="'.$price.'">'.$examen.'</option>';
  }
} 

function display_docs()
{
 global $con;
 $query = "select id, usuario username, password, correo email, especialidad spec, honorarios docFees  from doctor";
 $result = mysqli_query($con,$query);
 while( $row = mysqli_fetch_array($result) )
 {
  $username = $row['username'];
  $id = $row['id'];
  $price = $row['docFees'];
  $spec = $row['spec'];
  echo '<option value="' .$id. '" data-value="'.$price.'" data-spec="'.$spec.'">'.$username.'</option>';
 }
}

if(isset($_POST['doc_sub']))
{
 $username=$_POST['username'];
 $query="insert into doctor(usuario)values('$username')";
 $result=mysqli_query($con,$query);
 if($result)
  header("Location:adddoc.php");
}

?>