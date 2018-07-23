#include<SoftwareSerial.h>
#include<stdio.h>
#include<string.h>
 
SoftwareSerial GPRS(7,8); //Rx , Tx
 
int lockPin = 12;
int unlockPin = 11;
unsigned char buffer[64];
unsigned char bufferReader[64];
int count = 0;
int bufferReaderCounter = 0;
float floatLat = 12.113;
float floatLng = 61.991;

void(* resetFunc) (void) = 0; //declare reset function @ address 0

void GSMinit(){
  floatLat++;
  floatLng++;
  Serial.println("In GSMInit");
  char charLat[10];
  char charLng[10];

  char main[100];
  
  //temporarily holds data from vals

  //4 is mininum width, 3 is precision; float value is copied onto buff
  dtostrf(floatLat, 4, 3, charLat);
  dtostrf(floatLng, 4, 3, charLng);

   char * writeQuery = "AT+HTTPPARA=\"URL\",\"http://198.211.96.87/v1/index_Cycle.php/gpsloc?lat=";
   strcpy(main,writeQuery);
   strcat(main,charLat);
   strcat(main,"&lng=");
   strcat(main, charLng);
   strcat(main,"&bk=1\"\r\n");

   Serial.write(main);
   
    //char * writeQuery = "AT+HTTPPARA=\"URL\",\"http://198.211.96.87/v1/index_Cycle.php/gpsloc?lat=29.64&lng=11.33&bk=1\"\r\n";
   GPRS.write(main);
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
    
  }

  
void setup() {
 
  pinMode(LED_BUILTIN, OUTPUT);//blink led for testing
  pinMode(lockPin, OUTPUT);
  pinMode(unlockPin, OUTPUT);
 
  // put your setup code here, to run once:
  GPRS.begin(9600);
  Serial.begin(9600);
 
   GPRS.write("AT\r\n");
   delay(200);
   
   GPRS.write("AT+HTTPINIT\r\n");
   delay(200);
 
   GPRS.write("AT+HTTPPARA=\"CID\",1\r\n");
   delay(500);
   
  
   
}
 
void loop() {
  // put your main code here, to run repeatedly:
   GSMinit();
  while(1){
   
  Serial.println("MASTER SANDWICH----------------------------------");
  count=0;
  bufferReaderCounter = 0;
 
  while(GPRS.available())
  {
    //Serial.println("Available --> ");
    //buffer[count++] = GPRS.read();
    //Serial.println(buffer[count-1]);
    if(GPRS.read() == '+'){
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
    //int i;
    //sscanf(p, "%d", &i);
    Serial.print("Found buffer array size:  ");
    //Serial.println(i);
    GPRS.flush();
    
    char * readContent = "AT+HTTPREAD=0,";
    strcat(p, "\r\n");
    strcat(readContent, p);
    Serial.print("Before write");
    GPRS.write(readContent);
    delay(500);
 
 
    char flag = 'f';
    while(flag == 'f' && !GPRS.available()){
     
    }
    flag = 't';
 
    char temp[20];
    char newTemp[33];
    int ntemp = 0;
    int itemp = 0;
    while(GPRS.available()){
      char rr = GPRS.read();
      if(rr >= 'a' && rr <= 'z'){
        newTemp[ntemp++] = rr;
      }
    }

   
    newTemp[ntemp] = '\0';
    temp[itemp] = '\0';
    bufferReader[bufferReaderCounter] = '\0';
 
   Serial.println("DEF");
    Serial.write(bufferReader,bufferReaderCounter);
    Serial.println("DEF");
    char* pch = strstr(bufferReader,"unlock"); // find "unlock" inside bufferReader
 
   
   
    if( strstr(bufferReader,"unlock") != NULL){
      Serial.println("Got unlock inside bufferedReader ");
      digitalWrite(LED_BUILTIN, HIGH);   // turn the LED on (HIGH is the voltage level)
      delay(1000);                       // wait for a second
      digitalWrite(LED_BUILTIN, LOW);    // turn the LED off by making the voltage LOW
      delay(1000);                       // wait for a second
    }
 
   Serial.println("ABCDEF");
   Serial.write(bufferReader,bufferReaderCounter);
   Serial.println("ABCDEF");
   Serial.println(temp);
   Serial.println("ABCDEF");
   if(temp[0] == 'u'){
    Serial.println("Unlock hoiseeeeeeee");
   }else if(temp[0] == 'l'){
    Serial.println("Lock hoiseeeeeeee");
   }else if(temp[0] == 'n'){
    Serial.println("No changed hoiseeeeeeee");
   }
   Serial.println("ABCDEF");
 
   Serial.println("SANDWICH");
   if(strcmp(temp, "unlock") == 0){
    Serial.println("Sandwiched unlock");
    digitalWrite(unlockPin, HIGH);  
    digitalWrite(lockPin, LOW);  
 
   }else if(strcmp(temp, "lock") == 0){
    Serial.println("Sandwiched lock");
 
    digitalWrite(unlockPin, LOW);  
    digitalWrite(lockPin, HIGH);  
 
   
   }else if(strcmp(temp, "nock") == 0){
    Serial.println("Sandwiched nock");
   }
   Serial.println("SANDWICH");
 
 
 
   
   Serial.println("EXTRA SANDWICH");
   Serial.write(newTemp, ntemp);
   if(strcmp(newTemp, "unlock") == 0){
    Serial.println("Sandwiched unlock");
    digitalWrite(unlockPin, HIGH);  
    digitalWrite(lockPin, LOW);  
    break;
 
   }else if(strcmp(newTemp, "lock") == 0){
    Serial.println("Sandwiched lock");
 
    digitalWrite(unlockPin, LOW);  
    digitalWrite(lockPin, HIGH);  
    break;
   
   }else if(strcmp(newTemp, "nock") == 0){
    Serial.println("Sandwiched nock");
    break;
   }
   Serial.println("EXTRA SANDWICH");
   
    Serial.println("-----T ");
    Serial.println("A----");
    //clearBufferReaderArray();
    //bufferReaderCounter = 0;
   
  }
  Serial.write(buffer , count);
//  Serial.println(i);
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
 
    Serial.println("MASTER SANDWICH END----------THE END :( --------------------------------");
  }
  
  delay(6000);
  resetFunc(); 
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
