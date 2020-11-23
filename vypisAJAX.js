function obnovit() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                // tento kód se provede v okamžiku navrácení hodnoty ze serveru
                document.getElementById("vypis").innerHTML = xmlhttp.responseText;
            }
        }
        var page = getCookie("page");
        var cil = "vypis.php" + "?page=" + page;
        console.log(cil);
        xmlhttp.open("POST", cil, true);
        xmlhttp.send();
}
casovac = window.setInterval(obnovit, 5000); //časovač
function getCookie(name) {
    function escape(s) { return s.replace(/([.*+?\^${}()|\[\]\/\\])/g, '\\$1'); };
    var match = document.cookie.match(RegExp('(?:^|;\\s*)' + escape(name) + '=([^;]*)'));
    return match ? match[1] : null;
}