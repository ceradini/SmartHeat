#include <DHT.h>
#include <ArduinoJson.h>

#define DHTTYPE DHT22
#define DHTPIN1 A1
#define DHTPIN2 A2
#define DHTPIN3 A3
#define DHTPIN4 A4
#define DHTPIN5 A5
#define DHTPIN6 2

#define DHTRELE 6

#define RELE1 7
#define RELE2 8
#define RELE3 9
#define RELE4 10
#define RELE5 11
#define RELE6 12

const int temp_capacity = JSON_OBJECT_SIZE(5);
StaticJsonDocument<temp_capacity> json_temp;

const int num_sensors = 6;
DHT *sensors = (DHT *)malloc(sizeof(DHT) * num_sensors);

const int num_rele = 6;
int *rele_ids = (int *)malloc(sizeof(int) * num_rele);

const int rele_status_capacity = JSON_OBJECT_SIZE(3);
StaticJsonDocument<rele_status_capacity> json_rele_status;

void setup()
{
  Serial.begin(9600);

  // setup sensors
  sensors[0] = DHT(DHTPIN1, DHTTYPE);
  sensors[1] = DHT(DHTPIN2, DHTTYPE);
  sensors[2] = DHT(DHTPIN3, DHTTYPE);
  sensors[3] = DHT(DHTPIN4, DHTTYPE);
  sensors[4] = DHT(DHTPIN5, DHTTYPE);
  sensors[5] = DHT(DHTPIN6, DHTTYPE);

  // setup sensors
  for (int i = 0; i < num_sensors; i++)
  {
    sensors[i].begin();
  }

  // setup rele for sensors alimentation
  pinMode(DHTPIN1, INPUT);
  pinMode(DHTPIN2, INPUT);
  pinMode(DHTPIN3, INPUT);
  pinMode(DHTPIN4, INPUT);
  pinMode(DHTPIN5, INPUT);
  pinMode(DHTRELE, OUTPUT);

  // setup rele pin ids
  rele_ids[0] = 7;
  rele_ids[1] = 8;
  rele_ids[2] = 9;
  rele_ids[3] = 10;
  rele_ids[4] = 11;
  rele_ids[5] = 12;

  digitalWrite(DHTRELE, HIGH);

  // setup pin rele
  pinMode(RELE1, OUTPUT);
  pinMode(RELE2, OUTPUT);
  pinMode(RELE3, OUTPUT);
  pinMode(RELE4, OUTPUT);
  pinMode(RELE5, OUTPUT);
  pinMode(RELE6, OUTPUT);

  // resetting the status of all rele to OFF
  digitalWrite(RELE1, HIGH);
  digitalWrite(RELE2, HIGH);
  digitalWrite(RELE3, HIGH);
  digitalWrite(RELE4, HIGH);
  digitalWrite(RELE5, HIGH);
  digitalWrite(RELE6, HIGH);

  delay(2500); //Wait before accessing Sensor
}

void loop()
{
  bool send_data_temp = false;
  bool send_data_rele = false;

  // check for commands
  if (Serial.available() > 0)
  {
    String data = Serial.readStringUntil('\n');

    StaticJsonDocument<200> doc;

    DeserializationError err = deserializeJson(doc, data);

    if (!err)
    {
      String type = doc["type"];

      // rele command
      if (type == "rele_management")
      {
        int id = (int)doc["id"];
        uint8_t mode;

        if (doc["status"] == 1)
        {
          mode = LOW;
        }
        else
        {
          mode = HIGH;
        }

        switch (id)
        {
        case 1:
          digitalWrite(RELE1, mode);
          break;
        case 2:
          digitalWrite(RELE2, mode);
          break;
        case 3:
          digitalWrite(RELE3, mode);
          break;
        case 4:
          digitalWrite(RELE4, mode);
          break;
        case 5:
          digitalWrite(RELE5, mode);
          break;
        case 6:
          digitalWrite(RELE6, mode);
          break;
        }
      }
      else if (type == "send_data_temp")
      {
        send_data_temp = true;
      }
      else if (type == "send_data_rele")
      {
        send_data_rele = true;
      }
    }
  }

  if (send_data_temp)
  {
    // turn on the sensors alimentation and wait 3 seconds before reading
    digitalWrite(DHTRELE, LOW);

    delay(3000);

    // read and send temperature measures
    for (int i = 0; i < num_sensors; i++)
    {
      float t = sensors[i].readTemperature();
      float h = sensors[i].readHumidity();

      if (!isnan(t) && !isnan(h))
      {
        float hic = sensors[i].computeHeatIndex(t, h, false);

        json_temp["type"] = "temp_read";
        json_temp["room"] = i + 1;
        json_temp["t"] = t;
        json_temp["h"] = h;
        json_temp["hi"] = hic;

        String output = "";
        serializeJson(json_temp, output);
        Serial.println(output);
      }
      else
      {
        json_temp["type"] = "temp_read_wrong";
        json_temp["room"] = i + 1;
        json_temp["t"] = t;
        json_temp["h"] = h;

        String output = "";
        serializeJson(json_temp, output);
        Serial.println(output);
      }
    }

    //turn off the sensors alimentation
    digitalWrite(DHTRELE, HIGH);
  }

  if (send_data_rele)
  {
    // send to the server the current status of rele
    for (int i = 0; i < num_rele; i++)
    {
      json_rele_status["type"] = "rele_status";
      json_rele_status["room"] = i + 1;
      json_rele_status["status"] = digitalRead(rele_ids[i]);

      String output = "";
      serializeJson(json_rele_status, output);
      Serial.println(output);
      delay(75);
    }
  }
}
