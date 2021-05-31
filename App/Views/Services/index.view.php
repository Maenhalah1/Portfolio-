<?php Core\View::LoadFile("Include" . DS . "topnav.main.view.php")?>

<div class="wrapper">
    <div class="services-section" id="services">
        <div class="overlay"></div>
        <div class="section-content">
            <div class="main-header sub-page-header"><span>Services</span></div>
            <div class="container ">
                <div class="content">
                    <div class="service"  style="background-image: url('media/code.jpg');">
                        <div class="overlay" style="background-color: rgba(0,184,255,0.90);"></div>
                        <div class="service-content">
                        <div class="icon"><i class="fas fa-laptop-code"></i></div>
                            <h2>Web Development</h2>
                            <p>Website Development With The Latest Technology</p>
                        </div>
                    </div>
                    <div class="service" style="background-image: url('media/online.jpg');">
                        <div class="overlay" style="background-color: rgba(255,152,0,0.90);"></div>
                        <div class="service-content">
                            <div class="icon"><i class="fas fa-headset"></i></div>
                            <h2>Technical Support</h2>
                            <p>High Technical Support For Websites</p>
                        </div>
                    </div>
                    <div class="service" style="background-image: url('media/update.jpg');">
                        <div class="overlay" style="background-color: rgba(251, 0, 255 , 0.80);"></div>
                        <div class="service-content">
                            <div class="icon"><i class="far fa-window-maximize"></i></div>
                            <h2>Websites Improvement</h2>
                            <p>Websites Improvement and Updating</p>
                        </div>
                    </div>
                    <div class="service" style="background-image: url('media/programmer.jpg');">
                        <div class="overlay" style="background-color: rgb(16 ,255, 0, 0.80)"></div>
                        <div class="service-content">
                            <div class="icon"><i class="fas fa-code"></i></div>
                            <h2>Provide Api's</h2>
                            <p>Provide Api's For Another Websites <br>and Mobail Applications</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php Core\View::LoadFile("Include" . DS . "appfooter.main.view.php")?>