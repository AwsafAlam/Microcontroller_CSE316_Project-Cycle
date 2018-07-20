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

ADC_start(){
	ADCSRA |= 1<<ADSC;
}

ADC_int(){
	//Configure ADC
	//Enable interrupts function in ADC
	//8-bit or 10-bit
	// 1 000 000 / 50 000 = 20  1000 000 / 20 000 = 5
	ADCSRA |= 1<<ADPS2;
	ADMUX |= 1<< ADLAR;
	ADMUX |= 1<<REFS0; //Setting Reference voltage
	ADCSRA |= 1<<ADIE;
	ADCSRA |= 1<<ADEN;


}

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

ISR(ADC_vect){
	
	float a = ((ADCH-7)/255.0)*5.0;
	ADC_start();	
}


ISR (USART_RXC_vect)
{
	uint8_t oldsrg = SREG;
	
	cli();
	char data = UDR;
	PORTA = 0xF0;
	
	if(data=='1'){
		PORTA |= (1<<PORTA0);
		debugClockWise();
		UART_send(data) ;
	}
	else if(data=='0'){
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
