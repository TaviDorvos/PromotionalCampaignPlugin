<?php

//the class table to show all the winners
class WinnersTable extends WP_List_Table {

    //getting prizes from database 'winners'
    static function get_winners($per_page = 15, $page_number = 1) {

        global $wpdb;
        $current_date = $_GET['date_current'];

        $sql = "SELECT * FROM winners WHERE date_current = '$current_date'";

        if (!empty($_REQUEST['orderby'])) {
            $sql .= ' ORDER BY ' . esc_sql($_REQUEST['orderby']);
            $sql .= !empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
        }

        $sql .= " LIMIT $per_page";

        $sql .= ' OFFSET ' . ($page_number - 1) * $per_page;

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;
        var_dump($result);
    }
    //

    //if there is no prizes available
    function no_items() {
        _e('No winner available.', 'sp');
    }

    //counting the records
    static function record_count() {
        global $wpdb;
        $current_date = $_GET['date_current'];

        $query = "SELECT COUNT(*) FROM winners WHERE date_current = '$current_date'";

        return $wpdb->get_var($query);
    }

    //creating the columns and the content
    function get_columns() {
        $columns = array(
            'id_winner' => 'ID win',
            'id_user' => 'ID participant',
            'win_code' => 'Winning code',
            'choosed_prize' => 'Choosen prize',
            'exported' => 'Exported',
            'date_current' => "Draw date"
        );

        return $columns;
    }

    function prepare_items() {

        $this->_column_headers = $this->get_column_info();

        $per_page     = $this->get_items_per_page('users_per_page', 15);
        $current_page = $this->get_pagenum();
        $total_items  = self::record_count();

        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page'    => $per_page
        ]);

        $columns  = $this->get_columns();
        $hidden   = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items           = self::get_winners($per_page, $current_page);
    }

    function column_default($item, $column_name) {
        switch ($column_name) {
            case 'id_winner':
            case 'win_code':
            case 'id_user':
            case 'choosed_prize':
            case 'exported':
            case 'date_current':
                return $item[$column_name];
            default:
                return print_r($item, true);
        }
    }

    //making the columns to be sortable
    function get_sortable_columns() {
        $sortable_columns = array(
            'id_winner' => array('id_winner', false),
            'id_user' => array('id_user', false),
            'choosed_prize' => array('choosed_prize', false),
            'exported' => array('exported', false),
            'date_current' => array('date_current', false),
        );

        return $sortable_columns;
    }

    function column_choosed_prize($item) {
        if ($item['choosed_prize'] == "no")
            return "<p class='text-danger mb-0'>".$item['choosed_prize']."</p>";
        else if ($item['choosed_prize'] == "yes")
            return "<a class='text-success' href='" . admin_url('admin.php?page=info_winner_page&id_user=' . $item['id_user'] . '&id_winner=' . $item['id_winner']) . "'><b><i>yes</i></b></a>";
    }

    function column_exported($item) {
        if ($item['exported'] == "no")
            return "<p class='text-danger mb-0'>".$item['exported']."</p>";
        else if ($item['exported'] == "yes")
            return "<p class='text-success mb-0'><b>".$item['exported']."</b></p>";
    }
}

class ExtractedDatesTable extends WP_List_Table {

    //getting extraction dates
    static function get_dates($per_page = 15, $page_number = 1) {

        global $wpdb;

        $sql = "SELECT DISTINCT date_current FROM winners";

        if (!empty($_REQUEST['orderby'])) {
            $sql .= ' ORDER BY ' . esc_sql($_REQUEST['orderby']);
            $sql .= !empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
        }

        $sql .= " LIMIT $per_page";

        $sql .= ' OFFSET ' . ($page_number - 1) * $per_page;

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;
        var_dump($result);
    }
    //

    //if there is no date available
    function no_items() {
        _e('No date available.', 'sp');
    }

    //counting the records
    static function record_count() {
        global $wpdb;

        $query = "SELECT COUNT(DISTINCT date_current) FROM winners";

        return $wpdb->get_var($query);
    }

