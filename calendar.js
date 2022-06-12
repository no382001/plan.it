//START---------------------------------------------- stolen barely modified

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

document.getElementById("year").innerHTML = createYear;

const calendar = document.getElementById("calendar");
const lang = calendar.getAttribute('data-lang');
const months = ["january", "february", "march", "april", "may", "june", "july", "august", "september", "october", "november", "december"];
var days = ["sun", "mon", "tue", "wed", "thu", "fri", "sat"];

var dataHead = "<tr>";
for (dhead in days) {
    dataHead += "<th data-days='" + days[dhead] + "'>" + days[dhead] + "</th>";
}
dataHead += "</tr>";

//alert(dataHead);
document.getElementById("thead-month").innerHTML = dataHead;


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

//END---------------------------------------------- stolen barely modified



//guaranteed O(log n) lookup
const selected_dates = new Map();

//const obj = Object.fromEntries(map1);
// { foo: 'bar', baz: 42 }
//const map2 = new Map(Object.entries(obj));
// Map(2) { 'foo' => 'bar', 'baz' => 42 }

$(".date-picker").mousedown(function(){

    let s = "";
    s += $(this).attr("data-year");
    s += "." + $(this).attr("data-month");
    s += "." + $(this).attr("data-date");

    if($(this).hasClass("_selected")){
        $(this).removeClass("_selected");
        selected_dates.delete(s); 
    }else{
        $(this).addClass("_selected");
        selected_dates.set(s,null);
    }

});

$(".post-btn").mousedown(function(){
    /*
    
    var title = title;
    var json = selected_dates;
    var notes = text;
    $.post("update.php", {title:res_id, json:selected_dates, notes:text});
    //  $_SESSION["title"] = $_POST["title"]; 
    //  $_SESSION["json"] = $_POST["json"];
    //  $_SESSION["notes"] = $_POST["notes"];
    
    */

    console.log(Object.fromEntries(selected_dates));
});


