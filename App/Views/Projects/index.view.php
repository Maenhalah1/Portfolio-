<?php Core\View::LoadFile("Include" . DS . "topnav.main.view.php")?>
<div class="wrapper">
    <div class="projects-section">
        <div class="overlay"></div>
        <div class="content container w80">
            <div class="main-header sub-page-header"><span>Projects</span></div>
            <div class="flex">
            <?php foreach($projects as $project):?>
                <div class="project">
                    <div class="image-container">
                        <img src="<?= "uploads" . DS . "projects_photos" . DS . $project->getPrimaryKey() . DS . $project->first_photo ?>" alt="">
                    </div>
                    <div class="project-info">
                        <div class="content">
                            <h2 class="header"><?= $project->project_name?></h2>
                            <span class="button-1">
                                <span class="button-text">See Project</span>
                                <a href="/projects/<?=$project->getPrimaryKey()?>/show" class="action"></a>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
            </div>
        </div>
    </div>
</div>
<?php Core\View::LoadFile("Include" . DS . "appfooter.main.view.php")?>