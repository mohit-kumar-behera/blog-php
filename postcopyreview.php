
<!DOCTYPE html>
<html>
<title>Review</title>
<head>
	<meta link-colorarset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Modak&display=swap" rel="stylesheet">


	<style type="text/css">
		body{
    /*background:linear-gradient(to left,#D3CCE3,#E9E4F0);*/
    background:linear-gradient(to left,#efede6,#EAEAEA,#F2F2F2,#d3d1c2);
   }
    /*styling the scroll bar */

    ::-webkit-scrollbar
    {
      width:3px;
    }
  
    ::-webkit-scrollbar-thumb
    {
      background:#FFCC00;
      border-radius:4px;
    }
    ::-webkit-scrollbar-thumb:hover
    {
      background:red;
    }
    /*end of styling scroll bar */
    #brandname
    {
      background:linear-gradient(to left,#8E2DE2,#4A00E0);
      font-family:'Modak',cursive;
      font-size:300%;
      text-shadow:2px 3px red,-3px -2px orange;
      color:#efe3ed;
      letter-spacing: 3px;
      height:88px;
    }
		
	</style>


</head>
<body>

	<div class="jumbotron-fluid" id="brandname">
      <div class="container p-2 ml-1" id="brandcontainer">
        <p class="display-4 ">PoStCoPy</p>
      </div><!--conatiner-->
    </div><!--jumobtron-->


    <div class="container mt-3" style='font-family: calibri'>
    <?php

    	include "config.php";
    	$sqlgetlist="SELECT * FROM `postcopyuserleft` ORDER BY date DESC,time DESC";
    	$listresult=mysqli_query($con,$sqlgetlist);
    	echo "<table class='table table-bordered table-striped'>";
    	echo "<thead class='thead-dark'><tr><th>Name</th><th>Reason</th><th>More</th></thead>";
    	echo "<tbody>";
    	while($listrow=mysqli_fetch_array($listresult))
    	{
    		$databasetime=$listrow['time'];
			$databasedate=$listrow['date'];
			$showposttime=date("H:i ",strtotime($databasetime));
			$showpostdate=date("d-m-Y ",strtotime($databasedate));
			$id=$listrow['id'];
			
			echo "<tr>";

			echo "<td>".$listrow['username']."</td><td>".$listrow['reason']."</td><td><button value='".$listrow['id']."' id='aboutbutton' class='btn btn-warning btn-block'>About</button></td>";

			echo "</tr>";

			
    	} 
    	echo "</tbody>";
    	echo "</table>";
    ?>
	</div><!--container-->

	<!--script for info about the user -->
	<script>
		$(function(){
			$(".btn").click(function(){
				var id=$(this).val();
				$.ajax({
					url:'deleteduser.php',
					type:'post',
					data:{id:id},
					success:function(data){
						$("#aboutcontent").html(data);
						$("#aboutmodal").modal('show');
					}
				});
			});
		});
	</script>

	<div class="modal fade" id="aboutmodal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-info text-light">
					<h1 style='font-size:25px' class='lead'>About</h1>
					<button class='close' data-dismiss="modal" style='height:69.4px;background:powderblue'>&times;</button>
				</div><!--modal header-->
				<div class="modal-body" id='aboutcontent'>

				  <!--content-->

				</div><!--modal body-->
				<div class="modal-footer" style='height:33px;background:lightgrey;'>
					<small class=" font-italic float-right" style=';position:relative;top:-12px;color:grey'>@PoStCoPy</small>
				</div><!--modal footer-->
			</div><!--mdoal content-->
		</div><!--mdoal dailog-->
	</div><!--modal-->

</body>
</html>