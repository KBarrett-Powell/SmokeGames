//Displaying first image
var slideIndex = 1;
showImg(slideIndex);

//Changes left and right clicks have on image displayed
function plusDivs(n) {
    showImg(slideIndex += n);
}

//Displaying image at n position in list
function currentDiv(n) {
    showImg(slideIndex = n);
}

//How image is displayed
function showImg(n) {
var i;
var x = document.getElementsByClassName("imgs");
var dots = document.getElementsByClassName("viewNum");
if (n > x.length) {slideIndex = 1}    
if (n < 1) {slideIndex = x.length}
for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
}
for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" white", "");
}
x[slideIndex-1].style.display = "block";  
    dots[slideIndex-1].className += " white";
}