#include<SPI.h> 

int slaveSelect = 2;

int delayTime = 500;

void setup() {
  pinMode(slaveSelect, OUTPUT);
  SPI.begin();
  SPI.setBitOrder(LSBFIRST);   
}

void loop() {
  for (int i; i < 256; i++)        //For loop to set data = 0 then increase it by one for every iteration of the loop, when the counter reaches the condition (256) it will be reset
  {
    digitalWrite(slaveSelect, LOW);            //Write our Slave select low to enable the SHift register to begin listening for data
    SPI.transfer(i);                     //Transfer the 8-bit value of data to shift register, remembering that the least significant bit goes first
    digitalWrite(slaveSelect, HIGH);           //Once the transfer is complete, set the latch back to high to stop the shift register listening for data
    delay(delayTime);                             //Delay
  }
}
