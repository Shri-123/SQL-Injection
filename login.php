<?php 
session_start(); 
include "db_conn.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$uname = validate($_POST['uname']);
	$pass = validate($_POST['password']);

	if (empty($uname)) {
		header("Location: index.php?error=User Name is required");
	    exit();
	}else if(empty($pass)){
        header("Location: index.php?error=Password is required");
	    exit();
	}else{
		$sql = "SELECT * FROM users WHERE user_name = '$uname' and password = '$pass'";
		//print($sql);

		$result = mysqli_query($conn, $sql);

		//USERNAME KNOWN PASSWORD UNKNOWN
		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			
            if ($row['user_name'] == $uname) {
            $_SESSION['user_name'] = $row['user_name'];
            	$_SESSION['name'] = $row['name'];
            	$_SESSION['id'] = $row['id'];
            	header("Location: home.php");
		    	exit();
            }else{
				header("Location: index.php?error=Incorect User name or password");
		        exit();
			}
		}else{
			header("Location: index.php?error=Incorect User name or password");
	        exit();
		}


		
		// //USER AND PASSWORD NAME NOT KNOWN
		// if (mysqli_num_rows($result) > 0) {
		// 	$row = mysqli_fetch_assoc($result);
			
        //     if (mysqli_num_rows($result) > 0) {
        //     $_SESSION['user_name'] = $row['user_name'];
        //     	$_SESSION['name'] = $row['name'];
        //     	$_SESSION['id'] = $row['id'];
        //     	header("Location: home.php");
		//     	exit();
        //     }else{
		// 		header("Location: index.php?error=Incorect User name or password");
		//         exit();
		// 	}
		// }else{
		// 	header("Location: index.php?error=Incorect User name or password");
	    //     exit();
		// }
		
		
	}
	
}else{
	header("Location: index.php");
	exit();
}