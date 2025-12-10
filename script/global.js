function christmasCountdown(){
        const today = Temporal.Now.plainDateISO();
        const christmasThisYear = new Temporal.PlainDate(today.year, 12, 25);
        const christmasNextYear = new Temporal.PlainDate(today.year + 1, 12, 25);
        const tillChristmas = today.until(christmasThisYear).days;
        const tillNextChristmas = today.until(christmasNextYear).days;
        
        // Countdown either to this christmas or next christmas
        if(tillChristmas < 0){
            countdown.innerText = `${tillNextChristmas} days till next christmas!`
        }else{
            countdown.innerText = `${tillChristmas} days till christmas!`
    }
}
christmasCountdown();

// Make it reload every 10 seconds
setTimeout(function(){
}, 10000);
