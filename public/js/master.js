$(document).ready(function(){

        
    // var backgroundInterval , backgroundCheck, backgroundSave;
    // backgroundCheck =true;

    // // set background from local_stroge to page
    // var backoption = localStorage.getItem('background-option');
    // if (backoption !== null) {
    // if (backoption == "true") {
    //     backgroundCheck = true;
    // } else {
    //     backgroundCheck = false;
    // }
    // }
    // if (backoption !== null) {
    // document.querySelector('.background-rand .active').classList.remove('active');
    // if (backoption == "true") {
    //     document.querySelector('.background-rand .yes').classList.add('active');
    // } else {
    //     document.querySelector('.background-rand .no').classList.add('active');
    // }
    // }
    // //Start all function use it
    // function setactive(i){ //set remove all active and add it in one
    //     i.parentElement.querySelectorAll(".active").forEach(ac => {
    //         ac.classList.remove("active");
    //     });
    //     i.classList.add("active");
    // }



    // if (backoption == "false") { //translete the background saved from local storge to background-image(if varible backopt has false (stop))
    //     landing.style.backgroundImage = localStorage.getItem("background-save");
    // }




    // // Start Option display bullet or hidden
    // var bulletContainer = document.querySelector('.nav-bullet');
    // var option = document.querySelectorAll('.bullets-show span');
    // var bulletLocal = localStorage.getItem('bullets-option');
    // if (bulletLocal !== null) {
    //     option.forEach(i => {
    //         i.classList.remove('active');
    //     });
    //     if (bulletLocal == 'yes') {
    //         bulletContainer.style.display = 'block';
    //         document.querySelector('.bullets-show .yes').classList.add('active');
    //     }else {
    //         bulletContainer.style.display = 'none';
    //         document.querySelector('.bullets-show .no').classList.add('active');
    //     }
    // }
    // option.forEach(i => {
    //     i.addEventListener('click', function(){
    //         if ( i.getAttribute('data-bullet') == 'yes') {
    //             bulletContainer.style.display = 'block';
    //             localStorage.setItem('bullets-option', 'yes');
    //         } else {
    //             localStorage.setItem('bullets-option', 'no');
    //             bulletContainer.style.display = 'none';
    //         }
    //         setactive(i);
    //     });
    // });



    //start bullet
    var allbullets = document.querySelectorAll(".nav-bullet .bullet");
    allbullets.forEach(bullet => {
    bullet.addEventListener("click", function(){
        var bulletText = bullet.querySelector(".content-bullet").textContent;
        var heighttop = document.querySelector(bullet.getAttribute('data-scroll')).offsetTop;
        var heightele = document.querySelector(bullet.getAttribute('data-scroll')).offsetHeight;
        var bulletEffect = $(".bullet-effect");
        bulletEffect[0].querySelector("span").textContent = bulletText;
        bulletEffect.fadeIn(500).delay(500).fadeOut(500);

        var windowheight= window.innerHeight;
        if (windowheight > heightele) {
            var sum = heighttop - (windowheight-(heightele));
        } else {
            sum = heighttop ;
        }
        window.scrollTo({
            left:0,
            top: sum ,
            behavior: 'smooth'
        });
    });
    });



    // Start Menu Events

    $(".menu-icon").on("click",function(){
        var icon = $(this);
        var topNav = $(".header-area");
        
        if(!$(this).hasClass("open")){
            $(".menu").fadeIn(400,function(){
                $(this).children(".links").children("li").addClass("open");
                icon.parents(".header-area").css("position","fixed").addClass("font-white");
            });
            $(this).addClass("open");
        }else{
            $(".menu").fadeOut(400,function(){
                icon.removeClass("open");
                $(this).children(".links").children("li").removeClass("open");
                var header = icon.parents(".header-area");
                header.css("position","absolute");
                if(!header.hasClass("white"))
                    header.removeClass("font-white")

            });
        }
    });

    $(document).on("click",".popImg",function(){
        var imgSrc = $(this).siblings("img").attr("src");
        var img = document.createElement("img");
        var overlayImage = $(".overlay-image");
        img.setAttribute("src", imgSrc);
        overlayImage.find(".image-box").empty().append(img);
        overlayImage.fadeIn(500);
    });
    $(".close-icon").on("click",function(){
        $(this).parents(".overlay-image").fadeOut(500);
    });




});