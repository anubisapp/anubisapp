$(document).ready(function() {
    
    $("#btnDBCreate").click(function(event) {
        event.preventDefault();

        var user = $("#txt_username").val();
        var pass = $("#txt_pass").val();
        var db = $("#txt_db").val();
        var host = $("#txt_host").val();

        $.ajax({
            url: "php/createTable.php",
            type: "GET",
            dataType: "json",
            data: { method: "CreateTables", username: user, password: pass, database: db, host: host }
        }).done(function(data) {
                SuccessMessage(data);
        }).error(function(data) {
            console.log(data);
            if(data.responseText == "") {
                ErrorMessage("Sorry about this something unexpected happened, please check your database to see if the tables have been created");
            }
            else {
                ErrorMessage(data.responseText);
            }
        });
    });
    $("#btnDBUpdate").click(function(event) {
        event.preventDefault();
        
        var user = $("#txt_username").val();
        var pass = $("#txt_pass").val();
        var db = $("#txt_db").val();
        var host = $("#txt_host").val();
        
        $.ajax({
            url: "php/createTable.php",
            type: "GET",
            dataType: "json",
            data: { method: "updateTables", username: user, password: pass, database: db, host: host }
        }).done(function(data) {
            SuccessMessage(data);
        }).error(function(data) {
            console.log(data);
            if(data.responseText == "") {
                ErrorMessage("Sorry about this something unexpected happened, please check your database to see if the tables have been created");
            }
            else {
                ErrorMessage(data.responseText);
            }
        });
    });
    
    function SuccessMessage(message)
    {
         $("#result").html("<div class='alert alert-success'><strong>"+message+"</strong></div>");
    }
    
    function ErrorMessage(message)
    {
        $("#result").html("<div class='alert alert-error'><strong>"+message+"</strong></div>");
    }
    
    
});