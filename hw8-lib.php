<?php
function connect(&$db) 
{
                $mycnf="/etc/hw5-mysql.conf";
		if(!file_exists($mycnf))
		{
                        echo "ERROR: DB config file not: $mycnf";
                        exit;
                }
        $mysql_ini_array=parse_ini_file($mycnf);
        $db_host=$mysql_ini_array["host"];
        $db_user=$mysql_ini_array["user"];
        $db_pass=$mysql_ini_array["pass"];
        $db_port=$mysql_ini_array["port"];
        $db_name=$mysql_ini_array["dbName"];
        $db=mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);
	if(!$db) {
                print " Error Connecting to DB: ".mysqli_connect_error();
		print " <br>Try again later! :D";

                exit;
        } 
}


function authenticate($db,$postuser,$postpass)
{

		$_SESSION['ip']=$_SERVER['REMOTE_ADDR'];
		$_SESSION['HTTP_USER_AGENT']=md5($_SERVER['SERVER_ADDR'].$_SERVER['HTTP_USER_AGENT']);
		$_SESSION['created']=time();
		$test=$_SESSION['ip'];	
		$query="SELECT count(ip),MAX(loginid)  FROM login WHERE date > (DATE_SUB(NOW(),INTERVAL 1 HOUR)) and action='fail'";
		$whitelist=array("198.18.3.206","121.138.65.219","191.18.6.2");
		$list_check=0;
		foreach($whitelist as $wl)
		{
			$wl=(string)$wl;
			$io=$test;
			if($wl==$io)
			{
				$list_check=1;
				break;
			}

		}	
		/*$white_query="SELECT * FROM whitelist where ip=$test";
		$result_2=mysqli_query($db,$white_query);
		if(mysqli_num_rows($result_2)!=0)
		{
			$list_check=1;
		}*/
		$result=mysqli_query($db,$query);
		while($row=mysqli_fetch_row($result))
		{	
			if($row[0]>=5 and $list_check==0) 
			{		
				header("Location:/hw8/login.php");
			}

		}
		$query=("select userid,email,password,salt from users where username=?");
        	if($stmt=mysqli_prepare($db,$query))
        	{		
                	mysqli_stmt_bind_param($stmt,"s",$postuser);
                	mysqli_stmt_execute($stmt);
                	mysqli_stmt_bind_result($stmt,$userid,$email,$password,$salt);
                	while(mysqli_stmt_fetch($stmt))
                	{
                        	$userid=$userid;
                       		$email=$email;
                        	$password=$password;
                        	$salt=$salt;
                        }
                	mysqli_stmt_close($stmt);
        	}
		
		$epass=hash('sha256',$postpass.$salt);

		$check="";
		if($epass==$password)
		{
			echo "epass : $epass";
			echo "<br>password : $password";
			session_regenerate_id();
			$ip=$_SESSION['ip'];
			echo "<br>ip is $ip <br>";
			echo "<br> user is $postuser";
			$tim=$_SESSION['created'];
			echo "<br>time is $tim";	
			$action="pass";
			$tim=time();
			if($stmt=mysqli_prepare($db,"INSERT into login set loginid='',ip=?,user=?, action=?, date=now()"))
			{
				mysqli_stmt_bind_param($stmt,"sss",$ip,$postuser,$action) ;
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);

			}
			$loginid="";
			if($stmt=mysqli_prepare($db,"SELECT MAX(loginid) FROM login"))
			{
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt,$loginid);
				while(mysqli_stmt_fetch($stmt))
				{
					$loginid=$loginid;
				}

			}		

			$deleteid=$loginid - 1;
			$fail="fail";
			if($stmt=mysqli_prepare($db,"DELETE from login where loginid=? AND action=?"))
			{
				mysqli_stmt_bind_param($stmt,"ss",$deleteid,$fail);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
				
			}




			$_SESSION['userid']=$userid;
			$_SESSION['authenticated']="yes";
			$_SESSION['email']=$email;
			$_SESSION['ip']=$_SERVER['REMOTE_ADDR'];
		}

		else
		{	
			echo "epass: $epass";
			echo "<br> password: $password";
			echo "Failed to login";
	                $action="fail";
			$check="fail";
			$ip=$_SESSION['ip'];
			$tim=time();
                        echo "<br>time is $tim ";
			#if($postuser!=""){

			if($stmt=mysqli_prepare($db,"INSERT into login set loginid='',ip=?,user=?, action=?, date=now()"))
			{

                        	mysqli_stmt_bind_param($stmt,"sss",$ip,$postuser,$action) ;
                        	mysqli_stmt_execute($stmt);
                        	mysqli_stmt_close($stmt);

			}
			error_log("**ERROR** :Tolkien App has failed login from $ip",0);
			logout();
		}
		#}
			
	
}

function logout()
{
	if(session_id()!="")
		{	session_destroy();	}
	header("Location: /hw8/login.php");
	
}




function checkauth()
{

	# HTTP user agent is not working :(
	if(isset($_SESSION['HTTP_USER_AGENT']))
	{
		if($_SESSION['HTTP_USER_AGENT']!=md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']))
		{
			echo "<br> 11 <br>";
	#		logout();
		}
	}
	else
	{
			echo "<br> 22 <br>";
		logout();
	}

	if(isset($_SESSION['ip']))
	{
		if($_SESSION['ip']!=$_SERVER['REMOTE_ADDR'])
		{
			echo "<br> 33 <br>";
				logout();
		}
		
	}
	else
	{	logout();	
		echo "<br> 44 <br>";
	}

	if(isset($_SESSION['created']))
	{
		if(time() - $_SESSION['created'] > 1800)
		{
			logout();
			echo "<br> 55 <br>";
		}
	}
	else
	{
		logout();	
		echo "<br> 66 <br>";
	}

	if("POST" == $_SERVER['REQUEST_METHOD'])
	{
			if(isset($_SERVER['HTTP_ORIGIN']))
			{
				if($_SERVER['HTTP_ORIGIN']!="https://100.66.1.18")
				{ 
			logout();
			
				echo "<br> 77 <br>";
	}
				
			}
	
			else
			{
				logout();	
				echo "<br> 88 <br>";
			}		
	}
}
?>

