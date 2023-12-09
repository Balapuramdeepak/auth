$(document).ready(function () {
    $("#loginBtn").click(function (event) {
        event.preventDefault();

        var email = $("#email").val();
        var password = $("#password").val();

        $.ajax({
            type: "POST",
            url: "php/login.php",
            data: {
                email: email,
                password: password
            },
            success: function (response) {
                 
                var data = JSON.parse(response);

                if (data.status === "success") {
                     
                    localStorage.setItem('token', data.token);
                    window.location.replace('profile.html');
                  
                } else {
                    alert("Login failed: " + data.message);
                }
            },
            error: function (error) {
                console.log("Error:", error);
            }
        });
    });
});
