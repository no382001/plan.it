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

$query = "SELECT version_id FROM calendars WHERE url={$_POST['url']};";
                            
$stmt = $conn->prepare($query)->execute();
$stmt->bind_result($version_id);
$stmt->fetch();

$query = "SELECT title_id, json_id, notes_id FROM calendars
                                            WHERE url={$_POST['url']}
                                            AND version_id={$version_id};";
$stmt = $conn->prepare($query)->execute();
$stmt->bind_result($title_hash,$json_hash,$notes_hash);
$stmt->fetch();

//if something is not the same commit a change
//and update variable
$new_title_hash = hash('ripemd160', $_POST['title']);
$new_json_hash = hash('ripemd160', $_POST['json']);
$new_notes_hash = hash('ripemd160', $_POST['notes']);

$changes = 0;
if($new_title_hash != $title_hash){
    $query = "INSERT INTO title_table VALUES ({$new_title_hash},{$_POST['title']});";
    $stmt = $conn->prepare($query)->execute();
    $title_hash = $new_title_hash;
    $changes += 1;
}
if($new_json_hash != $json_hash){
    $query = "INSERT INTO json_table VALUES ({$new_json_hash},{$_POST['json']});";
    $stmt = $conn->prepare($query)->execute();
    $json_hash = $new_json_hash;
    $changes += 1;
}
if($new_notes_hash != $notes_hash){
    $query = "INSERT INTO notes_table VALUES ({$new_notes_hash},{$_POST['notes']});";
    $stmt = $conn->prepare($query)->execute();
    $notes_hash = $new_notes_hash;
    $changes += 1;
}

if($changes > 0){
    //if there were changes
    $version_id += 1;
    $query = "INSERT INTO versions VALUES  ({$_POST['url']},
                                            {$version_id},
                                            {$title_hash},
                                            {$json_hash},
                                            {$notes_hash});";
    $stmt = $conn->prepare($query)->execute();

    $query = "UPDATE calendars SET  version_id={$version_id} WHERE url={$_POST['url']};";
    $stmt = $conn->prepare($query)->execute();

}

$stmt->close();
$conn->close();

?>