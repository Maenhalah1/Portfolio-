$(document).ready(function(){



    // Typing Wiriter
    var head = document.querySelector(".intro-text h1 .cont-text");
    var heading = document.querySelector(".intro-text h1");
    var cursor = document.querySelector(".intro-text h1 .cursor");
    var headData = ['Freelancer','Web Developer', 'Web Designer'];
    var txt ="";

    function typing (wordIndex, isdeleting, wait,Cont,ContIndex,txt="") {
        if (isdeleting == false) {
        txt = txt + Cont[ContIndex][wordIndex];
        wordIndex++;
        wait = 40;
        
        }else if(isdeleting == true){
            wait = 30;
            txt = txt.substring(0, wordIndex);
            wordIndex --;
            if(wordIndex < 0 ) {
                ContIndex ++;
                isdeleting = false;
                wordIndex = 0;
            }
        }
        if (ContIndex  == Cont.length  && txt == "") {
            ContIndex = 0;
        }
        if(Cont[ContIndex].length == wordIndex) {
            wait = 1800;
            isdeleting = true;
            wordIndex --;
            heading.classList.add("stop");
            cursor.classList.add("stop");
            
        }else {
            heading.classList.remove("stop");
            cursor.classList.remove("stop");
        }
        head.innerHTML = txt;
        setTimeout(() => typing(wordIndex, isdeleting, wait,Cont,ContIndex,txt), wait);
    }

    setTimeout(() => typing(0, false, 250, headData,0), 600);

    setInterval(() => {
        if(cursor.style.visibility != 'hidden') {
            cursor.style.visibility  = 'hidden';
        }else {
            cursor.style.visibility  = 'visible';
        }
        
    }, 130);











    // Content Showing Effect
    
    var sectionStatus = {"about":0,"skills":0,"feature":0,"education":0, "resume":0}
    //About Me Variables
    var aboutMe = $("#about-me");
    var aboutMeofftop = aboutMe.offset().top;
    var aboutMeOuterHeight = aboutMe.height();

    //My Skills Variables
    var skills = $("#skills");
    var skillofftop = skills.offset().top;
    var skillOuterheight = skills.height();

    //My Features Variables
    var features = $("#features");
    var featuresOfftop = features.offset().top;
    var featuresOuterheight = features.height();

    //My Education Variables
    var education = $("#education");
    var educationOfftop = education.offset().top;
    var educationOuterheight = education.height();

    var resume = $("#resume");
    var resumeOfftop = resume.offset().top;
    var resumeOuterheight = resume.height();


    $(document).scroll(function(){
        var scrollVal = $(document).scrollTop();
        var windowHeight = $(window).innerHeight();

        // About Me 
        if(scrollVal > (aboutMeofftop + aboutMeOuterHeight) - windowHeight && sectionStatus["about"] == 0){
            imgBox = aboutMe.children(".image-about"),
            infoBox = aboutMe.children(".info");
            if($(window).width() > 920){
                imgBox.animate({
                    opacity:"1"
                },500,function(){
                    imgBox.animate({
                        width:"40%"
                    },500,function(){
                        infoBox.fadeIn();
                    });
                });
            }else{
                imgBox.animate({
                    opacity:"1"
                },500,function(){
                    infoBox.fadeIn();
                });
            }
            sectionStatus["about"] = 1;
        }

        // Resume Effect
        if(scrollVal > (resumeOfftop + resumeOuterheight) - windowHeight && sectionStatus["resume"] == 0){
            resume.find(".content").addClass("showing");
            sectionStatus["resume"] = 1;
        }

        // My Skills
        if(scrollVal > (skillofftop + skillOuterheight) - windowHeight && sectionStatus["skills"] == 0) {
            skills.find(".main-skills-box").animate({
                opacity:"1",
                top:"0px"
            },1000,function(){
                var skillporg = document.querySelectorAll(".skill-box .skill-prog .int-porg").forEach( ele =>{
                    if (!ele.classList.contains('open')) {
                    var progNum =0;
                    var progressInterval = setInterval(function (){
                        if (progNum >= ele.getAttribute("data-progress")) {
                            clearInterval(progressInterval);
                        } else {
                            progNum++;
                            ele.style.width = progNum + '%';
                            ele.parentElement.previousElementSibling.children[1].innerHTML = progNum + '%';
                        }
                    }, 25);
                    ele.classList.add('open');
                }
                });  

            });
            sectionStatus["skills"] = 1;  
        }

        //My Features
        if(scrollVal > (featuresOfftop + featuresOuterheight - 200) - windowHeight && sectionStatus["feature"] == 0) {
            features.find(".feat-box").addClass("show");
            sectionStatus["feature"] = 1;
        }

        //My Education
        if(scrollVal > (educationOfftop + educationOuterheight) - windowHeight) {
            var content = education.find(".timeline-contant");
            education.removeClass("hide");
            content.children(".year").delay(1500).animate({
                opacity:"1"
            },800,function(){
                $(this).siblings(".left").animate({
                    left:"0",
                    opacity:"1"
                },800);
            });
            sectionStatus["education"] = 1;
        }
    });

});