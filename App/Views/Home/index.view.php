<div class="bullet-effect">
    <span>My Eduction</span>
</div>
<?php Core\View::LoadFile("Include" . DS . "topnav.main.view.php")?>

<div class="nav-bullet">
        <div class="bullet" data-scroll = ".about-me">
            <div class="content-bullet" >About Me</div>
        </div>
        <div class="bullet" data-scroll = ".resume">
            <div class="content-bullet" >My Resume</div>
        </div>
        <div class="bullet" data-scroll = ".me-skills">
           <div class="content-bullet" >My Skills</div>
        </div>
        
        <div class="bullet" data-scroll = ".feature">
            <div class="content-bullet" >My Features</div>
        </div>
        <div class="bullet" data-scroll = ".timeline">
            <div class="content-bullet" >My Eduction</div>
        </div>
        <div class="bullet" data-scroll = ".mylinks">
            <div class="content-bullet" >Contact Me</div>
        </div>
    </div>
    <!-- End navigation-bullet -->
    <!-- Start Landing Page -->
    <div class="landing-page" data-vide-bg="<?=Config\Config::MEDIA_PATH . $settings->main_video["filename"]?>">
        <div class="overlay"></div>
        <div class="intro-text">
            <h2>Hi There, my name is <b>Maen Halah</b></h2>
            <h1><span class="static-text">I Am a </span><span class="cont-text"></span><span class="cursor"></span></h1>   
        </div>
    </div>
    <!-- Start About US -->
    <div class="container w80">
        <div class="about-me" id="about-me">
            <div class="image-about">
                <img src="<?=Config\Config::MEDIA_PATH . $settings->about_me_photo?>">
            </div>
            <div class="info">
                <h2 class=" main-header"><span>ABOUT ME</span></h2>
                <p class="paragh-prop"><?=$settings->about_me_text?></p>
            </div>
            <div class="clear-float"></div>
        </div>
    </div>

    <div class="section">
        <div class="resume text-align-center" id="resume" style="background-image: url('../media/resume2.jpg');">
            <div class="overlay"></div>
            <div class="container w80 ">
                <div class="content">
                    <h2 class=" main-header "><span>MY RESUME</span></h2>
                    <p class="paragh-prop"><?=$settings->resume_text?></p>
                    <span class="button-1">
                        <span class="button-text">Download Resume</span>
                        <a href="<?=Config\Config::MEDIA_PATH . $settings->resume_file?>" download="download" class="action"></a>
                    </span>
                </div>
            </div>
        </div>
    </div>
<?php if(!empty($skillsGroups)):?>
    <div class="outer-skills">
        <div class="me-skills" id="skills">
            <div class="container">
            <h2 class=" main-header"><span>MY SKILLS</span></h2>
            <div class="skills-sections">
            <?php foreach($skillsGroups as $skills):?>
                <div class="linear-skills-box main-skills-box">
                    <div class="skills-main-header"><?=$skills[0]->category_name?></div>
                    <div class="skills-container">
                    <?php foreach($skills as $skill):?>
                        <div class="skill-box linear-skills">
                            <div class="skill-header">
                                <div class="skill-name">
                                    <?=$skill->name?>
                                </div>
                                <div class="prog-counter">0%</div>
                            </div>
                            <div class="skill-prog">
                                <span data-progress = "<?=$skill->ratio?>" class="int-porg"></span>
                            </div>
                        </div>
                    <?php endforeach;?>
                    </div>
                </div>
            <?php endforeach;?>
            </div>
        </div>
        </div>
    </div>
<?php endif;?>
</div>
<!-- Start My Feature -->
<div class="feature" id="features">
    <h2 class=" main-header"><span>MY FEATURES</span></h2>
    <div class="container-small">
        <div class="feat-box">
            <img src="<?=Config\Config::MEDIA_PATH?>icon2.svg">
            <h3>Development</h3>
            
        </div>
        <div class="feat-box">
            <img src="<?=Config\Config::MEDIA_PATH?>icon4.svg">
            <h3>Poblem Solving</h3>
            
        </div>
        <div class="feat-box">
            <img src="<?=Config\Config::MEDIA_PATH?>icon3.svg">
            <h3>Self Learning</h3>
            
        </div>

        <div class="feat-box">
            <img src="<?=Config\Config::MEDIA_PATH?>icon6.svg">
            <h3>Team Work</h3>
            
        </div>
        <div class="feat-box">
            <img src="<?=Config\Config::MEDIA_PATH?>icon7.svg">
            <h3>Searching</h3>
            
        </div>
        <div class="feat-box">
            <img src="<?=Config\Config::MEDIA_PATH?>icon8.svg">
            <h3>Hard Working</h3>
            
        </div>
       
        <div class="clear-float"></div>
    </div>
</div>
<!-- End My Feature -->
<?php if($educations !== false):?>
<div class="timeline hide" id="education">
    <div class="container">
        <h1 class=" main-header"><span>MY EDUCATION</span></h1>
    <?php foreach($educations as $education):?>
        <div class="timeline-contant">
            <div class="year"><?=$education->start_year?> - <?=$education->end_year?></div>
            <div class="left">
                <div class="contant">
                    <h3><?=$education->degree?></h3>
                    <span><?=$education->university?></span>
                    <span><?=$education->major?></span>
                    <span><strong><?=$education->college?></strong>&nbsp; <?=$education->start_date?> - <?=$education->end_date?></span>
                    <span><?=$education->degree_abbreviation?></span>
                </div>
            </div>
        </div>
    <?php endforeach;?> 
    </div>
</div>
<?php endif;?>

<div class="clear-float"></div>
<?php Core\View::LoadFile("Include" . DS . "appfooter.main.view.php")?>
