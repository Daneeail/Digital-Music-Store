// JavaScript source code
// Verifies that user and account info is valid

$(document).ready(function () {
    var name, invalidName;
    var email, invalidEmail;
    var username, invalidUsername, usedUsername;
    var password, invalidPassword;
    var rePassword, invalidRePassword;

    $("#fName").blur(function () {
        name = $("#fName").val();
        if (name == "") {
            $("#fNameError").text("Enter your name.");
            invalidName = true;
        }
        else {
            $("#fNameError").text("");
            invalidName = false;
        }
    });

    $("#fEmail").blur(function () {
        email = $("#fEmail").val().toLowerCase();
        var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (email == "") {
            $("#fEmailError").text("Enter your email.");
            invalidEmail = true;
        }
        else if (!email.match(regex)) {
            $("#fEmailError").text("Invalid email.");
            invalidEmail = true;
        }
        else {
            $("#fEmailError").text("");
            invalidEmail = false;
        }
    });

    var request;

    $("#fUsername").blur(function () {
        username = $("#fUsername").val().toLowerCase();
        if (username == "") {
            $("#fUsernameError").text("Enter a username.");
            invalidUsername = true;
        }
        else {
            request = $.ajax({
                method: "POST",
                url: "verifyUsername.php",
                data: {
                    q: $("#fUsername").val()
                }
            });
            request.done(function (response, textStatus, jqXHR) {
                if (response == "no") {
                    $("#fUsernameError").text("");
                    invalidUsername = false;
                }
                else if (response == "yes") {
                    $("#fUsernameError").text("Username is taken.  Please enter another username.");
                    usedUsername = true;
                }
            });
        }
    });

    $("#fPassword").blur(function () {
        password = $("#fPassword").val();
        if (password == "") {
            $("#fPWError").text("Enter a password.");
            invalidPassword = true;
        }
        else if (password.length < 8) {
            $("#fPWError").text("Invalid password.");
            invalidPassword = true;
        }
        else {
            $("#fPWError").text("");
            invalidPassword = false;
        }
    });

    $("#fRePassword").blur(function () {
        rePassword = $("#fRePassword").val();
        if (rePassword == "") {
            $("#fRePWError").text("Re-enter your password.");
            invalidRePassword = true;
        }
        if (password != (rePassword)) {
            $("#fRePWError").text("Passwords do not match.");
            invalidRePassword = true;
        }
        else {
            $("#fRePWError").text("");
            invalidRePassword = false;
        }
    });

    $("form").submit(function (e) {
        if (invalidName || $("#fName").val() == "") {
            alert("Enter your name.");
            e.preventDefault();
        }
        else if (invalidEmail || $("#fEmail").val() == "") {
            alert("Invalid email.");
            e.preventDefault();
        }
        else if (invalidUsername || $("#fUsername").val() == "") {
            alert("Invalid username.");
            e.preventDefault();
        }
        else if (usedUsername) {
            alert("Username has been taken.  Please enter another username.")
        }
        else if (invalidPassword || $("#fPassword").val() == "") {
            alert("Invalid password.");
            e.preventDefault();
        }
        else if (invalidRePassword || $("#fRePassword").val() == "") {
            alert("Passwords do not match.");
            e.preventDefault();
        }
    })
});