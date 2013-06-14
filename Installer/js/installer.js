$(document).ready(function() {
    
    var page = 1;
    
    $("#cp").html($("#panel-"+page).html());
    
    $("#btnNext").click(function() {
        if(page < 5)
        {
            page++;
            console.log("panel " + page);
            changePanelContent(page);
        }
    });
    
    $("#btnPrev").click(function() {
        if(page > 1)
        {
            page--;
            console.log("panel " + page);
            changePanelContent(page);
        }
    });
});

    function changePanelContent(panelNumber) {
        if(panelNumber === 4) {
            writeAuthDetails();
            checkForTables();
        }
        $("#cp").html($("#panel-"+panelNumber).html());
    }

    function checkForTables() {
        var user = $("#txt_username").val();
        var pass = $("#txt_pass").val();
        var db = $("#txt_db").val();
        var host = $("#txt_host").val();

        $.ajax({
            url: "php/installFunctions.php",
            type: "GET",
            dataType: "json",
            data: { method: "updateOrInstall", username: user, password: pass, database: db, host: host },
            async: false
        }).done(function(data) {
            if(data === 1) {
                $("#btnDBCreate").addClass("hidden");
                $("#installTxt").text("We found existing anubis tables in database " + db);
            }
            else {
                $("#installTxt").text("We could not find any existing anubis tables in the database " + db);
                $("#btnDBUpdate").addClass("hidden");   
            }
        }).error(function(data) {
            ErrorMessage(data.responseText);
        }); 
    }

    function createDatabase() {
        console.log("create clicked");
        var user = $("#txt_username").val();
        var pass = $("#txt_pass").val();
        var db = $("#txt_db").val();
        var host = $("#txt_host").val();

        $.ajax({
            url: "php/installFunctions.php",
            type: "GET",
            dataType: "json",
            data: { method: "CreateTables", username: user, password: pass, database: db, host: host }
        }).success(function(data) {

        }).error(function(data) {
            console.log(data);
            ErrorMessage(data.responseText);
        });    
    }
    
    function updateTables() {  
        console.log("update clicked");
        var user = $("#txt_username").val();
        var pass = $("#txt_pass").val();
        var db = $("#txt_db").val();
        var host = $("#txt_host").val();
        
        $.ajax({
            url: "php/installFunctions.php",
            type: "GET",
            dataType: "json",
            contentType: "application/json",
            data: { method: "updateTables", username: user, password: pass, database: db, host: host },
            async: false
        }).success(function(data) {

        }).error(function(data) {
            console.log(data);
            ErrorMessage(data.responseText);
        });
    }
    
    function writeAuthDetails()
    {
        var userLogin = $("#txt_loginname").val();
        var userPass = $("#txt_loginpassword").val();
        console.log(userLogin + " " + userPass);
        $.ajax({
            url: "php/installFunctions.php",
            type: "GET",
            dataType: "json",
            contentType: "application/json",
            data: { method: "writeAuthDetails", user: userLogin, pass: userPass },
            async: false
        }).done(function(rsp) {

        }).error(function(rsp) {
            ErrorMessage(rsp.responseText);
        });
    }

    function SuccessMessage(message)
    {
         $("#result").html("<div class='alert alert-success'><strong>"+message+"</strong></div>");
    }
    
    function ErrorMessage(message)
    {
        $("#result").html("<div class='alert alert-error'><strong>"+message+"</strong></div>");
    }