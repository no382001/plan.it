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
$title = $_POST['title'];
$json = $_POST['json'];
$notes = $_POST['notes'];

//get version id for url
$query = "SELECT version_id FROM calendars WHERE url=?;";
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

echo $url.":".$version_id."\n";

//get hashes for content
$query = "SELECT title_id, json_id, notes_id FROM versions
                                            WHERE url=?
                                            AND version_id=?;";
if($stmt = $conn->prepare($query)){
    if(!$stmt->bind_param('si', $url,$version_id)){
        echo "bind (" . $stmt->errno . ") " . $stmt->error;
    }
    if(!$stmt->execute()){
        echo "execute (" . $stmt->errno . ") " . $stmt->error;
    }
    $stmt->bind_result($title_hash,$json_hash,$notes_hash);
    $stmt->fetch();
    $stmt->close();
}else{
    echo  "prepare ".$conn->errno .",". $conn->error;
}

//if something is not the same commit a change
$new_title_hash = hash('ripemd160', $_POST['title']);
$new_json_hash = hash('ripemd160', $_POST['json']);
$new_notes_hash = hash('ripemd160', $_POST['notes']);

$changes = 0;
if($new_title_hash != $title_hash){
    $query = "INSERT INTO titletable VALUES (?,?);";
    if($stmt = $conn->prepare($query)){
        if(!$stmt->bind_param('ss', $new_title_hash,$_POST['title'])){
            echo "bind (" . $stmt->errno . ") " . $stmt->error;
        }
        if(!$stmt->execute()){
            if($stmt->errno == 1062){
                echo "\nduplocate (" . $stmt->errno . ") ";
                $changes -= 1;
            }
        }
        $stmt->close();
    }else{
        echo  "prepare ".$conn->errno .",". $conn->error;
    }
    $title_hash = $new_title_hash;
    $changes += 1;
}

echo $changes."\n";
if($new_json_hash != $json_hash){
    $query = "INSERT INTO jsontable VALUES (?,?);";
    if($stmt = $conn->prepare($query)){
        if(!$stmt->bind_param('ss', $new_json_hash,$_POST['json'])){
            echo "bind (" . $stmt->errno . ") " . $stmt->error;
        }
        if(!$stmt->execute()){
            if($stmt->errno == 1062){
                echo "\nduplocate (" . $stmt->errno . ") ";
                $changes -= 1;
            }
        }
        $stmt->close();
    }else{
        echo  "prepare ".$conn->errno .",". $conn->error;
    }
    $json_hash = $new_json_hash;
    $changes += 1;
}
echo $changes."\n";
if($new_notes_hash != $notes_hash){
    $query = "INSERT INTO notestable VALUES (?,?);";
    if($stmt = $conn->prepare($query)){
        if(!$stmt->bind_param('ss', $new_notes_hash,$_POST['notes'])){
            echo "bind (" . $stmt->errno . ") " . $stmt->error;
        }
        if(!$stmt->execute()){
            if($stmt->errno == 1062){
                echo "\nduplocate (" . $stmt->errno . ") ";
                $changes -= 1;
            }
        }
        $stmt->close();
    }else{
        echo  "prepare ".$conn->errno .",". $conn->error;
    }
    $notes_hash = $new_notes_hash;
    $changes += 1;
}

echo $changes."\n";

//if there has been a change create a new version
if($changes > 0){
    $version_id += 1;
    $query = "INSERT INTO versions (url,version_id,title_id,json_id,notes_id) VALUES (?,?,?,?,?);";

    if($stmt = $conn->prepare($query)){
        if(!$stmt->bind_param('sisss',$_POST['url'],$version_id,$title_hash,$json_hash,$notes_hash)){
            echo "bind (" . $stmt->errno . ") " . $stmt->error;
        }
        if(!$stmt->execute()){
            echo "execute (" . $stmt->errno . ") " . $stmt->error;
        }
        $stmt->close();
    }else{
        echo  "prepare ".$conn->errno .",". $conn->error;
    }


    $query = "UPDATE calendars SET version_id=? WHERE url=?;";
    if($stmt = $conn->prepare($query)){
        if(!$stmt->bind_param('is',$version_id,$_POST['url'])){
            echo "bind (" . $stmt->errno . ") " . $stmt->error;
        }
        if(!$stmt->execute()){
            echo "execute (" . $stmt->errno . ") " . $stmt->error;
        }
        $stmt->close();
    }else{
        echo  "prepare ".$conn->errno .",". $conn->error;
    }
}
$conn->close();

$_SESSION['query-result'] = [
    'url' => $url,
    'title' => $title,
    'json' => $json,
    'notes' => $notes
    ];
?>