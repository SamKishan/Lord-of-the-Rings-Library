<?php 
session_start();
session_regenerate_id();
isset($_REQUEST['s'])? $s=strip_tags($_REQUEST['s']):$s="";
isset($_REQUEST['sid'])? $sid=strip_tags($_REQUEST['sid']):$sid="";
isset($_REQUEST['bid'])? $bid=strip_tags($_REQUEST['bid']):$bid="";
isset($_REQUEST['cid'])? $cid=strip_tags($_REQUEST['cid']):$cid="";
isset($_REQUEST['name'])? $name=strip_tags($_REQUEST['name']):$name="";
isset($_REQUEST['race'])? $race=strip_tags($_REQUEST['race']):$race="";
isset($_REQUEST['side'])? $side=strip_tags($_REQUEST['side']):$side="";
isset($_REQUEST['url']) ? $url=strip_tags($_REQUEST['url']):$url="";
isset($_REQUEST['options']) ? $options=strip_tags($_REQUEST['options']):$options="";
isset($_REQUEST['post_uname'])? $post_uname=strip_tags($_REQUEST['post_uname']):$post_uname="";

isset($_REQUEST['post_upass'])? $post_upass=strip_tags($_REQUEST['post_upass']):$post_upass="";
isset($_REQUEST['post_uemail'])? $post_uemail=strip_tags($_REQUEST['post_uemail']):$post_uemail="";
isset($_REQUEST['userid'])? $userid=strip_tags($_REQUEST['userid']):$userid="";
isset($_REQUEST['new_uname'])? $new_uname=strip_tags($_REQUEST['new_uname']):$new_uname="";
isset($_REQUEST['new_pword'])? $new_pword=strip_tags($_REQUEST['new_pword']):$new_pword="";

isset($_REQUEST['new_email'])? $new_email=strip_tags($_REQUEST['new_email']):$new_email="";
isset($_REQUEST['edit_user'])? $edit_user=strip_tags($_REQUEST['edit_user']):$edit_user="";
isset($_REQUEST['usid'])? $usid=strip_tags($_REQUEST['usid']):$usid="";

isset($_REQUEST['edit_pass'])? $edit_pass=strip_tags($_REQUEST['edit_pass']):$edit_pass="";

function int_check($a){
	if(is_int($a)==0)
	{
		print("Passed variable has to be an integer");
	}
	
}

if(is_null($s)!=NULL){
	int_check($s);
}

if(is_null($sid)!=NULL){
	int_check($sid);
}
if(is_null($bid)!=NULL){
	int_check($bid);
}
if(is_null($cid)!=NULL){
	int_check($cid);
}
include_once('/var/www/html/hw8/header.php');
include_once('/var/www/html/hw8/hw8-lib.php');
connect($db);
if(!isset($_SESSION['authenticated']))
{
	
	authenticate($db,$post_uname,$post_upass);
	checkauth();
}
#checkauth();
if(session_id()!="")

