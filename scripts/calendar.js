
//guaranteed O(log n) lookup
selected_dates = new Map();

if(calendar_content){
    //if the variable has been parsed from the global php variable
    // parse the json and convert into a map
    selected_dates = new Map(Object.entries(JSON.parse(calendar_content)));
    //const map2 = new Map(Object.entries(obj));
    //Map(2) { 'foo' => 'bar', 'baz' => 42 }
}


//START----------------------------------------------

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
                let s = "" + year + "." + (month + 1) + "." + date;
                if(selected_dates.get(s)){
                    cell.classList.add("_selected");
                    cell.style.backgroundColor = selected_dates.get(s);
                }              
                row.appendChild(cell);
                date++;
            }
        }
               tbl.appendChild(row);
    }
    $(".date-picker").mousedown(function(){
        //compile date and time hash
        let s = "";
        s += $(this).attr("data-year");
        s += "." + $(this).attr("data-month");
        s += "." + $(this).attr("data-date");
        if($(this).css("background-color")===curr_color){   //deselect clicked element
            $(this).removeClass("_selected");
            $(this).css("background-color","white");
            selected_dates.delete(s);
        }else if(!$(this).css("background-color","white")){         //clicked element is selected
            $(this).css("background-color",curr_color);
            selected_dates.set(s,curr_color);
        }else{                                                      //clicked element is not selected
            $(this).addClass("_selected");
            $(this).css("background-color",curr_color);
            selected_dates.set(s,curr_color);
        }
    });
}
function daysInMonth(iMonth, iYear) {
    return 32 - new Date(iYear, iMonth, 32).getDate();
}
//END----------------------------------------------
$(".post-btn").mousedown(function(){  
    let title = document.getElementById("calendar-title").innerText;
    let json = JSON.stringify(Object.fromEntries(selected_dates));
    //const obj = Object.fromEntries(map1);
    // { foo: 'bar', baz: 42 }
    let notes = document.getElementById("textarea").value;
    $.post("push_content.php", {title : title, json : json, notes : notes}, function(status){
        //console.log(status);
        location.reload();  
    });
});
var curr_color = $(".selected-color").css("background-color");
$(".circle").mousedown(function(){
    if(!$(this).hasClass("selected-color")){
        $(".selected-color").removeClass("selected-color");
        $(this).addClass("selected-color");
        curr_color = $(this).css("background-color");
    }
});
