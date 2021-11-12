<?php
	include 'postcopysqlconfig.php';
	//include 'config.php';
	$post_id=$_POST['post_id'];
	$ltype=$_POST['ltype'];
	$vusername=$_POST['vusername'];
	$vuseremail=$_POST['vuseremail'];
	$vuserpwd=$_POST['vuserpwd'];
	$vuserprofpic=$_POST['vuserprofpic'];


	// to check if the user has already liked or he is a new liker
	$sqluserexist=$conn->prepare("SELECT COUNT(*) AS cnt FROM `likepost` WHERE `photoid`=? AND `viewedmail`=? AND `viewedpassword`=?");
	$sqluserexist->bind_param("sss",$post_id,$vuseremail,$vuserpwd);
	$sqluserexist->execute();
	$sqluserexist->store_result();
	$sqluserexist->bind_result($countuser);
	$sqluserexist->fetch();
	$sqluserexist->close();


	//inserting like or unlike into database

	if($countuser==0) //if he is a new liker
	{
		$sqlinsertlike=$conn->prepare("INSERT INTO `likepost` (`photoid`,`viewedname`,`viewedmail`,`viewedpassword`,`viewedprofilepic`,`type`) VALUES (?,?,?,?,?,?)");
		$sqlinsertlike->bind_param("sssssi",$post_id,$vusername,$vuseremail,$vuserpwd,$vuserprofpic,$ltype);
		$sqlinsertlike->execute();
		$sqlinsertlike->close();
	}
	else if($countuser==1) //updating like list if he is an old liker
	{
		$sqlupdatelikelist=$conn->prepare("UPDATE `likepost` SET `type`=? WHERE `photoid`=? AND `viewedmail`=? AND `viewedpassword`=?");
		$sqlupdatelikelist->bind_param("isss",$ltype,$post_id,$vuseremail,$vuserpwd);
		$sqlupdatelikelist->execute();
		$sqlupdatelikelist->close();
	}


	$querylike=$conn->prepare("SELECT COUNT(*) AS cntlike FROM `likepost` WHERE `type`=1 AND `photoid`=?");
	$querylike->bind_param("s",$post_id);
	$querylike->execute();
	$querylike->store_result();
	$querylike->bind_result($countlike);
	$querylike->fetch();

	//initializing the result as array

	$return_array=array("likes"=>$countlike);
	echo json_encode($return_array);

	


?>