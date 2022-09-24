// This script opens a picture in bigger size when you click it

// All the images in the gallery
const images = document.getElementsByClassName('galleryPic');
// The shadow in the background
const shadow = document.querySelector('.shadow');
// The big picture where the clicked image will be shown
const bigImage = document.querySelector('.bigImage');
// A button for closing the opened image
const closeButton = document.querySelector('.closeButton');
// Source of the clicked image
let selectedSrc = '';

let displayBigImage = function(src) {
    // Make the hidden elements visible and set the source of the big image
    shadow.style.visibility = 'visible';
    shadow.style.opacity = '0.75';
    bigImage.src = src;
    bigImage.style.visibility = 'visible';
    bigImage.classList.add('visible');
    closeButton.style.visibility = 'visible';
    closeButton.classList.add('visible');
}

let unDisplayBigImage = function(){
    // Return to normal state
    shadow.style.visibility = 'hidden';
    shadow.style.opacity = '0';
    bigImage.src = '';
    bigImage.style.visibility = 'hidden';
    bigImage.classList.add('hidden');
    closeButton.style.visibility = 'hidden';
    closeButton.classList.add('hidden');
}

// Event listeners for each image
Array.from(images).forEach(element => {
        element.addEventListener('click', function(){
        selectedSrc = element.childNodes[0].nextSibling.src;
        displayBigImage(selectedSrc);
    });
});

// The close button event listener
closeButton.addEventListener('click', unDisplayBigImage);