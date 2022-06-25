<?php
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'plan';
$DATABASE_PASS = 'password';
$DATABASE_NAME = 'data';

$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	exit(mysqli_connect_error());
}

$url = $_POST['url'];

$query = "SELECT version_id FROM calendars WHERE url=?";
if($stmt = $conn->prepare($query)){
	if(!$stmt->bind_param('s', $url)){
		echo "bind (" . $stmt->errno . ") " . $stmt->error;
	}
	if(!$stmt->execute()){
		echo "execute (" . $stmt->errno . ") " . $stmt->error;
	}
	$stmt->bind_result($version_id);
	$stmt->fetch();
	$stmt->close();
}else{
	echo  "prepare ".$conn->errno .",". $conn->error;
}

//this would probably be more efficient with inner join
$query = "SELECT title_id,json_id,notes_id FROM versions WHERE url=? AND version_id=?;";
if($stmt = $conn->prepare($query)){
	if(!$stmt->bind_param('si',$url,$version_id)){
		echo "bind (" . $stmt->errno . ") " . $stmt->error;
	}
	if(!$stmt->execute()){
		echo "execute (" . $stmt->errno . ") " . $stmt->error;
	}
	$stmt->bind_result($title_id,$json_id,$notes_id);
	$stmt->fetch();
	$stmt->close();
}else{
	echo  "prepare ".$conn->errno .",". $conn->error;
}

$query = "SELECT title FROM titletable WHERE title_id=?";
if($stmt = $conn->prepare($query)){
	if(!$stmt->bind_param('s',$title_id)){
		echo "bind (" . $stmt->errno . ") " . $stmt->error;
	}
	if(!$stmt->execute()){
		echo "execute (" . $stmt->errno . ") " . $stmt->error;
	}
	$stmt->bind_result($title);
	$stmt->fetch();
	$stmt->close();
}else{
	echo  "prepare ".$conn->errno .",". $conn->error;
}

$query = "SELECT json FROM jsontable WHERE json_id=?";
if($stmt = $conn->prepare($query)){
	if(!$stmt->bind_param('s',$json_id)){
		echo "bind (" . $stmt->errno . ") " . $stmt->error;
	}
	if(!$stmt->execute()){
		echo "execute (" . $stmt->errno . ") " . $stmt->error;
	}
	$stmt->bind_result($json);
	$stmt->fetch();
	$stmt->close();
}else{
	echo  "prepare ".$conn->errno .",". $conn->error;
}

$query = "SELECT notes FROM notestable WHERE notes_id=?";
if($stmt = $conn->prepare($query)){
	if(!$stmt->bind_param('s',$notes_id)){
		echo "bind (" . $stmt->errno . ") " . $stmt->error;
	}
	if(!$stmt->execute()){
		echo "execute (" . $stmt->errno . ") " . $stmt->error;
	}
	$stmt->bind_result($notes);
	$stmt->fetch();
	$stmt->close();
}else{
	echo  "prepare ".$conn->errno .",". $conn->error;
}

$_SESSION['query-result'] = [
    'url' => $url,
    'title' => $title,
    'json' => $json,
    'notes' => $notes
    ];


?>