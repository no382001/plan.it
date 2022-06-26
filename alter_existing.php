<?php 
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_NAME = 'data';
$DATABASE_USER = 'plan';
$DATABASE_PASS = 'password';
$CHARSET = 'utf8mb4';
/*  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, */
$OPTIONS = [
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
$title = $_POST['title'];
$json = $_POST['json'];
$notes = $_POST['notes'];

//get version id for url
$query = "SELECT version_id FROM calendars WHERE url=:url;";
$stmt = $pdo->prepare($query);
$stmt->execute([
    'url' => $url
    ]);
$version_id = $stmt->fetchColumn();

//get hashes for content
$query = "SELECT title_id, json_id, notes_id FROM versions
                                            WHERE url=:url
                                            AND version_id=:version_id;";
$stmt = $pdo->prepare($query);
$stmt->execute([
    'url' => $url,
    'version_id' => $version_id
    ]);
$row = $stmt->fetch();
$title_id = $row['title_id'];
$json_id = $row['json_id'];
$notes_id = $row['notes_id'];

//if something is not the same commit a change
$new_title_id = hash('ripemd160', $title);
$new_json_id = hash('ripemd160', $json);
$new_notes_id = hash('ripemd160', $notes);

$changes = 0;
if($new_title_id != $title_id){
    $query = "INSERT INTO titletable (title_id,title) VALUES (:title_id,:title);";
    //if its not 1062 duplicate, exec
    if($stmt = $pdo->prepare($query)){
        $stmt->execute([
            'title_id' => $new_title_id,
            'title' => $title
            ]);
    }
    $title_id = $new_title_id;
    $changes += 1;
}

if($new_json_id != $json_id){
    $query = "INSERT INTO jsontable (json_id,json) VALUES (:json_id,:json);";
    //if its not 1062 duplicate, exec
    if($stmt = $pdo->prepare($query)){
        $stmt->execute([
            'json_id' => $new_json_id,
            'json' => $json
            ]);
    }
    $json_id = $new_json_id;
    $changes += 1;
}

if($new_notes_id != $notes_id){
    $query = "INSERT INTO notestable (notes_id,notes)VALUES (:notes_id,:notes);";
    //if its not 1062 duplicate, exec
    if($stmt = $pdo->prepare($query)){
    $stmt->execute([
        'notes_id' => $new_notes_id,
        'notes' => $notes
        ]);
    }
    $notes_id = $new_notes_id;
    $changes += 1;
}

//if there has been a change create a new version
if($changes > 0){
    $version_id += 1;
    $query = "INSERT INTO versions (url,version_id,title_id,json_id,notes_id) VALUES (:url,:version_id,:title_id,:json_id,:notes_id);";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'url' => $url,
        'version_id' => $version_id,
        'title_id' => $title_id,
        'json_id' => $json_id,
        'notes_id' => $notes_id
        ]);

    $query = "SELECT COUNT(id) FROM versions WHERE url=:url";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'url' => $url
        ]);
    $no_versions = $stmt->fetchColumn();
    echo "no.vers:".$no_versions."\n";
    echo "no.change.this:".$changes."\n";
    
    $query = "UPDATE calendars SET version_id=:version_id, no_versions=:no_versions WHERE url=:url;";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'version_id' => $version_id,
        'no_versions' => $no_versions,
        'url' => $url,
    ]);
}

$_SESSION['query-result'] = [
    'url' => $url,
    'title' => $title,
    'json' => $json,
    'notes' => $notes,
    'no_versions' => $no_versions,
	'version' => $version_id
    ];

?>