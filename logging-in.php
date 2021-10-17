<?php

  session_start();
  
  if((!isset($_POST['email'])) || (!isset($_POST['password'])))
  {
	header('Location:log-in.php');
	exit();
  }

  require_once "connect.php";
  
  $connection = @new mysqli($host, $db_user, $db_password, $db_name);
  
  if($connection->connect_errno!=0)
  {
	echo "Error: ".$connection->connect_errno;
  }
  else
  {
	$login = $_POST['email'];
    $password = $_POST['password'];
	
	$login = htmlentities($login, ENT_QUOTES, "UTF-8");
	$password = htmlentities($password, ENT_QUOTES, "UTF-8");
	
	$sql = "SELECT * FROM users WHERE email='$login' AND password='$password'";
	
	if($result = @$connection->query(
	sprintf("SELECT * FROM users WHERE email='%s' AND password='%s'", 
	mysqli_real_escape_string($connection,$login), 
	mysqli_real_escape_string($connection,$password))))
	{
	  $how_many_users = $result->num_rows;
	  if($how_many_users>0)
	  {
		  
		$_SESSION['loggedIn'] = true;  
		  
		$row = $result->fetch_assoc();
		$_SESSION['id'] = $row['id'];
		$_SESSION['name'] = $row['username'];
		
		unset($_SESSION['error']);
		
		$result->free_result();
		header('Location: main-menu.php');
		
	  }
	  else
	  {
		$_SESSION['error']='<span style="color:red">Nieprawidłowy email lub hasło!</span>';
		header('Location: log-in.php');
	  }
	}
	
	$connection->close();
  }
  
?>

