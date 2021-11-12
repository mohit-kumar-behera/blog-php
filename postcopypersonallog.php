<?php

	include "postcopysqlconfig.php";
	$_SESSION['id']=$_GET['id'];
	$sqlgetuser=$conn->prepare("SELECT * FROM `usersprofile` WHERE `id`=?");
	$sqlgetuser->bind_param("s",$_SESSION['id']);
	$sqlgetuser->execute();
	$sqlgetuser->store_result();
	$sqlgetuser->bind_result($getuserid,$getusername,$getusermail,$getuserpassword,$getusernumber,$getuseraddress,$getuserbio,$getuserprofpic);
	$sqlgetuser->fetch();

?>


<!DOCTYPE html>
<html>
<title>Credential</title>
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
		body{
			background:#1F1F1F;
		}
		@media screen and (min-width:576px)
		{
			.container
			{
				width:65%;
				margin-top:128px;
			}
			
		}
		@media screen and (max-width:576px)
		{
			.container
			{
				width:85%;
				margin-top:168px;
			}
		}

		
	</style>


</head>
<body>

	<div class="container" id="choose_credentials">
		<div class="card" style="border:2.6px solid powderblue">
			<div class="card-body bg-info rounded-top" style="">
				<div class="card-text">
					<h3 style="color:white;font-family:calibri">Credential</h3>
				</div><!--card text-->
				<div class="card-text">
					<div class="card">
						<div class="card-body">
							<div class="card-text">
								<form method="post" class="form-group" action="<?php echo "postcopyprofile.php?id=$getuserid" ;?>">
								<input type="email" id="newemail" spellcheck="false" class="form-control mb-2" placeholder="New Email (Optional)"/>
								<input type="password" id="oldpassword" spellcheck="false" class="form-control mb-2" placeholder="Old Password" required="" />
								<input type="password" id="newpassword" spellcheck="false" class="form-control mb-2" placeholder="New Password" required/><hr>
								<div class="d-flex justify-content-around">
									<button type="submit" id="credentialsubmit" class="btn btn-outline-success ">Submit</button>
									<a href="postcopyprofile.php?id=<?php echo $getuserid; ?>"><button type="button" class="btn btn-outline-success ml-1"><i id="prevpageicon"  class="fa fa-angle-double-left mr-1"></i>Previous Page</button></a>
								</div><!--d-flex-->
								</form>
								
							</div><!--inner card text-->
						</div><!--inner card body-->
					</div><!--inner card-->
				</div><!--card text-->
			</div><!--card body-->
			<div class="card-footer rounded-bottom" style="height:38px;background:#d6cbcb">
				<small class=" font-italic float-right" style="color:#686767">@PoStCoPy</small>
			</div><!--card footer-->
		</div><!--card-->
	</div><!--container-->



	<div class="container" id="delete_account">
		<div class="card" style="border:2.6px solid powderblue">
			<div class="card-body bg-info rounded-top" style="">
				<div class="card-text">
					<h3 style="color:white;font-family:calibri">Delete Account</h3>
				</div><!--card text-->
				<div class="card-text">
					<div class="card">
						<div class="card-body">
							<div class="card-text">
								<form method="post" class="form-group" action='postcopylogin.php' >
									<input type="password" id="password" class="form-control mb-2"placeholder="Password" required/>
									<textarea id="reason" class="form-control mb-2" placeholder="Reason to Delete Account (How can We Improve?)" spellcheck="false"></textarea><hr>
									<div class="d-flex justify-content-around">
									<a href="#" data-toggle="tooltip" data-placement="right" title="Are you sure ?"><button type="submit" id="deleteaccount" class="btn btn-outline-success ">Delete</button></a>
									<a href="postcopyprofile.php?id=<?php echo $getuserid; ?>"><button type="button" class="btn btn-outline-success ml-1"><i id="prevpageicon"  class="fa fa-angle-double-left mr-1"></i>Previous Page</button></a>
								</div><!--d-flex-->
								</form>								
							</div><!--inner card text-->
						</div><!--inner card body-->
					</div><!--inner card-->
				</div><!--card text-->
			</div><!--card body-->
			<div class="card-footer rounded-bottom" style="height:38px;background:#d6cbcb">
				<small class=" font-italic float-right" style="color:#686767">@PoStCoPy</small>
			</div><!--card footer-->
		</div><!--card-->
	</div><!--container-->

<!--script for tooltip  for delete account -->
<script>
	$(function(){
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>


<!--script for deleting the account -->
<script>
	$(function(){
		$("#deleteaccount").click(function(){
			var id='<?php echo $getuserid; ?>';
			var password=$("#password").val();
			var reason=$("#reason").val();
			var oldpassword='<?php echo $getuserpassword; ?>';
			if(oldpassword==password)
			{
			$.ajax({
				url:'accountdelete.php',
				type:'post',
				data:{id:id,password:password,reason:reason},
				success:function(data){
					$type=1;
				}
			});
			}
			else{alert("Your Password doesn't match with the Existing Password");$type=0;}
		});
	});
</script>

	<div class="container" id="url_error" >
		<div class="card" style="border:2.6px solid powderblue">
			<div class="card-body bg-info rounded-top" style="">
				<div class="card-text">
					<h3 style="color:white;font-family:calibri">Page Not Found</h3>
				</div><!--card text-->
				<div class="card-text">
					<form method="get" action="postcopyprofile.php" class="form-group">
						<button class="btn btn-warning" name="id" id="prevbutton" value='<?php echo $getuserid; ?>'><i id="prevpageicon" style="color:green" class="fa fa-angle-double-left"></i><span class="ml-2 font-weight-bold" style="color:brown">Previous Page</span></button>
					</form>
				</div><!--card text-->

			</div><!--card body-->
			<div class="card-footer rounded-bottom" style="height:38px;background:#d6cbcb">
				<small class=" font-italic float-right" style="color:#686767">@PoStCoPy</small>
			</div><!--card footer-->
		</div><!--card-->
	</div><!--container-->

<!--script to get the url and show information acc to that url -->
	<script>
			var url=window.location.href;
			if(url.indexOf("da")>-1)
			{
				$("#choose_credentials").hide();
				$("#delete_account").show();
				$("#url_error").hide();
			}
			else if(url.indexOf("cc")>-1)
			{
				$("#choose_credentials").show();
				$("#delete_account").hide();
				$("#url_error").hide();				
			}
			else
			{
				$("#choose_credentials").hide();
				$("#delete_account").hide();
				$("#url_error").show();
			}
		
	</script>

	<!--script for credential change-->
	<script>
		$(function(){
			$("#credentialsubmit").click(function(){
				var id='<?php echo $getuserid; ?>';
				var email=$("#newemail").val();
				var old_password=$("#oldpassword").val();
				var new_password=$("#newpassword").val();
				if(old_password=='' && new_password==''){alert("Fill The Required Field");}
				else if(old_password!='<?php echo $getuserpassword;?>'){alert("Your Password doesn't match with the Existing Password");}
				else
				{
					$.ajax({
						url:'credentialcheck.php',
						type:'post',
						data:{id:id,email:email,old_password:old_password,new_password:new_password},
						success:function(data){
							
						}
					});
				}
			});
		});
	</script>

	<div class="modal" id="alertmodal">
		<div class="modal-content">
			<div class="modal-dialog">
				<div class="modal-body">
					<div class="alert alert-success">Successfully Updated Your Credentials</div>
				</div><!--modal-body-->
			</div><!--modal dialog-->
		</div><!--modal content-->
	</div><!--modal-->
	
</body>
</html>