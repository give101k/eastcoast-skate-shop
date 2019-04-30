function updateqt(qt, pnum) {
  if (qt == "") {
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
    /*xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById(pnum).innerHTML = this.responseText;
      }
    };*/
    var rt = "index.php?action=updateqt&qt=" + qt;
    xmlhttp.open("POST", rt, true);
    xmlhttp.send();
  }
}
