$(document).ready(function () {
           
    $("#prof-name input").hide();
    $("#prof-dob input").hide();
    $("#prof-contact input").hide();
    $("#submitBtn").hide();


    const jwtString = localStorage.getItem('token');
    const [, payload,] = jwtString.split('.');
    const decodedPayload = JSON.parse(atob(payload));
    var email = decodedPayload.email;

    $.ajax({
        type: "POST",
        url: "php/user.php",
        data: {
            email: email
        },
        dataType: 'json',
        success: function (response) {
          
            console.log(response);
            if (response.name!=="" && response.name!==null ){

                $("#nameParagraph").text(  response.name);
                $("#name").val(response.name);
            }
            if (response.dob!=="" && response.dob!==null){

                $("#dateParagraph").text(   response.dob);
                $("#date").val(response.dob);
            }
            if (response.contact!=="" &&  response.contact!==null){

                $("#contactParagraph").text(  response.contact);
                $("#Contact").val(response.contact);
            }
           
         

             
           
  
 
        },
        error: function (error) {
            console.log("Error:", error);
        }
    });

    $("#btn_link").click(function () {
       
        $("#prof-name p, #prof-name input").toggle();
        $("#prof-dob p, #prof-dob input").toggle();
        $("#prof-contact p, #prof-contact input").toggle();
        $("#submitBtn").toggle();
    });


    $("#registrationForm").submit(function (event) {
        event.preventDefault();

        var name = $("#name").val();
        var date = $("#date").val();
        var contact = $("#Contact").val();

        $.ajax({
            type: "POST",
            url: "php/profile.php",
            data: {
                name: name,
                date: date,
                contact: contact,
                email: email
            },
            success: function (response) {
            
                location.reload();
            },
            error: function (error) {
                console.log("Error:", error);
            }
        });
    });


    $("#logoutBtn").click(function () {
       
        localStorage.removeItem('token');
        
        window.location.href = 'index.html';
    });

});