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

//removing profile pic
if(isset($_POST['removephoto']))
{
  $target_remove_img="profileImage/img_5eb55d6a8a219png";

  //remove profpic from users profile
  $sqlremove1=$conn->prepare("UPDATE `usersprofile` SET `profilepic`=? WHERE `id`=?");
  $sqlremove1->bind_param("ss",$target_remove_img,$getuserid);
  $sqlremove1->execute();
  $sqlremove1->close();

  //remove profpic from postpicture
  $sqlremove2=$conn->prepare("UPDATE `picturepost` SET `userprofilepic`=? WHERE `useremail`=? AND `userpassword`=?");
  $sqlremove2->bind_param("sss",$target_remove_img,$getuseremail,$getuserpassword);
  $sqlremove2->execute();
  $sqlremove2->close();

  //remove profpic from comment section
  $sqlremove3=$conn->prepare("UPDATE `postcomments` SET `viewedprofilepic`=? WHERE `viewedusermail`=? AND `viewedpassword`=?");
  $sqlremove3->bind_param("sss",$target_remove_img,$getuseremail,$getuserpassword);
  $sqlremove3->execute();
  $sqlremove3->close();

  //remove profpic from like section
  $sqlremove4=$conn->prepare("UPDATE `likepost` SET `viewedprofilepic`=? WHERE `viewedmail`=? AND `viewedpassword`=?");
  $sqlremove4->bind_param("sss",$target_remove_img,$getuseremail,$getuserpassword);
  $sqlremove4->execute();
  $sqlremove4->close();

  header("Refresh:0");


}



