function updateInfo(){
   // console.log("hello");
   //var res="nn";

   $.get( "data.php", function( data ) {
       
    var result = JSON.parse(data);
    $('#totalUsers').text(result.totalusers);
    $('#totalInvestment').text(result["totalinvestment"]);
    $('#totalFundsDeposited').text(result["totaldeposits"]);
$("#pendingdeposits").text(result["pendingdeposit"]);
    $('#totalActiveInvestment').text(result["totalactivecapital"]);
    
    $('#totalWithdrawal').text(result["totalwithdrawal"]);
    $('#pendingwithdrawal').text(result["pendingwithdrawal"]);
    
    
  
  });

}
updateInfo();
$(document).ready(function(){
    updateInfo();
    
  setInterval(updateInfo,5000);  
});

