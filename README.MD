# **Volt vs Twig performance**

### How to use it?

in public file you can run application via:

`php -S 127.0.0.1:8080`

and then

`http://localhost:8080/?test=1`


Now you cat run the test

`ab -C 200 -n 10000 http://localhost:8080/?test=TEST_NUMBER`

### Results

The table below shows the results of the 10 different iterations for each of test. All test were made on my local laptop:

`
Ubuntu 18.04
PHP 7.2.24
8 CPU
16 G Ram
`


| Test | Volt (req/sec)                                | Twig (req/sec)                             | Volt median (req/sec) | Twig median (req/sec) |
|------|-----------------------------------------------|--------------------------------------------|----------|-----|
|1     |834 1118 1076 928 1082 1094 1163 914 1094 1085 | 720	829	840	846	656	670	769	745	802	803 | **1083** | 785 |
|2     |917	1082 1083 1093 1092	962	1042 820 1018 1095 | 387	391	375	376	385	375	375	373	314	337 | **1062** | 375 |
|3     |359	336	404	402	403	403	354	358	356	387        | 363	361	361	286	299	359	347	366	369	377 | **373**  | 361 |
|4     |406	403	350	404	369	387	382	399	403	396        | 338	354	363	340	320	369	314	370	305	315 | **397**  | 339 |