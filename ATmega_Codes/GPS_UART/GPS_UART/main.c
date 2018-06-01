#define F_CPU 8000000UL
#define SREG    _SFR_IO8(0x3f)

#include <avr/io.h>
#include <string.h>
#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>
#include <util/delay.h>
#include <avr/interrupt.h>
#include "LCD.h"
#include "USART.h"

void convert_time_to_UTC();
void convert_to_degrees(char *);

#define Buffer_Size 150
#define degrees_buffer_size 20

int LCD_pos = 0;

char Latitude_Buffer[15],Longitude_Buffer[15],Time_Buffer[15],Altitude_Buffer[8];
char degrees_buffer[degrees_buffer_size];                      /* save latitude or longitude in degree */
char GGA_Buffer[Buffer_Size];                                  /* save GGA string */
uint8_t GGA_Pointers[20];                                      /* to store instances of ',' */
char GGA_CODE[3];

volatile uint16_t GGA_Index, CommaCounter;

bool	IsItGGAString	= false,
		flag1			= false,
		flag2			= false;


void get_gpstime(){
	cli();
	uint8_t time_index=0;
	/* parse Time in GGA string stored in buffer */
	for(uint8_t index = 0;GGA_Buffer[index]!=','; index++){
		
		Time_Buffer[time_index] = GGA_Buffer[index];
		time_index++;
	}
	convert_time_to_UTC();
	sei();
}

void get_latitude(uint16_t lat_pointer){
	cli();
	uint8_t lat_index;
	uint8_t index = lat_pointer+1;
	lat_index=0;
	
	/* parse Latitude in GGA string stored in buffer */
	for(;GGA_Buffer[index]!=',';index++){
		Latitude_Buffer[lat_index]= GGA_Buffer[index];
		lat_index++;
	}
	
	Latitude_Buffer[lat_index++] = GGA_Buffer[index++];
	Latitude_Buffer[lat_index]= GGA_Buffer[index];		/* get direction */
	convert_to_degrees(Latitude_Buffer);
	sei();
}

void get_longitude(uint16_t long_pointer){
	cli();
	uint8_t long_index;
	uint8_t index = long_pointer+1;
	long_index=0;
	
	/* parse Longitude in GGA string stored in buffer */
	for( ; GGA_Buffer[index]!=','; index++){
		Longitude_Buffer[long_index]= GGA_Buffer[index];
		long_index++;
	}
	
	Longitude_Buffer[long_index++] = GGA_Buffer[index++];
	Longitude_Buffer[long_index]   = GGA_Buffer[index]; /* get direction */
	convert_to_degrees(Longitude_Buffer);
	sei();
}

void get_altitude(uint16_t alt_pointer){
	cli();
	uint8_t alt_index;
	uint8_t index = alt_pointer+1;
	alt_index=0;
	/* parse Altitude in GGA string stored in buffer */
	for( ; GGA_Buffer[index]!=','; index++){
		Altitude_Buffer[alt_index]= GGA_Buffer[index];
		alt_index++;
	}
	
	Altitude_Buffer[alt_index]   = GGA_Buffer[index+1];
	sei();
}
void convert_time_to_UTC()
{
	unsigned int hour, min, sec;
	uint32_t Time_value;
		
	Time_value = atol(Time_Buffer);               /* convert string to integer */
	hour = (Time_value / 10000);                  /* extract hour from integer */
	min = (Time_value % 10000) / 100;             /* extract minute from integer */
	sec = (Time_value % 10000) % 100;             /* extract second from integer*/

	sprintf(Time_Buffer, "%d:%d:%d", hour,min,sec);
	
}

void convert_to_degrees(char *raw){
	
	double value;
	float decimal_value,temp;
	
	int32_t degrees;
	
	float position;
	value = atof(raw);                             /* convert string into float for conversion */
	
	/* convert raw latitude/longitude into degree format */
	decimal_value = (value/100);
	degrees = (int)(decimal_value);
	temp = (decimal_value - (int)decimal_value)/0.6; 
	position = (float)degrees + temp;
	
	dtostrf(position, 6, 4, degrees_buffer);       /* convert float value into string */	
}

int main() {
    GGA_Index=0;
	memset(GGA_Buffer, 0, Buffer_Size);
	memset(degrees_buffer,0,degrees_buffer_size);
	
    LCD_init();                      /* initialize LCD16x2 */
    _delay_ms(3000);                 /* wait for GPS receiver to initialize */
    SendCommand(CLEAR_SCREEN);
    SendCommand(0x80);

    SendCharacter('$');
    _delay_ms(200);
    SendCommand(CLEAR_SCREEN);
    SendCommand(0x80);
    
	USART_Init(9600);                /* initialize USART with 9600 baud rate */
	sei();
	
    while (1)
    {
			//_delay_ms(1000);
			//LCD_String_xy(1,0,"UTC Time: ");
		//	get_gpstime();                         /* Extract Time in UTC */
//			SendString(Time_Buffer);
	//		SendString(" - ");
			
			//LCD_String_xy(2,0,"Lat: ");
			SendString("Lat: ");
			//get_latitude(GGA_Pointers[0]);         /* Extract Latitude */
		//	SendString(degrees_buffer);            /* display latitude in degree */
			//memset(degrees_buffer,0,degrees_buffer_size);
			
			//LCD_String_xy(3,0,"Long: ");
			//get_longitude(GGA_Pointers[2]);        /* Extract Longitude */
			//SendString(degrees_buffer);            /* display longitude in degree */
			//memset(degrees_buffer,0,degrees_buffer_size);
			
			//LCD_String_xy(4,0,"Alt: ");
			//get_altitude(GGA_Pointers[7]);         /* Extract Altitude in meters*/
			//SendString(Altitude_Buffer);
			
	}
		return 0;
}


	
ISR (USART_RXC_vect)
{
	uint8_t oldsrg = SREG;
	cli();
	char received_char = USART_RxChar();
	SendCommand(0x80 + LCD_pos);
	SendCharacter(received_char);
	LCD_pos ++;
	
	if(LCD_pos == 15){
		LCD_pos = 64;
	//	_delay_ms(500);
	}
	else if(LCD_pos == 79){
		LCD_pos = 0;
		//_delay_ms(1000);
		SendCommand(CLEAR_SCREEN);
		SendCommand(0x80);
	}
	
	
	if(received_char =='$'){
		SendCommand(0x80);
		SendString("Got Dollar");  
		SendCommand(0x80 + LCD_pos);
		SendCharacter(received_char);
		LCD_pos ++;
		
		GGA_Index = 0;
		CommaCounter = 0;
		IsItGGAString = false;
	}
	else if(IsItGGAString == true){                                             /* if true save GGA info. into buffer */
		if(received_char == ',' ) GGA_Pointers[CommaCounter++] = GGA_Index;     /* store instances of ',' in buffer */
		GGA_Buffer[GGA_Index++] = received_char;
	}
	else if(GGA_CODE[0] == 'G' && GGA_CODE[1] == 'G' && GGA_CODE[2] == 'A'){    /* check for GGA string */
		SendCommand(0x80);
		SendString(" KISU HOISEE ");
		
		IsItGGAString = true;
		GGA_CODE[0] = 0; GGA_CODE[1] = 0; GGA_CODE[2] = 0;
	}
	else{
		GGA_CODE[0] = GGA_CODE[1];  GGA_CODE[1] = GGA_CODE[2]; GGA_CODE[2] = received_char; 
	}
	SREG = oldsrg;
}
