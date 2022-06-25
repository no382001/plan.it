<?php
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'plan';
$DATABASE_PASS = 'password';
$DATABASE_NAME = 'data';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	exit(mysqli_connect_error());
}

$url = $_POST['url'];

$query = "SELECT version_id FROM calendars WHERE url={$url}";
$stmt = $con->prepare($query)->execute();
$stmt->bind_result($version_id);
$stmt->fetch();

$query = "SELECT title_id,json_id,notes_id FROM versions WHERE url={$url} AND version_id={$version_id};";
$stmt = $con->prepare($query)->execute();
$stmt->bind_result($title_id,$json_id,$notes_id);
$stmt->fetch();

$query = "SELECT title FROM title_table WHERE title_id={$title_id}";
$stmt = $con->prepare($query)->execute();
$stmt->bind_result($title);
$stmt->fetch();

$query = "SELECT json FROM json_table WHERE json_id={$json_id}";
$stmt = $con->prepare($query)->execute();
$stmt->bind_result($json);
$stmt->fetch();

$query = "SELECT notes FROM notes_table WHERE notes_id={$notes_id}";
$stmt = $con->prepare($query)->execute();
$stmt->bind_result($notes);
$stmt->fetch();

$stmt->close();

$_SESSION['query-result'] = [
							'url' => $url,
							'title' => $title,
							'json' => $json,
							'notes' => $notes,
							];

?>