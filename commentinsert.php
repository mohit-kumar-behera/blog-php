<?php
	
	date_default_timezone_set("Asia/Kolkata");
	include "postcopysqlconfig.php";
	$id=$_POST['id'];
	$name=$_POST['name'];
	$email=$_POST['email'];
	$password=$_POST['password'];
	$comment=$_POST['comment'];
	$profilepic=$_POST['profilepic'];
	$date=date("Y-m-d");
	$time=date("H:i:s");

	if($comment!="")
	{
	$sqlinsertcomment=$conn->prepare("INSERT INTO `postcomments`(`id`, `viewedusername`, `viewedusermail`, `viewedpassword`, `viewedprofilepic`, `comment`, `date`, `time`) VALUES (?,?,?,?,?,?,?,?)");
	$sqlinsertcomment->bind_param("ssssssss",$id,$name,$email,$password,$profilepic,$comment,$date,$time);
	$sqlinsertcomment->execute();
	$sqlinsertcomment->close();
    }

    $commentquerylike=$conn->prepare("SELECT COUNT(*) AS cntcmnt FROM `postcomments` WHERE `id`=?");
	$commentquerylike->bind_param("s",$id);
	$commentquerylike->execute();
	$commentquerylike->store_result();
	$commentquerylike->bind_result($countcomment);
	$commentquerylike->fetch();

	//initializing the result as array

	$return_array=array("cntcmnt"=>$countcomment);
	echo json_encode($return_array);

exit;