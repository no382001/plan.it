<?php 
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'plan';
$DATABASE_PASS = 'password';
$DATABASE_NAME = 'data';

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

$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
    exit(mysqli_connect_error());
}

// --first entry with url
//hash data
$title_hash = hash('ripemd160', $_POST['title']);
$json_hash = hash('ripemd160', $_POST['json']);
$notes_hash = hash('ripemd160', $_POST['notes']);

//create their table elements
$query = "INSERT INTO title_table VALUES ({$title_hash},{$_POST['title']});";
$stmt = $conn->prepare($query)->execute();
$query = "INSERT INTO json_table VALUES ({$json_hash},{$_POST['json']});";
$stmt = $conn->prepare($query)->execute();
$query = "INSERT INTO notes_table VALUES ({$notes_hash},{$_POST['notes']});";
$stmt = $conn->prepare($query)->execute();

//create new key for the calendar entry
$url = keygen();
//create version entry
$query = "INSERT INTO versions VALUES ({$url},1,{$title_hash},{$json_hash},{$notes_hash});";
$stmt = $conn->prepare($query)->execute();

//create calendar entry 
$query = "INSERT INTO calendars VALUES ({$url},1,1)";
$stmt = $conn->prepare($query)->execute();

$stmt->close();
$conn->close();

?>