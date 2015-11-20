var timer;
var counter = 1;
var pause = true;


/**************************
 *  Timer Interactions    *
 **************************/

// run timer 
$(document).on('click', '.pause', function() {
	$(this).html('Pause');
	$(this).addClass('running').removeClass('pause');
	if (pause) {
		timer = runTimer();
		pause = false;
	}
});

//pause timer
$(document).on('click', '.running', function() {
	$(this).html('Run');
	$(this).addClass('pause').removeClass('running');
	pauseTimer();
	pause = true;
});

//reset timer
$(document).on('click', '#btnReset', function() {
	
	var r = confirm("Are you sure?");
	
	if (r) {
		$('#btnStart').html('Run');
		if ($('#btnStart').hasClass('running')) {
			$('#btnStart').addClass('pause').removeClass('running');
		}
		resetTimer();
		pause = true;
	}
});

// Send the timer via ajax to the backend
$(document).on('click', '#btnC42', function() {
	
	var title = $('#action').val();
	var timer = $('#timer').html();
	
	$.ajax({
		url: './ajax.php',
		method: "POST",
		data: { 
			title: title, 
			timer: timer,
			target: 'saveTimer'
		}
	}).done(function( msg ) {
		if (msg == 'success') {
			$('#msg-box').css('color','lightgreen');
			$('#msg-box').html('Time has been Saved: ' + timer);
		} else {
			$('#msg-box').css('color','#e64d41');
			$('#msg-box').html(msg);
		}
	});
});



/**************************
 *      functions         *
 **************************/
function runTimer() {
	timer = setInterval(function() {
    	displayTime(counter);
    	counter++;
    }, 1000);
    return timer;
}

function pauseTimer() {
	clearInterval(timer);
}

function resetTimer() {
	pauseTimer();
	counter = 0;
	displayTime(counter);
}

function displayTime(counter) {
    var output; 
    var seconds;
    var minutes;
    var hours = "0";
    if (counter < 10) {
        seconds = counter;
        output = "00:00:0" + seconds;
    } else if (counter < 60) {
    	seconds = counter;
        output = "00:00:" + seconds;
    } else if (counter < 600) {
        seconds = counter%60;
        if (seconds<10) {
            seconds = "0"+seconds;
        }
        minutes = (counter-seconds)/60;
        output = "00:0"+minutes+":"+seconds;
    } else if (counter<3600) {
        seconds = counter%60;
        if (seconds<10) {
            seconds = "0"+seconds;
        }            
        minutes = (counter-seconds)/60;
        output = '00:'+minutes+":"+seconds;
    } else {
        seconds = counter%60;
        if (seconds<10) {
            seconds = "0"+seconds;
        }
        minutes = (counter-seconds)/60;
        while (minutes > 59) {
            minutes = minutes-60;
            hours++;
        }
        if (minutes<10) {
            minutes = "0"+minutes;
        }
        if (hours<10) {
            hours = "0"+hours;
        } 
        output = hours+":"+minutes+":"+seconds;
    }
    
    $('#timer').html(output);
}


/*******************************
 *  Interface fixes and debug  *
 *******************************/


// footer position CSS-fix
(function() {
	
	checkFooterPos();
	
	// no < IE9 support
	window.addEventListener( "resize", function() {
		checkFooterPos();
	});
	
	// execute on turning a mobile screen
	window.addEventListener( "orientationchange", function() {
		checkFooterPos();
	});
	
	function checkFooterPos() {
		footer = document.getElementsByTagName('footer')[0];
		windowHeight = window.innerHeight;
		headerHeight = document.getElementsByTagName('header')[0].offsetHeight;
		wrapperHeight = document.getElementById('body').offsetHeight;
		footerHeight = footer.offsetHeight;
		contentHeight = headerHeight+wrapperHeight+footerHeight;
		
		if (contentHeight > windowHeight) {
			footer.style.position = 'relative';
		} else {
			footer.style.position = 'absolute';
		}
	}
	
})();


/*
 * show screen size numbers in pixel for development purpose
 * plugin by @jona Paulus
 */
(function() {
	
	//setting
	var active = false;
	
	if (!active) {
		return false;
	}
	
	var node = document.createElement('div');
	node.id = 'windowsize';
	node.style.position = "fixed";
	node.style.top = '0';
	node.style.left = '0';
	node.style.fontSize = '10px';
	node.style.color = 'black';
	
	showsize(node);
	
	// no < IE9 support
	window.addEventListener( "resize", function() { 
		showsize(node);
	}); 
	
	function showsize(node) {
		node.innerHTML = '';
		var height = window.innerHeight;
		var width = window.innerWidth;
		var text = document.createTextNode(width + ' x ' + height);
		node.appendChild(text);
		var body = document.getElementsByTagName('body')[0].appendChild(node);
	}
	
})();