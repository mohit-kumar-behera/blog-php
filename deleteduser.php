<?php

include 'postcopysqlconfig.php';

$id=$_POST['id'];

$sqlgetinfo=$conn->prepare("SELECT * FROM `postcopyuserleft` WHERE `id`=?");
$sqlgetinfo->bind_param("s",$id);
$sqlgetinfo->execute();
$sqlgetinfo->store_result();
$sqlgetinfo->bind_result($getuserid,$getusername,$getuseremail,$getuserpassword,$getuserreason,$getusertime,$getuserdate,$getusercontact);
$sqlgetinfo->fetch();

$databasetime=$getusertime;
$time=date("h:i:s a",strtotime($databasetime));
$databasedate=$getuserdate;
$date=date("d-m-Y",strtotime($databasedate));

echo "<div class='card'><div class='card-body border-rounded' style='background:aquamarine'><div class='card-title'><h4 style='font-family:'Chelsea Market',cursive;color:#5a167c'><span style='font-size:28px;color:#41ba93'>I</span>n<span style='color:blue'>f</span>o<span style='color:#fc0c90'>r</span>ma<span style='color:#d1d10a'>t</span>io<span style='color:darkgreen'>n</span></h4></div><div class='card-text' style='font-family:calibri'><p><b style='color:#005c6b'>Id : </b><span style='color:#756969'>".$getuserid."</span></p><p><b style='color:#005c6b'>Name : </b><span style='color:#756969'>".$getusername."</span></p><p><b style='color:#005c6b'>Email : </b><span style='color:#756969'>".$getuseremail."</span></p><p><b style='color:#005c6b'>Contact Number : </b><span style='color:#756969'>".$getusercontact."</span></p><p><b style='color:#005c6b'>Left Time : </b><span style='color:#756969'>".$time."</span></p><p><b style='color:#005c6b'>Left Date : </b><span style='color:#756969'>".$date."</span></p>";

?>