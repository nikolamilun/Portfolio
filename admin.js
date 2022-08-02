const adminNameInput = document.getElementById('adminNameInput');

let pageLoad = function(){
    if(document.cookie != "")
        {
            let cookiecontent = document.cookie.split('=');
            adminNameInput.innerHTML = cookiecontent[1];
        }
}

let getUsernameCookie = function(){
    document.cookie = 'AdminName=' + adminNameInput.innerHTML;
}