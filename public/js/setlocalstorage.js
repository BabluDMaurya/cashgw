$(document).on('click','.activetab',function(){
     if (typeof(Storage) !== "undefined") {         
//        localStorage.setItem("currenttab", $(this).attr('data-localstoraj'));
        localStorage.setItem("currenttabchild", $(this).attr('data-currenttabchild'));
      } else {
        // "Sorry, your browser does not support Web Storage...";
      }
 }); 