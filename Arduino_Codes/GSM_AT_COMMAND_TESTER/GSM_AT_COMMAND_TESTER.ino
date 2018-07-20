#include <SoftwareSerial.h>

SoftwareSerial mySerial(7, 8); // RX, TX 

void setup()  
{
  // Open serial communication
  Serial.begin(9600);

  // set the data rate for the SoftwareSerial port
  mySerial.begin(9600);

  delay(1000);
  Serial.println("Testing SIM800L module");
  Serial.println();
  Serial.print("Sizeof(mySerial) = "); Serial.println(sizeof(mySerial));
  Serial.println();

}

void loop() // run over and over
{

  if( mySerial.available() )
  {
    char c = mySerial.read();
    Serial.print(c);
  }

  if(Serial.available())
  {
    String Arsp = Serial.readString();

    Serial.println("Serial available");
    Serial.println(Arsp);
    mySerial.println(Arsp);
    Serial.println("Serial available end");
  }

}
