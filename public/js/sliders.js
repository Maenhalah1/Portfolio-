$(document).ready(function(){

    // Slider Effect
    var slider = document.querySelector(".slider");

    if(slider != null){
        var imagesSliderBox = slider.querySelector(".slider-images"),
        previous = slider.querySelector(".previous"),
        next = slider.querySelector(".next"),
        pageinateSlider = slider.querySelector(".slider-pageinate"),
        overlayImages = document.createElement("div"),
        popIcon = document.createElement("i"),
        sliderImages=imagesSliderBox.children,
        numberSliderImages = sliderImages.length,
        currentImageSlider = 0;
        if(numberSliderImages > 2){
            currentImageSlider = 1;
        }
        overlayImages.className = "overlay";
        popIcon.className = "fas fa-expand popup-icon popImg";

        //Create Pageinate Slider
        var pageinateBox = document.createElement("ul");
        for(var i = 1; i<=numberSliderImages; i++){
            var li = document.createElement("li");
            li.setAttribute("data-index", i-1);
            li.appendChild(document.createTextNode(i));
            pageinateBox.appendChild(li);
        }
        pageinateSlider.appendChild(pageinateBox);

        pageination = pageinateSlider.querySelector("ul");
        pageinationItems = pageination.children;


        changeSliderImage();

        next.addEventListener("click",function(){
            if(currentImageSlider < numberSliderImages - 1){
                currentImageSlider++;
                changeSliderImage();
            }
        
        });

        previous.addEventListener("click",function(){
            if(currentImageSlider > 0){
                currentImageSlider--;
                changeSliderImage();
            }


        });

        function changeSliderImage(){
            var previousNumber = currentImageSlider - 1,
            nextNumber = currentImageSlider + 1;

            removeAllActiveInSlider();
            if(previousNumber >= 0)
                sliderImages[previousNumber].classList.add("previous-img");
            pageinationItems[currentImageSlider].classList.add("active");

            
            sliderImages[currentImageSlider].classList.add("active");
            sliderImages[currentImageSlider].classList.add("overlay-pop");
            sliderImages[currentImageSlider].appendChild(overlayImages);
            sliderImages[currentImageSlider].appendChild(popIcon);

            if(nextNumber <= numberSliderImages - 1)
                sliderImages[nextNumber].classList.add("next-img");
            if(currentImageSlider < 1){
                previous.style.opacity = '0';
                next.style.opacity = '1';
            }else if(currentImageSlider >= numberSliderImages-1){
                previous.style.opacity = '1';
                next.style.opacity = '0';
            }else{
                previous.style.opacity = '1';
                next.style.opacity = '1'; 
            }

        }

        function removeAllActiveInSlider(){
            for(var i = 0; i < numberSliderImages; i++){
                if(sliderImages[i].classList.contains("active"))
                    sliderImages[i].classList.remove("active");
                if(pageinationItems[i].classList.contains("active"))
                    pageinationItems[i].classList.remove("active");

                if(sliderImages[i].classList.contains("previous-img"))
                    sliderImages[i].classList.remove("previous-img");

                if(sliderImages[i].classList.contains("next-img"))
                    sliderImages[i].classList.remove("next-img");

            }
        }
    }
});