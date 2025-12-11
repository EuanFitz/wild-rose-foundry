
const images = carousel.querySelectorAll('li');
const slider = document.createElement('ol');

images.forEach((feature, i) =>{
    const list = document.createElement('li');
    const button = document.createElement('button');
    button.innerText = `${i+1}`;

    list.appendChild(button);
    slider.appendChild(list);
    
})
const buttonNext = document.createElement('button');
const buttonPrev = document.createElement('button');

container.appendChild(slider);


container.addEventListener('click', (e) =>{
    // console.log(e);
    // console.log(e.target.parentElement.parentElement.children);
    const position = Array.from(e.target.parentElement.parentElement.children).indexOf(e.target.parentElement);
        console.log(position);
    if(e.target.nodeName == "BUTTON"){
        images[position].scrollIntoView({behavior: "smooth", block:"nearest", inline:"nearest"})
    }

});