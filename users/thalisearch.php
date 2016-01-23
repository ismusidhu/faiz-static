<?php
include('connection.php');
session_start();

if (!is_null($_SESSION['fromLogin']) && in_array($_SESSION['email'], array('yusuf4u52@gmail.com','tzabuawala@gmail.com','bscalcuttawala@gmail.com'))) {
 
}
else
  header("Location: login.php");

if($_POST)
{
    $query="SELECT Thali, NAME, CONTACT, Active, Transporter, Full_Address, Thali_start_date, Thali_stop_date, Total_Pending FROM thalilist";

    if(!empty($_POST['thalino']))
    {
      $query.= " WHERE Thali = '".addslashes($_POST['thalino'])."'";
    }
    else if(!empty($_POST['mobile']))
    {
      $query.= " WHERE CONTACT = '".addslashes($_POST['mobile'])."'";
    }
    else if(!empty($_POST['its']))
    {
      $query.= " WHERE ITS_No = '".addslashes($_POST['its'])."'";
    }
    else if(!empty($_POST['general']))
    {
      $query.= " WHERE Email_ID LIKE '%".addslashes($_POST['general'])."%' or NAME LIKE '%".addslashes($_POST['general'])."%'";
    }

    $result = mysqli_query($link,$query);
    
}
    
?>
<!DOCTYPE html>

<!-- saved from url=(0029)http://bootswatch.com/flatly/ -->

<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta charset="utf-8">

    <title>Bootswatch: Flatly</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="stylesheet" href="./src/bootstrap.css" media="screen">

    <link rel="stylesheet" href="./src/custom.min.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>

      <script src="../bower_components/html5shiv/dist/html5shiv.js"></script>

      <script src="../bower_components/respond/dest/respond.min.js"></script>

    <![endif]-->

  </head>

  <body>

    <div class="navbar navbar-default navbar-fixed-top">

      <div class="container">

        <div class="navbar-header">

          <a class="navbar-brand">Faiz Students</a>

        </div>

        <ul class="nav navbar-nav navbar-right">
            <li><a href="index.php">Home</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>

      </div>

    </div>



    <div class="container">

      <!-- Forms

      ================================================== -->

        <div class="row">

          <div class="col-lg-12">

            <div class="page-header">

              <h2 id="forms">Thali Search</h2>

            </div>

          </div>



        <div class="row">

          <div class="col-lg-6">

            <div class="well bs-component">

              <form class="form-horizontal" method="post">

                <fieldset>


                   <div class="form-group">

                    <label for="inputThalino" class="col-lg-2 control-label">Thali No</label>

                    <div class="col-lg-10">

                      <input type="text" class="form-control" id="inputThalino" placeholder="Thali No"  name="thalino">

                    </div>

                  </div>

                  <div class="form-group">

                    <label for="inputIts" class="col-lg-2 control-label">Its No</label>

                    <div class="col-lg-10">

                      <input type="text" class="form-control" id="inputIts" placeholder="Its No" name="its">

                    </div>

                  </div>



                  <div class="form-group">

                    <label for="inputMobile" class="col-lg-2 control-label">Mobile No</label>

                    <div class="col-lg-10">

                      <input type="text" class="form-control" id="inputMobile" placeholder="Mobile No"   name="mobile">

                    </div>

                  </div>



                  <div class="form-group">

                    <label for="inputGeneral" class="col-lg-2 control-label">Email / Name</label>

                    <div class="col-lg-10">

                      <input type="text" class="form-control" id="inputGeneral" placeholder="Email / Name"    name="general">

                    </div>

                  </div>



                  <div class="form-group">

                    <div class="col-lg-10 col-lg-offset-2">

                      <button type="submit" class="btn btn-primary">Submit</button>

                    </div>

                  </div>

                </fieldset>

              </form>

            </div>

          </div>
          <?php
            if($_POST):
              ?>
           <div class="col-lg-12">



          <div class="col-lg-12">

            <div class="page-header">

              <h2 id="tables">Thali Info</h2>

            </div>

            <div class="bs-component">

              <table class="table table-striped table-hover ">

                <thead>

                  <tr>
                    <th>Thali No</th>
                    <th>Name</th>
                    <th>Mobile No</th>
                    <th>Active</th>
                    <th>Transporter</th>
                    <th>Address</th>
                    <th>Start Date</th>
                    <th>Stop Date</th>
                    <th>Hub pending</th>
                  </tr>

                </thead>

                <tbody>
                  <?php
                    while($values = mysqli_fetch_assoc($result))
                    {
                  ?>
                  <tr>

                    <td><?php echo $values['Thali']; ?></td>
                    <td><?php echo $values['NAME']; ?></td>
                    <td><?php echo $values['CONTACT']; ?></td>
                    <td><?php echo ($values['Active'] == '1') ? 'Yes' : 'No'; ?></td>
                    <td><?php echo $values['Transporter']; ?></td>
                    <td><?php echo $values['Full_Address']; ?></td>
                    <td><?php echo $values['Thali_start_date']; ?></td>
                    <td><?php echo $values['Thali_stop_date']; ?></td>
                    <td><?php echo $values['Total_Pending']; ?></td>


                  </tr>
                  <?php } ?>

                  <!-- <tr>

                    <td>2</td>

                    <td>Column content</td>

                    <td>Column content</td>

                    <td>Column content</td>

                  </tr>

                  <tr class="info">

                    <td>3</td>

                    <td>Column content</td>

                    <td>Column content</td>

                    <td>Column content</td>

                  </tr>

                  <tr class="success">

                    <td>4</td>

                    <td>Column content</td>

                    <td>Column content</td>

                    <td>Column content</td>

                  </tr>

                  <tr class="danger">

                    <td>5</td>

                    <td>Column content</td>

                    <td>Column content</td>

                    <td>Column content</td>

                  </tr>

                  <tr class="warning">

                    <td>6</td>

                    <td>Column content</td>

                    <td>Column content</td>

                    <td>Column content</td>

                  </tr>

                  <tr class="active">

                    <td>7</td>

                    <td>Column content</td>

                    <td>Column content</td>

                    <td>Column content</td>

                  </tr> -->

                </tbody>

              </table> 

            </div><!-- /example -->
            

          </div>

      



          </div>
<?php
            endif;
              ?>
        </div>

      </div>

    </div>





    <script src="./src/jquery-1.10.2.min.js"></script>

    <script src="./src/bootstrap.min.js"></script>

    <script src="./src/custom.js"></script>





</body></html>