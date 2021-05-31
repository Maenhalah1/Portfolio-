<?php Core\View::LoadFile("Include" . DS . "topnav.admin.view.php")?>
<?php Core\View::LoadFile("Include" . DS . "leftnav.admin.view.php")?>
<div class="admin-wrapper">
    <div><a href="/admin/skills_categories/create">Create New Category</a></div><br>
    <?php if(isset($user_message)):?>
        <?php $message = $user_message[0]; $type = $user_message[1];?>
        <div class="form-message <?=$type?>"><?=$message?></div>
    <?php endif;?>
    <table border="1">
        <thead>
            <th>ID</th>
            <th>Category name</th>
            <th>Controls</th>
        </thead>
        <tbody>
        <?php if($categories !== false): foreach($categories as $category):?>
            <tr>
                <td><?=$category->getPrimaryKey()?></td>
                <td><?=$category->name?></td>
                <td>
                    <a href="skills_categories/<?=$category->getPrimaryKey()?>/update">Update</a>
                    <a href="skills_categories/<?=$category->getPrimaryKey()?>/delete">Delete</a>
                </td>
            </tr>
        <?php endforeach; endif;?>
        </tbody>
    </table>
</div>