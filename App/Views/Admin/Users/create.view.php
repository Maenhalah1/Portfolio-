<?php Core\View::LoadFile("Include" . DS . "topnav.admin.view.php")?>
<?php Core\View::LoadFile("Include" . DS . "leftnav.admin.view.php")?>
<div class="admin-wrapper">
    <h1>Create Admin</h1>
    <?php if(isset($user_message)):?>
        <?php $message = $user_message[0]; $type = $user_message[1];?>
        <div class="form-message <?=$type?>"><?=$message?></div>
    <?php endif;?>
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?=static::inputValue("username")?>"><br>
        <?=static::getFormErrors("username",$form_errors)?>

        <label for="email">Email:</label>
        <input type="text" name="email" value="<?=static::inputValue("email")?>"><br>
        <?=static::getFormErrors("email",$form_errors)?>

        <label for="email_backup">Email Backup:</label>
        <input type="text" name="email_backup" value="<?=static::inputValue("email_backup")?>"><br>
        <?=static::getFormErrors("email_backup",$form_errors)?>

        <label for="password">Password:</label>
        <input type="password" name="password"><br>  
        <?=static::getFormErrors("password",$form_errors)?>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password"><br>  
        <?=static::getFormErrors("confirm_password",$form_errors)?>

        <label for="first_name">First name:</label>
        <input type="text" name="first_name" value="<?=static::inputValue("first_name")?>"><br>
        <?=static::getFormErrors("first_name",$form_errors)?>

        <label for="last_name">Last name:</label>
        <input type="text" name="last_name" value="<?=static::inputValue("last_name")?>"><br>
        <?=static::getFormErrors("last_name",$form_errors)?>

        <input type="submit" name="create" value="create">
    </form>
</div>