var oXmlHttp;

function showPrograms(str1, str2, str3) {
  var url="getprogram.php?&syear=" + str1;
  url = url + "&smon=" + str2 + "&ssel=" + str3;
  if ((str3 == "1") || (str3 == "3") || (str3 == "5") || (str3 == "7") || (str3 == "9")) {
    if ((str1!="#") ) {
      oXmlHttp=GetHttpObject(stateChanged);
      oXmlHttp.open("GET", url , true);
	  oXmlHttp.send('x');
    }
  }
  if ((str3 == "2") || (str3 == "6")) {
    if (str1!="#") {
      oXmlHttp=GetHttpObject(bibaraniChanged);
      oXmlHttp.open("GET", url , true);
      oXmlHttp.send(null);
    }
  }
}

function stateChanged() {
  if (oXmlHttp.readyState==4 || oXmlHttp.readyState=="complete") {
    document.getElementById("programList").innerHTML=oXmlHttp.responseText
  }
}

function bibaraniChanged() {
  if (oXmlHttp.readyState==4 || oXmlHttp.readyState=="complete") {
    document.getElementById("bibaraniList").innerHTML=oXmlHttp.responseText
  }
}


function GetHttpObject(handler) {
  try {
    var oRequester = new XMLHttpRequest();
	oRequester.onload=handler
	oRequester.onerror=handler
	oRequester.onreadystatechange=handler
	return oRequester
  }
  catch (error) {
    try {
	  var oRequester = new ActiveXObject("Microsoft.XMLHTTP");
	  oRequester.onreadystatechange=handler
	  return oRequester
	}
	catch (error) {
	  return false;
	}
  }
}

function getProgYears() {
  var styr = 2001, enyr = 2010;
  document.write('<OPTION SELECTED VALUE="#">Select');
  for (var i=enyr; i>=styr; i--) {
   document.write('<OPTION VALUE="' + i + '">' + i);
  }
}

function getProgMonths() {
  document.write('<OPTION SELECTED VALUE="#">Month');
  document.write('<OPTION VALUE="99">All');  
  document.write('<OPTION VALUE="01">January');
  document.write('<OPTION VALUE="02">February');
  document.write('<OPTION VALUE="03">March');
  document.write('<OPTION VALUE="04">April');
  document.write('<OPTION VALUE="05">May');
  document.write('<OPTION VALUE="06">June');
  document.write('<OPTION VALUE="07">July');
  document.write('<OPTION VALUE="08">August');
  document.write('<OPTION VALUE="09">September');
  document.write('<OPTION VALUE="10">October');
  document.write('<OPTION VALUE="11">November');
  document.write('<OPTION VALUE="12">December');
}

function validDate(yr, mon, sel) {
  if ((mon=="01")||(mon=="02")||(mon=="03")||(mon=="04")||(mon=="05")||(mon=="06")
       ||(mon=="07")||(mon=="08")||(mon=="09")||(mon=="10")||(mon=="11")||(mon=="12")) {
    showPrograms(yr, mon, sel); 
  }
}
