function formatDate($scope)
{
    var d = new Date($scope);
    var days = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
    var month = days[d.getMonth()];
    var day = d.getDate();
    var year = d.getFullYear();
    var today = month+' '+day+', '+year;
    return today;
}
function datatabasedateCalculate($date){
    var d = new Date($date);
    var days = ["01","02","03","04","05","06","07","08","09","10","11","12"];
    var month = days[d.getMonth()];
    var day = d.getDate();
    var year = d.getFullYear();
    var today = year+'-'+month+'-'+day;
    return today;
}

