<?php
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'plan';
$DATABASE_PASS = 'password';
$DATABASE_NAME = 'data';


$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
    exit('failed to connect to mysql: ' . mysqli_connect_error());
}

$stmt = $conn->prepare('UPDATE content SET title = ?, content = ? WHERE url = ?');

$stmt->bind_param('sss',$_POST['title'],$_POST['text'],$_SESSION['query-result']['url']);
$stmt->execute();

$stmt->close();

$conn->close();

$_SESSION['query-result']['title'] = $_POST['title'];
$_SESSION['query-result']['text'] = $_POST['text'];

header("Location: index.php");

?>