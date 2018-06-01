/*
 * LCD.h
 *
 * Created: 6/1/2018 1:39:39 PM
 *  Author: Awsaf
 */ 


#ifndef LCD_H_
#define LCD_H_

#include <avr/io.h>
//#define F_CPU 1600000UL
#include <util/delay.h>
#include <stdlib.h>


#define LCD_DATA PORTB
#define LCD_DATA_DIRECTION DDRB
#define LCD_CONTROL PORTD
#define LCD_CONTROL_DIRECTION DDRD
#define LCD_ENABLE 5
#define  LCD_REGISTER_SELECT 2
#define  LCD_READ_WRITE 7
#define  CLEAR_SCREEN 0x01

void CheckBusy();
void Show();
void SendCommand(unsigned char command);
void SendCharacter(unsigned char character);
void SendString(char* string);
void SendNumber(int num);
void SendDouble(double num);

void LCD_init(void)
{
    /* Replace with your application code */
 	LCD_CONTROL_DIRECTION |= 1 <<LCD_ENABLE | 1 << LCD_READ_WRITE | 1<< LCD_REGISTER_SELECT; 	
	_delay_ms(15);
		
	SendCommand(CLEAR_SCREEN); //Clear Screen 0x01 = 0b00000001
	_delay_ms(50);
	SendCommand(0x38);
	_delay_ms(50);
	SendCommand(0b00001111); //control display and cursor (blinking cursor) -> see datasheet
	_delay_ms(50);

	
}

void CheckBusy(){
	LCD_DATA_DIRECTION = 0;
	
	LCD_CONTROL |= 1<<LCD_READ_WRITE;
	LCD_CONTROL &= ~1 <<LCD_REGISTER_SELECT;
	
	while (LCD_DATA >= 0x80) //D7 Port B1 = 1 (0b1xxx0000 -> greater or equal 0x80)
	{
		Show();
	}
	
	LCD_DATA_DIRECTION = 0xFF;
}

void Show(){
	LCD_CONTROL |= 1<<LCD_ENABLE;
	asm volatile ("nop");
	asm volatile ("nop");
	LCD_CONTROL &= ~1 <<LCD_ENABLE;
}

void SendCommand(unsigned char command){
	CheckBusy();
	LCD_DATA = command;
	LCD_CONTROL &= ~ (1<< LCD_READ_WRITE | 1<<LCD_REGISTER_SELECT);
	Show();
	LCD_DATA = 0;
}

void SendCharacter(unsigned char character){
	CheckBusy(); // LCD ready to display info
	LCD_DATA = character;
	LCD_CONTROL &= ~ (1<< LCD_READ_WRITE);
	LCD_CONTROL |= 1<<LCD_REGISTER_SELECT;
	Show();
	LCD_DATA = 0;
}

void SendString(char *string){
	while(*string >0){
		SendCharacter(*string++);	
	}

}

void SendNumber(int num){
	char str[10];
	itoa(num , str ,10);
	SendString(str);
}

void SendDouble(double num){
	
}







#endif /* LCD_H_ */