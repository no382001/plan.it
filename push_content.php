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
$DATABASE_NAME = 'data';
$DATABASE_USER = 'plan';
$DATABASE_PASS = 'password';
$CHARSET = 'utf8mb4';
/* PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, */
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

// --first entry with url
//hash data
$title_hash = hash('ripemd160', $_POST['title']);
$json_hash = hash('ripemd160', $_POST['json']);
$notes_hash = hash('ripemd160', $_POST['notes']);

//create their table elements
$query = "INSERT INTO titletable (title_id,title) VALUES (:title_id,:title);";
$stmt = $pdo->prepare($query);
$stmt->execute([
    'title_id' => $title_hash,
    'title' => $_POST['title']
    ]);

$query = "INSERT INTO jsontable (json_id,json) VALUES (:json_id,:json);";
$stmt = $pdo->prepare($query);
$stmt->execute([
    'json_id' => $json_hash,
    'json' => $_POST['json']
    ]);

$query = "INSERT INTO notestable (notes_id,notes)VALUES (:notes_id,:notes);";
$stmt = $pdo->prepare($query);
$stmt->execute([
    'notes_id' => $notes_hash,
    'notes' => $_POST['notes']
    ]);

//create new key for the calendar entry
$url = keygen();
//create version entry
$query = "INSERT INTO versions (url,version_id,title_id,json_id,notes_id) VALUES (:url,:version_id,:title_id,:json_id,:notes_id);";
$stmt = $pdo->prepare($query);
$stmt->execute([
    'url' => $url,
    'version_id' => 0,
    'title_id' => $title_hash,
    'json_id' => $json_hash,
    'notes_id' => $notes_hash
    ]);

//create calendar entry 
$query = "INSERT INTO calendars (url,version_id,no_versions) VALUES (:url,:version_id,:no_versions);";
$stmt = $pdo->prepare($query);
$stmt->execute([
    'url' => $url,
    'version_id' => 0,
    'no_versions' => 0
    ]);

$_SESSION['query-result'] = [
    'url' => $url,
    'title' => $_POST['title'],
    'json' => $_POST['json'],
    'notes' => $_POST['notes'],
    'no_versions' => 0,
    'version' => 1
    ];
?>