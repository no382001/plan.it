

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
    <link rel="stylesheet" href="css/calendar.css">
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
    <div class="calendar-wrapper">   
        <div class="container-calendar">
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
                <textarea> notes regarding the events go here</textarea>
            </div>
        </div>
    </div>
</div>

<div class="third-wrap">
    <form action="clear_session.php" method="POST">
        <button type="SUBMIT">clear session</button>
    </form>
    <button class="post-btn">push</button>
    <h1>changelog:</h1>
    <p>1.234982734</p>
    <p>2.32489</p>
    <p>3.3481jhs</p>
</div>

</body>
<script type="text/javascript" src="jq.js"></script>
<script type="text/javascript" src="calendar.js"></script>
</html>