#include <stdlib.h>
#include <stdio.h>
#include "log.h"

void processi_pm2()
{
    char name[50];
    char status[20];

    FILE *pm2 = popen("pm2 list | awk '{if(NR>3) print $4, $18}'", "r");
    if (!pm2)
    {
        log_result("ERRORE esecuzione seguente comando: \"pm2 list | awk '{if(NR>2) print $4, $18}'\"");
        exit(-1);
    }

    FILE *processi = fopen("processi_pm2.json", "w");
    if (!processi)
    {
        log_result("ERRORE apertura file: processi_pm2.json");
        exit(-1);
    }

    fprintf(processi, "{\n");
    int count = 0;
    while (fscanf(pm2, "%s %s", name, status) > 0)
    {
        if (count == 0)
        {
            fprintf(processi, "\t\"%s\": \"%s\"", name, status);
        }
        else
        {
            fprintf(processi, ",\n\t\"%s\": \"%s\"\n", name, status);
        }
        count++;
    }
    fprintf(processi, "}");

    fclose(processi);
    fclose(pm2);
}