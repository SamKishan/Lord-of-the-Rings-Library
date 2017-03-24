<?php 
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

include_once('/var/www/html/hw6/hw6-lib.php');
connect($db);
include_once('/var/www/html/hw7/header.php');
switch($s){

	case 0:
	default:
	#echo "s is $s";
		echo "<html>";
		echo "<style>
			html {
			text-align:center;
				}
			table #t1 {
			text-align:center
			width:70%;
			margin-left:15%;
			margin-right:15%;
			body {
			background-image: url(\"bg.jpg\");
			}
			}
			</style>";
		echo "<title> TLEN 5841 Sampreet Kishan </title>";
		echo "<body background=\"bg.jpg\">";
	/*	echo"	<br>
			<font size=\"+6\"><i> The Lord Of The Rings Library</i> </font>
			<br>
			<br>
			<font size=\"+3\"><a href=/hw7/index.php?s=8> Character List </a></font> 
			<br>
			<br>
			<a href=/hw7/index.php?s=4><font size =\"+3\"> Add a character</font> </a> 
			<br>
			<br>
			<br>
			<br>
	*/
	echo"		<br><br><br>
			<center>
			<table id=\"t1\">
			<table border=\"1\">
			<tr>
			<th><font size = \"+2\" face=\"modern\">Story</font></th>
			</tr>";
	
			
		$query="SELECT storyid,story from stories";
		$result=mysqli_query($db,$query);
		#echo "<table border=\"1\">";
		while($row=mysqli_fetch_row($result)){

		echo "<tr><th> <a href=/hw7/index.php?sid=$row[0]&s=1> $row[1] </a></th></tr> ";
		#echo "Hiiiiii";
		#echo "</html>";
	}
		echo "</table>";
		echo "<center>";		
		echo"<br><br><br>";
		#echo "<a href=/hw6/index.php?s=4><font=\"+2\"> Add a character</font> </a> "; #o  "<a href=/hw6/index.php?s=4><font=\"+2\"> Add a character</font> </a> ";
		echo "</body>";	
		echo "</html>";
		break;

	case 18:
		echo "<html>
			username = $post_uname	
		</html>
		";
	case 1: 
		echo "<br>";
		echo "<html>";
		echo "<title> TLEN 5841 Sampreet Kishan </title>";
		
		echo "<body background=\"bg.jpg\">";
		echo "<center>";
		echo "<table align=\"right\" border=\"1\">
		                <table style=\"width\"=100%>
       
			  <tr>
                        <th> <font size=\"+2\">Title of the book </font></th>
                        </tr>";
		$sid=mysqli_real_escape_string($db,$sid);
		if($stmt= mysqli_prepare($db, "SELECT bookid,title from books where storyid=?")) 
		{
			mysqli_stmt_bind_param($stmt,"s",$sid);	
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt,$bid,$title);
				while(mysqli_stmt_fetch($stmt)) {

				$bid=htmlspecialchars($bid);
				$title=htmlspecialchars($title);
				echo "<tr><td><a href=/hw7/index.php?bid=$bid&s=2>$title</a></td></tr>";
				}
		mysqli_stmt_close($stmt);
		}
		echo "</table>";
		echo "</center>";
		echo "</body>";

					
		echo "</html>";


		break;
	
	case 2:
		#echo "<br>";
		echo "<html>";
		echo "<title> TLEN 5841 Sampreet Kishan </title>";	
		echo "<center>";
		echo "<body background=\"bg.jpg\">";
		
		#echo "<table><tr><th>Title</th><th>Name</th><th>Image</th></tr>";
		               echo "<table style=\"width\"=10%>
                <table border=\"1\">
                <tr>
                        <th><font size=\"+2\">  Title  </font> </th>
                        <th><font size=\"+2\">  Name  </font> </th>
                       <th><font size=\"+2\"> Image </font> </th>
			 </tr>";


		$bid=mysqli_real_escape_string($db,$bid);
		if($stmt=mysqli_prepare($db,"SELECT DISTINCT title,name,url,characters.characterid from books,characters,appears,pictures,stories where appears.bookid=books.bookid and appears.characterid=characters.characterid and pictures.characterid=characters.characterid and books.bookid=?"))
		{
			mysqli_stmt_bind_param($stmt,"s",$bid);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt,$title,$name,$url,$cid);
			while(mysqli_stmt_fetch($stmt))
			{
				$title=htmlspecialchars($title);
				$name=htmlspecialchars($name);
				$url=htmlspecialchars($url);
				$cid=htmlspecialchars($cid);
				echo "<tr><th>$title</th><th><a href=/hw7/index.php?s=3&cid=$cid>$name</th><th><img src=$url style=\"width:304px;height:228px\"></th></tr>";
			}
		}
		echo "</body>";
		echo "</center>";
		echo "</html>";
			break;
	case 3: 
		echo "<html>";
		echo "<title>TLEN 5841 Sampreet Kishan </title>";
		$cid=mysqli_real_escape_string($db,$cid);
		 echo " <center> 
			<body background=\"bg.jpg\">
                        <table style=\"width\"=10%>
			<table border=\"1\">
                        <tr>
                                <font size =\"+2\"><th>Name of Character</th><th> Title of Books</th> </font>
                        <tr>
                ";

		if($stmt=mysqli_prepare($db,"SELECT DISTINCT name,title,books.bookid from characters,books,appears where appears.bookid=books.bookid and characters.characterid=appears.characterid and characters.characterid=?"))
		{
			mysqli_stmt_bind_param($stmt,"s",$cid);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt,$name,$title,$bid);
			while(mysqli_stmt_fetch($stmt))
			{
				$name=htmlspecialchars($name);
				$title=htmlspecialchars($title);
				$bid=htmlspecialchars($bid);
				echo "<tr><th>$name </th><th><a href=/hw7/index.php?s=0> $title </th></tr>";
			}
			mysqli_stmt_close($stmt);
		}

	echo"</table>"; 	
	echo "</body>";
	echo "</center>";
	echo "</html>";
		break;
	
	case 5:
		echo "<html>
			<title> 5841 Sampreet Kishan </title>
		";
		echo "	<body background=\"bg.jpg\">
			<table border=\"1\">
			<tr>
			<th>
				Character  </th><th>Image </th></tr>
			";
		$query="SELECT DISTINCT (characters.name), pictures.url from pictures,characters where pictures.characterid=characters.characterid";
		$result=mysqli_query($db,$query);
		while($row=mysqli_fetch_row($result))
		{
			echo "<tr>
				<th>
				$row[0] </th><th><img src=$row[1]></th>";
		}
		echo "</table> </center></html>";

		break;
	}

?>
