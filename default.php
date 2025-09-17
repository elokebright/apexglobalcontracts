<html>
<script src="home/template/assets/libs/jquery-1.12.4.min.js"></script>
<script>
        $.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null) {
       return "";
    }
    return decodeURI(results[1]) || 0;
}
let ref = $.urlParam('ref');

function setRefCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/;domain=apexglobalcontracts.com";
}
setRefCookie('sponsor',ref,1);
window.location.assign("home");
    </script>



</html>