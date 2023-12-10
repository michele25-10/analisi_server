#include <stdlib.h>
#include <stdio.h>
#include "log.h"

void porte_ascolto()
{
    char address[21];
    FILE *fp = popen("netstat -tuln | grep LISTEN | awk '{print $4}'", "r");
    if (!fp)
    {
        log_result("ERRORE esecuzione seguente comando: \"netstat -tuln | grep LISTEN | awk '{print $4}'\"");
        exit(-1);
    }
    FILE *porte = fopen("porte_attive.txt", "w");
    if (!porte)
    {
        log_result("ERRORE apertura file: porte_attive.txt");
        exit(-1);
    }
    while (fscanf(fp, "%s ", address) > 0)
    {
        fprintf(porte, "%s\n", address);
    }
    fclose(fp);
    fclose(porte);
}