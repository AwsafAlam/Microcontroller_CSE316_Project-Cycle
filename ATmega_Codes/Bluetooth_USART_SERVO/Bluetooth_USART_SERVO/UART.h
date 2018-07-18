#ifndef UART_H_
#define UART_H_

#define BAUD_PRESCALE ((F_CPU / (BAUDRATE * 16UL)) - 1)   /* Define prescale value */

void UART_init(unsigned long BAUDRATE){
	
	//Double Speed
	UCSRA = 0x02 ;
	
	
	//Polling
	/*
	UCSRB |= (1 << RXEN) | (1 << TXEN);              // Enable USART transmitter and receiver and Interrupt 
	UCSRB |= (1 << RXEN) | (1 << TXEN) ;              // Enable USART transmitter and receiver 
	UCSRC |= (1 << URSEL)| (1 << UCSZ0) | (1 << UCSZ1); // Write USCRC for 8 bit data and 1 stop bit 
	UBRRL = BAUD_PRESCALE;                          // Load UBRRL with lower 8 bit of prescale value 
	UBRRH = (BAUD_PRESCALE >> 8);                   // Load UBRRH with upper 8 bit of prescale value 
	*/
	
	//Interrupt
	/*
	UCSRB |= (1 << RXEN) | (1 << TXEN) | (1 << RXCIE);              // Enable USART transmitter and receiver and Interrupt 
	UCSRB |= (1 << RXEN) | (1 << TXEN) ;              // Enable USART transmitter and receiver 
	UCSRC |= (1 << URSEL)| (1 << UCSZ0) | (1 << UCSZ1); // Write USCRC for 8 bit data and 1 stop bit 
	UBRRL = BAUD_PRESCALE;                          // Load UBRRL with lower 8 bit of prescale value 
	UBRRH = (BAUD_PRESCALE >> 8);                   // Load UBRRH with upper 8 bit of prescale value 
	*/
	
	UCSRB |= (1 << RXEN) | (1 << TXEN) | (1 << RXCIE);
	UCSRC |= (1 << URSEL)| (1 << UCSZ0) | (1 << UCSZ1);
	
	UBRRL = 12 ;
	UBRRH = 0 ;
}

void UART_send(unsigned char data){
	while((UCSRA&(1<<UDRE))==0) ;
	UDR = data ;
}


char USART_RxChar()                                 /* Data receiving function */
{
	while (!(UCSRA & (1 << RXC)));                  /* Wait until new data receive */
	return(UDR);                                    /* Get and return received data */
}

void USART_TxChar(char data)                        /* Data transmitting function */
{
	UDR = data;                                     /* Write data to be transmitting in UDR */
	while (!(UCSRA & (1<<UDRE)));                   /* Wait until data transmit and buffer get empty */
}

#endif /* UART_H_ */