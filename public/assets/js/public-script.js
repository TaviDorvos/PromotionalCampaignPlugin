(function($) {
    /*************************************************************** FRONT FORM.php ***********************************************************/
    // Front-End

    //only numbers in the phone field
    //not entering letters
    $('input[name="input-phone"]').keydown(function(e) {
        // Can be pressed only: BACKSPACE, DELETE, TAB
        if ($.inArray(e.keyCode, [46, 8, 9]) !== -1) {
            return;
        }
        // Only numbers from the keyboard(Numpad too)
        if ((e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    }).on('paste', function(e) {
        e.preventDefault();
    });

    $("#contact-form").submit(function(e) {
        e.preventDefault();
        $('#contact-form input').css({
            "border": "1px solid #ccc"
        });

        // every field variable
        var inputLastName = $('input[name="input-last-name"]');
        var inputFirstName = $('input[name="input-first-name"]');
        var inputEmail = $('input[name="input-email"]');
        var inputPhone = $('input[name="input-phone"]');
        var inputCounty = $('input[name="input-county');


        var formData = new FormData(this);
        var ajaxurl = ajax_params.ajax_url; // I can acces ajax_url through ajax_params object
        var errors = validateFields();

        //checking if i have errors
        if (errors === undefined || errors.length === 0) {

            $("button.btn-primary").hide();
            $("img.loader").show();

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
                        alert("The form has been sent successfully!");
                        location.reload();
                    } else {
                        alert("Submit failed! \nError code: " + response);
                        location.reload();
                    }
                },
                error: function(response) {
                    console.log("error");
                    console.log(response);
                    alert("Submit failed! \n Error code: " + response);
                }
            })
        } else show_errors(errors);

        //diacritics 
        /*
          Ă --- u0103; Ş --- u0218; Â --- u00C2;
          ă --- u0102; ş --- u0219; â --- u00E2;
          Ţ --- u021A; Î --- u00CE;
          ţ --- u021B; î --- u00EE;
        */
        function validateFields() {
            var errors = [];
            var nameCondition = new RegExp("^[A-Za-z\u0103\u0102\u021A\u021B\u0218\u0219\u00CE\u00EE\u00C2\u00E2]+$");
            var emailCondition = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

            //LastName validation
            //In case of an empty field or the use of special characters
            if (inputLastName.val() === "") {
                errors.push({
                    "field": "input-last-name",
                    "error": "Empty field"
                });
            } else if (nameCondition.test(inputLastName.val()) == false) {
                errors.push({
                    "field": "input-last-name",
                    "error": "Do not use special characters such as: ()-/\*&^%$#@!"
                });
            }
            //FirstName validation
            //In case of an empty field or the use of special characters
            if (inputFirstName.val() === "") {
                errors.push({
                    "field": "input-first-name",
                    "error": "Empty field"
                });
            } else if (nameCondition.test(inputFirstName.val()) == false) {
                errors.push({
                    "field": "input-first-name",
                    "error": "Do not use special characters such as: ()-/\*&^%$#@!"
                });
            }
            //City validation
            //In case of an empty field or the use of special characters
            if (inputCounty.val() === "") {
                errors.push({
                    "field": "input-county",
                    "error": "Empty field"
                });
            } else if (nameCondition.test(inputCounty.val()) == false) {
                errors.push({
                    "field": "input-county",
                    "error": "Do not use special characters such as: ()-/*&^%$#@!"
                });
            }

            //Phone validation
            //In case of an empty field
            if (inputPhone.val() === "") {
                errors.push({
                    "field": "input-phone",
                    "error": "Empty field"
                });
            }

            //Email Validation
            //In case of an empty field or a wrong email format
            if (inputEmail.val() === "") {
                errors.push({
                    "field": "input-email",
                    "error": "Empty field"
                });
            } else if (emailCondition.test(inputEmail.val()) == false) {
                errors.push({
                    "field": "input-email",
                    "error": "Enter a valid email address"
                });
            }

            return errors;
        }

        // Clearing the old erorrs and then print the new ones if they exists
        function show_errors() {
            $(".error").remove();

            errors.forEach(function(value, index) {
                switch (value.field) {
                    default: $('#contact-form input[name*="' + value.field + '"]').before("<p class='error'>" + value.error + "</p>");
                    $('#contact-form input[name*="' + value.field + '"]').css({
                        "border": "1px solid red"
                    });
                    break;
                }
            })
            $(".error").fadeOut(3000);
        }
    });
    /***********************************************************************************************************************************************************************/

    //Used for 'winning-form.php' page
    $(document).on("submit", "#winning-code-form", function(e) {
        e.preventDefault()

        var winningCode = $("#input-win-code").val();
        var ajaxurl = ajax_params.ajax_url;

        $.ajax({
            url: ajaxurl,
            type: 'GET',
            data: {
                'action': 'winning_code_process',
                'win-code': winningCode,
            },
            success: function(response) {
                console.log("success");
                console.log(response);
                if (response == "success") {
                    alert("Congratulations! \nYou will be redirected to a new page where you can choose your prize!");
                    var encoded = $.md5(winningCode);
                    window.location.href = "http://localhost/codes_campaign/prize-page?token=" + encoded;
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


    //Used for 'winning-form.php' page
    $(document).on("submit", "#choose-prize-form", function(e) {
        e.preventDefault()

        var prizeChoose = $('input[name="prize"]:checked').val();;
        var ajaxurl = ajax_params.ajax_url;

        //getting the encoded token
        var url = window.location;
        var currentToken = new URLSearchParams(url.search).get('token');

        if (confirm("Are you sure about the prize you have chosen? \nIt cannot be changed or modified!")) {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    'action': 'choose_prize_process',
                    'prize-choose': prizeChoose,
                    'current-token': currentToken
                },
                success: function(response) {
                    console.log("success");
                    console.log(response);
                    if (response == "success") {
                        $('.choose-prize-form').empty();
                        $('#choose-prize-form').html("<h1>Congratulations, you have chosen your prize!");
                        window.setTimeout(function() {
                            window.location.href = 'http://localhost/codes_campaign/';
                        }, 3000);
                    } else {
                        alert("Submit failed! \nError code: " + response);
                        window.location.href = "http://localhost/codes_campaign/did-you-win/";
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