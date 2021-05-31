<?php Core\View::LoadFile("Include" . DS . "topnav.admin.view.php")?>
<?php Core\View::LoadFile("Include" . DS . "leftnav.admin.view.php")?>
<div class="admin-wrapper">
    <h1>Update Skill Category</h1>
    <?php if(isset($user_message)):?>
        <?php $message = $user_message[0]; $type = $user_message[1];?>
        <div class="form-message <?=$type?>"><?=$message?></div>
    <?php endif;?>
    <form action="" method="post">
        <label for="name">name:</label>
        <input type="text" name="name"  value="<?=static::inputValue("name",$skillCateg)?>"><br>
        <?=static::getFormErrors("name",$form_errors)?>

        <input type="submit" name="update" value="Save">
    </form>
</div>