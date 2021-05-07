<?php

//displaying the front-form page
//where is the shortcode for the front form
include 'shortcodes/front-form.php';

//displaying the winning code form
//for the winners
include 'shortcodes/winning-form.php';

//displaying the choose prize form
//for the winners
include 'shortcodes/choose-prize.php';

function codes_campaign_plugin_public_scripts() {

    wp_register_script('codes-campaign-plugin-public-js', plugin_dir_url(__DIR__) . 'public/assets/js/public-script.js', array(), _S_VERSION, true);
    wp_register_script('codes-campaign-plugin-md5', plugin_dir_url(__DIR__) . 'public/assets/js/md5-script.js', array(), _S_VERSION, true);

    wp_localize_script('codes-campaign-plugin-public-js', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));

    wp_enqueue_script('codes-campaign-plugin-public-js');
    wp_enqueue_script('codes-campaign-plugin-md5');

    //all styles
    wp_enqueue_style('codes-campaign-style', plugin_dir_url(__DIR__) . 'public/assets/css/style.css', array(), _S_VERSION);
    wp_enqueue_style('codes-campaign-style-bootstrap', plugin_dir_url(__DIR__) . 'assets/bootstrap/css/bootstrap.min.css', array(), _S_VERSION);

    //all scripts
    wp_enqueue_script('codes-campaign-bootstrap-js', plugin_dir_url(__DIR__) . 'assets/bootstrap/js/bootstrap.min.js', array('jquery'), _S_VERSION, true);
    wp_enqueue_script('codes-campaign-jquery', plugin_dir_url(__DIR__) . 'assets/bootstrap/js/jquery-3.5.1.min.js', array('jquery'), _S_VERSION, true);
}
add_action('wp_enqueue_scripts', 'codes_campaign_plugin_public_scripts');

/*********************************************  FRONT-FORM.php FUNCTIONS *************************************************/
//Inserting the info from the front form
//into the database
function adding_details_process() {
    global $wpdb;

    //checking for errors(rightly filled ot not empty)
    if (validate_fields() == false) {

        //checking if the code is valid or used
        $currentCode = $_POST['input-code'];
        $codeQuery = "SELECT used FROM generated_codes WHERE gen_code ='$currentCode'";
        $codeQueryResult = $wpdb->get_row($codeQuery, ARRAY_A);

        if ($codeQueryResult['used'] == '0') {

            $currentPhoneNumber = $_POST['input-phone'];
            $queryPhoneList = "SELECT phone FROM users_details WHERE phone='$currentPhoneNumber'";
            $phoneListResult = $wpdb->get_row($queryPhoneList, ARRAY_A);

            //if the user is new one
            //add info into the users_details 
            if ($phoneListResult == null) {
                $users_details = $wpdb->insert(
                    "users_details",
                    array(
                        "lastName" => $_POST['input-last-name'],
                        "firstName" => $_POST['input-first-name'],
                        "phone" => $_POST['input-phone'],
                        "email" => $_POST['input-email'],
                        "country" => $_POST['input-country'],
                        "county" => $_POST['input-county'],
                        "city" => $_POST['input-city'],
                        "address" => $_POST['input-address'],
                    )
                );

                //last id inserted
                $id_user = $wpdb->insert_id;
            } else {
                $queryGetID = "SELECT id_user FROM users_details WHERE phone='$currentPhoneNumber'";
                $id_user = $wpdb->get_var($queryGetID);
            }

            //adding the code into users codes
            //for the person who used it
            $results_codes = $wpdb->insert(
                "users_codes",
                array(
                    "code" => $_POST['input-code'],
                    "id_user" => $id_user
                )
            );

            if ($results_codes != false || $users_details != false) {
                //making the code used
                $wpdb->update('generated_codes', array(
                    'used' => 1
                ), array(
                    'gen_code' => $currentCode
                ));
                echo ("success");
            } else {
                echo ("Database insert failed. Please try again.");
            }
        } else {
            echo ("Enter a valid code!");
        }
    }

    wp_die();
}
add_action('wp_ajax_adding_details_process', 'adding_details_process');
add_action('wp_ajax_nopriv_adding_details_process', 'adding_details_process');

