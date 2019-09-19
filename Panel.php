<?php defined('ABSPATH') or exit;?>

<div class="wrap">
    <h2>Frlink - 友链管理 <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=frlink_add');?>">添加</a></h2>
    <p>
        更美观，更易于管理的友链。
    </p>

    <!-- 数据表格 -->
    <?php $frink_table->display();?>
</div>