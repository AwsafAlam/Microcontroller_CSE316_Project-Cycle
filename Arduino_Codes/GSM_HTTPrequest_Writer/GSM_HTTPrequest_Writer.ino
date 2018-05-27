#include<SoftwareSerial.h>
#include<stdio.h>
#include<string.h>

SoftwareSerial GPRS(7,8); //Rx , Tx

unsigned char buffer[64];
unsigned char bufferReader[64];
int count = 0;
int bufferReaderCounter = 0;

void setup() {
  // put your setup code here, to run once:
  GPRS.begin(9600);
  Serial.begin(9600);

   GPRS.write("AT\r\n");
   delay(200);
   
   GPRS.write("AT+HTTPINIT\r\n");
   delay(200);

   GPRS.write("AT+HTTPPARA=\"CID\",1\r\n");
   delay(500);

   char * writeQuery = "AT+HTTPPARA=\"URL\",\"http://198.211.96.87/Awsaf/index.php?Lng=296&Lat=100\"\r\n";
   GPRS.write(writeQuery);
   delay(500);
   
   GPRS.write("AT+CREG?\r\n");
   delay(500);
   
   GPRS.write("AT+CGATT=1\r\n"); // Attach to GPRS
   delay(500);
   
   GPRS.write("AT+SAPBER=3,1,\"APN\",\"gpinternet\"\r\n");  // To query the GPRS context
   delay(200);

   GPRS.write("AT+SAPBR=1,1\r\n"); // Open a GPRS context
   delay(500);
   
   GPRS.write("AT+HTTPACTION=1\r\n");
   delay(1000);

   
    while(GPRS.available())
    {
      buffer[count++] = GPRS.read();
      if(count == 64) break;
    }
    //Serial.println(buffer);
    Serial.write(buffer , count);
    clearBufferArray();
    count = 0;
    Serial.write("\r\n ... ... \r\n");
    //  delay(1000);
    
    /*while(1)
    {
      if(GPRS.available()){
        if(GPRS.read()!='+'){continue;}
        else{
        buffer[count++] = GPRS.read();
        Serial.write("Something");
        break;
        }
        if(count == 64) break;
      }
    }
    Serial.write(buffer , count);
    //clearBufferArray();
    count = 0;

    */
   // Serial.write("\r\n ... ... \r\n");

    
    //GPRS.write("AT+HTTPREAD=0,7\r\n"); // Open a GPRS context
   // delay(700);
 
    
}

void loop() {
  // put your main code here, to run repeatedly:
  count=0;
  bufferReaderCounter = 0;
  while(GPRS.available())
  {
    Serial.println("Available --> ");
    //buffer[count++] = GPRS.read();
    //Serial.println(buffer[count-1]);
    if(GPRS.read() == '+'){
      Serial.println("--------------Found plus ------------");
      while(GPRS.available()){
        buffer[count++] = GPRS.read();
        Serial.println(buffer[count-1]);
      }
    }
    else{
      continue;
    }
    if(count == 64) break;
  }
  
  //Serial.println("Wrinting from buffer ..........................");

  char *p;
  p = strtok(buffer, ",");
  p = strtok(NULL, ",");
  p = strtok(NULL, ",");

  

  if(buffer[0] != NULL){
    //int i;
    //sscanf(p, "%d", &i);
    Serial.print("Found buffer array size:  ");
    //Serial.println(i);

    char * readContent = "AT+HTTPREAD=0,";
    strcat(p, "\r\n");
    strcat(readContent, p);
    GPRS.write(readContent);
    delay(200);


    char flag = 'f';
    while(flag == 'f' && !GPRS.available()){
      
    }
    flag = 't';
    while(GPRS.available()){
      bufferReader[bufferReaderCounter++] = GPRS.read();
    }

    Serial.println("Read Content GOt: ");
    Serial.write(bufferReader,bufferReaderCounter);
    Serial.println("----");
    //clearBufferReaderArray();
    //bufferReaderCounter = 0;
    
  }
  Serial.write(buffer , count);
//  Serial.println(i);
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



void clearBufferReaderArray()
{
  for(int i = 0; i< bufferReaderCounter ; i++)
  {
    bufferReader[i] = NULL; 
   
  }  
  
}
