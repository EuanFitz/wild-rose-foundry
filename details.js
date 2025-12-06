const imagesrc = document.querySelector('main div img');
const newUrl = window.location.href;
thumb.addEventListener('click', (e) =>{
    console.log(e.target.id);
    console.log(e.target.attributes.src);
    const varid = e.target.id;
    const imgsrc = e.target.src;
    imagesrc.src = imgsrc.replace(`/thumb`, '');
    window.location.href = (newUrl+=varid); 
});

