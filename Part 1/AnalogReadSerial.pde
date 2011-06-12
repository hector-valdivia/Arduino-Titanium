/*
  AnalogReadSerial
 Reads an analog input on pin 0, prints the result to the serial monitor 
 
 This example code is in the public domain.
 */

void setup() {
  Serial.begin(9600);
}

void loop() {
  int sensorValue = analogRead(A0);
  Serial.println(sensorValue);
  delay(1000);
}


/*
	the second example can be used if you do not have a input sensor avaliable.
*/


/*
void setup() {
  Serial.begin(9600);
}

void loop() {
  Serial.println("NO FORMAT"); 
  delay(1000);
}
*/
