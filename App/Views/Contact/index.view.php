<?php Core\View::LoadFile("Include" . DS . "topnav.main.view.php")?>
<div class="wrapper">
    <div class="contact" style="background-image: url('../media/map2.jpg');">
        <div class="overlay"></div>
        <div class="container">
        <?php if(isset($user_message)):?>
            <?php $message = $user_message[0]; $type = $user_message[1];?>
            <div class="page-message <?=$type?>"><?=$message?></div>
        <?php endif;?>
            <div class="main-header sub-page-header"><span>Contact Me</span></div>
            <div class="form-1">
                <form  action="" method="POST" >
                    <div class="fields-box left">
                        <input type="text" placeholder="First Name" name="first_name" value="<?=static::inputValue("first_name")?>">
                    <?=static::getFormErrors("first_name",$form_errors)?>
                        <input type="text" placeholder="Last Name" name="last_name" value="<?=static::inputValue("last_name")?>">
                    <?=static::getFormErrors("last_name",$form_errors)?>        
                        <input type="text" placeholder="Your Email" name="email" value="<?=static::inputValue("email")?>">
                    <?=static::getFormErrors("email",$form_errors)?>
                        <input type="text" placeholder="Subject" name="subject" value="<?=static::inputValue("subject")?>">
                    <?=static::getFormErrors("subject",$form_errors)?>
                    </div>
                    <div class="fields-box right">
                        <textarea name="message" placeholder="Your Message"><?=static::inputValue("message")?></textarea>
                    <?=static::getFormErrors("message",$form_errors)?>
                        <span class="button button-1">
                                <span class="button-text">Send</span>
                                <input type="submit" value="" class="action">
                        </span>
                    </div>
                    <div class="clear-float"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php Core\View::LoadFile("Include" . DS . "appfooter.main.view.php")?>
