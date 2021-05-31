<?php Core\View::LoadFile("Include" . DS . "topnav.admin.view.php")?>
<?php Core\View::LoadFile("Include" . DS . "leftnav.admin.view.php")?>
<div class="admin-wrapper">
    <h1>Settings</h1>
    <?php if(isset($user_message)):?>
        <?php $message = $user_message[0]; $type = $user_message[1];?>
        <div class="form-message <?=$type?>"><?=$message?></div>
    <?php endif;?>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="main_video">Main Video:</label>
        <input type="file" name="main_video"><br>
        <?=static::getFilesErrors($files_errors, "main_video")?>

        <label for="about_me_text">About Me Text:</label>
        <textarea name="about_me_text"><?=static::inputValue("about_me_text", $settings)?></textarea><br>  
        <?=static::getFormErrors("about_me_text",$form_errors)?>

        <label for="about_me_photo">About Me Photo:</label>
        <input type="file" name="about_me_photo"><br>
        <?=static::getFilesErrors($files_errors,"about_me_photo")?>

        <label for="resume_text">Resume Text:</label>
        <input type="text" name="resume_text" value="<?=static::inputValue("resume_text",$settings)?>"><br>
        <?=static::getFormErrors("resume_text",$form_errors)?>

        <label for="resume_file">Resume File:</label>
        <input type="file" name="resume_file"><br>
        <?=static::getFilesErrors($files_errors,"resume_file")?>

        <label for="footer_text">Footer Text:</label>
        <textarea name="footer_text"><?=static::inputValue("footer_text",$settings)?></textarea><br>  
        <?=static::getFormErrors("footer_text",$form_errors)?>

        <input type="submit" name="save" value="save">
    </form>
</div>