<!-- https://stackoverflow.com/questions/33138756/create-unique-url-in-php-for-each-entry -->

<!-- https://github.com/vinkla/hashids           should check this out, looks like a good one --> 

<!-- otherwise use this with MVP -->

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

//check if data is populated
if ( !isset($_POST['text']) ) {
    exit('text is not filled in, post is without value, even tho this shouldnt happen');
}
$url = keygen();

$stmt = $conn->prepare('INSERT INTO content (`url`,`title`,`content`) VALUES (?,?,?)');

$stmt->bind_param('sss', $url,$_POST['title'],$_POST['text']);
$stmt->execute();

$stmt->close();
$conn->close();

$_SESSION['query-result'] = [
                            'url' => $url,
                            'title' => $_POST['title'],
                            'text' => $_POST['text'],
                            ];

echo "success! your key is ".$url;
echo "<br><a href='index.php'>return</a>"


?>