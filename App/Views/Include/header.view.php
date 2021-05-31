<?php $customCssPaths = Core\View::getCustomPageCssFiles();?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?=@$text_page_title?></title>

        <link rel="stylesheet" href="<?=Config\Config::CSS_PATH?>normal.css">        
        <link rel="stylesheet" href="<?=Config\Config::CSS_PATH?>all.min.css">
        <link rel="stylesheet" href="<?=Config\Config::CSS_PATH?>fontawesome.min.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?=Config\Config::CSS_PATH?>master.css">
        <link rel="stylesheet" href="<?=Config\Config::CSS_PATH?>responsive.css">

        <?php Core\View::loadHeaderResourse();?>
        <?php if($customCssPaths !== -1): ?>
            <?php foreach($customCssPaths as $cssPath):?>
                <link rel="stylesheet" href="<?= DS . $cssPath?>">
            <?php endforeach;?>
         <?php endif;?>
    </head>
<body>

