<?php
  session_start();
  if(!isset($_SESSION["customer"])){
    header("Location: identification.html");
  }
?>

<?php
  include("../config.php");
  $query = "SELECT store_brand, store_id, opening_time, closing_time, store_image FROM store";
  $result = mysqli_query($conn, $query);
  $storeRes = mysqli_query($conn, "SELECT store_brand, store_id FROM store");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
      integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
      crossorigin="anonymous"
    />
    <title>PU eCanteen</title>
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap");
      body{
          overflow-x: hidden;
          background-color: #AFD198;
      }
      .carousel-item{
          height: 29rem;
          background: #777;
          color: white;
      }

      .container{
          position: absolute;
          bottom: 0;
          left: 0;
          right: 0;
          padding-bottom: 60px;
      }

      .overlay-image{
          position: absolute;
          bottom: 0;
          left: 0;
          top: 0;
          right: 0;
          background-position: center;
          background-size: cover;
          background-repeat: no-repeat;
      }


      .card{
          background-color: #FEFDED;
          border: 2px solid black;
          border-radius: 10px;
          width: 26rem;
          padding: 0;
          overflow: hidden;
      }

      .card-body{
          background-color: #ECCA9C;
          border-bottom-left-radius: 10px;
          border-bottom-right-radius: 10px;
      }

      p{
          font-weight: bold;
          font-family: "Poppins";
      }

      .divider-line {
          border-top: 2px solid black; 
      }

      .card-img-top {
          display: block;
          padding: 0;
      }

      .row-gap{
          margin-bottom: 50px;
      }

      footer{
          text-align: left;
          padding: 3px;
          background-color: #777;
          color: white;
          height: 5rem;
          font-family: "Poppins";
      }

      ul li{
            margin-right: 10px;
        }
    </style>
    </head>
  <body>
    <nav
      class="navbar navbar-expand-lg bg-body-tertiary"
      style="background-color: #fcf2e8"
    >
      <div class="container-fluid">
        <a class="navbar-brand" href="">
          <img src="../source/logo.png" alt="logo" height="45" />
        </a>

        <ul class="navbar-nav ml-auto">
        <li class="btn-group">
                        <a class="btn dropdown-toggle" style="background-color:#F7C566;" href="#" id="navbardrop" data-toggle="dropdown">
                            Check Another Store
                        </a>
                        <div class="dropdown-menu">
                            <?php
                                if(mysqli_num_rows($storeRes) > 0){
                                    while($row = mysqli_fetch_assoc($storeRes)){
                                        echo '<a class="dropdown-item" href="menu.php?store_id='. $row["store_id"].'">' . $row["store_brand"] . '</a>';
                                    }
                                }
                            ?>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-block" style="background-color:#90D26D;" href="./home.php">Back To Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-block" style="background-color:#FA7070;" href="./logout.php">Log Out</a>
                    </li>
        </ul>
        
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
    </nav>

    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="overlay-image">
            <img src="../source/slide-1.png">
          </div>
          <div class="container">
          </div>
        </div>
        <div class="carousel-item">
          <div class="overlay-image">
            <img src="../source/slide-2.png">
          </div>
        </div>
        <div class="carousel-item">
        <div class="overlay-image">
            <img src="../source/slide-3.png">
          </div>
        </div>
      </div>
      <a
        href="#myCarousel"
        class="carousel-control-prev"
        role="button"
        data-slide="prev"
      >
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      </a>
      <a
        href="#myCarousel"
        class="carousel-control-next"
        role="button"
        data-slide="next"
      >
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
      </a>
    </div>
    <br /><br /><br />

    <div class="card-deck justify-content-center">
      <div class="row row-gap">
        <?php
          if(mysqli_num_rows($result) > 0){
            $count = 0;
            while($row = mysqli_fetch_assoc($result)){
              echo '<div class="col">';
              echo '<div class="card">'; 
              echo '<img src="../image/'. $row["store_image"] . '" class="card-img-top" style="max-width: 100%; max-height: 220px;"/>';
              
              echo '<div class="card-body divider-line">';
              echo '<h3 class="card-title">' . $row["store_brand"] . '</h3>';
              echo '<p class="card-text">Operational Time: <br>' . $row["opening_time"] . ' - ' . $row["closing_time"] . '</p>';
              echo '<a href="menu.php?store_id='. $row["store_id"] . '" class="btn btn-primary btn-block">View Store</a>';
              echo '</div></div></div>';
              $count++;
              if($count % 3 == 0){
                echo '</div><div class="row row-gap">';
              }
            }
          }else{
            echo "0 Result";
          }
        ?>
        </div>
    </div>

    <br>
    <footer>
      <br>
      <center><h6>© 2024 President University eCanteen Service</h6></center>
      <center><p>All Rights Reserved</p></center>
    </footer>

    <script
      src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
      integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
      integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
      integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
