#ifndef F_CPU
#define F_CPU 8000000UL // 1 MHz clock speed
#endif


#include <avr/io.h>
#include <util/delay.h>




int main(void)
{
	DDRD = 0XFF;
	TCCR1A |= 1 << WGM11 | 1 << COM1A1 | 1 << COM1A0;
	TCCR1B |= 1<<WGM12 | 1<<WGM13 | 1<<CS10;
	ICR1 = 19999;

	

	while(1){
		OCR1A = ICR1 - 500; // CLockwise control
		_delay_ms(100);
		OCR1A = ICR1 - 2200; // Anti-clockwise control
		_delay_ms(100);
	}
	
}