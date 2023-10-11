function getTheDate() {
  Todays = new Date();
  TheDate = "";
  TheDate += Todays.getMonth() + 1 + "/";
  TheDate += Todays.getDate() + "/";
  TheDate += Todays.getFullYear();
  document.getElementById("data").innerHTML = TheDate;
}
var timerID = null;
var timerRunning = false;
function stopclock() {
  if (timerRunning) {
    clearTimeout(timerID);
  }
  timerRunning = false;
}
function startclock() {
  stopclock();
  getTheDate();
  showtime();
  showSeconds();
}
function showtime() {
  var now = new Date();
  var hours = now.getHours();
  var minutes = now.getMinutes();
  var seconds = now.getSeconds();
  var timevalue = "" + (hours > 12 ? hours - 12 : hours);
  timevalue += (minutes < 10 ? ":0" : ":") + minutes;
  timevalue += seconds < 10 ? ":0" : ":" + seconds;
  timevalue += hours >= 12 ? " P.M." : " A.M.";
  document.getElementById("zegarek").innerHTML = timevalue;
  timerID = setTimeout("showtime()", 1000);
  timerRunning = true;
}

function showSeconds() {
  var now = new Date();
  var hours = now.getHours();
  var minutes = now.getMinutes();
  var seconds = now.getSeconds();
  var timevalue = "";
  timevalue += hours * 3600 + minutes * 60 + seconds;
  document.getElementById("seconds").innerHTML = timevalue;
  timerID = setTimeout("showDelta()", 1000);
  timerRunning = true;
}
