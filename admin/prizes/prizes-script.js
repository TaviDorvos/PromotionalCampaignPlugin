(function($) {
    //Used for 'edit-prize-form
    //for updating the info about the prize
    //edit-prize.php
    $(document).on("submit", "#edit-prize-form", function(e) {
        e.preventDefault()

        var formData = new FormData(document.getElementById('edit-prize-form'));

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log("success");
                console.log(response);
                if (response === "success") {
                    alert("The changes have been made successfully!");
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
    });

    //Used for 'add-prize-form'
    //for adding a new prize to the database
    //prizes-view.php
    $(document).on("submit", "#add-prize-form", function(e) {
        e.preventDefault();

        var formData = new FormData(document.getElementById('add-prize-form'));

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log("success");
                console.log(response);
                if (response === "success") {
                    alert("The prize has been added!");
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
    });

    //Used for 'delete-prize-form'
    //to delete a priz from the database
    //prizes-tables.php -> column_delete()
    $("#delete-prize").on("click", function(e) {
        e.preventDefault();

        var id_prize = this.getAttribute("data-prize-id");

        if (window.confirm("Are you sure you want to delete this prize?")) {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    'action': 'delete_prize_form_process',
                    'id_prize': id_prize,
                },
                success: function(response) {
                    console.log("success");
                    console.log(response);
                    if (response === "success") {
                        alert("The prize has been deleted!");
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