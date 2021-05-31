<?php Core\View::LoadFile("Include" . DS . "topnav.admin.view.php")?>
<?php Core\View::LoadFile("Include" . DS . "leftnav.admin.view.php")?>
<div class="admin-wrapper">
    <h1>Update Skill</h1>
    <?php if(isset($user_message)):?>
        <?php $message = $user_message[0]; $type = $user_message[1];?>
        <div class="form-message <?=$type?>"><?=$message?></div>
    <?php endif;?>
    <form action="" method="post">
        <label for="username">name:</label>
        <input type="text" name="name" value="<?=static::inputValue("name",$skill)?>"><br>
        <?=static::getFormErrors("name",$form_errors)?>

        <label for="email">Skill Category:</label>
        <select name="skill_category">
            <option value="">none</option>
            <?php foreach($skills_categories as $categ):?>
                <option value="<?=$categ->getPrimaryKey()?>" <?=static::selected("skill_category",$categ->getPrimaryKey(),$skill)?>><?= $categ->name?></option>
            <?php endforeach;?>
        </select><br>
        <?=static::getFormErrors("skill_category",$form_errors)?>

        <label for="ratio">Skill Ratio:</label>
        <input type="number" name="ratio" value="<?=static::inputValue("ratio", $skill)?>"><br>
        <?=static::getFormErrors("ratio",$form_errors)?>


        <input type="submit" name="update" value="Save">
    </form>
</div>