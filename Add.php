<div class="wrap">
    <h2>Frlink - 添加友链
    <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=frlink_admin_panel');?>">回到友链管理</a>
    </h2>
    <hr>
<?php
if (isset($_POST['submit'])) {
    add_new_frlink();
    echo('<div class="updated"><h4>添加成功！</h4></div>');
}
?>
    <div>
        <form method="POST" action="">
            <table>
                <tr>
                    <td>
                        <label for="site_name">站点名称</label>
                    </td>
                    <td>
                        <input type="text" class="regular-text" name="site_name"/>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="image_url">头像</label>
                    </td>
                    <td>
                        <input type="text" id="avatar" name="avatar" class="regular-text">
                        <input type="button" id="upload_btn" class="button-secondary" value="选择图片">
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="site_url">URL</label>
                    </td>
                    <td>
                        <input type="text" class="regular-text" name="url"/>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="site_summary">概述</label>
                    </td>
                    <td>
                        <input type="text" class="regular-text" name="summary"/>
                    </td>
                </tr>
            </table>
            <br>
            <input type="submit" name="submit" value="添加" class="button button-primary" />
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