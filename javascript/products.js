function showMake(year) {
  if (year == "") {
    document.getElementById("make").innerHTML = "";
    return;
  } else {
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp = new XMLHttpRequest();
    } else {
      // code for IE6, IE5
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("make").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "view/getmake.php?year=" + year, true);
    xmlhttp.send();
  }
}

function showModel(year, make) {
  if (make == "") {
    document.getElementById("model").innerHTML = "";
    return;
  } else {
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp = new XMLHttpRequest();
    } else {
      // code for IE6, IE5
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("model").innerHTML = this.responseText;
      }
    };
    var rt = "view/getmodel.php?year=" + year + "&make=" + make;
    xmlhttp.open("GET", rt, true);
    xmlhttp.send();
  }
}

function showEngine(year, make, model) {
  if (make == "") {
    document.getElementById("engine").innerHTML = "";
    return;
  } else {
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp = new XMLHttpRequest();
    } else {
      // code for IE6, IE5
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("engine").innerHTML = this.responseText;
      }
    };
    var rt =
      "view/getengine.php?year=" + year + "&make=" + make + "&model=" + model;
    xmlhttp.open("GET", rt, true);
    xmlhttp.send();
  }
}
