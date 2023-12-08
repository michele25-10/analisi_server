#include <stdlib.h>
#include <stdio.h>
#include <time.h>
#include <unistd.h>

void log_result(char *str)
{
    FILE *fp = fopen("log.txt", "a+");
    if (!fp)
    {
        exit(-1);
    }

    time_t t;
    struct tm *current_time;
    t = time(NULL);
    current_time = localtime(&t);

    fseek(fp, 0, SEEK_END);
    fprintf(fp, "%02d-%02d-%d %02d:%02d:%02d |: %s\n",
            current_time->tm_mday,
            current_time->tm_mon + 1,
            current_time->tm_year + 1900,
            current_time->tm_hour,
            current_time->tm_min,
            current_time->tm_sec,
            str);

    fclose(fp);
}

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
    float temp;
    FILE *fp = fopen("/sys/class/thermal/thermal_zone0/temp", "r");
    if (!fp)
    {
        log_result("ERRORE apertura file: /sys/class/thermal/thermal_zone0/temp");
        return 0;
    }
    fscanf(fp, "%2.f", &temp);
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

void processi_pm2()
{
    char name[50];
    char status[20];

    FILE *pm2 = popen("pm2 list | awk '{if(NR>2) print $4, $18}'", "r");
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