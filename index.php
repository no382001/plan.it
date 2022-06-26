

<?php

session_start();
$session = (isset($_SESSION['query-result']))?$_SESSION['query-result']:'';
//localhost:port/     should automatically handle request with any url

//$clean_url = substr($_SERVER['REQUEST_URI'],1);
//$clean_url = $_GET['q'];

?>


<!DOCTYPE html>

<script type="text/javascript">
    var calendar_content = '<?php echo $session['json']; ?>';
</script>

<html>
<head>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/calendar.css">
    <title>plan.it</title>
</head>
<body>

<div class="first-wrap">
        <input type="text" name="url" placeholder="url" id="url" required>
        <button class="get-btn">open url</button>
</div>

<div class="second-wrap">
    <div class="calendar-wrapper">   
        <div class="container-calendar">
            <textarea class="calendar-title"><?php
            if($_SESSION['query-result']['title'] != NULL){
                echo $_SESSION['query-result']['title'];
            }else{
                echo "";
            }
            ?></textarea>
            <h3 id="monthAndYear"></h3>
            <div class="button-container-calendar">
                <button id="previous" onclick="previous()">&#8249;</button>
                <button id="next" onclick="next()">&#8250;</button>
            </div>
            <table class="table-calendar" id="calendar" data-lang="en">
                <thead id="thead-month"></thead>
                <tbody id="calendar-body"></tbody>
            </table>
            <div class="footer-container-calendar">
                <label for="month">select: </label>
                <select id="month" onchange="jump()">
                     <option value=0>jan</option>
                     <option value=1>feb</option>
                     <option value=2>mar</option>
                     <option value=3>apr</option>
                     <option value=4>may</option>
                     <option value=5>jun</option>
                     <option value=6>jul</option>
                     <option value=7>aug</option>
                     <option value=8>sep</option>
                     <option value=9>oct</option>
                     <option value=10>nov</option>
                     <option value=11>dec</option>
                 </select>
                 <select id="year" onchange="jump()"></select>       
            </div>
            <div class="color-selector">
                <div class="circle pink selected-color"></div>
                <div class="circle blue"></div>
                <div class="circle green"></div>
                <div class="circle red"></div>
            </div>

            <div class="post-calendar-notes">
                <textarea id="textarea" oninput='this.style.height="";this.style.height=this.scrollHeight+"px"'><?php
                    if($_SESSION['query-result']['notes'] != NULL){
                        echo $_SESSION['query-result']['notes'];
                    }else{
                        echo "";
                    }
                    ?></textarea>
            </div>
        </div>
    </div>
</div>

<div class="first-wrap">
    <form action="clear_session.php" method="POST">
        <button type="SUBMIT">clear session</button>
    </form>
    <button class="post-btn">push</button>
    <button class="alter-btn">alter</button>
    <h1>url:</h1>
    <a id="url-shown"><?php echo $_SESSION['query-result']['url'];?></a>
    <h1>versions:</h1>
    <ul class="versions">
        <?php 
            for ($i = 1; $i <= 10; $i++) {
                echo "<a class='version-href' href='#'>v.{$i}</a>";
            };
        ?>
    </ul>
<!--     <p2>10 versions are kept at the same time</p2> -->
</div>

</body>
<script type="text/javascript" src="scripts/jq.js"></script>
<script type="text/javascript" src="scripts/calendar.js"></script>
</html>