<?php 
	include "config.php";
	if (isset($_GET['updatestatus']))
	{
		$SOID = $_GET["updatestatus"];
		mysqli_query($connection, "UPDATE stockopname SET cek = 'OK'
			WHERE SOID = '$SOID' AND cek = 'UNCHECKED'");
		echo "<script>document.location='index.php'</script>";
	}
?>