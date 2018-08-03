#define F_CPU 1000000UL
#include <avr/io.h>
#include <string.h>
#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>
#include <util/delay.h>
#include <avr/interrupt.h>
#include "Servo.h"
#include "UART.h"

int main(void)
{

	DDRA = 0x0F;
	DDRD = 0XFF;
	PORTA = 0xFF;
	
	ServoInit();
	UART_init(9600);
	
	sei();
	
	while (1)
	{
		
	}
	
}


ISR (USART_RXC_vect)
{
	uint8_t oldsrg = SREG;
	
	cli();
	char data = UDR;
	PORTA = 0xF0;
	
	if(data=='1'){ //unlock
		PORTA |= (1<<PORTA0);
		debugClockWise();
		UART_send(data) ;
	}
	else if(data=='0'){ //lock
		PORTA |= (1<<PORTA1);
		debugAntiClockWise();
		UART_send(data) ;
	}
	else{
		PORTA |= (1<<PORTA2);
		UART_send(data) ;
	}
	
	SREG = oldsrg;
}
