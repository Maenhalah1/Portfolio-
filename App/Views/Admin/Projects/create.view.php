<?php Core\View::LoadFile("Include" . DS . "topnav.admin.view.php")?>
<?php Core\View::LoadFile("Include" . DS . "leftnav.admin.view.php")?>
<div class="admin-wrapper">
    <h1>Create Proejct</h1>
    <?php if(isset($user_message)):?>
        <?php $message = $user_message[0]; $type = $user_message[1];?>
        <div class="form-message <?=$type?>"><?=$message?></div>
    <?php endif;?>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="project_link">Project Photos:</label>
        <input type="file" multiple="multiple" name="project_photos[]"><br>
        <?=static::getFilesErrors($files_errors)?>

        <label for="project_name">Project Name:</label>
        <input type="text" name="project_name" value="<?=static::inputValue("project_name")?>"><br>
        <?=static::getFormErrors("project_name",$form_errors)?>

        <label for="project_link">Project Link:</label>
        <input type="text" name="project_link" value="<?=static::inputValue("project_link")?>"><br>
        <?=static::getFormErrors("project_link",$form_errors)?>

        <label for="project_video_link">Project Video Link:</label>
        <input type="text" name="project_video_link" value="<?=static::inputValue("project_video_link")?>"><br>
        <?=static::getFormErrors("project_video_link",$form_errors)?>

        <label for="project_description">Project Description:</label>
        <textarea name="project_description"><?=static::inputValue("project_description")?></textarea><br>  
        <?=static::getFormErrors("project_description",$form_errors)?>


        <label for="client_name">Client Name:</label>
        <input type="text" name="client_name" value="<?=static::inputValue("client_name")?>"><br>
        <?=static::getFormErrors("client_name",$form_errors)?>


        <input type="submit" name="create" value="create">
    </form>
</div>