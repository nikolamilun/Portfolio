// input for admin name (admin form)
const adminNameInput = document.getElementById('adminNameInput');

// Use cookies to autofill the admin name field
let pageLoad = function(){
    if(document.cookie != "")
        {
            let cookiecontent = document.cookie.split('=');
            adminNameInput.innerHTML = cookiecontent[1];
        }
}

// Store the admin name in a cookie
let getUsernameCookie = function(){
    document.cookie = 'AdminName=' + adminNameInput.innerHTML;
}