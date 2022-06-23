<?php 
session_start();

function keygen()
{
    $chars = "abcdefghijklmnopqrstuvwxyz";
    $chars .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $chars .= "0123456789";
    while (1) {
        $key = '';
        srand((double) microtime() * 1000000);
        for ($i = 0; $i < 8; $i++) {
            $key .= substr($chars, (rand() % (strlen($chars))), 1);
        }
        break;
    }
    return $key;
}

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'plan';
$DATABASE_PASS = 'password';
$DATABASE_NAME = 'data';

$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
    exit('failed to connect to mysql: ' . mysqli_connect_error());
}


$url = keygen();

$stmt = $conn->prepare('INSERT INTO content (`url`,`title`,`json`,`notes`) VALUES (?,?,?,?)');

$stmt->bind_param('ssss', $url, $_POST['title'], $_POST['json'], $_POST['notes']);
$stmt->execute();

$stmt->close();
$conn->close();

$_SESSION['query-result'] = [
                            'url' => $url,
                            'title' => $_POST['title'],
                            'json' => $_POST['json'],
                            'notes' => $_POST['notes'],
                            ];

echo $url;


?>