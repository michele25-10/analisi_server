#include <stdio.h>
#include <stdlib.h>
#include "log.h"

float CPU_uso()
{
    FILE *fp = fopen("/proc/stat", "r");
    if (!fp)
    {
        log_result("ERRORE apertura file: /proc/stat");
        exit(-1);
    }

    unsigned long long int user, nice, system, idle, total;
    fscanf(fp, "cpu %llu %llu %llu %llu", &user, &nice, &system, &idle);
    fclose(fp);

    total = user + nice + system + idle;
    return ((float)(total - idle) / total) * 100.0;
}

float CPU_temp()
{
    int temp;
    FILE *fp = fopen("/sys/class/thermal/thermal_zone0/temp", "r");
    if (!fp)
    {
        log_result("ERRORE apertura file: /sys/class/thermal/thermal_zone0/temp");
        return 0;
    }
    fscanf(fp, "%d", &temp);
    fclose(fp);

    return (float)temp / 1000.0;
}

void spazio_disco(char *GB_usati, char *GB_liberi)
{
    FILE *fp = popen("df -h | awk '/\\/$/ {print $3, $4}'", "r");
    if (!fp)
    {
        log_result("ERRORE esecuzione seguente comando: \"df -h | awk '/\\/$/ {print $3, $4}'\"");
        exit(-1);
    }
    fscanf(fp, "%s %s", GB_usati, GB_liberi);
    fclose(fp);
}