{
$userid=$_SESSION['userid'];
}
echo "<body background=\"bg.jpg\">";
#echo " <br> s is $s <br>";
switch($s){
	
	case 4:
	default:
		
		$s=5;
		echo "<html> <title> TLEN 5841 Sampreet Kishan </title></html>";
		echo "<center><body background=\"bg.jpg\">";
		echo "<form action=\"/hw8/add.php\" method=\"post\">
		Enter Name:	<input type=\"text\" name=\"name\">
		<br>
		Enter race:
		<input type=\"text\" name=\"race\">
		<br>
		Side:
		
		<br>
		
				<select name=\"side\" id=\"side\">
                       			<option value=\"\">Select a side</option>
                        		<option value=1>Good</option>
                        		<option value=2>Bad</option>
                		</select>

		<input type=\"hidden\" name=\"userid\" value=$userid>
		<input type=\"hidden\" name=\"s\" value=5>
		<br>
		<input type=\"submit\" name=\"submit\" value=\"Submit\">
		";
		
		if($userid==1){
		echo "<br><br><font size=\"+2\"><a href=\"/hw8/add.php?s=90&userid=$userid\"> Add new users? </a></font>"; 	
		}	
		echo "<br><font size=\"+2\"><a href=\"/hw8/add.php?s=99\"> Logout </a></font>";
		echo "<br> <font size=\"+2\"><a href=\"/hw8/add.php?s=93\"> List of users </a></font>";	
		echo "<br> <font size=\"+2\"><a href=\"/hw8/add.php?s=102\"> Login attempts </a></font>";
		echo "</body> </center>";
		echo "</html>";
		break;
	case 5:
		echo "<html>";
		echo "<body background=\"bg.jpg\">";
		if($side==1)
		{
			$side="Good";
		}
		else 
		{
			$side="Bad";
		}
		$name=mysqli_real_escape_string($db,$name);
		$race=mysqli_real_escape_string($db,$race);
		$side=mysqli_real_escape_string($db,$side);
		if($stmt=mysqli_prepare($db,"INSERT INTO characters set characterid='',name=?,race=?,side=?"))
		{
			mysqli_stmt_bind_param($stmt,"sss",$name,$race,$side);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}	
		else
		{
			echo "Error with query"	;
		}
		 echo "<center>
			<form action=\"/hw8/add.php\" method=\"post\">
                     <font=\"+3\">   Enter the url for the image:<br></font>
                        <input type=\"text\" name=\"url\">
                        <br>
                        <input type=\"hidden\" name=\"s\" value=6>
                        <br>
                        <input type=\"hidden\" name=\"cid\" value=$cid>
                        <input type=\"submit\" name=\"submit\" value=\"Submit\">
                        </center>
			";	
		echo "</body>";
		echo "</html>";
		break;	
	case 6: 
		echo "<html><title>TLEN 5841 Sampreet Kishan</title>";

				
		echo "<body background=\"bg.jpg\">";
		if($stmt=mysqli_prepare($db,"SELECT characters.characterid from characters ORDER BY characterid DESC LIMIT 1;"))
		{
			mysqli_stmt_bind_param($stmt);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt,$cid);
			echo "<br>";
			while(mysqli_stmt_fetch($stmt))
			{
		
				echo "<br>";
			}
		}
		$cid=mysqli_real_escape_string($db,$cid);
		$url=mysqli_real_escape_string($db,$url);
		if($stmt=mysqli_prepare($db,"INSERT INTO pictures set pictureid='', url=?, characterid=?"))
		{
			mysqli_stmt_bind_param($stmt,"ss",$url,$cid);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
		
		else
		{
			echo "Error with query";
		}
		echo "
		<center>Please choose a book that you think the character appears in</center> <br>
		<center>	
	<form action=/hw8/add.php method=\"post\">
			<select name=\"options\" id=\"options\">
                
       			<option value=\"\">Select an option..</option>";
		
		if($stmt=mysqli_prepare($db,"SELECT DISTINCT books.bookid,books.title from books where books.bookid NOT IN (select bookid from appears where appears.characterid=$cid)"))
		{
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt,$bid,$title);
			while(mysqli_stmt_fetch($stmt))
			{
					echo "<option value=$bid>$title </option>";
	
			}
			mysqli_stmt_close($stmt);
		}
		
		echo"
                </select>
		
		<input type=\"hidden\" name=\"s\" value=7>        
		<input type=\"hidden\" name=\"cid\" value=$cid>
		<input type=\"submit\" value=\"submit\">
		</center>
			</form>
		";
		echo "</body>";
		echo "</html>";
		break;
	case 7:
		echo "<html><title>TLEN 5841 Sampreet Kishan </title>";
		echo "<center><body backgroud=\"bg.jpg\">";
		if($stmt=mysqli_prepare($db,"INSERT INTO appears SET appearsid='',bookid=?,characterid=?"))
		{
			mysqli_stmt_bind_param($stmt,"dd",$options,$cid);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
		echo "Wanna add the character in more books? <br> <a href=/hw8/add.php?s=6>YES</a> <br> <br> <font=\"2\"><a href=/hw8/add.php?s=0>Back to main menu</font>";	
		echo "</body>";
		echo "</center>";
		echo "</html>";
		break;

	case 8:
			echo "<html><title>TLEN 5841 Sampreet Kishan</title>";
			echo "<center><body background=\"bg.jpg\">";
			echo "<table style=\"width\"=10%>	
			<table border=\"1\">	
				<tr> <th> Name </th><th> Image </th></tr>
";
			$query="select distinct (characters.name),pictures.url,characters.characterid from characters,pictures where characters.characterid=pictures.characterid GROUP BY(characters.name) ; ";
			$result=mysqli_query($db,$query);
			while($row=mysqli_fetch_row($result))
			{
				echo "<tr><th><a href=/hw8/index.php?s=3&cid=$row[2]>$row[0]</th><th><img src=$row[1] style=\"width:304px;height:228px;\">";
			}
			echo"</table>";
			echo "</body>";
			echo "</center>";
			echo "</html>";

		break;

	case 90:
		echo "<html><title>TLEN 5841 Sampreet Kishan</title>
			<center><body background=\"bg.jpg\">";	
		echo "<center><br><font size=\"+3\"> Page to add new users.</font><br><br><br> ";
		if($userid==1)		
		{
			echo "<br> <center> Yes you are the admin </br></center>";
			echo " <form method=\"post\" action=\"/hw8/add.php\">
				Username:
				<input type=\"text\" name=\"new_uname\">
				<br> Password:
				<input type=\"password\" name=\"new_pword\">
				<br>
				Email id:
				<input type=\"text\" name=\"new_email\">
			
				<input type=\"hidden\" name=\"s\" value=91>
				<br>
				<input type=\"Submit\" name=\"Submit\" value=\"Submit\">
				</form>
				";
			
				
			
		}
		else if($userid!=1)
		{
			echo "<font size=\"+3\"> Only the administrator can add new users. Sorry :( </font></center>";
		}
		echo "</html>";
		break;	
	
	case 91:
		echo "<html><title>TLEN 8541 Sampreet Kishan </title>
                        <center><body background=\"bg.jpg\">";
		$salt=rand();
		echo "<br> salt is : $salt <br>"; 
		$new_uname=mysqli_real_escape_string($db,$new_uname);
		$new_pword=mysqli_real_escape_string($db,$new_pword);
		$new_email=mysqli_real_escape_string($db,$new_email);
		$new_pword=hash('sha256',$new_pword.$salt);
		if($stmt=mysqli_prepare($db,"INSERT INTO users set username=?,password=?,salt=?,email=?"))
		{
			mysqli_stmt_bind_param($stmt,"ssss",$new_uname,$new_pword,$salt,$new_email);  
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}

		else
		{
			echo " Error with query";
		}


		echo "<br> Username is : $new_uname <br>";
		
		break;
	case 99:
		if(session_id()!="")
		{	session_destroy();	}
		echo "<center><font size=\"+2\">Logged out</font></center>";
		header("Location :/hw8/login.php");
		break;
	case 93: 
		if($userid==1){
		echo "<html><font size=\"+2\">  <center> <table border=\"1\">
			<tr><th><font size=\"+2\"> Users </font> </th></tr>";
		$query="select username from users order by userid";
		$result=mysqli_query($db,$query);
		while($row=mysqli_fetch_row($result))
		{
			echo "<tr><th>$row[0]</th></tr>";
			
		}
		echo "</table>";
		echo "<br> <a href=\"/hw8/add.php?s=94\">Update the password of a user </a> ";
		echo "</center> </font> </html>";
		}
		else
		{
			echo "<html><center><font size=\"+2\">Only the admin user can view all the users in the application </font></center></html> ";
			echo "<br>  <html><center><font size=\"+2\"> Have a nice day  </font></center></html> ";
		}

		break;
	case 94:
		
		if($userid==1){
	
                $query="select userid,username from users order by userid";
                $result=mysqli_query($db,$query);
	         echo "<center><form method=\"post\" id=\"names\" action=\"/hw8/add.php\">";
		echo "<input type=\"hidden\" name=\"s\" value=95>";
		echo "
			<br> Enter the name of the user : 
			<input type=\"text\" name=\"edit_user\">	
			<input type=\"Submit\" name=\"Submit\" value=\"Submit\">
			";	
		echo "</form></center>";
		}
		else
		{	
			echo "You should not be on this page";
		}
		break;
	case 95:
		if($userid==1)
		{
			$edit_user=mysqli_real_escape_string($db,$edit_user);
			$usid="";
			echo "User select is : $edit_user <br>";
			if($stmt=mysqli_prepare($db,"SELECT userid from users where username=?"))
			{
				echo "<br>in the if construct<br>";
				mysqli_stmt_bind_param($stmt,"s",$edit_user);
				mysqli_stmt_execute($stmt);
				mysqli_Stmt_bind_result($stmt,$usid);
				while(mysqli_stmt_fetch($stmt))
				{
					$usid=$usid;
				}
				
				mysqli_stmt_close($stmt);
			echo "Selected<br>";		
			}
			if($usid!="" and $usid!=1)
			{
				echo "<center> <form method=\"post\" action=\"/hw8/add.php\">
					<br>
					Enter new password: 
					
					<input type=\"text\" name=\"edit_pass\">
					<br>
					
					<input type=\"hidden\" name=\"s\" value=96>
					<input type=\"hidden\" name=\"usid\" value=$usid>
					<input type=\"Submit\" name=\"Submit\" value=\"Submit\">
					";
			}
			
			else
			{
				echo "<center><font size=\"+2\">You've entered an incorrect user </font></center>";
			}									
		}		
		else{
			echo "You should not be on the page";
		}
		break;
	case 96:
		echo "<html>";
		$edit_pass=mysqli_real_escape_string($db,$edit_pass);
		$usid=mysqli_real_escape_string($db,$usid);
		$new_salt=rand();
		$edit_pass=hash('sha256',$edit_pass.$new_salt);
		if($stmt=mysqli_prepare($db,"UPDATE users set password=?,salt=? where userid=?"))
		{
			mysqli_stmt_bind_param($stmt,"sss",$edit_pass,$new_salt,$usid);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);	
		} 	
		echo "<center> password of user with user id $usid has been changed</center></html> ";
		break;
	

	case 102:
		echo "<html><title> TLEN 5841 Sampreet Kishan </title> <body><center>";
		$query="SELECT user,ip,date,action from login";
		$result=mysqli_query($db,$query);
		echo "<table border=\"1\"><tr><font size=\"+2\"> <th>User </th><th> IP address </th><th>Time </th><th> Login fail or pass </th></font> </tr>";
		while($row=mysqli_fetch_row($result))
		{
			echo "<tr><th> $row[0] </th><th>$row[1]</th><th>$row[2]</th><th>$row[3]</th></tr>";
		}
		echo "</table></center></body></html>";
		break;

	}		






?>
