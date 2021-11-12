<?php

include 'postcopysqlconfig.php';
include 'config.php';

$userid=$_POST['userid'];
$postid=$_POST['postid'];
$comment=$_POST['comment'];
date_default_timezone_set("Asia/Kolkata");
$date=date("Y-m-d");
$time=date("H:i:s");

$sqlgetuserinfo=$conn->prepare("SELECT `username`,`email`,`password`,`profilepic` FROM `usersprofile` WHERE `id`=?");
$sqlgetuserinfo->bind_param("s",$userid);
$sqlgetuserinfo->execute();
$sqlgetuserinfo->store_result();
$sqlgetuserinfo->bind_result($getusername,$getusermail,$getuserpassword,$getuserprofilepic);
$sqlgetuserinfo->fetch();
$sqlgetuserinfo->close();

$sqlcommentinsert=$conn->prepare("INSERT INTO `postcomments` (`id`,`viewedusername`,`viewedusermail`,`viewedpassword`,`viewedprofilepic`,`comment`,`date`,`time`) VALUES (?,?,?,?,?,?,?,?)");
$sqlcommentinsert->bind_param("ssssssss",$postid,$getusername,$getusermail,$getuserpassword,$getuserprofilepic,$comment,$date,$time);
$sqlcommentinsert->execute();
$sqlcommentinsert->close();

?>