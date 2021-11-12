<?php


	session_start();

	$_SESSION['mail']=$_GET['useremail'];
	$_SESSION['pwd']=$_GET['userpassword'];
		
    include "postcopysqlconfig.php";
    
	if($conn->connect_error){die("Connection failed");}

 		$alertmessage="";$count=0;

 		$checkmail=$_SESSION['mail'];
 		$checkpwd=$_SESSION['pwd'];
 		$sqlch="SELECT email,password FROM usersprofile";
 		$result=$conn->query($sqlch);
 		
 		if($result->num_rows>0)
 		{
 			while($res=$result->fetch_assoc())
 			{
 				if((strcmp($res['email'],$checkmail)==0) && (strcmp($res['password'],$checkpwd)==0))
 				{
 					$count=$count+1;
 				}

 			}
 		}
 		
 		$sqldetail=$conn->prepare("SELECT username,profilepic FROM usersprofile WHERE email=? AND password=?");
 		$sqldetail->bind_param("ss",$_SESSION['mail'],$_SESSION['pwd']);
 		$sqldetail->execute();
 		$sqldetail->store_result();
 		$sqldetail->bind_result($uname,$pfpic);
 		$sqldetail->fetch();
 		$sqldetail->close();

 	
?>


<!DOCTYPE html>
<html>
<title>Check User</title>
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
		@media screen and (min-width:576px)
		{
			#newAccount
			{
				width:65%;
				margin-top:168px;
			}
			#oldAccount
			{
				width:65%;
				margin-top:168px;
			}
		}
		@media screen and (max-width:576px)
		{
			#newAccount
			{
				width:85%;
				margin-top:168px;
			}
			#oldAccount
			{
				width:85%;
				margin-top:168px;
			}
		}
		body{
			background:#1F1F1F;
		}

		#previouspage{
			border:0.75px solid #3BAF56;
			color:#3BAF56;
			letter-spacing: 2px;
		}
		#previouspage:hover{
			color:#F7F7F7;
			box-shadow:2px 2px 4.7px #3BAF56,-2px -2px 4.7px #3BAF56;
			background:#3BAF56;
		}
		

	</style>

	</head>
<body>
	<!--account doesnt exist-->
	<div class="container " id="newAccount">
		<div class="card" id="check1">
			<div class="card-header bg-info">
				<h4 class="card-title">A New Account ?</h4>
			</div><!--card header-->
			<div class="card-body">
				<p class="lead">Go to the Previous Page and Create New Account.</p>
				<form action="postcopylogin.php" method="get" class="form-group">
					<input type="submit" class="form-control mb-2 font-weight-bolder" name="previouspage" id="previouspage" value="GO BACK" style="width:55%;margin-left:50%;transform:translateX(-50%);"/>
				</form>
			</div><!--card body-->
			<div class="card-footer ">
				<small class="text-muted float-right font-italic">@PoStCoPy</small>
			</div><!--card footer-->
		</div><!--card-->
	</div><!--container-->

	<!--account exist-->
	<div class="container mb-5" id="oldAccount" >
		<div class="card" id="check2">
			<div class="card-header bg-info">
				<h4 class="card-title">Verify Your Profile</h4>
			</div><!--card header-->
			<div class="card-body">
				<div class="media">
					<?php echo "<img src='".$pfpic."'style='width:70px;height:70px' class='rounded-circle '/>"?>
					<div class="media-body">
						<h3 class="text-dark ml-4"><?php echo $uname; ?></h3>
						<p class="lead ml-5 ">Is This You ?</p>
					</div><!--media body-->
				</div><!--media-->
				<form action="postcopy.php" method="get" class="form-group">
					<input type="email" name="useremail" value="<?php echo $_SESSION['mail'];?>" hidden/>
					<input type="password" name="userpassword" value="<?php echo $_SESSION['pwd'];?>" hidden/>
					<input type="submit" class="form-control mb-2 font-weight-bolder" name="previouspage" id="previouspage" value="CONTINUE" style="width:60%;margin-left:50%;transform:translateX(-50%);"/>
				</form>
			</div><!--card body-->
			<div class="card-footer ">
				<small class="text-muted float-right font-italic">@PoStCoPy</small>
			</div><!--card footer-->
		</div><!--card-->
	</div><!--container-->

	 <script>
		var cnt=<?php echo $count ?>;
		if(cnt==0)
		{
			$("#newAccount").show();
			$("#oldAccount").hide();
		}
		else if(cnt>0)
		{
			$("#newAccount").hide();
			$("#oldAccount").show();
		}
	</script>

</body>
</html>