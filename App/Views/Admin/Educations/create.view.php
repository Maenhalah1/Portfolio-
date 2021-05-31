<?php Core\View::LoadFile("Include" . DS . "topnav.admin.view.php")?>
<?php Core\View::LoadFile("Include" . DS . "leftnav.admin.view.php")?>
<div class="admin-wrapper">
    <h1>Create Education</h1>
    <?php if(isset($user_message)):?>
        <?php $message = $user_message[0]; $type = $user_message[1];?>
        <div class="form-message <?=$type?>"><?=$message?></div>
    <?php endif;?>
    <form action="" method="post">
        <label for="username">Degree:</label>
        <input type="text" name="degree" value="<?=static::inputValue("degree")?>"><br>
        <?=static::getFormErrors("degree",$form_errors)?>

        <label for="username">University:</label>
        <input type="text" name="university" value="<?=static::inputValue("university")?>"><br>
        <?=static::getFormErrors("university",$form_errors)?>

        <label for="username">Major:</label>
        <input type="text" name="major" value="<?=static::inputValue("major")?>"><br>
        <?=static::getFormErrors("major",$form_errors)?>

        <label for="username">College:</label>
        <input type="text" name="college" value="<?=static::inputValue("college")?>"><br>
        <?=static::getFormErrors("college",$form_errors)?>

        <label for="username">Degree Abbreviation:</label>
        <input type="text" name="degree_abbreviation" value="<?=static::inputValue("degree_abbreviation")?>"><br>
        <?=static::getFormErrors("degree_abbreviation",$form_errors)?>

        <label for="username">Start Date:</label>
        <input type="date" name="start_date" value="<?=static::inputValue("start_date")?>"><br>
        <?=static::getFormErrors("start_date",$form_errors)?>

        <label for="username">End Date:</label>
        <input type="date" name="end_date" value="<?=static::inputValue("end_date")?>"><br>
        <?=static::getFormErrors("end_date",$form_errors)?>

        <input type="submit" name="create" value="create">
    </form>
</div>