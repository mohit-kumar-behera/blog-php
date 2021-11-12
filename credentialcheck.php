<?php

include 'postcopysqlconfig.php';
$id=$_POST['id'];
$email=$_POST['email'];
$old_password=$_POST['old_password'];
$new_password=$_POST['new_password'];

/*info of the user */
$sqlgetuser=$conn->prepare("SELECT * FROM `usersprofile` WHERE `id`=?");
$sqlgetuser->bind_param("s",$id);
$sqlgetuser->execute();
$sqlgetuser->store_result();
$sqlgetuser->bind_result($getuserid,$getusername,$getusermail,$getuserpassword,$getusernumber,$getuseraddress,$getuserbio,$getuserprofpic);
$sqlgetuser->fetch();

if($email=='')
{
	$email=$getusermail;
}
/*changing mail or password from database */
if($new_password!='')
{
	/*from usersprofile*/
	$sqlchange1=$conn->prepare("UPDATE `usersprofile` SET `email`=?,`password`=? WHERE `id`=?");
	$sqlchange1->bind_param("sss",$email,$new_password,$id);
	$sqlchange1->execute();
	$sqlchange1->close();

	/*from picturepost*/
	$sqlchange1=$conn->prepare("UPDATE `picturepost` SET `useremail`=?,`userpassword`=? WHERE `username`=?");
	$sqlchange1->bind_param("sss",$email,$new_password,$getusername);
	$sqlchange1->execute();
	$sqlchange1->close();

	/*from postcomment*/
	$sqlchange1=$conn->prepare("UPDATE `postcomments` SET `viewedusermail`=?,`viewedpassword`=? WHERE `viewedusername`=?");
	$sqlchange1->bind_param("sss",$email,$new_password,$getusername);
	$sqlchange1->execute();
	$sqlchange1->close();

	/*from likepost*/
	$sqlchange1=$conn->prepare("UPDATE `likepost` SET `viewedmail`=?,`viewedpassword`=? WHERE `viewedname`=?");
	$sqlchange1->bind_param("sss",$email,$new_password,$getusername);
	$sqlchange1->execute();
	$sqlchange1->close();

}
/*end of changing mail or password form database */


?>