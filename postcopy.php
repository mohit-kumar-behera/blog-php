<?php
	date_default_timezone_set("Asia/Kolkata");
	$date=date("d/m/y");
	$revdate=date("Y-m-d");
	$time=date("H:i:s");
	session_start();
	$_SESSION['email']=$_GET['useremail'];
	$_SESSION['pwd']=$_GET['userpassword'];
	include "postcopysqlconfig.php";


	
	/*Get every information from the user logged in*/
	$sqlgetuser=$conn->prepare("SELECT * FROM usersprofile WHERE email=? AND password=?");
	$sqlgetuser->bind_param("ss",$_SESSION['email'],$_SESSION['pwd']);
	$sqlgetuser->execute();
	$sqlgetuser->store_result();
	$sqlgetuser->bind_result($getuserid,$getusername,$getuseremail,$getuserpassword,$getusernumber,$getuseraddress,$getuserbio,$getuserprofilepic);
	$sqlgetuser->fetch();
	$sqlgetuser->close();

	/*get username and profile pic of every user using postcopy*/
	$sqlcontact="SELECT id,username,profilepic FROM usersprofile";
	$resultcontact=$conn->query($sqlcontact);

	/*get username and profile pic of every user*/
	$sqlc="SELECT id,username,profilepic FROM usersprofile";
	$resultc=$conn->query($sqlc); 
	



 	/* if caption for the post is set or not */
 	if(isset($_POST['postsubmit']))
 	{
		if(isset($_POST['postCaption']))
		{
			$caption=$_POST['postCaption'];
		}else{$caption="";}
	}
	/*moving the posted image from directory to database of logged in user*/
	$caption="";
	if(isset($_POST['postsubmit']))
	{
		/*picture posting to the file */
		if(isset($_FILES['postpictures']))
		{
		$id=uniqid();	
		$target_dir="postImage/";
		$target_file=basename($_FILES['postpictures']['name']);
		$file_type=strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$target_post_img=$target_dir.uniqid($prefix="img_").$file_type;
		if(!move_uploaded_file($_FILES['postpictures']['tmp_name'],$target_post_img))
 	    {
 		   $target_post_img="";
 	    }
 		}
 		/*end of picture posting to the file */
 		
 		/*setting of caption*/
		if(isset($_POST['postCaption']))
		{
			$caption=$_POST['postCaption'];
		}else{$caption="";}
		/*end of setting of caption*/

		/*insert picture and caption into DATABASE */
		$sqlpostinsert=$conn->prepare("INSERT INTO `picturepost` (`id`,`username`,`useremail`,`userpassword`,`caption`,`time`,`date`,`picture`,`userprofilepic`,`userid`) VALUES(?,?,?,?,?,?,?,?,?,?)");
		$sqlpostinsert->bind_param("ssssssssss",$id,$getusername,$getuseremail,$getuserpassword,$caption,$time,$revdate,$target_post_img,$getuserprofilepic,$getuserid);
		$sqlpostinsert->execute();
		$sqlpostinsert->close();



		/*$sqlinsertliketable=$conn->prepare("INSERT INTO `likepost` (`photoid`) VALUES (?)");
		$sqlinsertliketable->bind_param("s",$id);
		$sqlinsertliketable->execute();
		$sqlinsertliketable->close();*/


	}

	

	/*$orgdate=$postrow['time'];
	$newdate=date("H:i a",strtotime($orgdate));
	echo $newdate;*/


	/*if(isset($_POST['submitlike']))
	{

		$sqlinsertlike=$conn->prepare("INSERT INTO `photolike` (`postedname`,`postedmail`,`postedpassword`,`postedprofilepic`,`postedphoto`,`viewname`,`viewmail`,`viewpassword`,`viewprofilepic`,`likephoto`) VALUES (?,?,?,?,?,?,?,?,?,?)");
		$sqlinsertlike->bind_param("ssssssssis",$postrow['username'],$postrow['useremail'],$postrow['userpassword'],$postrow['userprofilepic'],$postrow['picture'],$getusername,$getuseremail,$getuserpassword,$getuserprofilepic,$like);
		$sqlinsert->execute();
		$sqlinsert->close();


		$sqlupdatelike=$conn->prepare("UPDATE `photolike` SET likephoto='0' WHERE postedusdre90ufhir ")


	}*/
	


?>

