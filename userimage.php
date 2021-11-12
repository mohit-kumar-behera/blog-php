<?php
	
	include "postcopysqlconfig.php";
	include "config.php";

	$post_id=$_POST['post_id'];
	$user_id=$_POST['user_id'];
	$viewerid=$_POST['viewerid'];

	$sqlselectimage=$conn->prepare("SELECT `picture`,`caption`,`time`,`date` FROM `picturepost` WHERE `id`=?");
	$sqlselectimage->bind_param("s",$post_id);
	$sqlselectimage->execute();
	$sqlselectimage->store_result();
	$sqlselectimage->bind_result($pic,$caption,$time,$date);
	$sqlselectimage->fetch();

	$sqlselectlike=$conn->prepare("SELECT COUNT(*) AS cntlike FROM `likepost` WHERE `photoid`=? AND `type`=1");
	$sqlselectlike->bind_param("s",$post_id);
	$sqlselectlike->execute();
	$sqlselectlike->store_result();
	$sqlselectlike->bind_result($cntlike);
	$sqlselectlike->fetch();

	$sqlselectcomm=$conn->prepare("SELECT COUNT(*) AS cntcmnt FROM `postcomments` WHERE `id`=?");
	$sqlselectcomm->bind_param("s",$post_id);
	$sqlselectcomm->execute();
	$sqlselectcomm->store_result();
	$sqlselectcomm->bind_result($cntcmnt);
	$sqlselectcomm->fetch();

	$databasetime=$time;
	$databasedate=$date;
	$showtime=date("H:i ",strtotime($databasetime));
	$showdate=date("d-m-y ",strtotime($databasedate));

	$sqlgetuserinfo=$conn->prepare("SELECT * FROM `usersprofile` WHERE `id`=?");
	$sqlgetuserinfo->bind_param("s",$user_id);
	$sqlgetuserinfo->execute();
	$sqlgetuserinfo->store_result();
	$sqlgetuserinfo->bind_result($getuserid,$getusername,$getusermail,$getuserpassword,$getusernumber,$getuseraddress,$getuserbio,$getuserprofilepic);
	$sqlgetuserinfo->fetch();
	$sqlgetuserinfo->close();
	
	
	echo "<div class='row'><div class='col-md p-0'><img src='".$pic."' style='width:100%;position:relative;top:-15px'/>

		<div class='d-flex justify-content-between' style='position:relative;top:-10px'><div class='pl-2'>".$caption."</div><div>&nbsp&nbsp&nbsp&nbsp&nbsp</div><div class='pr-2'><small class='text-muted'>".$showtime."<b><i> on</i> </b><p class='text-wrap'>".$showdate."</p></small></div></div>

		<div class='d-flex justify-content-around m-3' style='position:relative;top:-20px'>
		<div class='d-flex flex-column'><button style='border:none;outline:none;background:transparent;position:relative;left:-15px;top:2.4px' data-target='#likemodal' data-toggle='modal' class='likebutton' id='".$post_id."'><span class='fa fa-heart' style='color:darkred;font-size:23px'></span></button><p class='text-muted' style='position:relative;top:-5px;left:-14px'>$cntlike Likes</p></div><div class='d-flex'>
		<span class='fa fa-comments' style='color:green;font-size:25px;position:relative;left:20px;top:2.6px'</span><p class='text-muted' style='font-size:16px;position:relative;left:-23px'>$cntcmnt Comments</p></div><button class='btn btn-outline-danger' data-dismiss='modal' style='width:58px;height:40px;position:relative;top:2px;font-size:20px'>&times;</button>
		</div>
		</div>
		<div class='col-md'>
			<div class='border pl-2' style='overflow:scroll;height:415px'>";
			include "config.php";
			$sqlgetcomment="SELECT * FROM `postcomments` WHERE `id`='".$post_id."'";
			$result=mysqli_query($con,$sqlgetcomment);
			while($row=mysqli_fetch_array($result))
			{
				include 'postcopysqlconfig.php';

				$sql=$conn->prepare("SELECT `id` from `usersprofile` WHERE `email`=? AND `password`=?");
				$sql->bind_param("ss",$row['viewedusermail'],$row['viewedpassword']);
				$sql->execute();
				$sql->store_result();
				$sql->bind_result($id);
				$sql->fetch();

			echo "<div class='d-flex p-2'><img src='".$row['viewedprofilepic']."' class='rounded' style='width:30px;height:30px;position:relative;top:8px'><div class='media-body bg-warning ml-3 p-2 rounded' style='color:#138496'><div class='d-flex flex-column'><a href='postcopyviewprofile.php?id=".$id."&userid=".$viewerid."' style='color:#4a0c8c'><h6><u>".$row['viewedusername']."</u></h6></a><p>".$row['comment']."</p></div><small class='text-muted ml-2 float-right'>".$showtime."<b> on </b>".$showdate."</small></div></div>";
			}
		echo "</div>

		<div class='container'><form class='form-group mt-2' method='post'><div class='input-group'><textarea class='form-control' id='comment' placeholder='Write Your Comment'></textarea><input type='text' value='".$post_id."' id='postid' hidden/><button type='button' class='btn btn-success input-group-append' id='commentsubmit'>Comment</button></div></form></div>

			</div></div>";
		
		echo "<div class='modal mt-3 fade' id='likemodal'><div class='modal-dialog'><div class='modal-content'><div class='model-header bg-info text-light' style='height:55px'><h5 class='ml-3 mt-2'>Likes</h5></div><div class='modal-body'><div id='likelist' style='overflow:scroll;height:300px'>";

		$sql="SELECT * FROM `likepost` WHERE `photoid`='$post_id' AND `type`=1";
	
		$result = mysqli_query($con,$sql);
	
		while($row=mysqli_fetch_array($result))
		{
				include 'postcopysqlconfig.php';

				$sql=$conn->prepare("SELECT `id` from `usersprofile` WHERE `email`=? AND `password`=?");
				$sql->bind_param("ss",$row['viewedmail'],$row['viewedpassword']);
				$sql->execute();
				$sql->store_result();
				$sql->bind_result($id);
				$sql->fetch();

			echo "<div class='media mb-2 ml-2 mt-2' ><a href='postcopyviewprofile.php?id=".$id."&userid=".$viewerid."'><img src='".$row['viewedprofilepic']."'style='width:32px;height:32px;position:relative;top:1.7px' class='rounded'/></a><div class='media-body mr-5><h6 class='text-capitalize ' style='font-size:22px;font-family:calibri;margin-left:16px'><a href='postcopyviewprofile.php?id=".$id."&userid=".$viewerid."' style='font-size:18px;color:black' id='searchuserlink'>".$row['viewedname']."</a></h6></div></div>";
		}


		echo "</div></div><div class='modal-footer' style='height:60px'><button id='closed' class='btn btn-danger' style='position:relative;top:-8px'>Close</button></div></div></div></div>";


 		/*like modal script*/
		echo "<script>
		$(function(){
			$('#closed').click(function(){
				$('#likemodal').modal('hide');
				});
			});
				
			</script>";


		/*script for comment*/
		echo "<script>

			$(function(){
				$('#commentsubmit').click(function(){
					var postid=$('#postid').val();
					var comment=$('#comment').val();
					var userid='".$viewerid."';
					$.ajax({
						url:'commentinsert2.php',
						type:'post',
						data:{postid:postid,comment:comment,userid:userid},
						success:function(data){
							location.reload();
						}
						});
					});
				});

			</script>"

?>