<?php

	include "config.php";
	$postid=$_POST['postid'];
	$viewerid=$_POST['viewerid'];
	$postuserid=$_POST['postuserid'];

	$sql="SELECT * FROM `likepost` WHERE `photoid`='$postid' AND `type`=1";
	
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

			echo "<div class='media mb-2 ml-4 mt-2' ><a href='postcopyviewprofile.php?id=".$id."&userid=".$viewerid."'><img src='".$row['viewedprofilepic']."'style='width:32px;height:32px;position:relative;top:1.7px' class='rounded'/></a><div class='media-body mr-5><h6 class='text-capitalize ' style='font-size:22px;font-family:calibri;margin-left:16px'><a href='postcopyviewprofile.php?id=".$id."&userid=".$viewerid."' style='font-size:18px;color:black' id='searchuserlink'>".$row['viewedname']."</a></h6></div></div>";
		}


?>