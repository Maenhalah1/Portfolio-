<?php Core\View::LoadFile("Include" . DS . "topnav.main.view.php")?>
<section class="project-details-section">
    <div class="overlay-image">
        <div class="image-container">
            <span class="close-icon" data-upload="db"><i class="fas fa-times"></i></span>
            <div class="image-box"></div>
        </div>
    </div>
    <div class="project-header">
        <div class="content">
            <div class="header"><?=$project->project_name?></div>
            <div class="links"><a href="projects">Projects</a><span class="sperator">|</span><a><?=$project->project_name?></a></div>
        </div>
    </div>
    <div class="slider">
        <div class="slider-section pageinate">
            <div class="slider-pageinate"></div>
        </div>
        <div class="slider-section images">
            <span class="previous"><i class="fas fa-chevron-right"></i></span>
            <div class="slider-images"> 
            <?php foreach($projectPhotos as $photo):?>
                <div class="images-box ">
                    <img src="<?= DS . "uploads" . DS . "projects_photos" . DS . $project->getPrimaryKey() . DS . $photo->photo_name?>" alt="">
                </div>
            <?php endforeach;?>
            </div>
            <span class="next"><i class="fas fa-chevron-right"></i></span>
        </div>

    </div>

    <div class="project-main-information">
        <div class="container-small">
            <div class="content">
            <?php if(!empty($project->client_name)):?>
                <div class="info-part">
                    <div class="info-name">Client</div>
                    <div class="info-content"><?=$project->client_name?></div>
                </div>
            <?php endif;?>
            <?php if(!empty($project->project_link)):?>
                <div class="info-part">
                    <div class="info-name">Link</div>
                    <div class="info-content"><a href="<?=$project->project_link?>"><?=$project->project_name?></a>
                </div>
            <?php endif;?>
            </div>
        </div>
    </div>
    <div class="project-description">
        <div class="container-small">
        <h2 class="header"><span>Project Description</span></h2>
            <div class="content">
                <p><?=$project->project_description?></p>
                <?php if(!empty($project->project_video_link)):?>
                    <iframe src="<?=$project->project_video_link?>" frameborder="0"></iframe>
                <?php endif;?>
            </div>
        </div>
    </div>

</section>
<?php Core\View::LoadFile("Include" . DS . "appfooter.main.view.php")?>