#include <time.h>
#include <stdlib.h>
#include <stdio.h>

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