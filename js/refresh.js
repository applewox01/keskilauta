
document.addEventListener("DOMContentLoaded", function(){
    if (document.getElementById("kommentit")) {
  
    console.log("load");
  
  function removeAllChildNodes(parent) {
    while (parent.firstChild) {
        parent.removeChild(parent.firstChild);
    }
  }
    function refresh() {
      let kommentit = document.getElementById("kommentit");
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         // Typical action to be performed when the document is ready:
         removeAllChildNodes(kommentit);
         kommentit.innerHTML = this.responseText;
      }
  };
  xhttp.open("GET", "<?php echo $baseLink; ?>/phpInfo/commentsGET.php/?artikkeli=<?php echo $_GET["artikkeli"]?>", true);
  xhttp.send();
    }
    refresh();
  
    document.getElementById("laheta").addEventListener("click",function(e){
        refresh();
    });
  
      setInterval(() => {
        refresh()
      }, 5000);
    };
  });