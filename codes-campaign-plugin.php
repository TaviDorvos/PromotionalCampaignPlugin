<?php

/**
 * @package codesCampaign
 */
/*
    Plugin Name: Codes Campaign
    Plugin URI: https://github.com/TaviDorvos
    Description: This plugin is a form that allows you to insert a promo code and pick a random winners when you want.
    Version: 1.0.0
    Author: Octavian-Vincentiu Dorvos
    Author URI: https://www.linkedin.com/in/octavian-dorvos/
    License: GPLv2 or later
    Text Domanin: codes-campaign
*/

// It prevent public user to directly access 
// your .php files through URL
defined('ABSPATH') or die('Died');


function codes_campaign_installer() {
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    //Creating the database for the users_details
    $usersDetailsTable = "CREATE TABLE IF NOT EXISTS users_details ( 
                id_user int(11) NOT NULL auto_increment, 
                lastName TEXT NOT NULL, 
                firstName TEXT NOT NULL, 
                phone TEXT NOT NULL, 
                email TEXT NOT NULL, 
                country TEXT NOT NULL, 
                county TEXT NOT NULL, 
                city TEXT NOT NULL, 
                address TEXT NOT NULL,  
                date_current DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
                PRIMARY KEY (id_user) 
                ) $charset_collate;";

    //Creating the database for the users_codes
    $usersCodesTable = "CREATE TABLE IF NOT EXISTS users_codes ( 
        id int(11) NOT NULL auto_increment, 
        code TEXT NOT NULL,  
        win int NOT NULL,
        id_user int(11) NOT NULL,
        date_current DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
        PRIMARY KEY (id),
        FOREIGN KEY (id_user) REFERENCES users_details(id_user) 
        ) $charset_collate;";

    //Creating the database with the generated codes
    $generatedCodesTable = "CREATE TABLE IF NOT EXISTS generated_codes (
        id int(11) NOT NULL auto_increment,
        gen_code TEXT NOT NULL,
        used int(1) NOT NULL,
        PRIMARY KEY (id)
        ) $charset_collate;";

    //Creating the database for the prizes
    $prizesTable = "CREATE TABLE IF NOT EXISTS prizes (
        id_prize int(11) NOT NULL auto_increment,
        name_prize TEXT NOT NULL,
        quantity int NOT NULL,
        image TEXT NULL,
        description TEXT NULL,
        date_current DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id_prize)
        ) $charset_collate;";

    //Creating the database for the winners
    $winnersTable = "CREATE TABLE IF NOT EXISTS winners (
        id_winner int(11) NOT NULL auto_increment,
        win_code TEXT NOT NULL,
        md5_code TEXT NOT NULL,
        id_user int(11) NOT NULL,
        choosed_prize TEXT NOT NULL,
        prize_id int(11) NULL,
        exported TEXT NOT NULL,
        date_current DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id_winner) 
        ) $charset_collate;";

    require_once(ABSPATH . '/wp-admin/includes/upgrade.php');

    dbDelta($usersDetailsTable);
    dbDelta($usersCodesTable);
    dbDelta($generatedCodesTable);
    dbDelta($prizesTable);
    dbDelta($winnersTable);
}

register_activation_hook(__FILE__, 'codes_campaign_installer');

require plugin_dir_path(__FILE__) . 'public/public-functions.php';

require plugin_dir_path(__FILE__) . 'admin/admin-functions.php';
