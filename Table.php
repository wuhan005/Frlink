<?php
defined( 'ABSPATH' ) or exit;

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class Frlink_List_Table extends WP_List_Table {
    public function __construct(){
        global $status, $page;

        parent::__construct( array(
            'singular'  => '友链',     //singular name of the listed records
            'plural'    => '友链',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ));
    }

    public function column_default($item, $column_name){
        return $item[$column_name];
    }

    function get_columns(){
        $columns = array(
            'site_name'  =>'站点名称',
            'url'       => 'URL',
            'avatar'    => '头像',
            'summary'   => '概述',
        );
        return $columns;
    }

    public function get_data( $per_page = 10, $page_number = 1 ) {
        return get_option('flink_data');
    }

    public function get_count(){
        return count(get_option('flink_data'));
    }

    function column_site_name($item) {
        $actions = array(
            'edit'      => sprintf('<a href="?page=%s&id=%s">编辑</a>', 'frlink_edit', $item['id']),
            'delete'    => sprintf('<a href="?page=%s&action=%s&id=%s">删除</a>', $_REQUEST['page'], 'delete', $item['id']),
        );

        return sprintf('<b>%1$s</b> %2$s', $item['name'], $this->row_actions($actions) );
    }

    function column_avatar($item){
        return '<img alt="" src="' . $item['avatar'] . '" class="avatar avatar-32 photo" height="50" width="50">';
    }

    // function get_bulk_actions() {
    //     $actions = array(
    //         'delete'    => '删除'
    //     );
    //     return $actions;
    // }

    function prepare_items() {
        // $this->_column_headers = $this->get_column_info();
      
        /** Process bulk action */
        $this->process_bulk_action();

        $columns = $this->get_columns();        
        $this->_column_headers = array($columns, [], []);
      
        $per_page     = 10;
        $current_page = $this->get_pagenum();
        $total_items  = self::record_count();
      
        $this->items = $this->get_data( $per_page, $current_page );

        $this->set_pagination_args(array(
            'total_items' => $this->get_count(), 
            'per_page' => $per_page,
            'total_pages' => 1
        ));
      }

    function process_bulk_action() {
        if( 'delete' === $this->current_action() ) {
            
        }  
    }


}