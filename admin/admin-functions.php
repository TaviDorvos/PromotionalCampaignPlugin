<?php
if (!function_exists('wp_handle_upload')) {
    require_once(ABSPATH . 'wp-admin/includes/file.php');
}

function admin_scripts() {
    //all styles
    wp_enqueue_style('codes-campaign-style-bootstrap', plugin_dir_url(__DIR__) . 'assets/bootstrap/css/bootstrap.min.css', array(), _S_VERSION);
    wp_enqueue_style('codes-campaign-statistics-style', plugin_dir_url(__DIR__) . 'assets/css/statistics-style.css', array(), _S_VERSION);

    //all scripts
    wp_enqueue_script('codes-campaign-bootstrap-js', plugin_dir_url(__DIR__) . 'assets/bootstrap/js/bootstrap.min.js', array('jquery'), _S_VERSION, true);
    wp_enqueue_script('codes-campaign-jquery', plugin_dir_url(__DIR__) . 'assets/bootstrap/js/jquery-3.5.1.min.js', array('jquery'), _S_VERSION, true);
    wp_enqueue_script('prizes-script', plugin_dir_url(__DIR__) . 'admin/prizes/prizes-script.js', array('jquery'), _S_VERSION, true);
    wp_enqueue_script('users-script', plugin_dir_url(__DIR__) . 'admin/users/users-script.js', array('jquery'), _S_VERSION, true);
    wp_enqueue_script('winners-script', plugin_dir_url(__DIR__) . 'admin/winners/winners-script.js', array('jquery'), _S_VERSION, true);
}
add_action('admin_enqueue_scripts', 'admin_scripts');

//wordpress menu pages
function add_codes_campaign_plugin_pages() {
    // registered users page
    add_menu_page("Participants", "Participants", 'manage_options', 'users-view-page', 'users_view', 'dashicons-buddicons-buddypress-logo', 100);
    // list of available prizes
    add_submenu_page("users-view-page", "Prizes", "Prizes", 'manage_options', 'prizes-view-page', 'prizes_view', 1);
    // list with all days of extractions
    add_submenu_page("users-view-page", "Raffle Draw", "Raffle Draw", 'manage_options', 'extracted-dates-page', 'extracted_dates_view', 2);
    // hide page with all used codes by the users
    add_submenu_page(null, null, 'Entered Codes', 'manage_options', 'used_codes', 'used_codes_view');
    // hide page to edit a current prize 
    add_submenu_page(null, null, 'Edit', 'manage_options', 'edit_prize', 'prizes_edit');
    // hide page which can see all the winning codes 
    add_submenu_page(null, null, 'See Entered Codes', 'manage_options', 'winners_view_page', 'winners_view');
    // hide page to edit a current prize 
    add_submenu_page(null, null, 'Winner Informations', 'manage_options', 'info_winner_page', 'info_winner_view');
    // statistics page
    add_menu_page("Statistics", "Statistics", 'manage_options', 'statistics-page', 'statistics_view', 'dashicons-analytics', 101);
}
add_action("admin_menu", "add_codes_campaign_plugin_pages");

//view for all registered users
function users_view() {
    include "users/users-view.php";
}

//view for all used codes by an user
function used_codes_view() {
    include "users/used-codes-view.php";
}

//view for all prizes available
function prizes_view() {
    include "prizes/prizes-view.php";
}

//page for editing the prize
function prizes_edit() {
    include "prizes/edit-prize.php";
}

//view for all winners
function winners_view() {
    include "winners/winners-view.php";
}

//view for all dates where was an extraction
function extracted_dates_view() {
    include "winners/extracted-dates-view.php";
}

//view for a winner who choosed his prize and
//displaying info about the delivery address
function info_winner_view() {
    include "winners/info-winners.php";
}

function statistics_view() {
    include "statistics/statistics-page.php";
}


//Update info about the a prize
//edit-prize.php
function edit_prize_form_process() {
    global $wpdb;

    $id_prize = $_POST['input-id-prize'];
    $nameUpdated = $_POST['input-name-prize'];
    $quantityUpdated = $_POST['input-quantity'];
    $descriptionUpdated = $_POST['input-description'];

    $uploadedFile = $_FILES['input-edit-image'];
    $uploadOverrides = array('test_form' => false);

    $movefile = wp_handle_upload($uploadedFile, $uploadOverrides);

    $tableName = 'prizes';
    //in case an image is uploaded
    $tableDataImage = array(
        'name_prize' => $nameUpdated,
        'quantity' => $quantityUpdated,
        'description' => $descriptionUpdated,
        'image' => $movefile['url'],
    );

    //in case a new image is not uploaded
    $tableDataNoImage = array(
        'name_prize' => $nameUpdated,
        'quantity' => $quantityUpdated,
        'description' => $descriptionUpdated,
    );
    $tableWhere = array('id_prize' => $id_prize);

    if ($movefile && !isset($movefile['error'])) {
        $saved = $wpdb->update($tableName, $tableDataImage, $tableWhere);
    } else {
        $saved = $wpdb->update($tableName, $tableDataNoImage, $tableWhere);
    }

    if ($saved) {
        echo "success";
    } else {
        echo "The changes could not be saved!";
    }

    wp_die();
}
add_action('wp_ajax_edit_prize_form_process', 'edit_prize_form_process');
add_action('wp_ajax_nopriv_edit_prize_form_process', 'edit_prize_form_process');

