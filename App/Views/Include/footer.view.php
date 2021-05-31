<?php $customJsPaths = Core\View::getCustomPageJsFiles();?>


    <script src="<?= Config\Config::JS_PATH  ?>jquery-3.5.1.min.js"></script>
    <script src="<?= Config\Config::JS_PATH  ?>master.js"></script>
    <?php Core\View::loadFooterResourse();?>
    <?php if($customJsPaths !== -1):?>
        <?php foreach($customJsPaths as $jsPath):?>
            <script src="<?= DS . $jsPath?>"></script>
        <?php endforeach;?>
    <?php endif;?>
    </body>
</html>