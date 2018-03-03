#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <ArduinoJson.h>

// WiFi Parameters
const char* ssid = "wustl-guest-2.0";
const char* password = "";

void setup() {
  Serial.begin(115200);
  WiFi.begin(ssid, password);
 
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting...");
  }
}

void loop() {
  // Check WiFi Status
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;  //Object of class HTTPClient
    http.begin("http://104.131.22.37/recipe.json");
    int httpCode = http.GET();
    //Check the returning code                                                                  
    if (httpCode > 0) {
      // Parsing
      const size_t bufferSize = 20000;
      DynamicJsonBuffer jsonBuffer(bufferSize);
      JsonObject& root = jsonBuffer.parseObject(http.getString());
      // Parameters
      int id = root["id"]; // 1
      const char* stepNo = root["Step Number"]; // "Leanne Graham"
      const char* ingredients = root["Ingredients"]; // "Bret"
      const char* steps = root["Steps"]; // "Sincere@april.biz"
      // Output to serial monitor
      Serial.print("Step Number:");
      Serial.println(stepNo);
      Serial.print("Ingredients:");
//      const char s = ingredients[0];
      Serial.println(ingredients);
      Serial.print("Steps:"); 
      Serial.println(steps);
//        Serial.println(http.getString());
    }
    http.end();   //Close connection
  }
  // Delay
  delay(60000);
}
