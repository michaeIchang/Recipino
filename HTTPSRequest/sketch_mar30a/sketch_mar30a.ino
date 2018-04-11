/*****************************************
 * Include Libraries
 ****************************************/
#include <ESP8266WiFi.h>
#include <ConfigManager.h>
#include <PubSubClient.h>

/****************************************
 * Define Constants
 ****************************************/
 
namespace{
  const char * AP_NAME = "Ubidots Access Point"; // Assigns your Access Point name
  const char * MQTT_SERVER = "things.ubidots.com"; 
  const char * TOKEN = "A1E-CmKXjfNoC8qXseROBRoD2x1FuLQWBc"; // Assigns your Ubidots TOKEN
  const char * DEVICE_LABEL = "my-device"; // Assigns your Device Label
  const char * VARIABLE_LABEL = "my-variable"; // Assigns your Variable Label
  int SENSOR = A0;
}

char topic[150];
char payload[50];
String clientMac = "";
unsigned char mac[6];

struct Config {
  char name[20];
  bool enabled;
  int8 hour;
} config;

/****************************************
 * Initialize a global instance
 ****************************************/
WiFiClient espClient;
PubSubClient client(espClient);
ConfigManager configManager;


/****************************************
 * Auxiliar Functions
 ****************************************/

void callback(char* topic, byte* payload, unsigned int length){
  
}

void reconnect() {
  while (!client.connected()) {
    Serial.print("Attempting MQTT connection...");
    // Attempt to connect
    if (client.connect(clientMac.c_str(), TOKEN, NULL)) {
      Serial.println("connected");
      break;
      } else {
        configManager.reset();
        Serial.print("failed, rc=");
        Serial.print(client.state());
        Serial.println(" try again in 3 seconds");
        for(uint8_t Blink=0; Blink<=3; Blink++){
          digitalWrite(LED, LOW);
          delay(500);
          digitalWrite(LED, HIGH);
          delay(500);
        }
      }
  }
}

String macToStr(const uint8_t* mac) {
  String result;
  for (int i = 0; i < 6; ++i) {
    result += String(mac[i], 16);
    if (i < 5)result += ':';
  }
  return result;
}

/****************************************
 * Main Functions
 ****************************************/
void setup() {
  Serial.begin(115200);
  /* Declare PINs as input/outpu */
  pinMode(SENSOR, INPUT);
  pinMode(PIN_RESET, INPUT);
  pinMode(LED, OUTPUT);

  /* Assign WiFi MAC address as MQTT client name */
  WiFi.macAddress(mac);
  clientMac += macToStr(mac);

  /* Access Point configuration */
  configManager.setAPName(AP_NAME);
  configManager.addParameter("name", config.name, 20);
  configManager.addParameter("enabled", &config.enabled);
  configManager.addParameter("hour", &config.hour);
  configManager.begin(config);

  /* Set Sets the server details */
  client.setServer(MQTT_SERVER, 1883);
  client.setCallback(callback);
  
  /* Build the topic request */
  sprintf(topic, "%s%s", "/v1.6/devices/", DEVICE_LABEL);
}

void loop() {  
  configManager.reset();
  configManager.loop();    
  
  /* MQTT client reconnection */
  if (!client.connected()) {
      reconnect();
  }
  
  /* Sensor Reading */
  int value = analogRead(SENSOR);
  /* Build the payload request */
  sprintf(payload, "{\"%s\": %d}", VARIABLE_LABEL, value);
  /* Publish sensor value to Ubidots */ 
  client.publish(topic, payload);
  client.loop();
  delay(5000);
}
