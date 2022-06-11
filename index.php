

<?php

session_start();

//localhost:port/     should automatically handle request with any url

//$clean_url = substr($_SERVER['REQUEST_URI'],1);  
//index.php/asdi2234n1
//          ^ should grab this "hash part"
// ^ but now without .htaccess it instead grabs this

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <title>plan.it</title>
</head>
<body>

<div class="first-wrap">
    <form action="get_content.php" method="POST">
        <input type="text" name="url" placeholder="url" id="url" required>
        <button type="SUBMIT">open url</button>
    </form>
</div>

<div class="second-wrap">
    <?php 

    if ($_SESSION['query-result'] == null) {
        echo '<form action="push_content.php" method="POST">';
    }else{
        echo '<form action="alter_content.php" method="POST">';
    }

        if ($_SESSION['query-result'] != null) {
            echo '
<h1>'.$_SESSION['query-result']['url'].'</h1>
<input id="title"type="text" name="title" placeholder="title" value="'.$_SESSION['query-result']['title'].'" required>
<textarea id="text" type="text" name="text" required>'.$_SESSION['query-result']['text'].'</textarea>';
        }else{
            echo '
            <input id="title"type="text" name="title" placeholder="title" value="Lorem ipsum" required>
        <textarea id="text" type="text" name="text" required>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce a massa nec purus molestie lacinia. Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean ullamcorper quis augue sit amet ultricies. Phasellus pretium velit magna, malesuada vehicula turpis elementum ac. Nunc quis velit dignissim</textarea>';
        }

         if ($_SESSION['query-result'] == null) {
        echo '<button type="SUBMIT">push content</button>';
    }else{
        echo '<button type="SUBMIT">alter content</button>';
    }

    ?>
    </form>
</div>



<div class="third-wrap">
    <form action="clear_session.php" method="POST">
        <button type="SUBMIT">clear session</button>
    </form>
<?php
if($_SESSION['query-result'] != null){
    echo "<h1>current session</h1>";
    echo "<p>".$_SESSION['query-result']['url']."</p>";
    echo "<p>".$_SESSION['query-result']['title']."</p>";
    //echo "<a href='view.php'>view session</a>";
}
?>
</div>

</body>
</html>