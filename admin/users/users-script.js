(function($) {
    //Used for 'get-winner' button
    //to select a winner from the registered users
    //users-view.php -> bottom button
    $("#get-winner").on("click", function(e) {
        e.preventDefault();

        if (window.confirm("You are about to draw 5 winners and send them an information email. \nAre you sure you want to do this? \nOnce selected, they cannot be changed.")) {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    'action': 'get_winner_process'
                },
                success: function(response) {
                    console.log("success");
                    console.log(response);
                    if (response === "success") {
                        alert("The winning codes were chosen successfully! \nThe winners received an information email!");
                        location.reload();
                    } else {
                        alert("Submit failed! \nError code: " + response);
                    }
                },
                error: function(response) {
                    console.log("error");
                    console.log(response);
                    alert("Submit failed! \n Error code: " + response);
                }
            });
        }
    });
})(jQuery)