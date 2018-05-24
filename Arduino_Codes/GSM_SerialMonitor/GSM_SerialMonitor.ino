#include<SoftwareSerial.h>
SoftwareSerial GPRS(7,8); //Rx , Tx

unsigned char buffer[64];
int count = 0;

void setup() {
  // put your setup code here, to run once:
  GPRS.begin(9600);
  Serial.begin(9600);
}

void loop() {
  // put your main code here, to run repeatedly:
  while(GPRS.available())
  {
    buffer[count++] = GPRS.read();
    if(count == 64) break;
  }
  //Serial.println(buffer);
  Serial.write(buffer , count);
  clearBufferArray();
  count = 0;

  if(Serial.available()){
    Serial.println("Got data...");
   byte b = Serial.read();
   if( b == '*')
      GPRS.write(0x1a);
   else
      GPRS.write(b);
   }
}

void clearBufferArray()
{
  for(int i = 0; i< count ; i++)
  {
    buffer[i] = NULL; 
  }  
  
}
