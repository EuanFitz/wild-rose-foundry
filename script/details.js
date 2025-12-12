const variantKey = document.createElement('p');
productname.after(variantKey);


thumb.addEventListener('click', (e) =>{
    const imgsrc = e.target.src;
    const imgTitle = e.target.title;
    const newVarid = e.target.id;
    const imgKey = e.target.dataset.key;
    console.log(imgKey);
    
    if(e.target.nodeName == "IMG"){
        productimg.src = imgsrc.replace(`/thumb`, '');
        varid.value = newVarid;
        productimg.title = imgTitle;
        variantKey.innerText = `${imgKey}: ${imgTitle}`;
}
});


