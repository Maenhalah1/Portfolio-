<?php Core\View::LoadFile("Include" . DS . "topnav.admin.view.php")?>
<?php Core\View::LoadFile("Include" . DS . "leftnav.admin.view.php")?>
<div class="admin-wrapper">
    <div><a href="/admin/educations/create">Create New Education</a></div><br>
    <?php if(isset($user_message)):?>
        <?php $message = $user_message[0]; $type = $user_message[1];?>
        <div class="form-message <?=$type?>"><?=$message?></div>
    <?php endif;?>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>degree</th>
                <th>University</th>
                <th>Major</th>
                <th>College</th>
                <th>Degree Abbreviation</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>control</th>
            </tr>
        </thead>
        <tbody>
        <?php if($educations !== false): foreach($educations as $education):?>
            <tr>
                <td><?=$education->getPrimaryKey()?></td>
                <td><?=$education->degree?></td>
                <td><?=$education->university?></td>
                <td><?=$education->major?></td>
                <td><?=$education->college?></td>
                <td><?=$education->degree_abbreviation?></td>
                <td><?=$education->start_date?></td>
                <td><?=$education->end_date?></td>

                <td>
                    <a href="educations/<?=$education->getPrimaryKey()?>/update">Update</a>
                    <a href="educations/<?=$education->getPrimaryKey()?>/delete">Delete</a>
                </td>
            </tr>
        <?php endforeach; endif;?>
        </tbody>
    </table>
</div>