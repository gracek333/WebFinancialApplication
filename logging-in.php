<?php
	session_start();
  
	if((!isset($_POST['email'])) || (!isset($_POST['password'])))
	{
		header('Location:log-in.php');
		exit();
	}

    require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
	try
	{
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if($connection->connect_errno!=0)
		{
			throw new Exception(mysqli_connect_errno());
		}
		else
		{
			$login = $_POST['email'];
			$password = $_POST['password'];
			
			$login = htmlentities($login, ENT_QUOTES, "UTF-8");
			
			if(!($result = $connection->query(sprintf("SELECT * FROM users WHERE email='%s'", mysqli_real_escape_string($connection,$login)))))
			{
				throw new Exception($connection->error);
			}
			
			$how_many_users = $result->num_rows;
			if($how_many_users>0)
			{
				$row = $result->fetch_assoc();  
				
				if (password_verify($password, $row['password']))
				{
					$_SESSION['loggedIn'] = true;  
					$_SESSION['id'] = $row['id'];
					$_SESSION['name'] = $row['username'];
					
					unset($_SESSION['error_log_in']);
					$result->free_result();
					header('Location: main-menu.php');
				}
				else
				{
					$_SESSION['error_log_in']="Nieprawidłowy email lub hasło!";
					header('Location: log-in.php');
				}
			}
			else
			{
				$_SESSION['error_log_in']="Nieprawidłowy email lub hasło!";
				header('Location: log-in.php');
			}
			$connection->close();
		}
	}
	catch(Exception $serverError)
	{
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
		echo '<br/>Informacja developerska: '.$serverError;
	}
?>

