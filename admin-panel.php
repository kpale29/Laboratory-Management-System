<!DOCTYPE html>
<?php
include('func.php');
include('newfunc.php');
$con = mysqli_connect("localhost", "root", "", "myhmsdb2");


$pid = $_SESSION['pid'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$fname = $_SESSION['fname'];
$gender = $_SESSION['gender'];
$lname = $_SESSION['lname'];
$contact = $_SESSION['contact'];



if (isset($_POST['app-submit'])) {
  $pid = $_SESSION['pid'];
  $username = $_SESSION['username'];
  $email = $_SESSION['email'];
  $fname = $_SESSION['fname'];
  $lname = $_SESSION['lname'];
  $gender = $_SESSION['gender'];
  $contact = $_SESSION['contact'];
  $doctor = $_POST['doctor'];
  $examen = $_POST['examen'];
  $email = $_SESSION['email'];
  # $fees=$_POST['fees'];
  $docFees = $_POST['docFees'];

  $appdate = $_POST['appdate'];
  $apptime = $_POST['apptime'];
  $cur_date = date("Y-m-d");
  date_default_timezone_set('Asia/Kolkata');
  $cur_time = date("H:i:s");
  $apptime1 = strtotime($apptime);
  $appdate1 = strtotime($appdate);

  if (date("Y-m-d", $appdate1) >= $cur_date) {
    if ((date("Y-m-d", $appdate1) == $cur_date and date("H:i:s", $apptime1) > $cur_time) or date("Y-m-d", $appdate1) > $cur_date) {
      $check_query = mysqli_query($con, "select fecha from cita where id_doctor = '$doctor'and fecha ='$appdate'and hora = '$apptime'");

      if (mysqli_num_rows($check_query) == 0) {
        $query = mysqli_query($con, "insert into cita(id_paciente,id_doctor,id_examen,fecha,hora,userStatus,doctorStatus) values('$pid','$doctor','$examen','$appdate','$apptime','1','1')");

        if ($query) {
          echo "<script>alert('Tu cita fue agendada con exito!');</script>";
        } else {
          echo "<script>alert('Unable to process your request. Please try again!');</script>";
        }
      } else {
        echo "<script>alert('Lamentamos informarle que el doctor no se encuentra disponible en este horario, eliga uno diferente.');</script>";
      }
    } else {
      echo "<script>alert('Selecciona una fecha distinta a hoy.');</script>";
    }
  } else {
    echo "<script>alert('Selecciona una fecha distinta a hoy.');</script>";
  }

}

if (isset($_GET['cancel'])) {
  $query = mysqli_query($con, "update cita set userStatus='0' where id = '" . $_GET['ID'] . "'");
  if ($query) {
    echo "<script>alert('Tu cita fue cancelada con exito!');</script>";
  }
}


if (isset($_GET["generate_bill"])) {
  $query = mysqli_query($con, "select r.id, c.id, p.pnombre,papellido,d.usuario,r.fecha,'','',r.hora,r.comentario,e.precio, r.path_resultado path from resultado r inner join cita c on r.id_cita = c.id inner join paciente p on c.id_paciente = p.id inner join doctor d on c.id_doctor = d.id inner join examen e on c.id_examen = e.id where r.id = '" . $_GET['id_resultado'] . "'");
  while ($row = mysqli_fetch_array($query)) {

    $ruta_archivo = $row["path"];
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($ruta_archivo) . '"');
    header('Content-Length: ' . filesize($ruta_archivo));

    // Leer el archivo y enviarlo al cliente
    readfile($ruta_archivo);
  }
}

function get_specs()
{
  $con = mysqli_connect("localhost", "root", "", "myhmsdb2");
  $query = mysqli_query($con, "select username,spec from doctor");
  $docarray = array();
  while ($row = mysqli_fetch_assoc($query)) {
    $docarray[] = $row;
  }
  return json_encode($docarray);
}

?>
<html lang="en">

