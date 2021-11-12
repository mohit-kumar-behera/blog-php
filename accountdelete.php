<?php

include 'postcopysqlconfig.php';

$id=$_POST['id'];
$password=$_POST['password'];
$reason=$_POST['reason'];

date_default_timezone_set("Asia/Kolkata");
$date=date("Y-m-d");
$time=date("H:i:s");
/*info of the user */
$sqlgetuser=$conn->prepare("SELECT * FROM `usersprofile` WHERE `id`=?");
$sqlgetuser->bind_param("s",$id);
$sqlgetuser->execute();
$sqlgetuser->store_result();
$sqlgetuser->bind_result($getuserid,$getusername,$getusermail,$getuserpassword,$getusernumber,$getuseraddress,$getuserbio,$getuserprofpic);
$sqlgetuser->fetch();


/*Inserting the reason to delete into database*/
$sqlinsertreason=$conn->prepare("INSERT INTO `postcopyuserleft` (`id`,`username`,`useremail`,`userpassword`,`reason`,`time`,`date`,`contactnumber`) VALUES (?,?,?,?,?,?,?,?) ");
$sqlinsertreason->bind_param("sssssssi",$id,$getusername,$getusermail,$getuserpassword,$reason,$time,$date,$getusernumber);
$sqlinsertreason->execute();
$sqlinsertreason->close();


/*deleting user informatiion from everything*/

//deleting from likepost
$sqlaccountdelete1=$conn->prepare("DELETE FROM `likepost` WHERE `viewedmail`=? AND `viewedpassword`=?");
$sqlaccountdelete1->bind_param("ss",$getusermail,$getuserpassword);
$sqlaccountdelete1->execute();
$sqlaccountdelete1->close();

//deleting from postcomment
$sqlaccountdelete2=$conn->prepare("DELETE FROM `postcomments` WHERE `viewedusermail`=? AND `viewedpassword`=?");
$sqlaccountdelete2->bind_param("ss",$getusermail,$getuserpassword);
$sqlaccountdelete2->execute();
$sqlaccountdelete2->close();

//deletoing from postpicture
$sqlaccountdelete3=$conn->prepare("DELETE FROM `picturepost` WHERE `useremail`=? AND `userpassword`=?");
$sqlaccountdelete3->bind_param("ss",$getusermail,$getuserpassword);
$sqlaccountdelete3->execute();
$sqlaccountdelete3->close();

//deleting the postcopy account
$sqlaccountdelete4=$conn->prepare("DELETE FROM `usersprofile` WHERE `id`=? ");
$sqlaccountdelete4->bind_param("s",$id);
$sqlaccountdelete4->execute();
$sqlaccountdelete4->close();


?>