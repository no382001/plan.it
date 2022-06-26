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
$query = "INSERT INTO titletable VALUES (?,?);";
//echo $query."\n";
if($stmt = $conn->prepare($query)){
    if(!$stmt->bind_param('ss', $title_hash,$_POST['title'])){
        echo "bind (" . $stmt->errno . ") " . $stmt->error;
    }
    if(!$stmt->execute()){
        echo "execute (" . $stmt->errno . ") " . $stmt->error;
    }
    $stmt->close();
}else{
    echo  $conn->errno .",". $conn->error;
}

$query = "INSERT INTO jsontable VALUES (?,?);";
//echo $query."\n";
if($stmt = $conn->prepare($query)){
    if(!$stmt->bind_param('ss', $json_hash,$_POST['json'])){
        echo "bind (" . $stmt->errno . ") " . $stmt->error;
    }
    if(!$stmt->execute()){
        echo "execute (" . $stmt->errno . ") " . $stmt->error;
    }
    $stmt->close();
}else{
    echo  $conn->errno .",". $conn->error;
}

$query = "INSERT INTO notestable VALUES (?,?);";
//echo $query."\n";
if($stmt = $conn->prepare($query)){
    if(!$stmt->bind_param('ss', $notes_hash,$_POST['notes'])){
        echo "bind (" . $stmt->errno . ") " . $stmt->error;
    }
    if(!$stmt->execute()){
        echo "execute (" . $stmt->errno . ") " . $stmt->error;
    }
    $stmt->close();
}else{
    echo  $conn->errno .",". $conn->error;
}


//create new key for the calendar entry
$url = keygen();
//create version entry
$query = "INSERT INTO versions (url,version_id,title_id,json_id,notes_id) VALUES (?,?,?,?,?);";
//echo $query."\n";
if($stmt = $conn->prepare($query)){
    $first = 0;
    if(!$stmt->bind_param('sisss', $url, $first, $title_hash, $json_hash, $notes_hash)){
        echo "bind (" . $stmt->errno . ") " . $stmt->error;
    }
    if(!$stmt->execute()){
        echo "execute (" . $stmt->errno . ") " . $stmt->error;
    }
    $stmt->close();
}else{
    echo  $conn->errno .",". $conn->error;
}

//create calendar entry 
$query = "INSERT INTO calendars VALUES (?,?,?);";
//echo $query."\n";
if($stmt = $conn->prepare($query)){
    $one = 1;
    if(!$stmt->bind_param('sii', $url, $one, $one)){
        echo "bind (" . $stmt->errno . ") " . $stmt->error;
    }
    if(!$stmt->execute()){
        echo "execute (" . $stmt->errno . ") " . $stmt->error;
    }
    $stmt->close();
}else{
    echo  "prepare ".$conn->errno .",". $conn->error;
}

$_SESSION['query-result'] = [
    'url' => $url,
    'title' => $_POST['title'],
    'json' => $_POST['json'],
    'notes' => $_POST['notes']
    ];

$conn->close();
?>