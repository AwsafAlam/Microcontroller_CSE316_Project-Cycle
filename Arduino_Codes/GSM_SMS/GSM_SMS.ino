#include<SoftwareSerial.h>
#include<stdio.h>
#include<string.h>
 
SoftwareSerial GPRS(7,8); //Rx , Tx
 

void setup() {
  // put your setup code here, to run once:
  GPRS.begin(9600);
  Serial.begin(9600);
 
   GPRS.write("AT\r\n");
   delay(500);
   
}

void loop() {
  // put your main code here, to run repeatedly:

   GPRS.write("AT+CMGF=1\r\n"); // Set the GSM module in text mode
   delay(500);

   GPRS.write("AT+CMGS=\"+8801630246627\"\r\n");
   delay(500);
  
    GPRS.write("Hello");
    GPRS.write(0x1a);
    GPRS.write("\r\n");
    
   delay(30000);
}
