<!-- 
if url is in calendars url
    and there has been a change
        create data for new changes
        create version in versions

        change version reference in calendars
            and change no_versions
 -->

 <?php
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'plan';
$DATABASE_PASS = 'password';
$DATABASE_NAME = 'data';

    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    if ( mysqli_connect_errno() ) { exit('failed to connect to database: ' . mysqli_connect_error());}

    $statement = "";

    if ($stmt = $con->prepare($statement)) { $stmt->execute(); $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($url,$title,$json,$notes);
            $stmt->fetch();
            } else {
                echo 'no matches';
            }
        $stmt->close();
        $_SESSION['query-result'] = [
                                    'url' => $url,
                                    'title' => $title,
                                    'json' => $json,
                                    'notes' => $notes,
                                    ];
        } else {
            echo 'query did not pass prepare()';
    }
?>