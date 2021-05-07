<?php
if (!class_exists('Link_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

//class for registered users table
class PrizesTable extends WP_List_Table {

    //getting prizes from database 'prizes'
    static function get_prizes($per_page = 15, $page_number = 1) {

        global $wpdb;

        $sql = "SELECT * FROM prizes";

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
        _e('No prize available', 'sp');
    }

    //counting the records
    static function record_count() {
        global $wpdb;

        $query = "SELECT COUNT(*) FROM prizes";

        return $wpdb->get_var($query);
    }

    //creating the columns and the content
    function get_columns() {
        $columns = array(
            'id_prize' => 'ID',
            'name_prize' => 'Prize name',
            'quantity' => 'Available Stock',
            'description' => 'Description',
            'image' => 'Prize Image',
            'date_current' => 'Date added',
            'edit' => 'Edit prize',
            'delete' => 'Delete prize'
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
        $this->items           = self::get_prizes($per_page, $current_page);
    }

    function column_default($item, $column_name) {
        switch ($column_name) {
            case 'id_prize':
            case 'name_prize':
            case 'quantity':
            case 'description':
            case 'date_current':
                return $item[$column_name];
            default:
                return print_r($item, true);
        }
    }

    //making the columns to be sortable
    function get_sortable_columns() {
        $sortable_columns = array(
            'id_prize' => array('id_prize', false),
            'name_prize' => array('name_prize', false),
            'date_current' => array('date_current', false),
        );

        return $sortable_columns;
    }

    //page that redirects to the all registered codes of an user
    function column_edit($item) {
        return "<a class='btn btn-warning' style='font-size: 12px; padding: 3px 10px;' href='" . admin_url('admin.php?page=edit_prize&id_prize=' . $item['id_prize']) . "'>Edit</a>";
    }

    //Redirects to the prize's image
    function column_image($item) {
        return "<a class='text-info' href='" . $item['image'] . "'>See image</a>";
    }

    function column_delete($item) {
        // Submit button
        return "<button type='submit' class='btn btn-danger' style='font-size: 12px; padding: 3px 10px;' id='delete-prize' data-prize-id='" . $item['id_prize'] . "'>Delete</button>";
    }
}
