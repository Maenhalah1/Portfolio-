<?php Core\View::LoadFile("Include" . DS . "topnav.admin.view.php")?>
<?php Core\View::LoadFile("Include" . DS . "leftnav.admin.view.php")?>
<div class="admin-wrapper">
    <div><a href="/admin/users/create">Create New User</a></div><br>
    <?php if(isset($user_message)):?>
        <?php $message = $user_message[0]; $type = $user_message[1];?>
        <div class="form-message <?=$type?>"><?=$message?></div>
    <?php endif;?>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>email</th>
                <th>email backup</th>
                <th>first name</th>
                <th>last name</th>
                <th>Control</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($users as $user):?>
            <tr>
                <td><?=$user->getPrimaryKey()?></td>
                <td><?=$user->username?></td>
                <td><?=$user->email?></td>
                <td><?=$user->email_backup?></td>
                <td><?=$user->first_name?></td>
                <td><?=$user->last_name?></td>
                <td>
                    <a href="users/<?=$user->getPrimaryKey()?>/update">Update</a>
                    <a href="users/<?=$user->getPrimaryKey()?>/delete">Delete</a>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>