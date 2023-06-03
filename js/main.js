document.addEventListener("DOMContentLoaded", function(){
    
    let list = document.getElementById("hiddenList");
    let button = document.getElementById("kirjButton");
  
    button.addEventListener("click", listVisibility);
  
    function listVisibility(event) {
      event.preventDefault();
      if (list.className == "hidden") {
        list.className = "listVisible";
      } else {
        list.className = "hidden";
      }
    };

    let ele = document.getElementsByClassName('showProfile');

    for (let i = 0; i < ele.length; ++i) {
        let item = ele[i];  
       item.addEventListener("mouseover", showP);
       item.addEventListener("mouseleave", hideP);
       item.addEventListener("click", copy);
    };
    
    function showP(event) {
        let button = event.target;
        let author = button.author;

        let address = document.getElementById(`showAddress${author}`);
    };
    
    function hideP(event) {
        
    };

    function copy(event) {
        copyToClipboard();
    };

})
