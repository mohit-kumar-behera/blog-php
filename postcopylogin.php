<?php

	$curyear=date("Y");

	//profile pic upload
	if(isset($_POST['submitdetail']))
	{
		$target_dir="profileImage/";
		$target_file=basename($_FILES['profilepic']['name']);
		$file_type=strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$target_path=$target_dir.uniqid($prefix="img_").$file_type;
		if(!move_uploaded_file($_FILES['profilepic']['tmp_name'],$target_path))
 	    {
 		   $target_path="profileImage/img_5eb55d6a8a219png";
 	    }

	}

	//sql connect
	include "postcopysqlconfig.php";


	//to enter user info into the database	
	if(isset($_POST['submitdetail']))
	{
		$username=$_POST['username'];
 		$id=uniqid();
 		$useremail=$_POST['useremail'];
 		$userpassword=$_POST['userpassword'];
 		$usercontact=$_POST['userphonenumber'];
 		$useraddress=$_POST['useraddress'];
 		$userbio=$_POST['userbio'];
		$sqlinsert=$conn->prepare("INSERT INTO usersprofile (`id`,`username`,`email`,`password`,`contactnum`,`contactaddr`,`bio`,`profilepic`) VALUES (?,?,?,?,?,?,?,?) LIMIT 1");
		$sqlinsert->bind_param("ssssisss",$id,$username,$useremail,$userpassword,$usercontact,$useraddress,$userbio,$target_path);
		$sqlinsert->execute();
		$sqlinsert->close();
	}

	$username=$useremail=$userpassword=$userphonenumber=$useraddress=$userbio=$id="";
	if(isset($_POST['submitdetail']))
	{
		if(isset($_POST['username']))
 		{
 			$username=$_POST['username'];
 			$id=uniqid();

 		}else{$username=""; }

 		if(isset($_POST['useremail']))
 		{
 			$useremail=$_POST['useremail'];
 		}else{$useremail=""; }

 		if(isset($_POST['userpassword']))
 		{
 			$userpassword=$_POST['userpassword'];
 		}else{$userpassword=""; }

 		if(isset($_POST['userphonenumber']))
 		{
 			$usercontact=$_POST['userphonenumber'];
 		}else{$usercontact="";}

 		if(isset($_POST['userbio']))
 		{
 			$userbio=$_POST['userbio'];
 		}else{$userbio="";}
 		if(isset($_POST['useraddress']))
 		{
 			$useraddress=$_POST['useraddress'];
 		}else{$useraddress="";}
	}

 /*$message=$action="";
 	if(isset($_GET['signinsubmit']))
 	{ $message=$action="";
 		$count=0;
 		$checkmail=$_GET['useremail'];
 		$checkpwd=$_GET['userpassword'];
 		$sqlch="SELECT email,password FROM usersprofile";
 		$result=$conn->query($sqlch);
 		
 		if($result->num_rows>0)
 		{
 			while($res=$result->fetch_assoc())
 			{
 				if((strcmp($res['email'],$checkmail)==0) && (strcmp($res['password'],$checkpwd)==0))
 				{
 					$count=$count+1;
 					echo $res['email']." "."<br>";
 				}

 			}
 		}

 		if($count==0)
 		{
 			$message="create account first";
 			echo $message;
 			$action="http://localhost/myProject/postcopylogin.php";
 			
 		}
 		else
 		{
 			//$parts=explode("@","checkmail");
 			//$part1=$parts[0];
 			//$part2=$parts.$parts[1];
 			$action="http://localhost/myProject/postcopy.php";
 			
 			//$message="accountn is created";
 			//echo $message;
 			echo "<br>".$action;
 		}
 	
 	}*/

   
?>