    //creating the columns and the content
    function get_columns() {
        $columns = array(
            'date_current' => "Draw date",
            'winners_list' => "List of winning codes",
        );

        return $columns;
    }

    function prepare_items() {

        $this->_column_headers = $this->get_column_info();

        $per_page     = $this->get_items_per_page('users_per_page', 15);
        $current_page = $this->get_pagenum();
        $total_items  = self::record_count();

        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page'    => $per_page
        ]);

        $columns  = $this->get_columns();
        $hidden   = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items           = self::get_dates($per_page, $current_page);
    }

    function column_default($item, $column_name) {
        switch ($column_name) {
            case 'date_current':
                return $item[$column_name];
            default:
                return print_r($item, true);
        }
    }

    //making the columns to be sortable
    function get_sortable_columns() {
        $sortable_columns = array(
            'date_current' => array('date_current', false),
        );

        return $sortable_columns;
    }

    function column_winners_list($item) {
        return "<a href='" . admin_url('admin.php?page=winners_view_page&date_current=' . $item['date_current']) . "'>Winning codes</a>";
    }
}

//extracted winners with the info about delivery address and prize choosen
class InfoWinnersTable extends WP_List_Table {

    //getting prizes from database 'winners'
    static function get_info($per_page = 15, $page_number = 1) {

        global $wpdb;
        $id_winner = $_GET['id_winner'];

        $sql = "SELECT * FROM (( users_details INNER JOIN winners ON users_details.id_user = winners.id_user ) INNER JOIN prizes ON winners.prize_id = prizes.id_prize ) WHERE winners.id_winner = '$id_winner'";

        if (!empty($_REQUEST['orderby'])) {
            $sql .= ' ORDER BY ' . esc_sql($_REQUEST['orderby']);
            $sql .= !empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
        }

        $sql .= " LIMIT $per_page";

        $sql .= ' OFFSET ' . ($page_number - 1) * $per_page;

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;
        var_dump($result);
    }
    //

    //counting the records
    static function record_count() {
        global $wpdb;

        $id_winner = $_GET['id_winner'];
        $query = "SELECT COUNT(*) FROM (( users_details INNER JOIN winners ON users_details.id_user = winners.id_user ) INNER JOIN prizes ON winners.prize_id = prizes.id_prize ) WHERE winners.id_winner = '$id_winner'";

        return $wpdb->get_var($query);
    }

    //creating the columns and the content
    function get_columns() {
        $columns = array(
            'lastName' => 'Last Name',
            'firstName' => 'First Name',
            'phone' => 'Phone number',
            'email' => 'Email',
            'county' => 'County',
            'city' => 'City',
            'address' => 'Address',
            'prize_id' => 'ID Prize',
            'name_prize' => "Prize Name",
            'image' => 'Prize Image'
        );

        return $columns;
    }

    function prepare_items() {

        $this->_column_headers = $this->get_column_info();

        $per_page     = $this->get_items_per_page('users_per_page', 15);
        $current_page = $this->get_pagenum();
        $total_items  = self::record_count();

        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page'    => $per_page
        ]);

        $columns  = $this->get_columns();
        $hidden   = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items           = self::get_info($per_page, $current_page);
    }

    function column_default($item, $column_name) {
        switch ($column_name) {
            case 'lastName':
            case 'firstName':
            case 'phone':
            case 'email':
            case 'county':
            case 'city':
            case 'address':
            case 'prize_id':
            case 'name_prize':
                return $item[$column_name];
            default:
                return print_r($item, true);
        }
    }

    //making the columns to be sortable
    function get_sortable_columns() {
        $sortable_columns = array(
            'lastName' => array('lastname', false),
            'county' => array('county', false),
            'city' => array('city', false),
            'prize_id' => array('prize_id', false),
            'name_prize' => array('name_prize', false),
        );

        return $sortable_columns;
    }

    //Redirects to the prize's image
    function column_image($item) {
        return "<a href='" . $item['image'] . "'>Image</a>";
    }
}
