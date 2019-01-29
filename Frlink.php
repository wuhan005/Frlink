<?php
/*
Plugin Name: Frlink - 友链管理
Plugin URI: https://github.red/frlink
Description: 更美观，更易于管理的友链。
Version: 1.0.0
Author: John Wu
Author URI: https://github.red
*/

define('PLUGIN_URL', plugin_dir_url(__FILE__));

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
                    <img class="uk-border-circle" width="50" height="50" style="height: 50px;" src="'. $value['image'] .'">
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
add_action('admin_menu', 'add_main_menu');
function add_main_menu() {
    add_menu_page( 
        __('友链管理'),     //主菜单名
        __('友链管理'),     //展开菜单名
        'administrator',   //权限
        __FILE__,
        'main_page',     //显示界面
        'dashicons-admin-links',      //图标
        30      //位置
    );
}

function main_page(){

    // jQuery
    wp_enqueue_script('jquery');
    // 加入媒体上传
    wp_enqueue_media();

    wp_register_style('panelCSS', PLUGIN_URL . 'css/Panel.css');  //加载 css 文件
    wp_enqueue_style('panelCSS');

    //添加
    if($_POST['do'] === 'add'){
        if(isset($_POST['site_name'], $_POST['image_url'], $_POST['site_url'], $_POST['site_summary'])
        AND $_POST['site_name'] !== '' AND $_POST['image_url'] !== '' AND $_POST['site_url'] !== '' AND $_POST['site_summary'] !== ''
        ){
            $data = array(
                'name' => sanitize_text_field($_POST['site_name']),
                'image' => sanitize_text_field($_POST['image_url']),
                'url' => sanitize_text_field($_POST['site_url']),
                'summary' => sanitize_text_field($_POST['site_summary'])
            );

            $flink_data = get_option('flink_data');
            $flink_data[] = $data;

            //更新值
            update_option(
                'flink_data',
                $flink_data
            );
            
            echo('<div id="message" class="updated"><p><strong>添加成功！</strong></p></div>');

        }else{
            echo('<div id="message" class="error"><p><strong>字段为空，添加失败！</strong></p></div>');
        }
    }

    //修改
    if($_POST['do'] === 'edit'){
        if(isset($_POST['id'], $_POST['site_name'], $_POST['image_url'], $_POST['site_url'], $_POST['site_summary'])
        AND is_numeric($_POST['id']) AND $_POST['site_name'] !== '' AND $_POST['image_url'] !== '' AND $_POST['site_url'] !== '' AND $_POST['site_summary'] !== ''
        ){
            $data = array(
                'name' => sanitize_text_field($_POST['site_name']),
                'image' => sanitize_text_field($_POST['image_url']),
                'url' => sanitize_text_field($_POST['site_url']),
                'summary' => sanitize_text_field($_POST['site_summary'])
            );

            $flink_data = get_option('flink_data');
            $flink_data[$_POST['id']] = $data;

            //更新值
            update_option(
                'flink_data',
                $flink_data
            );
            
            echo('<div id="message" class="updated"><p><strong>更新成功！</strong></p></div>');

        }else{
            echo('<div id="message" class="error"><p><strong>字段为空，更新失败！</strong></p></div>');
        }
    }
    
    //删除
    if($_GET['action'] === 'delete'){
        if(isset($_GET['id']) && $_GET['id'] !== '' && is_numeric($_GET['id'])){
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

    //选择进行编辑
    $editValue = [];

    if($_GET['action'] === 'edit'){
        if(isset($_GET['id']) && $_GET['id'] !== '' && is_numeric($_GET['id'])){
            $flink_data = get_option('flink_data');
            if(isset($flink_data[$_GET['id']])){    //判断索引是否存在
                $editValue = $flink_data[$_GET['id']];
                $editValue['id'] = $_GET['id'];
            }
        }
    }

    require_once('Panel.php');
}