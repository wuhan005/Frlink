<?php defined('ABSPATH') or exit;?>

<div class="wrap">
    <h2>Frlink - 友链管理</h2>
    <p>
        更美观，更易于管理的友链。
        <br>
        By: <a href="https://github.red">John Wu</a>
    </p>
    <!-- <div id="message" class="updated"><p><strong>设置保存成功</strong></p></div>
    <div id="message" class="error"><p><strong>保存出现错误</strong></p></div> -->
</div>

    <!-- 表单 -->
    <div>
        <form method="POST" action="?page=Frlink/Frlink.php">
        <?php if(empty($editValue)){?>
            <h3>添加友链</h3>
            <input type="hidden" id="do" name="do" value="add"/>
        <?php }else{?>
            <h3>修改友链 - <?php _e($editValue['name']);?></h3> <a class="button" href="?page=Frlink/Frlink.php">添加友链</a>
            <input type="hidden" id="do" name="do" value="edit"/>
        <?php } ?>
            <table>
                <input type="hidden" id="id" name="id" value="<?php _e($editValue['id']);?>"/>
                <tr>
                    <td>
                        <label for="site_name">站点名称</label>
                    </td>
                    <td>
                        <input type="text" class="regular-text" id="site_name" name="site_name" value="<?php _e($editValue['name']);?>" />
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="image_url">头像</label>
                    </td>
                    <td>
                        <input type="text" name="image_url" id="image_url" class="regular-text" value="<?php _e($editValue['image']);?>">
                        <input type="button" id="upload_btn" class="button-secondary" value="选择图片">
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="site_url">URL</label>
                    </td>
                    <td>
                        <input type="text" class="regular-text" id="site_url" name="site_url" value="<?php _e($editValue['url']);?>" />
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="site_summary">概述</label>
                    </td>
                    <td>
                        <input type="text" class="regular-text" id="site_summary" name="site_summary" value="<?php _e($editValue['summary']);?>" />
                    </td>
                </tr>
            </table>

            <p>
                <?php if(empty($editValue)){?>
                    <input type="submit" name="submit" value="添加" class="button button-primary" />
                <?php }else{?>
                    <input type="submit" name="submit" value="修改" class="button button-primary" />
                <?php } ?>
            </p>
            
        </form>
    </div>

    <!-- 数据表格 -->
    <div>
        <table class="widefat fixed striped posts">
	    <thead>
            <tr>
                <th scope="col" id="title" class="manage-column">
                    站点名称
                </th>
                <th scope="col" id="author" class="manage-column">
                    URL
                </th>
                <th scope="col" id="categories" class="manage-column">
                    头像
                </th>
                <th scope="col" id="categories" class="manage-column">
                    概述
                </th>
            </tr>
	    </thead>


	    <tbody id="the-list">
        <?php
            $flink_data = get_option('flink_data');
            if(!empty($flink_data)){
        ?>

            <?php foreach($flink_data as $key => $value){?>
			<tr class="iedit format-standard hentry entry">
                <td class="title column-title column-primary" data-colname="站点名称">
                    <strong>
                        <a class="row-title" href="?page=Frlink/Frlink.php&action=edit&id=<?php echo($key);?>" aria-label="<?php _e($value['name']);?>（编辑）"><?php _e($value['name']);?></a>
                    </strong>

                    <div class="row-actions">
                        <span class="edit"><a href="?page=Frlink/Frlink.php&action=edit&id=<?php echo($key);?>" aria-label="编辑 <?php _e($value['name']);?>">编辑</a> | </span>
                        <span class="trash"><a href="?page=Frlink/Frlink.php&action=delete&id=<?php echo($key);?>" class="submitdelete" aria-label="删除">删除</a></span>
                    </div>
                </td>

                <td data-colname="URL">
                    <?php _e($value['url']);?>
                </td>
                
                <td data-colname="头像">
                    <img alt="" src="<?php _e($value['image']);?>" class="avatar avatar-32 photo" height="50" width="50">
                </td>
                
                <td data-colname="概述">
                    <?php _e($value['summary']);?>
                </td>
            </tr>
            <?php } ?>

        <?php }else{ ?>
            <h3>当前无任何友链，添加一个吧！</h3>
        <?php } ?>
        </tbody>
        </table>
    </div>


<script type="text/javascript">
//图片上传
jQuery(document).ready(function($){
    $('#upload_btn').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
            title: '选择友链头像',
            multiple: false     //是否多选
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            var image_url = uploaded_image.toJSON().url;
            // Let's assign the url value to the input field
            $('#image_url').val(image_url);
        });
    });
});
</script>