<div class="wrap">
    <h2>Frlink - 修改友链
    <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=frlink_admin_panel');?>">回到友链管理</a>
    </h2>
    <div>
        <form method="POST" action="">
            <table>
                <input type="hidden" name="id" value="<?php _e($editValue['id']);?>"/>
                <tr>
                    <td>
                        <label for="site_name">站点名称</label>
                    </td>
                    <td>
                        <input type="text" class="regular-text" name="site_name" value="<?php _e($editValue['name']);?>" />
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="image_url">头像</label>
                    </td>
                    <td>
                        <input type="text" id="avatar" name="avatar" class="regular-text" value="<?php _e($editValue['avatar']);?>">
                        <input type="button" id="upload_btn" class="button-secondary" value="选择图片">
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="site_url">URL</label>
                    </td>
                    <td>
                        <input type="text" class="regular-text" name="url" value="<?php _e($editValue['url']);?>" />
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="site_summary">概述</label>
                    </td>
                    <td>
                        <input type="text" class="regular-text" name="summary" value="<?php _e($editValue['summary']);?>" />
                    </td>
                </tr>
            </table>
            <br>
            <input type="submit" name="submit" value="修改" class="button button-primary" />
        </form>
    </div>
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
            $('#avatar').val(image_url);
        });
    });
});
</script>