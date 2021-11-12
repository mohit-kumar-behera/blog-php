<?php 


	include "config.php";
	$userid=$_POST['userid'];
	$viewerid=$_POST['viewerid'];

	$sql="SELECT * FROM `postcomments` WHERE `id`='".$userid."'";
	
	$result = mysqli_query($con,$sql);
	$count=0;
		while($row=mysqli_fetch_array($result))
		{
			include 'postcopysqlconfig.php';

			$sql=$conn->prepare("SELECT `id` from `usersprofile` WHERE `email`=? AND `password`=?");
			$sql->bind_param("ss",$row['viewedusermail'],$row['viewedpassword']);
			$sql->execute();
			$sql->store_result();
			$sql->bind_result($id);
			$sql->fetch();

			$count=$count+1;
			$databasetime=$row['time'];
			$databasedate=$row['date'];
			$showtime=date("H:i ",strtotime($databasetime));
			$showdate=date("d-m-Y",strtotime($databasedate));
			echo "<div class='media mb-2'><div class='d-flex'><img src='".$row['viewedprofilepic']."' class='rounded' style='width:26px;height:26px;position:relative;top:8px'><div class='media-body bg-warning ml-3 p-2 rounded' style='color:#138496'><div class='d-flex flex-column'><a href='postcopyviewprofile.php?id=".$id."&userid=".$viewerid."' style='color:#4a0c8c'><h6><u>".$row['viewedusername']."</u></h6></a><p>".$row['comment']."</p></div><small class='text-muted ml-2 float-right'>".$showtime."<b> on </b>".$showdate."</small></div></div></div>";
		}
	




exit;