//JavaScript, use pictures as buttons, sends and receives values to/from the Rpi
//These are all the buttons
var button_0 = document.getElementById("button_0");
var button_1 = document.getElementById("button_1");
var button_2 = document.getElementById("button_2");
var button_3 = document.getElementById("button_3");
var button_4 = document.getElementById("button_4");
var button_5 = document.getElementById("button_5");
var button_6 = document.getElementById("button_6");
var button_7 = document.getElementById("button_7");


//this function sends and receives the pin's status
function change_pin (pin, status) {
	//this is the http request
	var request = new XMLHttpRequest();
	request.open( "GET" , "gpio.php?pin=" + pin + "&status=" + status );
	request.send(null);
	//receiving information
	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			return (parseInt(request.responseText));
		}
	//test if fail
		else if (request.readyState == 4 && request.status == 500) {
			alert ("server error");
			return ("fail");
		}
	//else 
		else { return ("fail"); }
	}
}

//these are all the button's events, it just calls the change_pin function and updates the page in function of the return of it.
button_0.addEventListener("click", function () { 
	//if red
	if ( button_0.alt === "off" ) {
		//use the function
		var new_status = change_pin ( 0, 0);
		if (new_status !== "fail") { 
			button_0.alt = "on"
			button_0.src = "data/img/green/green_0.png"; 
			return 0;
			}
		}
	//if green
	if ( button_0.alt === "on" ) {
		//use the function
		var new_status = change_pin ( 0, 1);
		if (new_status !== "fail") { 
			button_0.alt = "off"
			button_0.src = "data/img/red/red_0.png"; 
			return 0;
			}
		}
} );
	
button_1.addEventListener("click", function () { 
	//if red
	if ( button_1.alt === "off" ) {
		//use the function
		var new_status = change_pin ( 1, 0);
		if (new_status !== "fail") { 
			button_1.alt = "on"
			button_1.src = "data/img/green/green_1.png"; 
			return 0;
			}
		}
	//if green
	if ( button_1.alt === "on" ) {
		//use the function
		var new_status = change_pin ( 1, 1);
		if (new_status !== "fail") { 
			button_1.alt = "off"
			button_1.src = "data/img/red/red_1.png"; 
			return 0;
			}
		}
} );
	
button_2.addEventListener("click", function () { 
	//if red
	if ( button_2.alt === "off" ) {
		//use the function
		var new_status = change_pin ( 2, 0);
		if (new_status !== "fail") { 
			button_2.alt = "on"
			button_2.src = "data/img/green/green_2.png"; 
			return 0;
			}
		}
	//if green
	if ( button_2.alt === "on" ) {
		//use the function
		var new_status = change_pin ( 2, 1);
		if (new_status !== "fail") { 
			button_2.alt = "off"
			button_2.src = "data/img/red/red_2.png"; 
			return 0;
			}
		}
} );
	
button_3.addEventListener("click", function () { 
	//if red
	if ( button_3.alt === "off" ) {
		//use the function
		var new_status = change_pin ( 3, 0);
		if (new_status !== "fail") { 
			button_3.alt = "on"
			button_3.src = "data/img/green/green_3.png"; 
			return 0;
			}
		}
	//if green
	if ( button_3.alt === "on" ) {
		//use the function
		var new_status = change_pin ( 3, 1);
		if (new_status !== "fail") { 
			button_3.alt = "off"
			button_3.src = "data/img/red/red_3.png"; 
			return 0;
			}
		}
} );
	
button_4.addEventListener("click", function () { 
	//if red
	if ( button_4.alt === "off" ) {
		//use the function
		var new_status = change_pin ( 4, 0);
		if (new_status !== "fail") { 
			button_4.alt = "on"
			button_4.src = "data/img/green/green_4.png"; 
			return 0;
			}
		}
	//if green
	if ( button_4.alt === "on" ) {
		//use the function
		var new_status = change_pin ( 4, 1);
		if (new_status !== "fail") { 
			button_4.alt = "off"
			button_4.src = "data/img/red/red_4.png"; 
			return 0;
			}
		}
} );
	
button_5.addEventListener("click", function () { 
	//if red
	if ( button_5.alt === "off" ) {
		//use the function
		var new_status = change_pin ( 5, 0);
		if (new_status !== "fail") { 
			button_5.alt = "on"
			button_5.src = "data/img/green/green_5.png"; 
			return 0;
			}
		}
	//if green
	if ( button_5.alt === "on" ) {
		//use the function
		var new_status = change_pin ( 5, 1);
		if (new_status !== "fail") { 
			button_5.alt = "off"
			button_5.src = "data/img/red/red_5.png"; 
			return 0;
			}
		}
} );
	
button_6.addEventListener("click", function () { 
	//if red
	if ( button_6.alt === "off" ) {
		//use the function
		var new_status = change_pin ( 6, 0);
		if (new_status !== "fail") { 
			button_6.alt = "on"
			button_6.src = "data/img/green/green_6.png"; 
			return 0;
			}
		}
	//if green
	if ( button_6.alt === "on" ) {
		//use the function
		var new_status = change_pin ( 6, 1);
		if (new_status !== "fail") { 
			button_6.alt = "off"
			button_6.src = "data/img/red/red_6.png"; 
			return 0;
			}
		}
} );
	
button_7.addEventListener("click", function () { 
	//if red
	if ( button_7.alt === "off" ) {
		//use the function
		var new_status = change_pin ( 7, 0);
		if (new_status !== "fail") { 
			button_7.alt = "on"
			button_7.src = "data/img/green/green_7.png"; 
			return 0;
			}
		}
	//if green
	if ( button_7.alt === "on" ) {
		//use the function
		var new_status = change_pin ( 7, 1);
		if (new_status !== "fail") { 
			button_7.alt = "off"
			button_7.src = "data/img/red/red_7.png"; 
			return 0;
			}
		}
} );
	
