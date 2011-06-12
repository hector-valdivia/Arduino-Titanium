<?php
header('Content-type: application/json');

    // Normally we would load the serial port class
 	// But to use with Titanium we remove this to use with titanium and include it in the index, so its only called once.
   	
	// if you want to test in a web browser make sure you have php running on your computer and uncomment this next line
   	// include_once("php_serial.php");

	    // Initialize the class
	    $serial = new phpSerial();
	
	    //Specify the serial port to use... in this case COM1
	    $serial->deviceSet("/dev/cu.usbserial-A800etjJ");
	
	    // Set the serial port parameters. The documentation says 9600 8-N-1, so
	   	$serial->confBaudRate(9600); //Baud rate: 9600 
	
	// leave this alone 
	    $serial->confParity("none");  //Parity (this is the "N" in "8-N-1")
	    $serial->confCharacterLength(8); //Character length 
	// (this is the "8" in "8-N-1")
	    $serial->confStopBits(1);  //Stop bits (this is the "1" in "8-N-1")
	    $serial->confFlowControl("none");
	
	// Device does not support flow control of any kind, 
	// so set it to none.
	
	
	// Now we "open" the serial port so we can read from it
	    $serial->deviceOpen();
	
	sleep(2);
	$read = $serial->readPort();
	
	// trim it down, because we are printing a new line every time and thers a \n at the end of it. 
	$read =  (substr($read, 0, -2)); 
	
	    //We're done, so close the serial port again
	    $serial->deviceClose();
	
	/// set your timezone of titanium flips shit 
	date_default_timezone_set('America/New_York');
	
	// format we are matching is 	Sat, 30 Apr 2011 08:51:00 -0400
	$time = date("D, d M Y H:i:s O");
	// 
	$json = '{
		"serialdata": [
			{
				"A0":"'.$read.'",
				"date":"'.$time.'"
			}
		]
	}';
	echo $json;

?>