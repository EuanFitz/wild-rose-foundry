
thumb.addEventListener('click', (e) =>{
    console.log(e.target.nodeName);
    const imgsrc = e.target.src;
    const imgTitle = e.target.title;
    const newVarid = e.target.title;
    
    if(e.target.nodeName == "IMG"){
        productimg.src = imgsrc.replace(`/thumb`, '');
        varid.value = newVarid;
        productimg.title = imgTitle;
}
});


