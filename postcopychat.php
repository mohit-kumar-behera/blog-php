<?php

session_start();
$_SESSION['id']=$_GET['id'];
include 'postcopysqlconfig.php';

$sqlchatuser=$conn->prepare("SELECT * FROM `usersprofile` WHERE `id`=?");
$sqlchatuser->bind_param("s",$_SESSION['id']);
$sqlchatuser->execute();
$sqlchatuser->store_result();
$sqlchatuser->bind_result($getuserid,$getusername,$getuseremail,$getuserpassword,$getusernumber,$getuseraddress,$getuserbio,$getuserprofilepic);
$sqlchatuser->fetch();
$sqlchatuser->close();


?>


<!DOCTYPE html>
<html>
<title>Postcopy BaatCheet</title>
<head>
	<meta link-colorarset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Modak&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Galada&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Permanent+Marker&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Pangolin&display=swap" rel="stylesheet">
   <!-- To prevent Confirm Form Resubmission When page reload after submitting a form -->
  	<script>
    	if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    	}
	 </script>
   <style type='text/css'>

    /*styling the scroll bar */

    ::-webkit-scrollbar
    {
      width:3px;
    }
  
    ::-webkit-scrollbar-thumb
    {
      background:#FFCC00;
      border-radius:4px;
    }
    ::-webkit-scrollbar-thumb:hover
    {
      background:red;
    }
    /*end of styling scroll bar */

    #brandname
    {
      background:linear-gradient(to left,#8E2DE2,#4A00E0);
      color:#efe3ed;
      height:75px;
    }
    #tophomemenu
    {
      color:white;
    }
    #tophomemenu:hover
    {
      color:orange;
    }
    #topprofpic:hover
    {
      transform:rotateX(360deg);
      transition-duration: 1.5s;
    }

    @media screen and (max-width:820px)
    {
      #chatonsmallscreen{
        display:block;

      }
      #chatonbigscreen{
        display:none;
      }
    }
    @media screen and (min-width:821px)
    {
      #chatonsmallscreen{
        display:none;

      }
      #chatonbigscreen{
        display:block;
      }
    }

   </style>
 </head>
 <body>


<div class="jumbotron-fluid sticky-top" id="brandname">
    <div class="container p-2 ml-1" id="brandcontainer">
      <div class='d-flex justify-content-between'>
        <div class='d-flex flex-column ml-2'>
          <div class='d-flex' style='position:relative;left:-6px'>

              <div style='height:22px;padding-bottom:2px;transform:rotate(270deg);position:relative;top:10px;right:-5px'><small style='font-size:16px;color:orange'><b>k</b></small><small style='font-size:15px;color:lightgrey'>a</small><small style='font-size:14px;color:orange'>r</small><small style='font-size:16px;color:lightgrey'>o</small></div>
              
                <h2 style="font-family: 'Pangolin', cursive;letter-spacing:2.5px;color:lightgrey"><span style='color:#86c7ce;font-size:40px;'>B</span>a<span style='color:lightgreen;'>a</span>t<span style='color:orange;font-size:40px'>C</span><span style="font-size:18px;position:relative;top:-8px;left:-18.2px">h</span><span style='color:#ff5eff;position:relative;left:-10px'>e</span><span style="position:relative;left:-10px">e</span><span style='color:yellow;text-shadow:2px 0px 20px yellow;position:relative;left:-10px'>t</span></h2>
              
          </div><!--inner d-flex-->
          <small class="text-warning font-italic pl-1" style='position:relative;bottom:12px;left:7px'>@PoStCoPy</small>
        </div><!--dflex flex-column-->
        <div class='d-flex mt-2 mr-2'>
          <a href="#"><span class="fas fa-home pr-5" id='tophomemenu' style='font-size:32px;position:relative;top:4.5px'></span></a>
          <?php echo "<a href='postcopyprofile.php?id=$getuserid'><img id='topprofpic' class='rounded-circle' style='width:41px;height:41px;position:relative;right:10px' src='$getuserprofilepic'/></a>"; ?>
        </div><!--d-flex-->
      </div><!--dflex justify content between-->
    </div><!--container-->
  </div><!--jumbotron-->


  <div class="container mt-4 " id="chatonbigscreen">
    <div class="row">
      <div class="col border">
        <div class="d-flex">
          <div style="transform:rotate(30deg)">A</div><div>B</div><div>c</div>
        </div>
        
      </div><!--col-->
      <div class="col border">

        safsafdsa
       
      </div><!--col-->
    </div><!--row-->
  </div><!--container-->

  <div class="container" style="" id="chatonsmallscreen">
   ugiugiugviu
  </div><!--container-->




 </body>
 </html>