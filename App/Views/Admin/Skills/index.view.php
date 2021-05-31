<?php Core\View::LoadFile("Include" . DS . "topnav.admin.view.php")?>
<?php Core\View::LoadFile("Include" . DS . "leftnav.admin.view.php")?>
<div class="admin-wrapper">
    <div><a href="/admin/skills_categories">Skills Categories</a></div><br>
    <div><a href="/admin/skills/create">Create New Skill</a></div><br>
    <?php if(isset($user_message)):?>
        <?php $message = $user_message[0]; $type = $user_message[1];?>
        <div class="form-message <?=$type?>"><?=$message?></div>
    <?php endif;?>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>name</th>
                <th>Skill Category</th>
                <th>ratio</th>
                <th>control</th>
            </tr>
        </thead>
        <tbody>
        <?php if($skills !== false): foreach($skills as $skill):?>
            <tr>
                <td><?=$skill->getPrimaryKey()?></td>
                <td><?=$skill->name?></td>
                <td><?=$skill->category_name?></td>
                <td><?=$skill->ratio?></td>
                <td>
                    <a href="skills/<?=$skill->getPrimaryKey()?>/update">Update</a>
                    <a href="skills/<?=$skill->getPrimaryKey()?>/delete">Delete</a>
                </td>
            </tr>
        <?php endforeach; endif;?>
        </tbody>
    </table>
</div>