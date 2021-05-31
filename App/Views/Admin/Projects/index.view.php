<?php Core\View::LoadFile("Include" . DS . "topnav.admin.view.php")?>
<?php Core\View::LoadFile("Include" . DS . "leftnav.admin.view.php")?>
<div class="admin-wrapper">
    <div><a href="/admin/projects/create">Create New Project</a></div><br>
    <?php if(isset($user_message)):?>
        <?php $message = $user_message[0]; $type = $user_message[1];?>
        <div class="form-message <?=$type?>"><?=$message?></div>
    <?php endif;?>
    <table border="1">
        <thead>
            <th>ID</th>
            <th>Project name</th>
            <th>Project link</th>
            <th>Project video link</th>
            <th>Project description</th>
            <th>Client name</th>
            <th>Controls</th>
        </thead>
        <tbody>
        <?php if($projects !== false): foreach($projects as $project):?>
            <tr>
                <td><?=$project->getPrimaryKey()?></td>
                <td><?=$project->project_name?></td>
                <td><?=$project->project_link?></td>
                <td><?=$project->project_video_link?></td>
                <td><?=$project->project_description?></td>
                <td><?=$project->client_name?></td>
                <td>
                    <a href="projects/<?=$project->getPrimaryKey()?>/update">Update</a>
                    <a href="projects/<?=$project->getPrimaryKey()?>/delete">Delete</a>
                </td>
            </tr>
        <?php endforeach; endif;?>
        </tbody>
    </table>
</div>