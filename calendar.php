<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
<link rel="stylesheet" href="css/calendar.css">
</head>
<body>


         <div class="wrapper">
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
        <div class="post-calendar-notes">
            <textarea> notes regarding the events go here</textarea>
        </div>
    </div>
</div>


</body>
<script type="text/javascript">
	
function generate_year_range(start, end) {
    var years = "";
    for (var year = start; year <= end; year++) {
        years += "<option value='" + year + "'>" + year + "</option>";
    }
    return years;
}

today = new Date();
currentMonth = today.getMonth();
currentYear = today.getFullYear();
selectYear = document.getElementById("year");
selectMonth = document.getElementById("month");


createYear = generate_year_range(2022, 2025);
/** or
 * createYear = generate_year_range( 1970, currentYear );
 */

document.getElementById("year").innerHTML = createYear;

var calendar = document.getElementById("calendar");
var lang = calendar.getAttribute('data-lang');

var monthDefault = ["january", "february", "march", "april", "may", "june", "july", "august", "september", "october", "november", "december"];

var dayDefault = ["sun", "mon", "tue", "wed", "thu", "fri", "sat"];


const months = monthDefault;
const days = dayDefault;

var $dataHead = "<tr>";
for (dhead in days) {
    $dataHead += "<th data-days='" + days[dhead] + "'>" + days[dhead] + "</th>";
}
$dataHead += "</tr>";

//alert($dataHead);
document.getElementById("thead-month").innerHTML = $dataHead;


monthAndYear = document.getElementById("monthAndYear");
showCalendar(currentMonth, currentYear);

function next() {
    currentYear = (currentMonth === 11) ? currentYear + 1 : currentYear;
    currentMonth = (currentMonth + 1) % 12;
    showCalendar(currentMonth, currentYear);
}

function previous() {
    currentYear = (currentMonth === 0) ? currentYear - 1 : currentYear;
    currentMonth = (currentMonth === 0) ? 11 : currentMonth - 1;
    showCalendar(currentMonth, currentYear);
}

function jump() {
    currentYear = parseInt(selectYear.value);
    currentMonth = parseInt(selectMonth.value);
    showCalendar(currentMonth, currentYear);
}

function showCalendar(month, year) {

    const firstDay = ( new Date( year, month ) ).getDay();

    const tbl = document.getElementById("calendar-body");

    tbl.innerHTML = "";

    monthAndYear.innerHTML = months[month] + " " + year;
    selectYear.value = year;
    selectMonth.value = month;

    // creating all cells
    var date = 1;
    for ( var i = 0; i < 6; i++ ) {
        
        var row = document.createElement("tr");
        
        for ( var j = 0; j < 7; j++ ) {
            if ( i === 0 && j < firstDay ) {
                cell = document.createElement( "td" );
                cellText = document.createTextNode("");
                cell.appendChild(cellText);
                row.appendChild(cell);
            } else if (date > daysInMonth(month, year)) {
                break;
            } else {
                cell = document.createElement("td");
                cell.setAttribute("data-date", date);
                cell.setAttribute("data-month", month + 1);
                cell.setAttribute("data-year", year);
                cell.setAttribute("data-month_name", months[month]);
                cell.className = "date-picker";
                cell.innerHTML = "<span>" + date + "</span>";

                if ( date === today.getDate() && year === today.getFullYear() && month === today.getMonth() ) {
                    cell.className = "date-picker selected";
                }
                
                row.appendChild(cell);
                date++;
            }


        }
               tbl.appendChild(row);
    }

}

function daysInMonth(iMonth, iYear) {
    return 32 - new Date(iYear, iMonth, 32).getDate();
}


</script>
</html>