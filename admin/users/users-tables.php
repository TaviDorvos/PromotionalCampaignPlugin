<?php
if (!class_exists('Link_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

//class for table registered users
class UsersTable extends WP_List_Table {

    //getting users from database 'users_details'
    static function get_users($per_page = 15, $page_number = 1) {

        global $wpdb;

        $sql = "SELECT * FROM users_details";

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

    //if there is no user available
    function no_items() {
        _e('No participants available.', 'sp');
    }

    //counting the records
    static function record_count() {
        global $wpdb;

        $query = "SELECT COUNT(*) FROM users_details";

        return $wpdb->get_var($query);
    }

    //creating the columns and the content
    function get_columns() {
        $columns = array(
            'id_user' => 'ID',
            'lastName' => 'Last Name',
            'firstName' => 'First Name',
            'phone' => 'Phone number',
            'email' => 'Email',
            'county' => 'County',
            'city' => 'City',
            'address' => 'Address',
            'used_codes' => 'Codes entered',
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
        $this->items           = self::get_users($per_page, $current_page);
    }

    function column_default($item, $column_name) {
        switch ($column_name) {
            case 'id_user':
            case 'lastName':
            case 'firstName':
            case 'phone':
            case 'email':
            case 'county':
            case 'city':
            case 'address':
                return $item[$column_name];
            default:
                return print_r($item, true);
        }
    }

    //making the columns to be sortable
    function get_sortable_columns() {
        $sortable_columns = array(
            'id_user' => array('id_user', false),
            'lastName' => array('lastName', false),
            'county' => array('county', false),
            'city' => array('city', false),
        );

        return $sortable_columns;
    }

    //page that redirects to the all registered codes of an user
    function column_used_codes($item) {
        return "<a href='" . admin_url('admin.php?page=used_codes&id_user=' . $item['id_user']) . "'>See the used codes</a>";
    }
}

//class for table with used codes by users
class UsedCodesTable extends WP_List_Table {

    //getting all codes of an user from database 'users_codes'
    static function get_used_codes($per_page = 15, $page_number = 1) {

        global $wpdb;

        $id_user = $_GET['id_user'];
        $sql = "SELECT * FROM users_codes WHERE id_user = '$id_user'";

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

    //if there is no prize available
    function no_items() {
        _e('No prize available.', 'sp');
    }

    //counting the records
    static function record_count() {
        global $wpdb;

        $id_user = $_GET['id_user'];
        $query = "SELECT COUNT(*) FROM users_codes WHERE id_user = '$id_user'";

        return $wpdb->get_var($query);
    }

    //creating the columns and the content
    function get_columns() {
        $columns = array(
            'id' => 'Registration ID',
            'code' => 'The used code',
            'win' => 'Is a winning code?',
            'date_current' => 'Code registration date'
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
        $this->items           = self::get_used_codes($per_page, $current_page);
    }

    function column_default($item, $column_name) {
        switch ($column_name) {
            case 'id':
            case 'code':
            case 'win';
            case 'date_current':
                return $item[$column_name];
            default:
                return print_r($item, true);
        }
    }

    //making the columns to be sortable
    function get_sortable_columns() {
        $sortable_columns = array(
            'code' => array('code', false),
            'win' => array('win', false),
            'date_current' => array('date_current', false),
        );

        return $sortable_columns;
    }
}
