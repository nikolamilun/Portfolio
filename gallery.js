const images = document.getElementsByClassName('galleryPic');
const shadow = document.querySelector('.shadow');
const bigImage = document.querySelector('.bigImage');
const closeButton = document.querySelector('.closeButton');
let selectedSrc = '';

let displayBigImage = function(src) {
    shadow.style.visibility = 'visible';
    shadow.style.opacity = '0.75';
    bigImage.src = src;
    bigImage.style.visibility = 'visible';
    bigImage.classList.add('visible');
    closeButton.style.visibility = 'visible';
    closeButton.classList.add('visible');
}

let unDisplayBigImage = function(){
    shadow.style.visibility = 'hidden';
    shadow.style.opacity = '0';
    bigImage.src = '';
    bigImage.style.visibility = 'hidden';
    bigImage.classList.add('hidden');
    closeButton.style.visibility = 'hidden';
    closeButton.classList.add('hidden');
}

Array.from(images).forEach(element => {
        element.addEventListener('click', function(){
        selectedSrc = element.childNodes[0].nextSibling.src;
        displayBigImage(selectedSrc);
    });
});

closeButton.addEventListener('click', unDisplayBigImage);