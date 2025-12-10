
thumb.addEventListener('click', (e) =>{
    console.log(e.target.nodeName);
    const imgsrc = e.target.src;
    const newVarid = e.target.id;

    if(e.target.nodeName == "IMG"){
        productimg.src = imgsrc.replace(`/thumb`, '');
        varid.value = newVarid;
}
});


