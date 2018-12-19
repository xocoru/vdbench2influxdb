# vdbench2influxdb
Simple script to upload vdbench results into Influxdb for Grafana visualisation

1. Install InfluxDB and create database for metrics upload:
```
# influx 
Visit https://enterprise.influxdata.com to register for updates, InfluxDB server management, and monitoring.
Connected to http://localhost:8086 version 1.1.1
InfluxDB shell version: 1.1.1
> create database G200;
``` 
2. Install Grafana and define influxdb datasource. 
3. Run vdbench with any options that you like. 
4. Pick ```flatfile.html``` from vdbench output directory.
5. Run ```php vdbench2influxdb.php flatfile.html sometag```  Use tag if you like to group data on Grafana graphs. 
6. Create or import Grafana dashboard. (For example ```grafana.json```, don't forgot change datasource)


PS: Sorry i am not a programmer at all ... so this PHP script could be mind blow. but it works. 
