hardware: hardware.o log.o porte.o processi.o stat.o
	gcc -g -o ../hardware hardware.o log.o porte.o processi.o stat.o

hardware.o: hardware.c log.h porte.h processi.h stat.h
	gcc -g -c hardware.c

log.o: log.c log.h
	gcc -g -c log.c

porte.o: porte.c log.h
	gcc -g -c porte.c

processi.o: processi.c log.h
	gcc -g -c processi.c

stat.o: stat.c log.h
	gcc -g -c stat.c