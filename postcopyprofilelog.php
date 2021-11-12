<?php

	include "postcopysqlconfig.php";
	
	$id=$_POST['id'];
	$username=$_POST['username'];
	$usernumber=$_POST['usernumber'];
	$useraddress=$_POST['useraddress'];
	$userbio=$_POST['userbio'];
	$useremail=$_POST['useremail'];
	$userpassword=$_POST['userpassword'];


	//updating users profile
	$sqlupdate1=$conn->prepare("UPDATE `usersprofile` SET `username`=?,`contactnum`=?,`contactaddr`=?,`bio`=? WHERE `id`=?");
	$sqlupdate1->bind_param("sisss",$username,$usernumber,$useraddress,$userbio,$id);
	$sqlupdate1->execute();
	$sqlupdate1->close();

	//updating user information from picturepost
	$sqlupdate2=$conn->prepare("UPDATE `picturepost` SET `username`=? WHERE `useremail`=? AND `userpassword`=?");
	$sqlupdate2->bind_param("sss",$username,$useremail,$userpassword);
	$sqlupdate2->execute();
	$sqlupdate2->close();

	//updating user information comments section
	$sqlupdate3=$conn->prepare("UPDATE `postcomments` SET `viewedusername`=? WHERE `viewedusermail`=? AND `viewedpassword`=?");
	$sqlupdate3->bind_param("sss",$username,$useremail,$userpassword);
	$sqlupdate3->execute();
	$sqlupdate3->close();

	//updating users information from like section
	$sqlupdate4=$conn->prepare("UPDATE `likepost` SET `viewedname`=? WHERE `viewedmail`=? AND `viewedpassword`=?");
	$sqlupdate4->bind_param("sss",$username,$useremail,$userpassword);
	$sqlupdate4->execute();
	$sqlupdate4->close();

?>