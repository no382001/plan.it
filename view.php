<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>view</title>
</head>
<body>
<?php 

if($_SESSION['query-result'] != null){
    echo '
    <form action="alter_content.php" method="POST">
	    <input type="text" name="title"  value="'.$_SESSION['query-result']['title'].'" required>
	    <input type="text" name="text" value="'.$_SESSION['query-result']['text'].'" required>
	    <button type="SUBMIT">alter content</button>
	</form>
	';
}else{
	header("Location: index.php");
}

?>


</body>
</html>