<?php
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_NAME = 'data';
$DATABASE_USER = 'plan';
$DATABASE_PASS = 'password';
$CHARSET = 'utf8mb4';
$OPTIONS = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false
	];
$dsn = "mysql:host=$DATABASE_HOST;dbname=$DATABASE_NAME;charset=$CHARSET";
try{
    $pdo = new PDO($dsn, $DATABASE_USER, $DATABASE_PASS, $OPTIONS);
}catch(\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$url = $_POST['url'];

//set to initial number
//if post contains version
if(isset($_POST['version'])){
	$get_version = true;
}

// go about it normally as <a> was not pressed, normal query for the latest version
if(!$get_version){
	//get latest version number
	$query = "SELECT version_id FROM calendars WHERE url=:url";
	$stmt = $pdo->prepare($query);
	$stmt->execute([
		'url' => $url
		]);
	$version_id = $stmt->fetchColumn();
}else{
	//if is other than 1, i.e. a query has been made with the version control <a>
	$version_id = $_POST['version'];
}

//this would probably be more efficient with inner join
$query = "SELECT title_id, json_id, notes_id FROM versions WHERE url=:url AND version_id=:version_id;";
$stmt = $pdo->prepare($query);
$stmt->execute([
	'url' => $url,
	'version_id' => $version_id
	]);

$row = $stmt->fetch();
$title_id = $row['title_id'];
$json_id = $row['json_id'];
$notes_id = $row['notes_id'];

$query = "SELECT title FROM titletable WHERE title_id=:title_id";
$stmt = $pdo->prepare($query);
$stmt->execute([
	'title_id' => $title_id
	]);
$title = $stmt->fetchColumn();

$query = "SELECT json FROM jsontable WHERE json_id=:json_id";
$stmt = $pdo->prepare($query);
$stmt->execute([
	'json_id' => $json_id
	]);
$json = $stmt->fetchColumn();

$query = "SELECT notes FROM notestable WHERE notes_id=:notes_id";
$stmt = $pdo->prepare($query);
$stmt->execute([
	'notes_id' => $notes_id
	]);
$notes = $stmt->fetchColumn();

$query = "SELECT COUNT(id) FROM versions WHERE url=:url";
$stmt = $pdo->prepare($query);
$stmt->execute([
	'url' => $url
	]);
$no_versions = $stmt->fetchColumn();

$_SESSION['query-result'] = [
    'url' => $url,
    'title' => $title,
    'json' => $json,
    'notes' => $notes,
	'version' => $version_id,
	'no_versions' => $no_versions
    ];
?>