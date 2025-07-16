#include <DHT.h>
#include "DHT.h"

#define DHTPIN1 A0 
#define DHTPIN2 A1
#define DHTPIN3 A2
#define DHTPIN3 A3
#define DHTTYPE DHT22


DHT dht1(DHTPIN1, DHTTYPE);
DHT dht2(DHTPIN2, DHTTYPE);
DHT dht3(DHTPIN3, DHTTYPE);
DHT dht4(DHTPIN3, DHTTYPE);

void setup(){ 
  Serial.begin(9600);
  delay(500);//Delay to let system boot
  Serial.println("DHT11 Humidity & temperature Sensor\n\n");
  delay(1000);//Wait before accessing Sensor
}
 
void loop(){
  int t1 = dht1.readTemperature(); // temp.
  int h1 = dht1.readHumidity(); // hum.
  float hic1 = dht1.computeHeatIndex(t1, h1, false); // heat-index (temp. perceived)
  int t2 = dht2.readTemperature();
  int h2 = dht2.readHumidity();
  int t3 = dht3.readTemperature();
  int h3 = dht3.readHumidity();
  int t4 = dht4.readTemperature();
  int h4 = dht4.readHumidity();

  if (isnan(t1) || isnan(h1)) {
    Serial.println("ERROR IN THE TENSOR");
  }

  Serial.println((float)t1, 2);
  Serial.println((float)h1, 2);
  Serial.println(hic1, 2);
  Serial.println((float)t2, 2);
  Serial.println((float)h2, 2);
  Serial.println((float)t3, 2);
  Serial.println((float)h3, 2);
  Serial.println((float)t4, 2);
  Serial.println((float)h4, 2);
  Serial.println("\n");

  delay(5000); 
}
