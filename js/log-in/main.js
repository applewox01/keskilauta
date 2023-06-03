document.addEventListener("DOMContentLoaded", function(){
    let button = document.getElementById("showPass");
    let password = document.getElementById("password");
    button.addEventListener("click", showOrHide);
    
    let hidPass = true;
    function showOrHide(event) {
    event.preventDefault();
    if (hidPass == true) {
      hidPass = false;
      button.innerHTML = "Piilota salasana";
      password.type = "text";
    } else {
      hidPass = true;
      button.innerHTML = "Näytä salasana";
      password.type = "password";
    };
    }; 
});