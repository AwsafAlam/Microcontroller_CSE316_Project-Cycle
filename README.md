# Project Cycle

## Project Name
Cycle | A  GPS based ride sharing system

---

### project Idea

[Here is a short demonstration of the project](https://youtu.be/ENsszsuazMk)

This project is a part of our Microcontroller course CSE 316.

The idea is Simple. There will be a shared bicycle, which will be kept on the streets. Any user who has the cycle app installed, can scan the QR code on the bicycle. The QR code will be verified in the server, and will unlock the bicycle. The user can then start using the bike. A meter will be started on the app, which will show the time used, and the distance covered. 

After the ride is over, user can end the ride from his app. This will lock the bicycle again, and the user will be charged accordingly. He can then leave the bicycle an go!

------

### Motivation 

Traffic congestion and pollution is two major problems in Bangladesh. In order to solve this two problems and help people  travel in faster, easier & economic way we have developed a GPS based bi-cycle sharing system. User needs to open an account in the app which will show him nearby bi-cycles. Then he just needs to unlock the bicycle & use it as per his need. He will be charged according to  the amount of time he  used the cycle and distance he traveled. In order to prevent thieves from stealing the cycle, latitude , longitude information is sent to the server every 10 seconds.  

--------

### Project Overview ( In brief )

Air pollution is a major problem in urban areas. Much of it is contributed by traffic. Traffic Jam is very common in our city, and is increasing everyday. Our project helps tackle these two major problems headon.

- Motivation: Conventional forms of transport such as cars and buses are the main cause of traffic jams in the city. Moreover, these transports cause air pollution which harms our lives. According to a World Bank report, in the last 10 years, the average traffic speed in Dhaka has dropped from 21 kilometres per hour (kmph) to 7 kmph, and by 2035, the speed might drop to 4kmph, which is slower than the walking speed. Another study, commissioned by Brac Institute of Government and Development, says traffic congestion in Dhaka eats up around 5 million working hours every day and costs the country USD 11.4 billion every year. The financial loss is a calculation of the cost of time lost in traffic congestion and the money spent on operating vehicles for the extra hours. The ministry of Environment and Forests thinks if pollution can be reduced by 20 percent, at least 1,200 to 3,500 lives can be saved and 80 to 230 million cases of respiratory diseases can be averted each year. If air pollution is reduced by 20 percent, it would also save $170 to 500 million in healthcare costs and save time of city dwellers which in turn will increase the productivity of them. [Ref: www.case-moef.gov.bd] .Therefore our project : CYCLE provides a much needed alternative to these problems. It is a cheap and pollution free form of transport, and will help reduce traffic jams in the city.

- Proposed Solution: Our proposed solution is  a GPS based bicycle sharing system. User needs to open an account in the app which will show him nearby bicycles. Once he gets near a bicycle he uses the app to unlock it, and use it as per his need. He will be charged according to the amount of time he used the cycle and distance he traveled. In order to prevent thieves from stealing the cycle, latitude , longitude information of the bicycle is constantly updated in the server , and a lock placed in the bicycle can only be opened by the app. Our project involves developing a low cost locking mechanism compatible with the app, and can be tracked through GPS. The bike owners can easily attach to their bikes, and leave them for other people on the platform to use. This solution is much effective since it will save journey time for short distance 


-----------------

### Required Hardwares

Sensors Used:

HC-05 Bluetooth Module
GPS NEO 6M
GSM SIM 800A
    
Actuator Used:

S90 Servo Motor

Others:

- ATMega-32
- Arduino UNO

-----------------

### Required Softwares

The app was developed completely in Android studio.
Firmware code, for builtin GPS, and locking mechanism was developed in Atmel Studio

-----------------

### Contributor

- Md Awsaf Alam Anindya
- Farhan Tanvir Utshaw

------

### Supervisor 

Abdus Salam Azad 
Asst. Prof, CSE, BUET  

T. M. Tariq Adnan 
Lecturer, CSE, BUET

Ahamed Al Nahian 
Lecturer,CSE,BUET

-----------------
