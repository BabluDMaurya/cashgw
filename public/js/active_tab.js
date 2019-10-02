 // get the local storage
if (typeof(Storage) !== "undefined") {
//    var currenttab = localStorage.getItem("currenttab");
    var count = localStorage.getItem("currenttabchild");
        if(count > 0){
            child = count;
        }else{
            child = 1;
        }
//       if(currenttab == 'RequestPayment'){            
           navtab(child);           
//       }else if(currenttab == 'SendMoney'){
//           navtab(child);
//       }else if(currenttab == 'AdminNotify'){
//           navtab(child);
//       }
       localStorage.clear();
 } else {
  //"Sorry, your browser does not support Web Storage...";
 }
 
 function navtab(child){
     $('#nav-tab item:nth-child('+child+')').addClass('active show').siblings().removeClass('active show');
     $('#nav-tabContent div:nth-child('+child+')').addClass('active show').siblings().removeClass('active show');
 }