<head>


  <!-- Required meta tags -->
  <meta charset="utf-8">
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="style.css">
  <!-- Bootstrap CSS -->

  <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">








  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css"
    integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <a class="navbar-brand" href="#"><i class="fa fa-user-plus" aria-hidden="true"></i> Laboratorio Clinico </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <style>
      .bg-primary {
        background: -webkit-linear-gradient(left, #3931af, #00c6ff);
      }

      .list-group-item.active {
        z-index: 2;
        color: #fff;
        background-color: #342ac1;
        border-color: #007bff;
      }

      .text-primary {
        color: #342ac1 !important;
      }

      .btn-primary {
        background-color: #3c50c1;
        border-color: #3c50c1;
      }
    </style>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"></a>
        </li>
      </ul>
    </div>
  </nav>
</head>
<style type="text/css">
  button:hover {
    cursor: pointer;
  }

  #inputbtn:hover {
    cursor: pointer;
  }
</style>

<body style="padding-top:50px;">

  <div class="container-fluid" style="margin-top:50px;">
    <h3 style="margin-left: 40%;  padding-bottom: 20px; font-family: 'IBM Plex Sans', sans-serif;"> Bienvenido &nbsp
      <?php echo $username ?>
    </h3>
    <div class="row">
      <div class="col-md-4" style="max-width:25%; margin-top: 3%">
        <div class="list-group" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active" id="list-dash-list" data-toggle="list"
            href="#list-dash" role="tab" aria-controls="home">Dashboard</a>
          <a class="list-group-item list-group-item-action" id="list-home-list" data-toggle="list" href="#list-home"
            role="tab" aria-controls="home">Agendar cita</a>
          <a class="list-group-item list-group-item-action" href="#app-hist" id="list-pat-list" role="tab"
            data-toggle="list" aria-controls="home">Historial de citas</a>
          <a class="list-group-item list-group-item-action" href="#list-pres" id="list-pres-list" role="tab"
            data-toggle="list" aria-controls="home">Resultados</a>

        </div><br>
      </div>
      <div class="col-md-8" style="margin-top: 3%;">
        <div class="tab-content" id="nav-tabContent" style="width: 950px;">


          <div class="tab-pane fade  show active" id="list-dash" role="tabpanel" aria-labelledby="list-dash-list">
            <div class="container-fluid container-fullw bg-white">
              <div class="row">
                <div class="col-sm-4" style="left: 5%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i
                          class="fa fa-terminal fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;"> Agendar una cita</h4>
                      <script>
                        function clickDiv(id) {
                          document.querySelector(id).click();
                        }
                      </script>
                      <p class="links cl-effect-1">
                        <a href="#list-home" onclick="clickDiv('#list-home-list')">
                          Agendar cita
                        </a>
                      </p>
                    </div>
                  </div>
                </div>

                <div class="col-sm-4" style="left: 10%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i
                          class="fa fa-paperclip fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">Mis citas</h2>

                        <p class="cl-effect-1">
                          <a href="#app-hist" onclick="clickDiv('#list-pat-list')">
                            Historial de citas
                          </a>
                        </p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-4" style="left: 20%;margin-top:5%">
                <div class="panel panel-white no-radius text-center">
                  <div class="panel-body">
                    <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i
                        class="fa fa-list-ul fa-stack-1x fa-inverse"></i> </span>
                    <h4 class="StepTitle" style="margin-top: 5%;">Resultados</h2>

                      <p class="cl-effect-1">
                        <a href="#list-pres" onclick="clickDiv('#list-pres-list')">
                          Historial de resultados
                        </a>
                      </p>
                  </div>
                </div>
              </div>


            </div>
          </div>





          <div class="tab-pane fade" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
            <div class="container-fluid">
              <div class="card">
                <div class="card-body">
                  <center>
                    <h4>Agendar una cita</h4>
                  </center><br>
                  <form class="form-group" method="post" action="admin-panel.php">
                    <div class="row">

                      <!-- <?php

                      $con = mysqli_connect("localhost", "root", "", "myhmsdb2");
                      $query = mysqli_query($con, "select id, usuario username,especialidad spec from doctor");
                      $docarray = array();
                      while ($row = mysqli_fetch_assoc($query)) {
                        $docarray[] = $row;
                      }
                      echo json_encode($docarray);

                      ?> -->


                      <div class="col-md-4">
                        <label for="spec">Examen:</label>
                      </div>
                      <div class="col-md-8">
                        <select name="examen" class="form-control" id="examen">
                          <option value="" disabled selected>Selecciona un examen</option>
                          <?php
                          display_examen();
                          ?>
                        </select>
                      </div>

                      <br><br>

                      <script>
                        document.getElementById('examen').onchange = function updateComent(e) {
                          var selection = document.querySelector(`[value="${this.value}"]`).getAttribute('valor');
                          document.getElementById('comment').value = selection;

                          var selection = document.querySelector(`[value="${this.value}"]`).getAttribute('data-value');
                          document.getElementById('docFees').value = selection;
                        };
                      </script>

                      <div class="col-md-4"><label for="consultancyfees">
                          Precio
                        </label></div>
                      <div class="col-md-8">
                        <!-- <div id="docFees">Select a doctor</div> -->
                        <input class="form-control" type="text" name="docFees" id="docFees" readonly="readonly" />
                      </div><br><br>

                      <div class="col-md-4"><label for="consultancyfees">
                          Comentario
                        </label></div>
                      <div class="col-md-8">
                        <!-- <div id="docFees">Select a doctor</div> -->
                        <input class="form-control" type="text" name="comment" id="comment" readonly="readonly" />
                      </div><br><br>

                      <div class="col-md-4"><label for="doctor">Técnico:</label></div>
                      <div class="col-md-8">
                        <select name="doctor" class="form-control" id="doctor" required="required">
                          <option value="" disabled selected>Selecciona un técnico</option>

                          <?php display_docs(); ?>
                        </select>
                      </div><br /><br />

                      <div class="col-md-4"><label>Fecha</label></div>
                      <div class="col-md-8"><input type="date" class="form-control datepicker" name="appdate"></div>
                      <br><br>

                      <div class="col-md-4"><label>Hora</label></div>
                      <div class="col-md-8">
                        <!-- <input type="time" class="form-control" name="apptime"> -->
                        <select name="apptime" class="form-control" id="apptime" required="required">
                          <option value="" disabled selected>Selecciona una fecha</option>
                          <option value="08:00:00">8:00 AM</option>
                          <option value="10:00:00">10:00 AM</option>
                          <option value="12:00:00">12:00 PM</option>
                          <option value="14:00:00">2:00 PM</option>
                          <option value="16:00:00">4:00 PM</option>
                        </select>

                      </div><br><br>

                      <div class="col-md-4">
                        <input type="submit" name="app-submit" value="Crear" class="btn btn-primary" id="inputbtn">
                      </div>
                      <div class="col-md-8"></div>
                    </div>
                  </form>
                </div>
              </div>
            </div><br>
          </div>

          <div class="tab-pane fade" id="app-hist" role="tabpanel" aria-labelledby="list-pat-list">

            <table class="table table-hover">
              <thead>
                <tr>

                  <th scope="col">Técnico</th>
                  <th scope="col">Precio</th>
                  <th scope="col">Fecha</th>
                  <th scope="col">Hora</th>
                  <th scope="col">Estado actual</th>
                  <th scope="col">Accion</th>
                </tr>
              </thead>
              <tbody>
                <?php

                $con = mysqli_connect("localhost", "root", "", "myhmsdb2");
                global $con;

                $query = "select c.Id ID, d.usuario doctor, e.precio docFees, c.fecha appdate, c.hora apptime, c.userStatus,c.doctorStatus
                from cita c
                inner join paciente p on p.id = c.id_paciente
                inner join doctor d on d.id = c.id_doctor
                inner join examen e on e.id = c.id_examen
                where p.pnombre = '$fname' and papellido = '$lname';";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_array($result)) {

                  #$fname = $row['fname'];
                  #$lname = $row['lname'];
                  #$email = $row['email'];
                  #$contact = $row['contact'];
                  ?>
                  <tr>
                    <td>
                      <?php echo $row['doctor']; ?>
                    </td>
                    <td>
                      <?php echo $row['docFees']; ?>
                    </td>
                    <td>
                      <?php echo $row['appdate']; ?>
                    </td>
                    <td>
                      <?php echo $row['apptime']; ?>
                    </td>

                    <td>
                      <?php if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 1)) {
                        echo "Active";
                      }
                      if (($row['userStatus'] == 0) && ($row['doctorStatus'] == 1)) {
                        echo "Cancelled by You";
                      }

                      if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 0)) {
                        echo "Cancelled by Doctor";
                      }
                      ?>
                    </td>

                    <td>
                      <?php if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 1)) { ?>


                        <a href="admin-panel.php?ID=<?php echo $row['ID'] ?>&cancel=update"
                          onClick="return confirm('Desea cancelar la cita?')" title="Cancel Appointment"
                          tooltip-placement="top" tooltip="Remove"><button class="btn btn-danger">Cancel</button></a>
                      <?php } else {

                        echo "Cancelled";
                      } ?>

                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
            <br>
          </div>



          <div class="tab-pane fade" id="list-pres" role="tabpanel" aria-labelledby="list-pres-list">

            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Id Resultado</th>
                  <th scope="col">Técnico</th>
                  <th scope="col">Id Cita</th>
                  <th scope="col">Fecha</th>
                  <th scope="col">Hora</th>
                  <th scope="col">Comentario</th>
                  <th scope="col">Resultado</th>
                </tr>
              </thead>
              <tbody>
                <?php

                $con = mysqli_connect("localhost", "root", "", "myhmsdb2");
                global $con;

                $query = "select r.id id_resultado,d.usuario doctor,c.id ID,c.fecha appdate, c.hora apptime, r.comentario prescription from resultado r inner join cita c on c.id = r.id_cita inner join doctor d on d.id = c.id_doctor inner join paciente p on p.id = c.id_paciente where p.id='$pid';";

                $result = mysqli_query($con, $query);
                if (!$result) {
                  echo mysqli_error($con);
                }


                while ($row = mysqli_fetch_array($result)) {
                  ?>
                  <tr>
                    <td>
                      <?php echo $row['id_resultado']; ?>
                    </td>
                    <td>
                      <?php echo $row['doctor']; ?>
                    </td>
                    <td>
                      <?php echo $row['ID']; ?>
                    </td>
                    <td>
                      <?php echo $row['appdate']; ?>
                    </td>
                    <td>
                      <?php echo $row['apptime']; ?>
                    </td>
                    <td>
                      <?php echo $row['prescription']; ?>
                    </td>
                    <td>
                      <form method="get">

                        <a href="admin-panel.php?id_resultado=<?php echo $row['id_resultado'] ?>">
                          <input type="hidden" name="id_resultado" value="<?php echo $row['id_resultado'] ?>" />
                          <input type="submit" name="generate_bill" class="btn btn-success" value="Descargar" />
                        </a>
                    </td>
                    </form>


                  </tr>
                <?php }
                ?>
              </tbody>
            </table>
            <br>
          </div>




          <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">...</div>
          <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
            <form class="form-group" method="post" action="func.php">
              <label>Doctors name: </label>
              <input type="text" name="name" placeholder="Enter doctors name" class="form-control">
              <br>
              <input type="submit" name="doc_sub" value="Add Doctor" class="btn btn-primary">
            </form>
          </div>
          <div class="tab-pane fade" id="list-attend" role="tabpanel" aria-labelledby="list-attend-list">...</div>
        </div>
      </div>
    </div>
  </div>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
    integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
    crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"
    integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.all.min.js">
  </script>



</body>

</html>