window.onload = function() {
    let user_input = document.getElementById("user_login"),
    pass_input = document.getElementById("user_pass"),
    login_avatar = document.getElementsByClassName("login")[0].querySelector("h1 a");
    login_avatar.className = "greeting"

    user_input.onfocus = function() {
        // login_avatar.style.backgroundImage = `url(${window.homeSourceUrl}/img/login_greeting.png)`
        login_avatar.className = "greeting"
    };
    user_input.onblur = function() {
        // login_avatar.style.backgroundImage = `url(${window.homeSourceUrl}/img/login_normal.png)`
        login_avatar.className = "normal"
    };
    pass_input.onfocus = function() {
        // login_avatar.style.backgroundImage = `url(${window.homeSourceUrl}/img/login_blindfold.png)`
        login_avatar.className = "blindfold"
    };
    pass_input.onblur = function() {
        // login_avatar.style.backgroundImage = `url(${window.homeSourceUrl}/img/login_normal.png)`
        login_avatar.className = "normal"
    };
}