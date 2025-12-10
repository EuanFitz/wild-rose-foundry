
const images = carousel.querySelectorAll('li');
const slider = document.createElement('ol');

images.forEach(feature =>{
    const list = document.createElement('li');
    const button = document.createElement('button');

    list.appendChild(button);
    slider.appendChild(list);
    
})
const buttonNext = document.createElement('button');
const buttonPrev = document.createElement('button');

container.appendChild(slider);
container.appendChild(buttonNext);
container.appendChild(buttonPrev);


container.addEventListener('click', (e) =>{
    // console.log(e);
    // console.log(e.target.parentElement.parentElement.children);
    const position = Array.from(e.target.parentElement.parentElement.children).indexOf(e.target.parentElement);
        console.log(position);
    if(e.target.nodeName == "BUTTON"){
        images[position].scrollIntoView({behavior: "smooth", block:"end", inline:"nearest"})
    }

});