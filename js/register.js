
$(document).ready(function () {
    $("#submitBtn").click(function (event) {
      
        event.preventDefault();

        var email = $("#email").val();
        var password = $("#password").val();
        var confirmPassword = $("#confirmPassword").val();

        console.log(email);
        console.log(password);

      
 
        $.ajax({
            type: "POST",
            url: "php/register.php",
            data: {
                email: email,
                password: password,
                confirmPassword: confirmPassword
            },
            success: function (response) {
                alert(response);
            },
            error: function (error) {
                console.log("Error:", error);
            }
        });
   
    });
});

