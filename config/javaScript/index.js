//======================
// LOGIN SPACE ELEMENTS
//======================





//======================
// MAKE RESERVATION DIV
//======================
var destinations = new Array();
function makeReservation()
{
    //Cool the first step is to make sure that we can create tables a will
    var makeReservationTable = document.createElement("table");
    makeReservationTable.id =  "makeReservationTable";
    var hdrRow = makeReservationTable.insertRow(0);
    var hdrDate = document.createElement("th");
    var hdrDepatureTime = document.createElement("th");
    var hdrDestinationTime = document.createElement("th");
    var hdrStartingPoint = document.createElement("th");
    var hdrDestination = document.createElement("th");
    var hdrSaveReservation = document.createElement("th");
    hdrRow.appendChild(hdrDate);
    hdrRow.appendChild(hdrDepatureTime);
    hdrRow.appendChild(hdrDestinationTime);
    hdrRow.appendChild(hdrStartingPoint);
    hdrRow.appendChild(hdrDestination);
    hdrRow.appendChild(hdrSaveReservation);
    hdrDate.innerHTML = "Date";
    hdrDepatureTime.innerHTML = "Start Time";
    hdrDestinationTime.innerHTML = "Arival Time";
    hdrStartingPoint.innerHTML = "Starting Point";
    hdrDestination.innerHTML = "Destination Location";
    hdrSaveReservation.innerHTML = "Save";
    //So far since for the sake of time we are only going to work on a single trip and reduce other complexities
    //Create Fellowing cells the goal is to make sure that we can request all the information that we need in order for us to make a reservation
    var row = makeReservationTable.insertRow(1);
    var cellDate = row.insertCell(0);//The date is just only going to show to days date to alert the user that they are booking this trip just for today. 
    var cellDepatureTime = row.insertCell(1);//This will be a drop down that is based upon the trip that the student is going to take
    var cellDestinationTime = row.insertCell(2);//This will be auto filled as it depends on the depature time
    var cellStartingPoint = row.insertCell(3);//The starting point will be allowed by the student
    var cellDestination = row.insertCell(4);//This will be auto we are working on a single trip so we are only going to have 2 values here since we are working on a single trip
    var cellSaveReservation = row.insertCell(5);//This should be a button that is going to take us to make reservation - 
    var myDate = new Date();
    var curMonth = myDate.getMonth()+ +1;
    var dateString = myDate.getFullYear() + "-" + curMonth + "-" + myDate.getDate();
    var depatureTimeSelect = createElement("depatureTime", "", "depatureTime", "departureTimes", "select", "text");
    depatureTimeSelect.addEventListener('change', setArivalTime);
    var tripDate = createElement("tripDate", "", "tripDate", "", "input", "text");
    tripDate.value = dateString;
    tripDate.readOnly = true;
    cellDate.appendChild(tripDate);
    var destinationTime = createElement("destinationTime", "", "destinationTime", "Destination Time", "input", "text");
    destinationTime.readOnly = true;
    cellDestinationTime.appendChild(destinationTime);
    var startingPoint = createElement("startingPoint", "", "startingPoint", "startingPoints", "select", "text");
    startingPoint.addEventListener('change', setDestinationPoint);
    //Now I need to get the members information from the database and I have to take that information and paste it to this table.
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://localhost/dashboard/studenttransportsystem/user/student/posts/postDepatureTimes.php', true);
    xhr.onload = function(){
        if(this.status = 200){ 
            var depatureTime = JSON.parse(this.responseText);
            for(var i in depatureTime){
                depatureTimeSelect.options[depatureTimeSelect.options.length] = new Option(depatureTime[i].startTime,i);
            }
        }
    }
    xhr.send();
    cellDepatureTime.appendChild(depatureTimeSelect);

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://localhost/dashboard/studenttransportsystem/user/student/posts/postStartingPoints.php', true);
    xhr.onload = function(){
        if(this.status = 200){ 
            var startingPointValues = JSON.parse(this.responseText);
            destinations = startingPointValues;
            for(var i in startingPointValues){
                startingPoint.options[startingPoint.options.length] = new Option(startingPointValues[i].startPoint,i);
            }
        }
    }
    xhr.send();
    cellStartingPoint.appendChild(startingPoint);
    var destinationLocation = createElement("destinationLocation", "", "destinationLocation", "Destination Location", "input", "text");
    destinationLocation.readOnly = true;
    cellDestination.appendChild(destinationLocation);

    document.getElementById("reservationDiv").appendChild(makeReservationTable);
    function createElement(elName, elStyle, elId, elPlaceholder, element, type){
        var elInput = document.createElement(element);
        elInput.id = elId, 
        elInput.type = type;
        elInput.required = true;
        elInput.className = elStyle
        elInput.placeholder = elPlaceholder;
        elInput.name = elName;
        return elInput;
    }

    var saveTrip = document.createElement("button");
    saveTrip.id = "saveTrip";
    saveTrip.innerHTML = "Save";
    saveTrip.name = "saveTrip";
    saveTrip.addEventListener("click", saveReservation);
    cellSaveReservation.appendChild(saveTrip);
}

function setArivalTime()
{
    // var depatureTimeValue = document.getElementById("depatureTime").options[this.value].innerText;
    var depatureTimeValue = document.getElementById(this.id).options[document.getElementById(this.id).value].innerText;
    var arivalTime = depatureTimeValue.replace(":00:00", ":45:00");
    document.getElementById("destinationTime").value = arivalTime;
}

function setDestinationPoint()
{
    //Use an array 
    var startPoint = document.getElementById(this.id).options[document.getElementById(this.id).value].innerText;
    for(var i in destinations)
    {
        if(startPoint != destinations[i].startPoint)
        {
            document.getElementById("destinationLocation").value = destinations[i].startPoint;
        }
    }
}

function saveReservation()
{
    //Show all the information.
    var tripReservation = new Array();
    tripReservation.push(document.getElementById("tripDate").value);
    var departureTime = document.getElementById("depatureTime").options[document.getElementById("depatureTime").value].innerText;
    tripReservation.push(departureTime);
    tripReservation.push(document.getElementById("destinationTime").value);
    var startPoint = document.getElementById("startingPoint").options[document.getElementById("startingPoint").value].innerText;
    tripReservation.push(startPoint);
    tripReservation.push(document.getElementById("destinationLocation").value);
    //Send the information
    var xhr = new XMLHttpRequest();
    var params = "reservation=" + JSON.stringify(tripReservation);
    xhr.open('POST', 'http://localhost/dashboard/studenttransportsystem/user/student/makeReservation.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(params);
}