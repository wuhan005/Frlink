<?php
/*
Plugin Name: Frlink - 友链管理
Plugin URI: https://github.red/frlink
Description: 更美观，更易于管理的友链。
Version: 1.0.1
Author: John Wu
Author URI: https://github.red
*/

defined( 'ABSPATH' ) or exit;

define('PLUGIN_URL', plugin_dir_url(__FILE__));

require_once('Table.php');

//初始化，添加数据
add_option(
    'flink_data',
    [],     //默认值
    NULL,
    'yes'
);

//注册短代码
add_shortcode('frlink_tag', 'short_code');
function short_code() {
    wp_register_style('panelCSS', PLUGIN_URL . 'css/Panel.css');  //加载 css 文件
    wp_enqueue_style('panelCSS');

    $frlink_data = get_option('flink_data');

    $rawHTML = '<div class="uk-column-1-1@s uk-column-1-2@m uk-column-1-2@l">';

    foreach($frlink_data as $key => $value){
    
        $rawHTML .= ('
        <div style="padding: 5px 10px;">
        <a href="'. $value['url'] .'" target="_blank">
            <div class="uk-grid-small uk-flex-middle uk-grid">
                <div class="uk-width-auto uk-first-column">
                    <img class="uk-border-circle" width="50" height="50" style="height: 50px;" src="'. $value['avatar'] .'">
                </div>
                <div class="uk-width-expand">
                    <h3 class="uk-card-title uk-margin-remove-bottom">'. $value['name'] .'</h3>
                    <p class="uk-text-meta uk-margin-remove-top" style="a:hover{text-decoration:none;}">'. $value['summary'] .'</p>
                </div>
            </div>
        </a>
        </div>');
    }
  
    $rawHTML .= '</div>';

    return $rawHTML;
}

// 左侧显示插件菜单
add_action('admin_menu', 'frlink_admin_menu');
function frlink_admin_menu() {
    add_menu_page( 
        __('查看友链'),     //展开菜单名
        __('友链管理'),     //主菜单名
        'administrator',   //权限
        'frlink_admin_panel',
        'frlink_main_page',     //显示界面
        'dashicons-admin-links',      //图标
        30      //位置
    );
    //子菜单
    add_submenu_page(
        'frlink_admin_panel', 
        __('添加'),
        __('添加'),
        'activate_plugins',
        'frlink_add',
        'frlink_add');

    add_submenu_page(
        NULL,
        __('编辑友链'),
        __('编辑友链'),
        'activate_plugins',
        'frlink_edit',
        'frlink_edit'
    );
}

// 后台管理主页
function frlink_main_page(){
    //删除
    if($_GET['action'] === 'delete'){
        if(isset($_GET['id']) && $_GET['id'] !== ''){
            $flink_data = get_option('flink_data');
            if(isset($flink_data[$_GET['id']])){    //判断索引是否存在
                unset($flink_data[$_GET['id']]);

                //更新值
                update_option(
                    'flink_data',
                    $flink_data
                );
            }
        }
    }

    // 列表
    $frink_table = new Frlink_List_Table();
    $frink_table->prepare_items();

    require_once('Panel.php');
}

// 友链添加页面
function frlink_add(){
    require_once('Add.php');
}

function add_new_frlink(){
    if(isset($_POST['site_name'], $_POST['avatar'], $_POST['url'], $_POST['summary']) AND $_POST['site_name'] !== '' AND $_POST['avatar'] !== '' AND $_POST['url'] !== '' AND $_POST['summary'] !== ''){
        $id = wp_generate_uuid4();
        $data = array(
            'id' => $id,
            'name' => sanitize_text_field($_POST['site_name']),
            'avatar' => sanitize_text_field($_POST['avatar']),
            'url' => sanitize_text_field($_POST['url']),
            'summary' => sanitize_text_field($_POST['summary'])
        );
        $flink_data = get_option('flink_data');
        $flink_data[$id] = $data;
        //更新值
        update_option(
            'flink_data',
            $flink_data
        );
    }
}

// 友链修改页面
function frlink_edit(){
    if (isset($_POST['submit'])) {
        edit_frlink();
        echo('<div class="updated"><h4>修改成功！</h4></div>');
    }

    if(isset($_GET['id']) && $_GET['id'] !== ''){
        $flink_data = get_option('flink_data');
        if(isset($flink_data[$_GET['id']])){    //判断索引是否存在
            $editValue = $flink_data[$_GET['id']];
        }
    }
    require_once('EditData.php');
}

function edit_frlink(){
    if(isset($_POST['id'], $_POST['site_name'], $_POST['avatar'], $_POST['url'], $_POST['summary']) AND $_POST['site_name'] !== '' AND $_POST['avatar'] !== '' AND $_POST['url'] !== '' AND $_POST['summary'] !== ''){
        $data = array(
            'id' => $_POST['id'],
            'name' => sanitize_text_field($_POST['site_name']),
            'avatar' => sanitize_text_field($_POST['avatar']),
            'url' => sanitize_text_field($_POST['url']),
            'summary' => sanitize_text_field($_POST['summary'])
        );
        $flink_data = get_option('flink_data');
        $flink_data[$_POST['id']] = $data;
        //更新值
        update_option(
            'flink_data',
            $flink_data
        );
    }
}