<!DOCTYPE html>
<html>
<title>Postcopy HomePage</title>
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

   <!-- To prevent Confirm Form Resubmission When page reload after submitting a form -->
  	<script>
    	if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    	}
	</script>

	<style type="text/css">

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
		
		
		@media screen and (max-width:768px)
		{
			#searchlist
			{
				display:none;
			}
		}
		@media screen and (min-width:768px)
		{
			#colforsearchlist
			{
				border-left:0.4px solid lightgrey;
				box-shadow: -2px 0 2.5px  lightgrey;

			}
		}
		@media screen and (min-width:768px)
		{
			#leftcontent
			{
				position:relative;
				left:-30px;
			}
			#captiononbigscreen
			{
				margin-left:42px;
			}
		}
		@media screen and (max-width:767px)
		{
			#captiononbigscreen
			{
				margin-left:7px;
			}	
		}


		/* for responsive post images */
		@media screen and (max-width:576px)
		{
			#postimageresponsive
			{
				height:auto;
			}
		}
		@media screen and (min-width:577px) and (max-width:617px)
		{
			#postimageresponsive
			{
				height:260px;
			}
		}
		@media screen and (min-width:618px) and (max-width:762px)
		{
			#postimageresponsive
			{
				height:340px;
			}
		}
		@media screen and (min-width:763px)
		{
			#postimageresponsive
			{
				height:360px;
			}
		}
		/* end of responsive post images */

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


		#searchuserlink
		{
			font-family:calibri;
		}
		#searchuserlink:hover
		{
			text-decoration: none;
		}
		#postedpicusername:hover
		{
			text-decoration: none
		}
		#topnavbartogglerbutton:focus
		{
			outline:none;
		}
		button:focus{outline:none;}
		#likebutton
		{
			border-bottom:3px solid transparent;
			border-top:none;
			border-left:none;
			border-right:none;
			border-radius:8px;
		}
		#likebutton:hover
		{
			border-radius:8px;
			border-bottom:3px solid green;
		}
		.commbutton
		{
			border-bottom:3px solid transparent;
			border-top:none;
			border-left:none;
			border-right:none;
			border-radius:8px;
		}
		.commbutton:hover
		{
			border-radius:8px;
			border-bottom:3px solid #1daa1d;
			transition-duration: 0.4s;

		}
		#numberofcomment
		{
			border-bottom:0.4px solid lightgrey;
		}

		#navbaritem
		{
			color:#936846;

		}
		#navbaritem:hover
		{
			
			color:#a34f13;
			
		}

		@keyframes likeanimation{
			0%{
				border-bottom:0.4px solid lightgreen;
				border-left:0.4px solid transparent;
				border-right:0.4px solid transparent;
				border-top:0.4px solid transparent;
				box-shadow:0px 1px 4px lightgreen;

			}
			33%{
				border-right:0.4px solid lightblue;
				border-left:0.4px solid transparent;
				border-bottom:0.4px solid transparent;
				border-top:0.4px solid transparent;
				box-shadow:1px 0px 4px lightblue;
			}
			66%{
				border-top:0.4px solid powderblue;
				border-left:0.4px solid transparent;
				border-right:0.4px solid transparent;
				border-bottom:0.4px solid transparent;
				box-shadow:0px -1px 4px powderblue;
			}
		99%{
				border-left:0.4px solid yellow;
				border-bottom:0.4px solid transparent;
				border-right:0.4px solid transparent;
				border-top:0.4px solid transparent;
				box-shadow:-1px 0px 3px #87e8ed;

			}
		}



		.like
		{
			border-bottom:0.4px solid transparent;
			border-right:0.4px solid transparent;
			border-top:0.4px solid transparent;
			border-left:0.4px solid transparent;
		}
	
		.like:hover
		{
			animation-name:likeanimation;
			animation-duration:0.5s;
			animation-iteration-count: 1;
			animation-timing-function:ease-in-out; 
		}

		.unlike
		{
			border-bottom:0.4px solid transparent;
			border-right:0.4px solid transparent;
			border-top:0.4px solid transparent;
			border-left:0.4px solid transparent;
		}
	
		.unlike:hover
		{
			animation-name:likeanimation;
			animation-duration:0.5s;
			animation-timing-function:linear; 
			animation-timing-function:ease-in-out;
			
		}
		.fa 
		{
			font-size:23px;
		}

		

		.showlikeuser:hover
		{
			text-shadow:0px 2px 5px pink,0px -2px 5px pink,2px 0px 5px pink,-2px 0px 5px pink;
			transition-duration: 0.4s;
		}

	</style>

