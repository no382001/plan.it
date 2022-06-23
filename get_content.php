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

if ($stmt = $con->prepare('SELECT url, title, json, notes FROM content WHERE url = ?')) {
	$stmt->bind_param('s', $_POST['url']);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
		$stmt->bind_result($url,$title,$json,$notes);
		$stmt->fetch();
		} else {
			echo 'no matches';
		}

	$stmt->close();
	$_SESSION['query-result'] = [
							    'url' => $url,
							    'title' => $title,
							    'json' => $json,
							    'notes' => $notes,
							    ];
	header("Location: index.php");
	} else {
		echo 'query did not pass prepare()';
}
?>