<!DOCTYPE html>
<html>
<title>Login Postcopy</title>
<head>
	<meta link-colorarset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Modak&display=swap" rel="stylesheet">
	<style type="text/css">
		#loginsubmit
		{
			border:0.75px solid #3BAF56;
			color:#3BAF56;
			letter-spacing: 8px;
		}
		#loginsubmit:hover
		{
			background:#3BAF56;
			color:#F7F7F7;
			box-shadow:2px 2px 4.7px #3BAF56,-2px -2px 4.7px #3BAF56;
		}
		#signinsubmit
		{
			border:0.75px solid #3BAF56;
			color:#3BAF56;
			letter-spacing: 8px;
		}
		#signinsubmit:hover
		{
			background:#3BAF56;
			color:#F7F7F7;
			box-shadow:2px 2px 4.7px #3BAF56,-2px -2px 4.7px #3BAF56;
		}
		#cardHeader1
		{
			background:linear-gradient(to right,#c31432,#240b36);
			color:#F7F7F7;
		}
		#cardHeader2
		{
			background:linear-gradient(to left,#c31432,#240b36);
			color:#F7F7F7;
		}
		@media screen and (max-width:575px)
		{
			#footerforbigscreen
			{
				display:none; 
			}
			#headlogo
			{
				display:none;
			}
			#headtext
			{
				margin-left:50%;
				transform:translateX(-50%);
			}
		}
		@media screen and (min-width:576px)
		{
			#headtext
			{
				margin-left:35px;
			}
		}
	</style>
</head>
<body>
	<div class="jumbotron-fluid" style="background:linear-gradient(to left,#8E2DE2,#4A00E0);color:#efe3ed;font-family:'Modak',cursive;height:100px;text-shadow:2px 3px red,-3px -2px orange;letter-spacing: 3px">
		<div class="container d-flex justify-content" style="position:relative;top:10%">
			<img src="https://cdn5.vectorstock.com/i/1000x1000/73/89/initial-letter-pc-logo-template-design-vector-22777389.jpg" id="headlogo" class="rounded-circle mt-2" style="width:55px;height:55px"/>
			<p class="display-3 text-center" id="headtext">PoStCoPy</p>
		</div><!--container-->
	</div><!--jumbotron fluid-->

	<div class="container mt-5 mb-3">
		<div class="row">
			<div class="col-sm mt-3">
				<div class="card">
					<div class="card-header" id="cardHeader1">
						<h4 class="card-title text-center">NEW USER</h4>
					</div><!--card header-->
					<div class="card-body bg-dark">
						<button class="btn btn-outline-success float-center" style="position:relative;left:50%;transform:translateX(-50%);" data-toggle="modal" data-target="#loginmodal">Sign Up</button>

						<!--MODAL-->
						<div class="modal" id="loginmodal" >
							<div class="modal-dialog model-dialog-centered">
								<div class="modal-content">
									<div class="modal-header bg-info text-white">
										<h4 class="modal-title ">Enter Details</h4>
										<button class="close" data-dismiss="modal">&times;</button>
									</div><!--modal header-->
									<div class="modal-body">
										<form class="form-group" method="post" enctype="multipart/form-data">
											<input type="text" class="form-control mb-2 text-capitalize" name="username" placeholder="Username" required/>
											<input type="email" class="form-control mb-2" name="useremail" placeholder="Email" required/>
											<input type="password" class="form-control mb-2" name="userpassword" placeholder="Password" required/>
											<input type="number" class="form-control mb-2" name="userphonenumber" placeholder="Contact Number" required/>
											<input type="text" class="form-control mb-2" placeholder="Address" name="useraddress" required/>
											<textarea rows="3" cols="10" class="form-control mb-2" placeholder="BIO..." name="userbio" id="bio"></textarea>
											<div class="custom-file mb-2">
											<input type="file" class="custom-file-input" id="customFile" name="profilepic" value="http://localhost/myProject/IMAGES">
                                            <label class="custom-file-label" for="customFile">Profile Pic</label>
                                            </div><!--custom-file--><hr>
											<input type="submit" class="form-control mb-2 font-weight-bolder" name="submitdetail" id="loginsubmit" value="SUBMIT"/>
										</form>
									</div><!--modal body-->
								</div><!--modal content-->
							</div><!--modal dialog-->
						</div><!--login modal-->
						<!--MODAL END-->

						<!--script for profile pic-->
						<script>
							$(function(){
								$(".custom-file-input").change(function(){
									var filename=$(this).val().split("\\").pop();
									$(this).siblings(".custom-file-label").html(filename);
								});
							});
						</script>
						<!--end of profile pic script-->

					</div><!--card body-->
					<div class="card-footer">
						<small class="text-muted font-italic float-right">@PoStCoPy</small>
					</div><!--card footer-->
				</div><!--card-->
			</div><!--col-->
			<div class="col-sm mt-3 mb-3">
				<div class="card">
					<div class="card-header" id="cardHeader2">
						<h4 class="card-title text-center">Already a USER</h4>
					</div><!--card header-->
					<div class="card-body bg-dark">
						<button class="btn btn-outline-success float-center" style="position:relative;left:50%;transform:translateX(-50%);" data-toggle="modal" data-target="#signinmodal">Log In</button>
						<div class="modal" id="signinmodal">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header bg-info text-light">
										<h4>Enter Details</h4>
										<button class="close" data-dismiss="modal">&times;</button>
									</div><!--modal header-->
									<div class="modal-body">
										<form method="get" action="checkuser.php" >
											<input type="email" class="form-control mb-2" name="useremail" placeholder="Email" id="signuseremail" required/> 
											<input type="password" class="form-control mb-2" name="userpassword" placeholder="Password" id="signuserpwd" required/><hr>
											<input type="submit" class="form-control mb-2 font-weight-bolder" name="signinsubmit" id="signinsubmit" value="SUBMIT"/>
										</form>
									</div><!--modal body-->
								</div><!--modal-content-->
							</div><!--modal-dialog-->
						</div><!--modal-->
					</div><!--card body-->
					<div class="card-footer">
						<small class="text-muted font-italic float-right">@PoStCoPy</small>
					</div><!--card footer-->
				</div><!--card-->
			</div><!--col-->
		</div><!--row-->
	</div><!--container-->

	<div class="jumbotron-fluid p-3" id="footerforbigscreen" style="background:linear-gradient(to right,#0f0c29,#302b63,#24243e);position:relative;bottom:-100px">
		<div class="container" style="color:lightgrey">
		  <div class="row">
		  	<div class="col-8">
		    	<p><small><span class="font-weight-bold">About Postcopy: </span>This site is just to share some pictures for entertainment and fun purpose.Post your images and check your friends post and enjoy it.</small></p>
		    	<p><small><span class="font-weight-bold">Email Us: </span>postcopy@gmail.com</small></p>
		    </div><!--col-->
		  	<div class="col-4">
				<p><small><span class="font-weight-bold">Created By: </span> Mohit Kumar</small></p>
				<p><small><span class="font-weight-bold">Developed By: </span> RXL Foundation</small></p>
				<p><small><span class="font-weight-bold">&copy;</span> 2020-<?php echo $curyear; ?> </small></p>
		    </div><!--col-->
		  </div><!--row-->
		</div><!--container-->
	</div><!--jumbotron-->

</body>
</html>