#ifndef SERVO_H_
#define SERVO_H_
unsigned char TCCR1AVal ;
unsigned char TCCR1BVal ;
unsigned char ICR1Val;


void moveClockWise(){
	OCR1A = ICR1 - 1400; // CLockwise control
}


void moveAntiClockWise(){
	OCR1A = ICR1 - 4400; // Anti-clockwise control
}

void _resetServo(){
	TCCR1A = TCCR1AVal;
	TCCR1B = TCCR1BVal;
	ICR1 = ICR1Val;
}

void _setServo(){
	TCCR1A |= 1 << WGM11 | 1 << COM1A1 | 1 << COM1A0;
	TCCR1B |= 1<<WGM12 | 1<<WGM13 | 1<<CS10;
	ICR1 = 19999;
}

void debugClockWise(){
	_setServo();
	moveClockWise();
	_delay_ms(250);
	_resetServo();
}

void ServoInit(){
	TCCR1AVal = TCCR1A;
	TCCR1BVal = TCCR1B;
	ICR1Val = ICR1;
}

void debugAntiClockWise(){
	_setServo();
	moveAntiClockWise();
	_delay_ms(250);
	_resetServo();
}

#endif /* SERVO_H_ */