</head>
<body>
	<div class="jumbotron-fluid" id="brandname">
		<div class="container p-2 ml-1" id="brandcontainer">
			<p class="display-4 ">PoStCoPy</p>
		</div><!--conatiner-->
	</div><!--jumobtron-->
	
	<nav class="navbar navbar-expand-md navbar-dark sticky-top" style="background:#ffcc00" id="topnavbar">
		<a class="navbar-brand" href="#"><img src="https://cdn5.vectorstock.com/i/1000x1000/73/89/initial-letter-pc-logo-template-design-vector-22777389.jpg" class="rounded-circle ml-3" style="width:45px;height:45px"/></a>
		<a class="navbar-brand text-capitalize" id="navusername" style="padding-right:75px;color:#4e0582;font-family: 'Galada', cursive;font-size:25px"><?php echo $getusername ?></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar" id="topnavbartogglerbutton" style="background:linear-gradient(to bottom,#FF8008,#FFC837);border:none">
			<span class="fa fa-bars" style="color:#bf2a2a"><span class="material-icons"></span></span></button>
		<div class="collapse navbar-collapse" id="collapsibleNavbar">
		<ul class="navbar-nav ml-4">

			<li class="nav-item pr-3"><a href="#" onClick="location.reload()" class="nav-link font-weight-bold " style="font-size:17.8px" id='navbaritem' >Home</a></li>

			<li class="nav-item pr-3"><a href="postcopyprofile.php?id=<?php echo $getuserid; ?>" class="nav-link font-weight-bold " style="font-size:17.8px" id='navbaritem'>Profile</a></li>

			<li class="nav-item pr-3"><a href="postcopychat.php?id=<?php echo $getuserid; ?> "class="nav-link font-weight-bold " style="font-size:17.8px" id='navbaritem' >Chat</a></li>
			
			<li class="nav-item pr-3" id="searchforsmallscreen"><a href="#searchusermodal" data-toggle="modal" class="nav-link font-weight-bold"
			 style="font-size:17.8px;" id='navbaritem'>Search</a></li>

			<li class="nav-item"><a href="#logoutmodal" data-toggle="modal"class="nav-link font-weight-bold" id='navbaritem' style="font-size:17.8px;">Logout</a></li>

		</ul> 
	    </div><!--collapse navbarcollapse-->
	</nav>	
	<script>
		$(function(){
			$("#logout").click(function(){
				session_destroy();
			});
		});
	</script>

			<!--modal-->
			<div class="modal fade" id="logoutmodal">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">LOG OUT</h4>
							<button class="close" data-dismiss="modal">&times;</button>
						</div><!--modal header-->
							<div class="modal-body">
								<p class="lead">Are you sure you want to Logout ?</p>
								<button class="btn btn-danger mr-3" data-dismiss="modal" style="margin-left:30%">Close</button>
								<button class="btn btn-success"><a href="postcopylogin.php" id="logout" style="color:white;">Log Out</a></button> 
							</div><!--modal body-->
					</div><!--modal-content-->
				</div><!--modal dialog-->
			</div><!--modal-->

			<div class="modal fade" id="searchusermodal">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Search People</h4>
							<button class="close" data-dismiss="modal">&times;</button>
						</div><!--modal header-->
							<div class="modal-body">
								<form class="form-group pt-3 pb-3" >
									<input type="text" class="form-control " placeholder="Search People" id="navsearchcontact">
								</form><!--form-->

								<div id="navcontact" style="overflow:scroll;height:280px">
									<?php
										if($resultc->num_rows>0)
										{
											while($rowc=$resultc->fetch_assoc())
											{
												echo "<div class='media mb-3 mr-3' ><a href='postcopyviewprofile.php?id=".$rowc['id']."&userid=".$getuserid."'><img src='".$rowc['profilepic']."'style='width:38px;height:38px' class='rounded'/></a><div class='media-body mr-4><h5 class='text-capitalize ' style='font-size:22px;font-family:calibri;margin-left:25px'><a href='postcopyviewprofile.php?id=".$rowc['id']."&userid=".$getuserid."' style='font-size:22px;color:black' id='searchuserlink'>".$rowc['username']."</a></h5></div></div>";
											}
										}
									?>	
								</div><!--contact-->
							</div><!--modal body-->
							<div class="modal-footer">
								<button class="btn btn-danger mr-3" data-dismiss="modal" style="margin-left:30%">Close</button> 
							</div><!--mdoal footer-->					
					</div><!--modal-content-->
				</div><!--modal dialog-->
			</div><!--modal-->
			<script>
					$(function(){
						$("#navsearchcontact").on("keyup",function(){
							var name=$(this).val().toLowerCase();
							$("#navcontact *").filter(function(){
								$(this).toggle($(this).text().toLowerCase().indexOf(name)>-1);
							});
						});
					});
			</script>
			<!--modal ends-->

	<!--main content-->
	<div class="container mt-3">
		<div class="row">
			<div class="col-md-8">
				<div class="container border rounded shadow " id="leftcontent" >
					<div class="media mt-2 mb-3 ">
						<div class="media-body">
								<div class="d-flex">
									<?php
										echo "<img src='$getuserprofilepic' style='width:48px;height:48px' class='rounded-circle'/>";

										echo "<h5 class='text-capitalize ml-4'><a href='postcopyprofile.php?id=$getuserid' style='color:#4E0582'>$getusername</a></h5>";
										echo "<small class='font-italic text-muted float-right ml-3'>@PoStCoPy</small>";
										echo "<br>";
									?>
								</div><!--d flex-->

								<div id="postingoption">
								    <?php
										echo "<blockquote class='font-italic ml-5' style='overflow:hidden;width:300px'>".'" '."$getuserbio".' "'."</blockquote>";
									?>
									<button class="btn btn-info " data-toggle="modal" data-target="#postimagemodal" style="width:85%">Post Images</button>
									
								</div><!--postingoption-->

						</div><!--media body-->
					</div><!--media-->
				</div><!--container-->
				<div class="modal fade" id="postimagemodal">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header bg-info">
								<h4 class="lead text-light">POST IMAGES</h4>
								<button class="close bg-light text-dark" style="height:68px" data-dismiss="modal">&times;</button>
							</div><!--modal header-->
							<div class="modal-body">

								<form class="form-group" method="post" enctype="multipart/form-data">
									<img src="" id="postedimage"/>
									<div class="custom-file mb-2">
									<input type="file" class="custom-file-input" id="postpic" name="postpictures" value="http://localhost/myProject/IMAGES">
                                    <label class="custom-file-label" for="customFile">Attach Image to Post</label>
                                    </div><!--custom-file-->
                                    <textarea class="form-control mb-2" placeholder="Write Caption" name="postCaption" spellcheck="false"></textarea><hr>
									<input type="submit" class="form-control mb-2 font-weight-bolder btn-outline-success" name="postsubmit" id="postsubmit" value="POST"/>
								</form>

						    </div><!--modal body-->
							<div class="modal-footer " style="background:lightgrey">
								<small class="text-muted font-italic float-right">@PoStCoPy</small>
							</div><!--modal footer-->
					</div><!--modal content-->
				</div><!--modal dialog-->
			</div><!--modal -->

			<!-- DISPLAY PHOTO POSTED BY ALL USERS -->
			
			<div class="container border rounded shadow mt-4 mb-4" id="leftcontent">
				<?php
					include "config.php";
					$sqlgetphotoposted="SELECT * FROM `picturepost` ORDER BY date DESC,time DESC"; 
					$postresult=mysqli_query($con,$sqlgetphotoposted);
					
						while($postrow=mysqli_fetch_array($postresult))
						{
							
							$databasetime=$postrow['time'];
							$databasedate=$postrow['date'];
							$showposttime=date("H:i ",strtotime($databasetime));
							$showpostdate=date("d-m-Y ",strtotime($databasedate));
							$id=$postrow['id'];

							echo "<div class='media'><div class='media-body'><div class='d-flex pt-3 pb-2 pl-1'><img src='".$postrow['userprofilepic']."' class='rounded-circle' style='width:42px;height:42px' /><div class='d-flex flex-column'><div class='d-flex'><h5 style='color:#4E0582;margin-left:10px'><a href='postcopyviewprofile.php?id=".$postrow['userid']."&userid=".$getuserid."' id='postedpicusername'>".$postrow['username']."</a></h5><small class='text-muted ml-3'>Posted a Photo</small><small class='text-muted font-italic ml-2'>@PoStCoPy</small></div><small class='text-muted ml-2' style='position:relative;top:-6px'>".$showposttime."<b>&nbsp on </b>".$showpostdate."</small></div></div><div id='showpostedphoto' class='d-flex flex-column mb-2'><img src='".$postrow['picture']."' class='rounded' id='postimageresponsive' style='width:88%;margin-left:5%;margin-bottom:10px'/><p id='captiononbigscreen' style='font-size:15px'>";

								if($postrow['caption']!='')
								{
									echo "<b>".$postrow['username']."</b>&nbsp<b>:</b>&nbsp".$postrow['caption'];
								}

							
							echo "</p></div><div id='commentNlikesection'><div class='d-flex justify-content-between' id='numberofcomment'><div class='d-flex' >

							<button style='position:relative;top:-17.5px;left:15px;background:transparent;outline:none;border:none' class='showlikeuser' id='".$postrow['userid']."' data-id='".$id."' ><span class='fa fa-heart' style='font-size:20px;color:#f21a66;position:relative'></span></button>

							<div id='countlikes' style='position:relative;top:-19px;left:16px'>
							<span style='font-size:13px;color:grey' id='cntlike_".$id."'>";

							include 'postcopysqlconfig.php';

							$sqllikeexist=$conn->prepare("SELECT COUNT(*) AS likecnt FROM `likepost` WHERE `photoid`=?");
							$sqllikeexist->bind_param("s",$id);
							$sqllikeexist->execute();
							$sqllikeexist->store_result();
							$sqllikeexist->bind_result($likeexist);
							$sqllikeexist->fetch();

							if($likeexist==0)
							{
								echo '0 Like';
							}
							else if($likeexist>0)
							{
								$sqllikecount=$conn->prepare("SELECT COUNT(*) AS likecnt FROM `likepost` WHERE `photoid`=? AND `type`=1");
								$sqllikecount->bind_param("s",$id);
								$sqllikecount->execute();
								$sqllikecount->store_result();
								$sqllikecount->bind_result($likecount);
								$sqllikecount->fetch();

								if($likecount==1)
								{
									echo $likecount.' Like';
								}
								else if($likecount>1)
								{
									echo $likecount.' Likes';
								}
							}


							echo "</span></div> 							</div><div class='d-flex'><span class='far fa-comments' style='font-size:20px;color:#8b8bbc;position:relative;top:-14px;'></span><span class='pl-2' id='cntcmnt_".$id."' style='font-size:13px;color:grey;position:relative;top:-14px;'>";

							/*to count the number of comments*/

							$comcountquery="SELECT COUNT(id) FROM `postcomments` WHERE id='".$id."'";
							$comcountresult=mysqli_query($con,$comcountquery);
							$comcountrow=mysqli_fetch_array($comcountresult);
							echo $comcountrow['COUNT(id)'];


						echo " Comments</span></div></div><div id='likeCommentBox' class='mb-2' style='position:relative;top:5px'><div class='d-flex justify-content-around'><div class='d-flex' style='position:relative;left:-28px'>
						
						<button type='button' style='background:transparent;width:50px;outline:none' class='like' id='like_".$id."'>

						<span id='likeicon_".$id."' class='";

						include 'postcopysqlconfig.php';

						$sqluserexist=$conn->prepare("SELECT COUNT(*) AS cnt FROM `likepost` WHERE `photoid`=? AND `viewedmail`=? AND `viewedpassword`=?");
						$sqluserexist->bind_param("sss",$id,$getuseremail,$getuserpassword);
						$sqluserexist->execute();
						$sqluserexist->store_result();
						$sqluserexist->bind_result($countuser);
						$sqluserexist->fetch();
						$sqluserexist->close();

						if($countuser==1) // is he is already a liker
						{	
							$querylike=$conn->prepare("SELECT `type` FROM `likepost` WHERE `photoid`=? AND `viewedmail`=? AND `viewedpassword`=?");
							$querylike->bind_param("sss",$id,$getuseremail,$getuserpassword);
							$querylike->execute();
							$querylike->store_result();
							$querylike->bind_result($types);
							$querylike->fetch();

							if($types==1){echo 'fa fa-thumbs-up';}
							else if($types==0){echo 'fa fa-thumbs-o-up';}
						}
						else if($countuser==0) // is he is not a liker
						{
							echo 'fa fa-thumbs-o-up';
						}

						echo "' style='";

						$sqluserexist=$conn->prepare("SELECT COUNT(*) AS cnt FROM `likepost` WHERE `photoid`=? AND `viewedmail`=? AND `viewedpassword`=?");
						$sqluserexist->bind_param("sss",$id,$getuseremail,$getuserpassword);
						$sqluserexist->execute();
						$sqluserexist->store_result();
						$sqluserexist->bind_result($countuser);
						$sqluserexist->fetch();
						$sqluserexist->close();

						if($countuser==1) //if user is already a liker
						{
							$querylike=$conn->prepare("SELECT `type` FROM `likepost` WHERE `photoid`=? AND `viewedmail`=? AND `viewedpassword`=?");
							$querylike->bind_param("sss",$id,$getuseremail,$getuserpassword);
							$querylike->execute();
							$querylike->store_result();
							$querylike->bind_result($types);
							$querylike->fetch();


							if($types==1){echo 'color:#7012ce';}
							else if($types==0){echo 'color:green';}
						}
						else if($countuser==0)// if he is not a liker
						{
							echo 'color:green';
						}

						echo "'></span></button>
		
						<button type='button' class='unlike' style='background:transparent;width:50px;margin-left:10px;outline:none'  id='unlike_".$id."'><span id='unlikeicon_".$id."' class='";

						$sqluserexist=$conn->prepare("SELECT COUNT(*) AS cnt FROM `likepost` WHERE `photoid`=? AND `viewedmail`=? AND `viewedpassword`=?");
						$sqluserexist->bind_param("sss",$id,$getuseremail,$getuserpassword);
						$sqluserexist->execute();
						$sqluserexist->store_result();
						$sqluserexist->bind_result($countuser);
						$sqluserexist->fetch();
						$sqluserexist->close();

						if($countuser==1)//if he is an old disliker
						{
							$querylike=$conn->prepare("SELECT `type` FROM `likepost` WHERE `photoid`=? AND `viewedmail`=? AND `viewedpassword`=?");
							$querylike->bind_param("sss",$id,$getuseremail,$getuserpassword);
							$querylike->execute();
							$querylike->store_result();
							$querylike->bind_result($types);
							$querylike->fetch();
							if($types==1){echo 'fa fa-thumbs-o-down';}
							else if($types==0){echo 'fa fa-thumbs-down';}
						}
						else if($countuser==0)//if he hasnt diskiled anything
						{
							echo 'fa fa-thumbs-o-down';
						}

						echo "' style='transform:rotateY(-180deg);";

						$sqluserexist=$conn->prepare("SELECT COUNT(*) AS cnt FROM `likepost` WHERE `photoid`=? AND `viewedmail`=? AND `viewedpassword`=?");
						$sqluserexist->bind_param("sss",$id,$getuseremail,$getuserpassword);
						$sqluserexist->execute();
						$sqluserexist->store_result();
						$sqluserexist->bind_result($countuser);
						$sqluserexist->fetch();
						$sqluserexist->close();

						if($countuser==1)
						{
							$querylike=$conn->prepare("SELECT `type` FROM `likepost` WHERE `photoid`=? AND `viewedmail`=? AND `viewedpassword`=?");
							$querylike->bind_param("sss",$id,$getuseremail,$getuserpassword);
							$querylike->execute();
							$querylike->store_result();
							$querylike->bind_result($types);
							$querylike->fetch();

							if($types==1){echo 'color:red';}
							else if($types==0){echo 'color:powderblue';}
						}
						else if($countuser==0)
						{
							echo 'color:red';
						}


						echo "'></span></button>

						</div><div class='d-flex'><button type='button' style='background:transparent' data-id='".$id."' class='commbutton'><span class='fas fa-comment-dots' style='font-size:23px;color:#17d885' ></span><span class='text-muted ml-2' style='position:relative;top:-3px'>Comments</span></button></div></div></div></div></div></div><hr style='background:transparent;box-shadow:1px 2px 4.5px powderblue,-1px 0px 5px grey'>";
						}
						
					

		

				?>
			</div><!--container-->

			<!-- SCRIPT FOR LIKE BUTTON -->

			<script>
				$(document).ready(function(){

				
					$(".like,.unlike").click(function(){

						var id=$(this).attr('id');
						var split_id=id.split("_");
						var text=split_id[0];
						var post_id=split_id[1];
						var vusername="<?php echo $getusername; ?>";
						var vuseremail="<?php echo $getuseremail; ?>";
						var vuserpwd="<?php echo $getuserpassword; ?>";
						var vuserprofpic="<?php echo $getuserprofilepic; ?>";
						var ltype=0;
						if(text=="like")
							{ltype=1;}
						else{ltype=0;}
						
						$.ajax({
							url: 'likeinsert.php',
							type: 'post',
							data: {post_id:post_id,ltype:ltype,vusername:vusername,vuseremail:vuseremail,vuserpwd:vuserpwd,vuserprofpic:vuserprofpic},
							dataType: 'json',
							success: function(data){
								var likes=data['likes'];
								$("#cntlike_"+post_id).text(likes+" Likes");
								if(ltype==1)
								{
									$("#likeicon_"+post_id).addClass('fa fa-thumbs-up');
									$("#unlikeicon_"+post_id).removeClass('fa fa-thumbs-down');
									$("#unlikeicon_"+post_id).addClass('fa fa-thumbs-o-down');
									$("#likeicon_"+post_id).css("color","#7012ce");
									$("#unlikeicon_"+post_id).css("color","red");

								}
								if(ltype==0)
								{
									$("#likeicon_"+post_id).removeClass('fa fa-thumbs-up');
									$("#likeicon_"+post_id).addClass('fa fa-thumbs-o-up');
									$("#unlikeicon_"+post_id).addClass('fa fa-thumbs-down');
									$("#likeicon_"+post_id).css("color","green");
									$("#unlikeicon_"+post_id).css("color","powderblue");

								}
							}
						});
					});
				});
			</script>

			<!-- END OF SCRIPT FOR LIKE BUTTON -->


			<!--SCRIPT FOR SEEING THE NAME OF PERSON WHO  LIKED -->

			<script>
				$(function(){
					$('.showlikeuser').click(function(){
						var postid = $(this).data('id');
						var viewerid='<?php echo $getuserid; ?>';
						var postuserid=$(this).attr('id');
								// AJAX request
   								$.ajax({
    								url: 'showlike.php',
    								type: 'post',
    								data: {postid: postid,viewerid:viewerid,postuserid:postuserid},

    								success: function(data){ 
      									// Add response in Modal body
      									$('#likelist').html(data);
										// Display Modal
     					 				$('#likemodal').modal('show'); 
     					 				//giving the id to the comment box
     					 			

    								}
  								});

					});
					
				});
			</script>

			<!--END OF SCRIPT FOR SEEING THE NAME OF PERSON WHO  LIKED -->


			<!-- SCRIPT FOR CALLING MODAL BOX -->
					<script>
						
						$(document).ready(function(){
							$('.commbutton').click(function(){
   								var postid = $(this).data('id');
   								var viewerid='<?php echo $getuserid; ?>';
								// AJAX request
   								$.ajax({
    								url: 'ajaxcommentmodalfile.php',
    								type: 'post',
    								data: {userid: postid,viewerid:viewerid},
    								success: function(data){ 
      									// Add response in Modal body
      									$('#commentsection').html(data);
										// Display Modal
     					 				$('#commentmodal').modal('show'); 
     					 				//giving the id to the comment box
     					 				$('#picidforcomment').val(postid);
     					 				//to empty the textarea of comments
     					 				$("#comments").val("");

    								}
  								});
 							});
						});

					</script>
			<!-- end of calling modal box -->


		</div><!--col-md-8-->

			<!--script for browse picture detail-->
			   <script>
				    $(function(){
						$(".custom-file-input").change(function(){
							var filename=$(this).val().split("\\").pop();
							$(this).siblings(".custom-file-label").html(filename);
						});
				    });	

				</script>

			<div class="col-md-4 mb-3" id="colforsearchlist"><!--hidden on less than medium screen-->
				<div id="searchlist" >
					<form class="form-group pt-3 pb-3" >
						<input type="text" class="form-control " placeholder="Search People" id="searchcontact">
					</form><!--form-->
					<div id="contact" class="border-top border-bottom pt-3 pl-2 pr-2 shadow-lg mb-3" style="overflow:scroll;height:540px">
						
					<?php

						if($resultcontact->num_rows>0)
						{
							while($rowcontact=$resultcontact->fetch_assoc())
							{
								echo "<div class='media mb-3 mr-3' ><a href='postcopyviewprofile.php?id=".$rowcontact['id']."&userid=".$getuserid."'><img src='".$rowcontact['profilepic']."'style='width:38px;height:38px' class='rounded'/></a><div class='media-body mr-4><h5 class='text-capitalize ' style='font-size:22px;font-family:calibri;margin-left:25px'><a href='postcopyviewprofile.php?id=".$rowcontact['id']."&userid=".$getuserid."' style='font-size:22px;color:black' id='searchuserlink'>".$rowcontact['username']."</a></h5></div></div>";
							}
						}

					?>
					</div><!--contact-->

				</div><!--searchlist-->
				<script>
					$(function(){
						$("#searchcontact").on("keyup",function(){
							var name=$(this).val().toLowerCase();
							$("#contact *").filter(function(){
								$(this).toggle($(this).text().toLowerCase().indexOf(name)>-1);
							});
						});
					});
				</script>
			</div><!--col-md-4-->
		</div><!--row-->
	</div><!--container-->	
	<!-- modal box of comment box-->


					<!-- comment modal -->
					<div class="modal fade mt-3" id="commentmodal">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header text-light bg-info">
									<h4>Comments</h4>
								<button class="close bg-light text-dark" style="width:55px;height:68px" data-dismiss="modal">&times;</button>	
								</div><!--modal header-->
								<div class="modal-body">

									<div class="border p-2 mb-3" id="commentsection" style="overflow:scroll;height:360px">

										<!--comment chat-->
										
										<!--code in ajaxcommentmodalfile.php-->

										<!-- end of comment chat -->

									</div><!--comment section-->

								</div><!--modal-body-->
								<div class="modal-foot p-1 " style="background:transparent;border-top:0.1px solid lightgrey">
									
									<form class="form-group mt-2" id="commentform" method="post" enctype="multipart/form-data">
										<div class="input-group">
											<input type="text" id="mail" name="useremail" value="<?php echo $getuseremail; ?>" hidden/>
											<input type="text" id="name" name="username" value="<?php echo $getusername;?>" hidden/>
											<input type="text" id="password" name="userpassword" value="<?php echo $getuserpassword;?>" hidden />
											<input type="text" id="userprofpic" name="userprofilepic" value="<?php echo $getuserprofilepic;?>" hidden />
											<input type="text" id="picidforcomment" name="postedpicid" value="" hidden/>
											<textarea class="form-control" placeholder="Write Your Comment" id="comments" spellcheck="false" name="commenttext"></textarea>
											<button type="submit" class="btn btn-success"  name="submitcomment" id="commentsubmit">Comment</button>
										</div>
									</form>

								</div><!--modal-footer-->
							</div><!--modal content-->
						</div><!--modal dialog-->
					</div><!--modal-->
					<!-- end of comment box -->


					<!--SCRIPT FOR SUBMITTING COMMENT -->
					<script>

						$(function(){
							$('#commentform').submit(function(e){
								e.preventDefault();
								var id=$("#picidforcomment").val();
								var name=$("#name").val();
								var email=$("#mail").val();
								var password=$("#password").val();
								var comment=$("#comments").val();
								var profilepic=$("#userprofpic").val();
								$.ajax({
									type:'post',
									url:'commentinsert.php',
									data:{id:id,name:name,email:email,password:password,comment:comment,profilepic:profilepic},
									dataType:'json',
									success:function(data){

										var cntcmnt=data['cntcmnt'];

										$("#cntcmnt_"+id).text(cntcmnt+" Comments")
										$('#commentmodal').modal('hide');


										

									}

								});
							});
						});

					</script>
					<!-- END OF SUBMITTING COMMENT -->
					

					<!-- END OF SUBMITTING COMMENT -->



					<!-- refreshing  the comment box on clicking it-->

					<script>

						$(function(){
							$(".commbutton[data-target=#commentmodal]").click(function(e){
								e.preventDefault();
								var target=$(this).attr("href");
								$("#commentmodal #commentsection").load(target,function(){
									$("#commentmodal").modal("show");
								});

          					});
						});
						
					</script>


					<!-- modal of likes -->
					<div class="modal mt-3 fade" id="likemodal">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header bg-info text-light">
									<h5>LIKES</h5>
									<button class="close bg-light text-dark" data-dismiss="modal" style="height:68px">&times;
									</button>
								</div><!--modal-header-->
								<div class="modal-body">
									<div id="likelist" class="border" style="overflow:scroll;height:300px">

										<!--LIST OF PERSON WHO LIKED THE POST -->


									</div><!--likelist-->
								</div><!--modal-body-->
								<div class="modal-footer" style="background:#edeaea">
									<small class="font-italic text-muted">@PoStCoPy</small>
								</div><!--modal-footer-->
							</div>
						</div><!--modal-dialog-->
					</div><!--modal-->
					<!--end of likes box -->
	


</body>
</html>