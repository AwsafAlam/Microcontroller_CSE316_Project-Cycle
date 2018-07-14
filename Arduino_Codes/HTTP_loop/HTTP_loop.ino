#include<SoftwareSerial.h>
#include<stdio.h>
#include<string.h>
 
SoftwareSerial GPRS(7,8); //Rx , Tx
int LockPin = 13;
int UnlockPin = 12;
 
unsigned char buffer[64];
unsigned char bufferReader[64];
int count = 0;
int bufferReaderCounter = 0;

void HTTPinit(){
   GPRS.write("AT+HTTPPARA=\"CID\",1\r\n");
   delay(500);
 
   char * writeQuery = "AT+HTTPPARA=\"URL\",\"https://onlinesohopathi.com/v1/index_Cycle.php/updateloc?lat=29.64&lng=11.33&bk=1\"\r\n";
   GPRS.write(writeQuery);
   delay(500);

   printSerial();
   
   GPRS.write("AT+CREG?\r\n");
   delay(500);
   
   GPRS.write("AT+CGATT=1\r\n"); // Attach to GPRS
   delay(500);
   printSerial();
   GPRS.write("AT+SAPBER=3,1,\"APN\",\"gpinternet\"\r\n");  // To query the GPRS context
   delay(200);
 
   GPRS.write("AT+SAPBR=1,1\r\n"); // Open a GPRS context
   delay(500);
   
   GPRS.write("AT+HTTPACTION=1\r\n");
   delay(1000);
   printSerial();
  
}

void printSerial(){
    while(GPRS.available())
    {
      buffer[count++] = GPRS.read();
      if(count == 64) break;
    }
    Serial.write(buffer , count);
    clearBufferArray();
    count = 0;
}

 
void setup() {
 
  pinMode(LockPin, OUTPUT);//blink led for testing
  pinMode(UnlockPin , OUTPUT);
  
  GPRS.begin(9600);
  Serial.begin(9600);
 
   GPRS.write("AT\r\n");
   delay(200);
   
   GPRS.write("AT+HTTPINIT\r\n");
   delay(200);
 
   printSerial();
   
}
 
void loop() {
  digitalWrite(LockPin, LOW);
  digitalWrite(UnlockPin, LOW);
  
  bufferReaderCounter = 0;
  HTTPinit();
  Serial.write("\r\n ... ... \r\n");
   
  while(GPRS.available())
  {
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
 
  
  char *p;
  p = strtok(buffer, ",");
  p = strtok(NULL, ",");
  p = strtok(NULL, ",");
 
  if(buffer[0] != NULL){
    int i;
    sscanf(p, "%d", &i);
    Serial.print("Found buffer array size:  ");
    Serial.println(i);
 
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
 
   
    Serial.write(bufferReader,bufferReaderCounter);
    char* pch = strstr (bufferReader,"unlock"); // find "unlock" inside bufferReader
   
    if(!pch){
      Serial.println("Got unlock inside bufferedReader ");
      digitalWrite(UnlockPin, HIGH);   // turn the LED on (HIGH is the voltage level)
      delay(1000);                       // wait for a second
      digitalWrite(UnlockPin, LOW);    // turn the LED off by making the voltage LOW
      delay(1000);                       // wait for a second
    }

    char* lock = strstr (bufferReader,"lock"); // find "lock" inside bufferReader
   
    if(!lock){
      Serial.println("Got lock inside bufferedReader ");
      digitalWrite(LockPin, HIGH);   // turn the LED on (HIGH is the voltage level)
      delay(1000);                       // wait for a second
      digitalWrite(LockPin, LOW);    // turn the LED off by making the voltage LOW
      delay(1000);                       // wait for a second
    }
   
   
    Serial.println("-----T ");
    Serial.println("A----");
    //clearBufferReaderArray();
    //bufferReaderCounter = 0;
   
  }
  Serial.write(buffer , count);
//Serial.println(i);
  clearBufferArray();
  count = 0;
 
  SerialIO();
 
  delay(3000);
   
}
 
void clearBufferArray()
{
  for(int i = 0; i< count ; i++)
  {
    buffer[i] = NULL;
   
  }  
 
}
 
void SerialIO(){
   
   while(Serial.available()){
     byte b = Serial.read();
     if( b == '*')
        GPRS.write(0x1a);
     else
        GPRS.write(b);
   }
     
}
 
 
void clearBufferReaderArray()
{
  for(int i = 0; i< bufferReaderCounter ; i++)
  {
    bufferReader[i] = NULL;
   
  }  
 
}
