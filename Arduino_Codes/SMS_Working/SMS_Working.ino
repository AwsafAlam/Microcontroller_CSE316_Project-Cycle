#include<SoftwareSerial.h>
#include<stdio.h>
#include<string.h>
#include <TinyGPS++.h>

static const uint32_t GPSBaud = 9600;

// The TinyGPS++ object
TinyGPSPlus gps;

SoftwareSerial GPRS(7,8); //Rx , Tx
SoftwareSerial GPS(9,10); //Rx , Tx

int lockButton =2;
int unlockButton =3;


unsigned char buffer[64];
 char charLat[10];
 char state[10];
 
int count = 0;

float lat=23.774867;
float lng=90.354095;
int speed=0;

void GPS_parse(){

    while(1){
      
      if (GPS.available()){
        gps.encode(GPS.read());
        //Serial.println("-----------Scanning--------");
          
        if (gps.location.isUpdated()){
          lng = gps.location.lng();
          lat = gps.location.lat();
          //speed = gps.speed.mps();
          
          /*
          Serial.println("------------------------------------------------------");
          // Latitude in degrees (double)
          Serial.print("Latitude= "); 
          Serial.print(gps.location.lat(), 6);      
          // Longitude in degrees (double)
          Serial.print(" Longitude= "); 
          Serial.println(gps.location.lng(), 6); 
           
          // Raw latitude in whole degrees
          Serial.print("Raw latitude = "); 
          Serial.print(gps.location.rawLat().negative ? "-" : "+");
          Serial.println(gps.location.rawLat().deg); 
          // ... and billionths (u16/u32)
          Serial.println(gps.location.rawLat().billionths);
          
          // Raw longitude in whole degrees
          Serial.print("Raw longitude = "); 
          Serial.print(gps.location.rawLng().negative ? "-" : "+");
          Serial.println(gps.location.rawLng().deg); 
          // ... and billionths (u16/u32)
          Serial.println(gps.location.rawLng().billionths);
    
          // Year (2000+) (u16)
          Serial.print("Year = "); 
          Serial.println(gps.date.year()); 
          // Month (1-12) (u8)
          Serial.print("Month = "); 
          Serial.println(gps.date.month()); 
          // Day (1-31) (u8)
          Serial.print("Day = "); 
          Serial.println(gps.date.day()); 
    
          // Raw time in HHMMSSCC format (u32)
          Serial.print("Raw time in HHMMSSCC = "); 
          Serial.println(gps.time.value()); 
    
          // Hour (0-23) (u8)
          Serial.print("Hour = "); 
          Serial.println(gps.time.hour()); 
          // Minute (0-59) (u8)
          Serial.print("Minute = "); 
          Serial.println(gps.time.minute()); 
          // Second (0-59) (u8)
          Serial.print("Second = "); 
          Serial.println(gps.time.second()); 
          
          
          // Speed in meters per second (double)
          Serial.print("Speed in m/s = ");
          Serial.println(gps.speed.mps()); 
    
          // Altitude in feet (double)
          Serial.print("Altitude in feet = "); 
          Serial.println(gps.altitude.feet()); 
    
          // Number of satellites in use (u32)
          Serial.print("Number os satellites in use = "); 
          Serial.println(gps.satellites.value()); 
          Serial.println("------------------------------------------------------");
          */
          //Send_SMS();
          break;
        }
      }  
    }
  
}

void Send_SMS(){
      //delay(60000);
  
      GPRS.write("AT+CMGF=1\r\n"); // Set the GSM module in text mode
      delay(500);

       GPRS.write("AT+CMGS=\"+8801521325390\"\r\n");
       delay(200);

      GPRS.write("AW114UT105;");
      
      dtostrf(lat, 6, 5, charLat);
      GPRS.write(charLat);
      GPRS.write(";"); 
            
      // Longitude in degrees (double)
      dtostrf(lng, 6, 5, charLat);
      GPRS.write(charLat);
      GPRS.write(";"); 
      // read the input pin:
//      GPRS.write("0");
      
      int lockbuttonState = digitalRead(lockButton);
      int unlockbuttonState = digitalRead(unlockButton);

      if(lockbuttonState == 0 && unlockbuttonState==1){
        //unlocked
        GPRS.write("1"); 
        
      }
      else if(lockbuttonState == 1 && unlockbuttonState==0){
        //locked
        GPRS.write("0"); 
        
      }
      else{
        //locked
        GPRS.write("0");  
      }
      
      GPRS.write(0x1a);
       GPRS.write("\r\n");
       delay(30000);  
       
}
  
void setup() {
  // put your setup code here, to run once:
  GPRS.begin(9600);
  GPS.begin(9600);

  pinMode(lockButton, INPUT);
  pinMode(unlockButton, INPUT);
  
  //Serial.begin(9600);
  delay(30000);
}

void loop() {
  // put your main code here, to run repeatedly:
//  while(GPRS.available())
//  {
//    buffer[count++] = GPRS.read();
//    if(count == 64) break;
//  }
//  //Serial.println(buffer);
//  Serial.write(buffer , count);
//  clearBufferArray();
//  count = 0;
//
//  if(Serial.available()){
//    //Serial.println("Got data...");
//   byte b = Serial.read();
//   if( b == '*')
//      GPRS.write(0x1a);
//   else
//      GPRS.write(b);
//   }
   Send_SMS();
   
   GPS_parse();
   
}

void clearBufferArray()
{
  for(int i = 0; i< count ; i++)
  {
    buffer[i] = NULL; 
  }  
  
}
