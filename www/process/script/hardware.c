#include <stdlib.h>
#include <stdio.h>
#include <unistd.h>
#include "stat.h"
#include "log.h"
#include "porte.h"
#include "processi.h"

int main()
{
    log_result("AVVIO ESEGUIBILE");

    float cpu;
    char GB_usati[6];
    char GB_liberi[6];
    float temp;

    while (1)
    {
        cpu = CPU_uso();
        temp = CPU_temp();
        spazio_disco(GB_usati, GB_liberi);
        FILE *fp = fopen("stat.json", "w");
        fprintf(fp, "{\n\t\"cpu\": %2.f,\n\t\"temp_cpu\": %2.f,\n\t\"GB_usati\": \"%sB\",\n\t\"GB_liberi\": \"%sB\"\n}", cpu, temp, GB_usati, GB_liberi);
        fclose(fp);

        processi_pm2();

        porte_ascolto();

        log_result("Aggiornati file");

        sleep(30);
    }

    return 0;
}