//updating profile pic
if(isset($_POST['submitdetail']))
{  
  if(isset($_FILES['profilepic']))
    {
    $target_dir="profileImage/";
    $target_file=basename($_FILES['profilepic']['name']);
    $file_type=strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $target_edit_path=$target_dir.uniqid($prefix="img_").$file_type;
    if(!move_uploaded_file($_FILES['profilepic']['tmp_name'],$target_edit_path))
      {
       $target_edit_path="profileImage/img_5eb55d6a8a219png";
      }
    }
  //remove profpic from users profile
  $sqledit1=$conn->prepare("UPDATE `usersprofile` SET `profilepic`=? WHERE `id`=?");
  $sqledit1->bind_param("ss",$target_edit_path,$getuserid);
  $sqledit1->execute();
  $sqledit1->close();

  //remove profpic from postpicture
  $sqledit2=$conn->prepare("UPDATE `picturepost` SET `userprofilepic`=? WHERE `useremail`=? AND `userpassword`=?");
  $sqledit2->bind_param("sss",$target_edit_path,$getuseremail,$getuserpassword);
  $sqledit2->execute();
  $sqledit2->close();

  //remove profpic from comment section
  $sqledit3=$conn->prepare("UPDATE `postcomments` SET `viewedprofilepic`=? WHERE `viewedusermail`=? AND `viewedpassword`=?");
  $sqledit3->bind_param("sss",$target_edit_path,$getuseremail,$getuserpassword);
  $sqledit3->execute();
  $sqledit3->close();

  //remove profpic from like section
  $sqledit4=$conn->prepare("UPDATE `likepost` SET `viewedprofilepic`=? WHERE `viewedmail`=? AND `viewedpassword`=?");
  $sqledit4->bind_param("sss",$target_edit_path,$getuseremail,$getuserpassword);
  $sqledit4->execute();
  $sqledit4->close();

  header("Refresh:0"); //refresh the page


}

  


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
  <link href="https://fonts.googleapis.com/css2?family=Bad+Script&family=Chelsea+Market&family=Dancing+Script:wght@700&family=Permanent+Marker&family=Piedra&family=Satisfy&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Maven+Pro:wght@900&display=swap" rel="stylesheet">

   <!-- To prevent Confirm Form Resubmission When page reload after submitting a form -->
  	<script>
    	if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    	}
	 </script>
   <style type='text/css'>
   body{
    /*background:linear-gradient(to left,#D3CCE3,#E9E4F0);*/
    background:linear-gradient(to left,#efede6,#EAEAEA,#F2F2F2,#d3d1c2);
   }
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
      font-family:'Modak',cursive;
      font-size:300%;
      text-shadow:2px 3px red,-3px -2px orange;
      color:#efe3ed;
      letter-spacing: 3px;
      height:88px;
    }
    #editbutton:hover
    {
      box-shadow:3px 3px 4px lightgreen;
      transition-duration: 0.4s;
    }
    @media screen and (max-width:324px)
    {
      .userpicture
      {
        width:140px;
        height:130px;
      }
    }
    @media screen and (min-width:325px)and (max-width:375px)
    {
      .userpicture
      {
        width:105px;
        height:100px;
      }
    }
    @media screen and (min-width:376px)and (max-width:399px)
    {
      .userpicture
      {
        width:115px;
        height:100px;
      }
    }

    @media screen and (min-width:400px) and (max-width:576px)
    {
      .userpicture
      {
        width:115px;
        height:100px;
      }
    }
    @media screen and (min-width:577px)
    {
      .userpicture
      {
        width:217px;
        height:150px;
      }
    }
    #tophomemenu:hover
    {
      color:#b75d5d;
    }
    .modal-lg{
      max-width:95%;
    }

    @media screen and (max-width:576px)
    {
      #modalplacement
      {
        position:relative;
        top:10px;
        left:4px;
      }

    }
    
    @media screen and (max-width:325px)
    {
      .modal-lg
      {
        max-width:90%;
      }

    }
    
    #morebutton:hover
    {
      box-shadow:3px 3px 4px pink;
      transition-duration: 0.4s;
    }

   #editphotolist
   {
    display:none;
   }
   #editphoto:hover
   {
    box-shadow:0px 0px 15px 5px lightgreen;
   }
   #removephoto:hover
   {
    box-shadow:0px 0px 12px 3px orange;
   }



   </style>
 </head>
 <body>


    <div class="jumbotron-fluid" id="brandname">
      <div class="container p-2 ml-1" id="brandcontainer">
        <p class="display-4 ">PoStCoPy</p>
      </div><!--conatiner-->
    </div><!--jumobtron-->


    <div class="container mt-4">
      <div class='container ml-2'>
        <div class='d-flex flex-column'>
          <div class='d-flex'>
            <div id='profileimage'>
              <?php echo "<a href='#editprofpic' data-toggle='modal'><img src='".$getuserprofilepic."' class='rounded-circle ' style='width:120px;height:120px;padding:2.7px;box-shadow:0px 0px 45px 5px #aaf9a7' id='profileimage'/></a>" ?><!--#aaf9a7-->
            </div><!--profileimage-->
            <div class='d-flex flex-column flex-grow-1 ml-5'>
              <div id='username'>
                <?php echo "<p class='lead'>$getusername</p>" ?>
              </div><!--username-->
              <div class="btn btn-group" id="buttonresponsive" >
                <button class="btn btn-outline-success" data-target="#editprofilemodal" data-toggle='modal' id='editbutton'><small>Edit Profile</small></button>
                <button class="btn btn-outline-danger ml-1" data-target="#moremodal" data-toggle='modal' id='morebutton'><i class="fas fa-ellipsis-h"></i></small></button>
              </div><!--edit profile-->
            </div><!--d-flex-->
          </div><!--d-flex-->
          <div class='d-flex flex-column'>
            <div id='username' class='mt-2'>
              <?php echo "<small class='text-muted  ml-3' style='position:relative;left:3px'><b>$getusername</b></small>" ?>
            </div><!--username-->
            <div id="caption">
              <?php echo "<p class='ml-3 lead text-muted font-italic' style='position:relative;left:5px;font-size:17px'><small class='text-muted'><b>says:</b> </small>".$getuserbio."</p>" ?>
            </div>
          </div><!--felx-column-->
        </div><!--d flex flex-column-->
      </div><!--container--><hr>
      
      <div class='d-flex justify-content-around ml-4' style='position:relative;top:-17px'>
        <div id="numofpost" class="d-flex flex-column" >
          <?php
            $sqlgetpost=$conn->prepare("SELECT COUNT(*) AS cntpost FROM `picturepost` WHERE `useremail`=? AND `userpassword`=?");
            $sqlgetpost->bind_param("ss",$getuseremail,$getuserpassword);
            $sqlgetpost->execute();
            $sqlgetpost->store_result();
            $sqlgetpost->bind_result($numofpost);
            $sqlgetpost->fetch();
            $sqlgetpost->close();

            echo "<span class='ml-2' style='color:#aa8383;position:relative;top:1.6px'><b>".$numofpost."</b></span>";
          ?>
          <small class='text-muted' style='position:relative;top:-4px'>Posts</small>
        </div><!--num of post-->
        <div class='d-flex flex-column' id='numofuser'>
          <?php
            $sqlnumuser=$conn->prepare("SELECT COUNT(*) AS cntuser FROM `usersprofile` WHERE 1");
            $sqlnumuser->execute();
            $sqlnumuser->store_result();
            $sqlnumuser->bind_result($numofuser);
            $sqlnumuser->fetch();
            $sqlnumuser->close();

            echo "<span class='ml-2' style='color:#aa8383;position:relative;top:1.6px'><b>".$numofuser."</b></span>";
          ?>
          <small class='text-muted ml-1' style='position:relative;top:-4px'>Users</small>
        </div><!--numofuser-->
        <div id="homebutton" class="d-flex flex-column ">
          <a href="postcopy.php?useremail=<?php echo $getuseremail;?>&userpassword=<?php echo $getuserpassword;?>" style='color:#b2a6a6'><span class="fas fa-home pr-5" id='tophomemenu' style='font-size:20px;position:relative;top:5px;left:3px'></span></a>
          <small class='text-muted'>Home</small>
        </div><!--home button-->
      </div><!--d-flex justify-content-between-->

      <hr style='position:relative;top:-30px'>
    </div><!--container-->

    <div class="container"style='position:relative;top:-30px'>
      <div class="d-flex flex-wrap">
        <?php
          include "config.php";
          $sqlgetpostpicture="SELECT * FROM `picturepost` WHERE `useremail`='$getuseremail' AND `userpassword`='$getuserpassword' ORDER BY date DESC,time DESC";
          $userpostresult=mysqli_query($con,$sqlgetpostpicture);
          while($postrow=mysqli_fetch_array($userpostresult))
          {
            echo "<a href='#' class='imglink' id='img_".$postrow['id']."'><img src='".$postrow['picture']."' class='mr-1 mb-1 userpicture' /></a>";

          }
        ?>

      </div><!--d-flex-->
    </div><!--container-->


    <!-- script of when image is clicked-->
    <script>
      $(function(){
        $(".imglink").click(function(e){
          e.preventDefault();
          var img_id=$(this).attr("id");
          var split_img_id=img_id.split("_");
          var post_id=split_img_id[1];
          var user_id='<?php echo $getuserid; ?>';
          var viewerid='<?php echo $getuserid; ?>';
          $.ajax({
            url:"userimage.php",
            type:"post",
            data:{post_id:post_id,user_id:user_id,viewerid:viewerid},
            success:function(data){
    
              $("#modalcontent").html(data);
              
              $("#imagemodal").modal('show');
            }
          });
        });
      });
    </script>
    <!--end of script-->


    <!--IMAGE MODAL-->

    <div class='modal fade' id='imagemodal' >
      <div class="modal-dialog modal-lg" id='modalplacement'>
        <div class='modal-content'>
          <div class='modal-body' id='modalcontent'>
                    
            <!-- IMAGE CONTENT IN userimage.php -->

          </div><!--modal body-->
        </div><!--modal content-->
      </div><!--modal-dialog-->
    </div><!--modal-->
    <!--End of image modal-->

    <!--edit profile-->
    <div class='modal fade' id='editprofilemodal'>
      <div class='modal-dialog'>
        <div class='modal-content'>
          <div class='modal-header bg-info'>
            <h4 class='text-white'>Edit Profile</h4>
            <button class='close' style='background:powderblue;height:68px;width:54px' data-dismiss='modal'><p style='position:relative;right:1.7px;top:4px'>&times;</p></button>
          </div><!--modal-header-->
          <div class='modal-body' >
            <form class="form-group" method="post" enctype="multipart/form-data">
              <div >
                <input type="text" spellcheck="false" class="form-control mb-2" id="edituname" name="editusername" placeholder="Edit Username"/>
                <input type="number" spellcheck="false" class="form-control mb-2" id="editnumber" name="edituserphonenumber" placeholder="Edit Contact Number" />
                <input type="text" spellcheck="false" class="form-control mb-2" id="editaddress" placeholder="Edit Address" name="edituseraddress"/>
                <textarea rows="3" cols="10" id="editbio" class="form-control mb-2" placeholder="BIO..." spellcheck="false" name="edituserbio" id="bio"></textarea>
              </div><!--overflow--><hr>
                <button type="submit" class="btn btn-block btn-success" name="editsubmitdetail" id="editsubmit" value="SUBMIT">Submit</button>
            </form>
          </div><!--modal-body-->
          <div class='modal-footer ' style='background:lightgrey;height:35px'>
            <small class='text-muted font-italic' style='position:relative;bottom:8px'>@PoStCoPy</small>
          </div><!--modal footer-->
        </div><!--modal-content-->
      </div><!--modal dialog-->
    </div><!--modal-->
    <!--end of edit profile-->


    <!--modal for more button-->
    <div class='modal fade' id='moremodal' >
      <div class='modal-dialog' >
        <div class='modal-content'>
          <div class='modal-header bg-info'>
            <h4 class='text-white'>Personal Log</h4>
            <button class='close' style='background:powderblue;height:68px;width:54px' data-dismiss='modal'><p style='position:relative;right:1.7px;top:4px'>&times;</p></button>
          </div><!--modal header-->
          <div class='modal-body '>
            <div class='card'>
              <div class="card-body border-rounded" style="background:aquamarine">
                <div class="card-title">
                  <h4 style="font-family: 'Chelsea Market', cursive;color:#5a167c"><span style="font-size:28px;color:#41ba93">U</span>s<span style="color:blue">e</span>r <span style="color:#fc0c90;font-size:28px">I</span>nf<span style="color:#d1d10a">o</span></h4>
                </div><!--card title-->
                <div class='card-text' style="font-family: calibri">
                  <p><b style='color:#005c6b'>Email : </b><span style="color:#756969"><?php echo $getuseremail;?></span></p>
                  <p><b style='color:#005c6b'>Contact : </b><span style="color:#756969"><?php echo $getusernumber; ?></span></p>
                  <p><b style='color:#005c6b'>Address : </b><span style="color:#756969"><?php echo $getuseraddress; ?></span></p>
                </div><!--card text-->
              </div><!--card body-->
            </div><!--card-->
            <form method="get" action="postcopypersonallog.php" class="from-group">
              <div class="btn btn-group float-right" style="position:relative;right:-10px">
                <input type="text" name="id" value='<?php echo $getuserid?>'hidden/>
                <button type="submit" name='choice' value="cc" class="btn btn-outline-warning rounded">Change Credentials</button>
                <button type="submit" name="choice" value="da" class="ml-4 btn btn-outline-danger rounded">Delete Account</button>
              </div><!--btn btn group-->
            </form>
          </div><!--modal body-->
          <div class='modal-footer ' style='background:lightgrey;height:35px'>
            <small class='text-muted font-italic' style='position:relative;bottom:8px'>@PoStCoPy</small>
          </div><!--modal footer-->
        </div><!--mdoal content-->
      </div><!--modal dialog-->
    </div><!--modal-->
    <!--end of modal for more button-->

    <!--choosing of profile pic-->
    
      <script>
              $(function(){
                $(".custom-file-input").change(function(){
                  var filename=$(this).val().split("\\").pop();
                  $(this).siblings(".custom-file-label").html(filename);
                });
              });
      </script>


  <!-- script for responsive button-->
  <script>
    
    $(window).resize(function(){

        var width=$(window).width();
        if(width<497)
        {
          $("#responsivebutton").removeClass("btn btn-group");
          $("#responsivebutton").addClass("btn btn-group-sm");
          $("#responsivebutton").css({"position":"relative","left":"-20px"})

        }
        else if(width>=497 && width<=983)
        {
          $("#responsivebutton").addClass("btn btn-group");
          $("#responsivebutton").removeClass("btn btn-group-sm");
        } 
        else if(width>983)
        {
          $("#responsivebutton").removeClass("btn btn-group");
          $("#responsivebutton").removeClass("btn btn-group-sm");
          $("#morebutton,#editbutton").css("width","22%");
        }
      
      });
    
  </script>
  <!--end of script for responsive button-->


  <!--script for button for excessive small screen-->
  <script>
    $(document).ready(function(){
      var width=$(window).width();
      if(width<=325)
      {
        $("#buttonresponsive").removeClass("btn btn-group");
        $("#buttonresponsive").addClass("btn btn-group-vertical");
        $("#morebutton").css({"position":"relative","left":"-3.5px","margin-top":"3px"});
         $("#buttonresponsive").css({"position":"relative","top":"-15px","left":"-10px"});
      }
    }); 
  </script>

  <!--script for edit submit -->
  <script>
    $(function(){
      $("#editsubmit").click(function(e){
        e.preventDefault();
        var id="<?php echo $getuserid; ?>";
        if($("#edituname").val()!="")
        {
          var username=$("#edituname").val();
        }
        else
        {
          var username="<?php echo $getusername; ?>";
        }

        if($("#editnumber").val()!="")
        {
          var usernumber=$("#editnumber").val();
        }
        else
        {
          var usernumber="<?php echo $getusernumber; ?>";
        }


        if($("#editaddress").val()!="")
        {
          var useraddress=$("#editaddress").val();
        }
        else
        {
          var useraddress="<?php echo $getuseraddress; ?>";
        }


        if($("#editbio").val()!="")
        {
          var userbio=$("#editbio").val();
        }
        else
        {
          var userbio="<?php echo $getuserbio; ?>";
        }

        var useremail="<?php echo $getuseremail;?>";
        var userpassword="<?php echo $getuserpassword;?>";
        $.ajax({
          url:'postcopyprofilelog.php',
          type:'post',
          data:{id:id,username:username,usernumber:usernumber,useraddress:useraddress,userbio:userbio,useremail:useremail,userpassword:userpassword},
          success:function(data){
            location.reload();
          }
        });
      });
    });
  </script>
  <!--end of script-->

  <div class="modal fade" id="editprofpic">
    <div class="modal-dialog" style="margin-top:110px">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h4 class='text-white'>Edit Profile Pic</h4>
            <button class='close' style='background:powderblue;height:68px;width:54px' data-dismiss='modal'><p style='position:relative;right:1.7px;top:4px'>&times;</p></button>
        </div><!--modalheader-->
        <div class="modal-body">

          <div class="btn btn-group btn-block ">

            <button type="button" id="editphoto" class="btn" style="background:linear-gradient(to right,#00b09b,#96c93d);color:white;border:none">Edit Photo</button>
            <form method="post">
            <button type="submit" name="removephoto" id="removephoto" class="btn btn-primary ml-1" style="background:linear-gradient(to right,#fc4a1a,#f7b733);color:white;border:none">Remove Photo</button>
            </form>
            
          </div><!--btn btn-group-->

          <div class="container border rounded mt-2" id="editphotolist">
            <form class="form-group" method="post" enctype="multipart/form-data">
              <div class= "custom-file mb-2 mt-4">
                <input type="file" class="custom-file-input " id="customFile"
                name="profilepic" value="http://localhost/myProject/IMAGES" >
                <label class="custom-file-label" for="customFile" style="color:grey">New Pic</label>
                  <button type="submit" class="btn btn-outline-success mt-3 mb-4" style="margin-left:40%;width:60%" name="submitdetail">Change</button>
              </div><!--custom-file-->
            </form>
          </div><!--container-->
        </div><!--modal body-->
        <div class='modal-footer ' style='background:lightgrey;height:35px'>
            <small class='text-muted font-italic' style='position:relative;bottom:8px'>@PoStCoPy</small>
        </div><!--modal footer-->
      </div><!--modal content-->
    </div><!--mdoal dialog-->
  </div><!--modal-->

  <!--script for show edit photo -->
  <script>
    $(function(){
      $("#editphoto").click(function(){
        $("#editphotolist").show();
      });
    });
  </script>


 </body>
 </html>