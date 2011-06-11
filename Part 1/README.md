Arduino & Titanium communication via PHP Part 1
=============================================


Default setup
----------------


## AnalogReadSerial.pde

In the setup() function we’re going to start the serial communications at 9600. Then our main programming goes into the loop() function. In the loop we read the A0 pin, print it to the serial, and wait for 1000ms.

Insert this code in your Arduino IDE, and upload it to your board and open up your serial monitor (there is a button for it, or a menu option, either works). In your serial monitor, make sure you set the baud rate to 9600, or you wont see anything.

If you don’t have a photocell or other sensor to read from, you can comment out the serial.println(sensorValue); line, and remove the comments on the Serial.println(“test”); line. That way you will still be posting some data for the Titanium app to see.


/* AnalogReadSerial Reads an analog input on pin 0, prints the result to the serial monitor
This example code is in the public domain. */

void setup() {
 Serial.begin(9600);
}

void loop() {
 int sensorValue = analogRead(A0);
 Serial.println(sensorValue);
//Serial.println('test');
 delay(1000);
}

----------------
##json.php

This is the most important file in the titanium project. It’s the bridge between your app and the Arduino, it contains the settings you need to update for this application to return the contents of the your Arduinos serial output. 


You will need to know your Arduino’s serial port to get this to work correctly. 
This can be done using the Arduino IDE, From the menu selecting “Tools->SerialPort” 
will show you the serial port you are talking to the Arduino on. On windows it will 
look more like COM1, COM2, or COM3. 

To update this fine replace the $serial->deviceSet(” “); value with your Arduino’s serial connection.

Currently the json.php file is outputting the A0 value along with the current time in a json encoded array. We later use jQuery to load this array into a table in our titanium project.

<?php
<pre>header('Content-type: application/json');
$serial = new phpSerial();

//Specify the serial port to use...
$serial->deviceSet('/dev/cu.usbserial-A800etjJ');

// leave this alone
$serial->confBaudRate(9600); //Baud rate: 9600
$serial->confParity('none');
$serial->confCharacterLength(8);
$serial->confStopBits(1);
$serial->confFlowControl('none');
$serial->deviceOpen();

sleep(2);
$read = $serial->readPort();
// trim it down, there was an '\n' at the end of it.
$read =  (substr($read, 0, -2));

$serial->deviceClose();

date_default_timezone_set('America/New_York');

$time = date('D, d M Y H:i:s O');
$json = '{
 'serialdata': [
 { 'A0':''.$read.'',
   'date':''.$time.''
 }
 ]
}';
echo $json;
?>
----------------
##index.html

In our index, we are using jQuery to call the json.php. It then parses the results from the Arduino’s response and adds them to our data table. Also note that in Titanium, we have to initialize the php_serial.class.php in a script tag rather then include it in the header of the json.php.

<html>
<head>
 <title>Serial Monitor</title>

 <!-- blueprint css -->
 <link rel='stylesheet' href='screen.css' type='text/css' media='screen' title='no title' charset='utf-8'>

 <!-- jQuery Minified -->
 <script src='jquery-1.5.min.js' type='text/javascript'> </script>

 <!-- Initialize php serial class -->
 <script src='php_serial.class.php' type='text/php' ></script>
</head>

 <body>
  <table id='data' border='0' >
  <thead>    <th>A 0</th> <th>date</th> </thead>
  <tbody>
    <!-- content will go here -->
  </tbody>
 </table>
<script>
 $(document).ready(function(){
  var checkStatus = function() {
   $.getJSON('json.php', function(data){
    $.each(data.serialdata, function(i,serial){
     var tblRow = '<tr>'+'<td>'+serial.A0+'</td>'+'<td>'+serial.date+'</td>'+'</tr>';
     $(tblRow).appendTo('#data tbody');
    });
   });
  setTimeout(checkStatus, 60000); // repeat every 60 seconds
 };
 checkStatus(); // on startup, call the get check status function
 });
 </script>
</body>
</html>