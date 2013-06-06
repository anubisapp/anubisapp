$(document).ready(function() {
    
    var page = 1;
    
    $("#cp").html($("#panel-"+page).html());
    
    $("#btnNext").click(function() {
        if(page < 4)
        {
            page++;
            changePanelContent(page);
        }
    });
    
    $("#btnPrev").click(function() {
        if(page > 1)
        {
            page--;
            changePanelContent(page);
        }
    });
});

    function changePanelContent(panelNumber) {
        if(panelNumber === 2) checkForTables();
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
                SuccessMessage(data);
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
            data: { method: "updateTables", username: user, password: pass, database: db, host: host }
        }).success(function(data) {
            SuccessMessage(data);
        }).error(function(data) {
            console.log(data);
            ErrorMessage(data.responseText);
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