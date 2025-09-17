function copy2Clipboard(elem) {
  /* Get the text field */
  var copyText = document.getElementById(elem);

  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); /* For mobile devices */

  /* Copy the text inside the text field */
  document.execCommand("copy");


}


function updateInfo(){
   // console.log("hello");
   //var res="nn";

   $.get( "user_data.php", function( data ) {
       
    var result = JSON.parse(data);
    $('#walletbal').text(result.walletbalance);
    $('#activeInv').text(result["totalactiveinvestment"]);
    $('#lastdeposit').text(result["lastdeposit"]);
    $('#totalDeposit').text(result["totaldeposit"]);
    $('#dailyprofit').text(result["dailyprofit"]);

    $('#lastWith').text(result["lastwithdrawal"]);
    $('#totalWith').text(result["totalwithdrawal"]);
    $('#pendingWith').text(result["pendingwithdrawal"]);
    $('#totalEarning').text(result["totalearning"]);
     $('#totalpackages').text(result["totalpackages"]);
    $('#activepackages').text(result["activepackages"]);
  
    $('#totalRefBonus').text(result["referralbonus"]);
    $('#refCount').text(result["referralCount"]);
     $('#totalBonus').text(result["walletbonus"]);
    
   
    
  
  });

}
updateInfo();
$(document).ready(function(){
    updateInfo();
    
  setInterval(updateInfo,5000);  
});