//adding a new prize to the database
//prizes-view.php
function add_prize_form_process() {
    global $wpdb;

    $prizeNameAdd = $_POST['input-name-add'];
    $quantityAdd = $_POST['input-add-quantity'];
    $descriptionAdd = $_POST['input-add-description'];
    $uploadedFile = $_FILES['input-add-image'];

    $uploadOverrides = array('test_form' => false);

    $movefile = wp_handle_upload($uploadedFile, $uploadOverrides);

    $added = $wpdb->insert(
        "prizes",
        array(
            'name_prize' => $prizeNameAdd,
            'quantity' => $quantityAdd,
            'description' => $descriptionAdd,
            'image' => $movefile['url'],
        )
    );

    if ($added) {
        echo "success";
    } else {
        echo "The prize could not be added! ";
    }

    wp_die();
}
add_action('wp_ajax_add_prize_form_process', 'add_prize_form_process');
add_action('wp_ajax_nopriv_add_prize_form_process', 'add_prize_form_process');

//deleting prize from the database
//prizes-tables.php
function delete_prize_form_process() {
    global $wpdb;

    $id_prize = $_POST['id_prize'];

    $deleted = $wpdb->delete('prizes', array(
        'id_prize' => $id_prize,
    ));

    if ($deleted) {
        echo "success";
    } else {
        echo "The prize could not be deleted!";
    }

    wp_die();
}
add_action('wp_ajax_delete_prize_form_process', 'delete_prize_form_process');
add_action('wp_ajax_nopriv_delete_prize_form_process', 'delete_prize_form_process');

//get a winning code from all registered codes by users
//users-view.php
function get_winner_process() {
    global $wpdb;

    $randomWinnerQuery = "SELECT * FROM users_details INNER JOIN users_codes 
    ON users_details.id_user = users_codes.id_user WHERE users_codes.win = 0
    ORDER BY RAND()
    LIMIT 5";
    $randomWinnerResults = $wpdb->get_results($randomWinnerQuery, ARRAY_A);

    //If I want only on winning code, change the limit to 1 
    //and change the function 'get_results' to 'get_row'
    //do not use anymore the 'foreach' loop

    foreach ($randomWinnerResults as $result) {
        //mailing the winners
        $to = "tavi.dorvos121@gmail.com"; //just for the test, for the real application i will change it to '$result['email']'
        $subject = "You Won!";
        $body = "Felicitări, \n" . $result['lastName'] . " " . $result['firstName'] . ", \nThe code you use, " . $result['code'] . ", was drawn as a winner! \ nPlease enter our page to choose your prize!";
        $headers = "From: Promotional campaign";

        mail($to, $subject, $body, $headers);

        $updated = $wpdb->update('users_codes', array('win' => 1), array('code' => $result['code']));

        $added = $wpdb->insert(
            "winners",
            array(
                'win_code' => $result['code'],
                'md5_code' => md5($result['code']),
                'id_user' => $result['id_user'],
                'exported' => "no",
                'choosed_prize' => "no",
            )
        );
    }

    if ($added && $updated) {
        echo "success";
    } else if ($randomWinnerResults == null) {
        echo "There are no registrations!";
    } else {
        echo "Could not choose winning codes!";
    }

    wp_die();
}
add_action('wp_ajax_get_winner_process', 'get_winner_process');
add_action('wp_ajax_nopriv_get_winner_process', 'get_winner_process');

//export all winners who choosed their prize into an xls
//winners-view.php
function export_winners_process() {
    global $wpdb;

    $prizeChoosedQuery = "SELECT choosed_prize FROM winners WHERE choosed_prize='da' AND exported='no'";
    $prizeChoosedResult = $wpdb->get_results($prizeChoosedQuery, ARRAY_A);

    if ($prizeChoosedResult != null) {

        require plugin_dir_url(__DIR__) . 'assets/phpspreadsheet/creating-excels.php';

        $updated = $wpdb->update('winners', array(
            'exported' => "yes"
        ), array(
            'choosed_prize' => "yes"
        ));
    }

    if ($updated) {
        echo "success";
    } else {
        echo "There are no winners to export.";
    }

    wp_die();
}
add_action('wp_ajax_export_winners_process', 'export_winners_process');
add_action('wp_ajax_nopriv_export_winners_process', 'export_winners_process');
