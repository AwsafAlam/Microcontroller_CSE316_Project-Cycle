#include<SoftwareSerial.h>
#include<stdio.h>
#include<string.h>
#include <TinyGPS++.h>

static const uint32_t GPSBaud = 9600;

// The TinyGPS++ object
TinyGPSPlus gps;

SoftwareSerial GPRS(7,8); //Rx , Tx
SoftwareSerial GPS(9,10); //Rx , Tx

unsigned char charLat[100];
unsigned char buffer[64];
int count = 0;


void GPS_parse(){
  
  if (GPS.available()){
    //Serial.print("<- GPS Data ->");
    gps.encode(GPS.read());
    if (gps.location.isUpdated()){
      
      GPRS.write("AT+CMGF=1\r\n"); // Set the GSM module in text mode
      delay(500);

       GPRS.write("AT+CMGS=\"+8801630246627\"\r\n");
       delay(200);
    
       GPRS.write(" Latitude= ");
      dtostrf(gps.location.lat(), 6, 6, charLat);
      GPRS.write(gps.location.lat());
            
      // Longitude in degrees (double)
      GPRS.write(" Longitude= "); 
      dtostrf(gps.location.lng(), 6, 6, charLat);
      GPRS.write(gps.location.lat());
    
//      Serial.println(gps.location.lng(), 6); 
//      // Raw latitude in whole degrees
//      Serial.print("Raw latitude = "); 
//      Serial.print(gps.location.rawLat().negative ? "-" : "+");
//      Serial.println(gps.location.rawLat().deg); 
//      // ... and billionths (u16/u32)
//      Serial.println(gps.location.rawLat().billionths);
//      
//      // Raw longitude in whole degrees
//      Serial.print("Raw longitude = "); 
//      Serial.print(gps.location.rawLng().negative ? "-" : "+");
//      Serial.println(gps.location.rawLng().deg); 
//      // ... and billionths (u16/u32)
//      Serial.println(gps.location.rawLng().billionths);
//
//      // Year (2000+) (u16)
//      Serial.print("Year = "); 
//      Serial.println(gps.date.year()); 
//      // Month (1-12) (u8)
//      Serial.print("Month = "); 
//      Serial.println(gps.date.month()); 
//      // Day (1-31) (u8)
//      Serial.print("Day = "); 
//      Serial.println(gps.date.day()); 
//
//      // Raw time in HHMMSSCC format (u32)
//      Serial.print("Raw time in HHMMSSCC = "); 
//      Serial.println(gps.time.value()); 
//
//      // Hour (0-23) (u8)
//      Serial.print("Hour = "); 
//      Serial.println(gps.time.hour()); 
//      // Minute (0-59) (u8)
//      Serial.print("Minute = "); 
//      Serial.println(gps.time.minute()); 
//      // Second (0-59) (u8)
//      Serial.print("Second = "); 
//      Serial.println(gps.time.second()); 
//      
//      
//      // Speed in meters per second (double)
//      Serial.print("Speed in m/s = ");
//      Serial.println(gps.speed.mps()); 
//
//      // Altitude in feet (double)
//      Serial.print("Altitude in feet = "); 
//      Serial.println(gps.altitude.feet()); 
//
//      // Number of satellites in use (u32)
//      Serial.print("Number os satellites in use = "); 
//      Serial.println(gps.satellites.value()); 
//      Serial.println("------------------------------------------------------");
//      
      
       GPRS.write(0x1a);
       GPRS.write("\r\n");
         
       delay(60000);
       //break;
       //Serial.println("--new cycle---");
      
    }
    }
    
}

  

void setup() {
  // put your setup code here, to run once:
  GPRS.begin(9600);
  GPS.begin(9600);
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
    //Serial.println("Got data...");
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
