//Grab header
const headerElement = document.querySelector('header');

//Make countdown for progressive JS
const countdown = document.createElement('p');
countdown.classList.add('countdown');

//Prepend at the start of header
headerElement.prepend(countdown);

//Default timer
let tillMidnightMilli = 10000;

function christmasCountdown(){
        const today = Temporal.Now.plainDateISO();
        const christmasThisYear = new Temporal.PlainDate(today.year, 12, 25);
        const christmasNextYear = new Temporal.PlainDate(today.year + 1, 12, 25);
        const tillChristmas = today.until(christmasThisYear).days;
        const tillNextChristmas = today.until(christmasNextYear).days;
        
        // Countdown either to this christmas or next christmas
        if(tillChristmas < 0){
            countdown.innerText = `${tillNextChristmas} days till next Christmas`
        }else{
            countdown.innerText = `${tillChristmas} days till Christmas!`
    }
}


// Time till midnight
function timeTillMidnight(){

        const todayTime = Temporal.Now.plainDateTimeISO();

        const midnight = todayTime.add({ days: 1}).with({
            hour: 0,
            minute: 0,
            second: 0,
            millisecond: 0,
            nanosecond: 0,
            microsecond: 0
        });

         tillMidnightMilli = todayTime.until(midnight).total({ unit: "milliseconds" });
}

//Midnight reset
function updateAtMidnight() {
    //Re run christmasCountDown
    christmasCountdown();


    timeTillMidnight();
}

updateAtMidnight();

// Make it reload every 10 seconds
setTimeout(updateAtMidnight(),tillMidnightMilli);