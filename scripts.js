$("#login-toggle").click(function()
{
    if($('#login-toggle').html() == "Log In")
    {
        
        $('#login-type').val( "Log In");
        $('#submit').html( "Log In");
        $('#description').html("Log in using your email and password");
        $('#login-toggle').html("Sign Up");
    }
    else
    {
        $('#login-type').val("Sign Up");
        $('#submit').html( "Sign Up");
        $('#description').html("Interested? Sign up now.");
        $('#login-toggle').html("Log In");
    }
})
$("form").submit(function(e)
{
    var error = "";
    if($("#email").val() == "")
    {
        error += "<br>An email is required.";
    }
    if($("#password").val() == "")
    {
        error += "<br>A password is required.";
    }
    if (error != "")
    {
        $("#error-section").html('<div class="alert alert-danger" role="alert"><strong>There were error(s): </strong>' + error + '</div>');
        return false;
    }
    else 
    {
        return true;
    }
})

$('#diary').bind('input propertychange', function() {

      $.ajax({
        method: "POST",
        url: "update-database.php",
        data: { content: $("#diary").val() }
      });

});