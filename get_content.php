<?php
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'plan';
$DATABASE_PASS = 'password';
$DATABASE_NAME = 'data';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	exit('failed to connect to mysql: ' . mysqli_connect_error());
}

if ($_SESSION["try-url"] != null){
	$_url = $_SESSION["try-url"];
}else{
	$_url = $_POST['url'];
}

if ($stmt = $con->prepare('SELECT url, title, content FROM content WHERE url = ?')) {
	$stmt->bind_param('s', $_url);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
		$stmt->bind_result($url,$title,$text);
		$stmt->fetch();
		} else {
			echo 'no matches';
/*			$_SESSION["try-url"] = null;
			header("Location: index.php");*/
		}

	$stmt->close();
	$_SESSION["try-url"] = null;
	$_SESSION['query-result'] = [
							    'url' => $url,
							    'title' => $title,
							    'text' => $text,
							    ];
	header("Location: index.php");


	} else {
		echo 'query did not pass prepare()';
}

	
?>