//Checking if the fields are valid
function validate_fields() {

    $error = false;

    //Verify LAST NAME
    if (empty($_POST["input-last-name"])) {
        $error = true;
        return $error;
        // } else {
        //     $inputLastName = test_input($_POST['input-last-name']);
        //     echo($inputLastName);
        //     if (!preg_match('/^[A-Za-z\u0103\u0102\u021A\u021B\u0218\u0219\u00CE\u00EE\u00C2\u00E2]+$/', $inputLastName)) {
        //         echo(" last name ");
        //         $error = true;
        //         return $error;
        //     }
    }

    //Verify FIRST NAME
    if (empty($_POST["input-first-name"])) {
        $error = true;
        return $error;
        // } else {
        //     $inputFirstName = test_input($_POST['input-first-name']);
        //     echo($inputFirstName);
        //     if (!preg_match("^[A-Za-z\u0103\u0102\u021A\u021B\u0218\u0219\u00CE\u00EE\u00C2\u00E2]+$", $inputFirstName)) {
        //         echo("first name");
        //         $error = true;
        //         return $error;
        //     }
    }

    //Verify COUNTY
    if (empty($_POST["input-city"])) {
        $error = true;
        return $error;
        // } else {
        //     $inputCity = test_input($_POST['input-city']);
        //     if (!preg_match("/^[A-Za-z\u0103\u0102\u021A\u021B\u0218\u0219\u00CE\u00EE\u00C2\u00E2]+$/", $inputCity)) {
        //         echo("city");
        //         $error = true;
        //         return $error;
        //     }
    }

    //Verify EMAIL
    if (empty($_POST["input-email"])) {
        $error = true;
        return $error;
        // } else {
        //     $inputEmail = test_input($_POST['input-email']);
        //     if (!preg_match("/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/", $inputEmail)) {
        //         echo("email");
        //         $error = true;
        //         return $error;
        //     }
    }
    //Verify PHONE NUMBER
    if (empty($_POST["input-phone"])) {
        $error = true;
        return $error;
        // } else {
        //     $inputPhone = test_input($_POST['input-phone']);
        //     if (!preg_match("^[0-9]+$", $inputPhone)) {
        //         echo("numbar");
        //         $error = true;
        //         return $error;
        //     }
    }

    return $error;
}

//strip unnecessary characters (extra space, tab, newline)
//remove backslashes (\) from the user input data with the PHP stripslashes() function.
//htmlspecialchars() function converts special characters to HTML entities
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
/********************************************************************************************************************************************************************************/


/*************************************************************** WINNING-FORM.PHP *********************************************************************************************/
//Function for the 'winning-form-code'
//Checking if the inserted code exists as a winning one
//winning-form.php
function winning_code_process() {
    global $wpdb;

    $winningCode = $_GET['win-code'];

    $winCodeQuery = "SELECT win_code, choosed_prize FROM winners WHERE win_code ='$winningCode'";
    $winCodeResult = $wpdb->get_row($winCodeQuery, ARRAY_A);

    if ($winCodeResult == null) {
        $saved = false;
    } else if($winCodeResult['choosed_prize'] == "no") {
        $saved = true;
    } else echo "The prize has already been chosen.\n";

    if ($saved) {
        echo "success";
    } else {
        echo "Database insert failed. Please try again.";
    }

    wp_die();
}
add_action('wp_ajax_winning_code_process', 'winning_code_process');
add_action('wp_ajax_nopriv_winning_code_process', 'winning_code_process');

/********************************************************************************************************************************************************************************/

/*************************************************************** CHOOSE-PRIZE.PHP *********************************************************************************************/
//Function for the 'choose-prize-form'
//choosing the prize for the selected winner
//choose-prize.php
function choose_prize_process() {
    global $wpdb;

    $prizeChoosen = $_POST['prize-choose'];
    $currentToken = $_POST['current-token'];

    //verify if the winner choosed his prize
    $checkChooseQuery = "SELECT choosed_prize FROM winners WHERE md5_code ='$currentToken'";
    $checkChooseResult = $wpdb->get_row($checkChooseQuery, ARRAY_A);

    //getting the actual stock
    $quantityCheckQuery = "SELECT quantity FROM prizes WHERE id_prize = '$prizeChoosen'";
    $quantityCheckResult = $wpdb->get_row($quantityCheckQuery, ARRAY_A);

    if($checkChooseResult['choosed_prize'] == "no") {
        $updated = $wpdb->update('prizes', array(
            'quantity' => ($quantityCheckResult['quantity'] - 1),
        ), array(
            'id_prize' => $prizeChoosen,
        ));

        $updated = $wpdb->update('winners', array(
            'choosed_prize' => 'yes',
            'prize_id' => $prizeChoosen,
        ), array(
            'md5_code' => $currentToken
        ));  
    } else echo "The prize has already been chosen.";
    
    if ($updated) {
        echo "success";
    } else {
        echo "Database insert failed. Please try again.";
    }

    wp_die();
}
add_action('wp_ajax_choose_prize_process', 'choose_prize_process');
add_action('wp_ajax_nopriv_choose_prize_process', 'choose_prize_process');

/********************************************************************************************************************************************************************************/
