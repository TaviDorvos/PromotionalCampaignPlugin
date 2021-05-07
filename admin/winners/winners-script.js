(function($) {
    //Used for 'export' button
    //to export all winners whoo choosed the prize and weren't exported before
    //winners-view.php -> bottom button
    $("#export").on("click", function(e) {
        e.preventDefault();

        if (window.confirm("You are about to export the winners who have chosen their prize. \n Are you sure you want to do this?")) {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    'action': 'export_winners_process'
                },
                success: function(response) {
                    console.log("success");
                    console.log(response);
                    if (response === "success") {
                        alert("The winners were successfully exported!");
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