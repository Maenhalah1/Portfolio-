<?php Core\View::LoadFile("Include" . DS . "topnav.admin.view.php")?>
<?php Core\View::LoadFile("Include" . DS . "leftnav.admin.view.php")?>
<div class="admin-wrapper">
    <?php if(isset($user_message)):?>
        <?php $message = $user_message[0]; $type = $user_message[1];?>
        <div class="form-message <?=$type?>"><?=$message?></div>
    <?php endif;?>
    <table border="1">
        <thead>
            <th>ID</th>
            <th>IP Address</th>
            <th>Country</th>
            <th>City</th>
            <th>Lat</th>
            <th>Lon</th>
            <th>os</th>
            <th>Browser</th>
            <th>Device Type</th>
            <th>Device Info</th>
            <th>Control</th>


        </thead>
        <tbody>
        <?php if($visitors !== false): foreach($visitors as $visitor):?>
            <tr>
                <td><?=$visitor->getPrimaryKey()?></td>
                <td><?=$visitor->ip_address?></td>
                <td><?=$visitor->country?></td>
                <td><?=$visitor->city?></td>
                <td><?=$visitor->lat?></td>
                <td><?=$visitor->lon?></td>
                <td><?=$visitor->os?></td>
                <td><?=$visitor->browser?></td>
                <td><?=$visitor->device_type?></td>
                <td><?=$visitor->device_info?></td>
                <td><a href="/admin/visitors/<?=$visitor->getPrimaryKey()?>/delete">Delete</a></td>
            </tr>
        <?php endforeach; endif;?>
        </tbody>
    </table>
</div>