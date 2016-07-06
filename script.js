//JavaScript, use pictures as buttons, sends and receives values to/from the Rpi
//These are all the buttons
var button_0 = document.getElementById("button_0");
var button_1 = document.getElementById("button_1");
var button_2 = document.getElementById("button_2");
var button_3 = document.getElementById("button_3");
var button_4 = document.getElementById("button_4");
var button_5 = document.getElementById("button_5");
var button_6 = document.getElementById("button_6");


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
//LIGHT
button_0.addEventListener("click", function () { 
	if ( button_0.alt === "off" ) {
		var new_status = change_pin ( 0, 0);
		if (new_status !== "fail") { 
			button_0.alt = "on"
			button_0.src = "data/img/on/light_on.png"; 
			return 0;
			}
		}
	if ( button_0.alt === "on" ) {
		var new_status = change_pin ( 0, 1);
		if (new_status !== "fail") { 
			button_0.alt = "off"
			button_0.src = "data/img/off/light_off.png"; 
			return 0;
			}
		}
} );
	
button_1.addEventListener("click", function () { 
	if ( button_1.alt === "off" ) {
		var new_status = change_pin ( 1, 0);
		if (new_status !== "fail") { 
			button_1.alt = "on"
			button_1.src = "data/img/on/light_on.png"; 
			return 0;
			}
		}
	if ( button_1.alt === "on" ) {
		var new_status = change_pin ( 1, 1);
		if (new_status !== "fail") { 
			button_1.alt = "off"
			button_1.src = "data/img/off/light_off.png"; 
			return 0;
			}
		}
} );
	

//RAIN
button_2.addEventListener("click", function () { 
	if ( button_2.alt === "off" ) {
		var new_status = change_pin ( 2, 0);
		if (new_status !== "fail") { 
			button_2.alt = "on"
			button_2.src = "data/img/on/rain_on.png"; 
			return 0;
			}
		}
	if ( button_2.alt === "on" ) {
		var new_status = change_pin ( 2, 1);
		if (new_status !== "fail") { 
			button_2.alt = "off"
			button_2.src = "data/img/off/rain_off.png"; 
			return 0;
			}
		}
} );
	
button_3.addEventListener("click", function () { 
	if ( button_3.alt === "off" ) {
		var new_status = change_pin ( 3, 0);
		if (new_status !== "fail") { 
			button_3.alt = "on"
			button_3.src = "data/img/on/rain_on.png"; 
			return 0;
			}
		}
	if ( button_3.alt === "on" ) {
		var new_status = change_pin ( 3, 1);
		if (new_status !== "fail") { 
			button_3.alt = "off"
			button_3.src = "data/img/off/rain_off.png"; 
			return 0;
			}
		}
} );
	
//MOON
button_4.addEventListener("click", function () { 
	if ( button_4.alt === "off" ) {
		var new_status = change_pin ( 4, 0);
		if (new_status !== "fail") { 
			button_4.alt = "on"
			button_4.src = "data/img/on/moon_on.png"; 
			return 0;
			}
		}
	if ( button_4.alt === "on" ) {
		var new_status = change_pin ( 4, 1);
		if (new_status !== "fail") { 
			button_4.alt = "off"
			button_4.src = "data/img/off/moon_off.png"; 
			return 0;
			}
		}
} );
	
//AIR
button_5.addEventListener("click", function () { 
	if ( button_5.alt === "off" ) {
		var new_status = change_pin ( 5, 0);
		if (new_status !== "fail") { 
			button_5.alt = "on"
			button_5.src = "data/img/on/air_on.png"; 
			return 0;
			}
		}
	if ( button_5.alt === "on" ) {
		var new_status = change_pin ( 5, 1);
		if (new_status !== "fail") { 
			button_5.alt = "off"
			button_5.src = "data/img/off/air_off.png"; 
			return 0;
			}
		}
} );
	
button_6.addEventListener("click", function () { 
	if ( button_6.alt === "off" ) {
		var new_status = change_pin ( 6, 0);
		if (new_status !== "fail") { 
			button_6.alt = "on"
			button_6.src = "data/img/on/air_on.png"; 
			return 0;
			}
		}
	if ( button_6.alt === "on" ) {
		var new_status = change_pin ( 6, 1);
		if (new_status !== "fail") { 
			button_6.alt = "off"
			button_6.src = "data/img/off/air_off.png"; 
			return 0;
			}
		}
} );
	

	
