/*********************************************************************************************************
  File                : Arduino-epd
  Hardware Environment:
  Build Environment   : Arduino
  Version             : V1.6.1
  By                  : WaveShare
                                   (c) Copyright 2005-2015, WaveShare
                                        http://www.waveshare.net
                                        http://www.waveshare.com
                                           All Rights Reserved
*********************************************************************************************************/
#include <epd.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <ArduinoJson.h>
#include <DNSServer.h>            //Local DNS Server used for redirecting all requests to the configuration portal
#include <ESP8266WebServer.h>     //Local WebServer used to serve the configuration portal
#include <WiFiManager.h>          //https://github.com/tzapu/WiFiManager WiFi Configuration Magic

//const int led = 13;                           //user led
const char* ssid = "";
const char* password = "";
int currPage = 0;
int numPages;
String content = "";
const int leftButtonPin = D5; 
const int rightButtonPin = D6; 


/*******************************************************************************
  Function Name  : void base_draw(void)
  Description    :
  Input          : None
  Output         : None
  Return         : None
*******************************************************************************/

void draw_page(void)
{
//  char buff[] = {'G', 'B', 'K', '3', '2', ':', ' ', 0xc4, 0xe3, 0xba, 0xc3, 0xca, 0xc0, 0xbd, 0xe7, 0};
//  epd_set_color(BLACK, WHITE);
//  epd_clear();

  if (WiFi.status() == WL_CONNECTED) {
    char buff[] = {'G', 'B', 'K', '3', '2', ':', ' ', 0xc4, 0xe3, 0xba, 0xc3, 0xca, 0xc0, 0xbd, 0xe7, 0};
    epd_set_color(BLACK, WHITE);
    epd_clear();
//    Serial.print("HERE");
    epd_set_ch_font(GBK48);
    epd_set_en_font(ASCII48);
    buff[3] = '6';
    buff[4] = '4';

    HTTPClient http;  //Object of class HTTPClient
    http.begin("http://104.131.22.37/recipe.json");
    int httpCode = http.GET();
    //Check the returning code
    if (httpCode > 0) {
      // Parsing
//      char json[] = "{\"Pages\":[0:[\"Chocolate\"],1: [\"Chip\"],2: [\"Cookies\"]]}";
//      StaticJsonBuffer<200> jsonBuffer;
//      JsonObject& root = jsonBuffer.parseObject(json);
      const size_t bufferSize = 20000;
      DynamicJsonBuffer jsonBuffer(bufferSize);
      JsonObject& root = jsonBuffer.parseObject(http.getString());
      //keep track of number of pages
      numPages = root["Pages"].size();
      for (int j = 0; j < root["Pages"][currPage].size(); ++j) {
        const char* ingredient = root["Pages"][currPage][j];
        epd_disp_string(ingredient, 0, 48 * j);
      }
    }
    http.end();   //Close connection
  }
  epd_udpate();
}

void setup(void)
{
  /*
    user led init
  */
//  pinMode(led, OUTPUT);
//  digitalWrite(led, LOW);
  
  pinMode(leftButtonPin, INPUT_PULLUP);
  pinMode(rightButtonPin, INPUT_PULLUP);

  epd_init();
  epd_wakeup();
  epd_set_memory(MEM_NAND);

  Serial.begin(115200);

//  WiFi.disconnect();
  WiFiManager wifiManager;
  wifiManager.autoConnect("Recipino");
//  WiFi.begin(ssid, password);

//  while (WiFi.status() != WL_CONNECTED) {
//    delay(1000);
//    Serial.println("Connecting...");
//  }

//  WiFi.macAddress(mac);
//  clientMac += macToStr(mac);

  /* Access Point configuration */
//  configManager.setAPName(AP_NAME);
//  configManager.addParameter("name", config.name, 20);
//  configManager.addParameter("enabled", &config.enabled);
//  configManager.addParameter("hour", &config.hour);
//  configManager.begin(config);

  /* Set Sets the server details */
//  client.setServer(MQTT_SERVER, 1883);
//  client.setCallback(callback);
  
  /* Build the topic request */
//  sprintf(topic, "%s%s", "/v1.6/devices/", DEVICE_LABEL);


}

void loop(void)
{
//  configManager.reset();
//  configManager.loop();    
  
  /* MQTT client reconnection */
//  if (!client.connected()) {
//      reconnect();
//  }
  
  /* Sensor Reading */
//  int value = analogRead(SENSOR);
  /* Build the payload request */
//  sprintf(payload, "{\"%s\": %d}", VARIABLE_LABEL, value);
  /* Publish sensor value to Ubidots */ 
//  client.publish(topic, payload);
//  client.loop();
//  delay(5000);

  
  //MC
  //IDK what this flag is for
//  char flag = 0;

  /*
    Draw text demo
  */
  
  draw_page();
//int leftButtonState = digitalRead(leftButtonPin);
//int rightButtonState = digitalRead(rightButtonPin);
//Serial.println("Left:" + leftButtonState);
//Serial.println("Right:" + rightButtonState);
//  delay(5000);
//  epd_enter_stopmode();
//  Serial.println(currPage);

  while (1)
  {
    int leftButtonState = digitalRead(leftButtonPin);
    int rightButtonState = digitalRead(rightButtonPin);
    if (leftButtonState == HIGH)
    {
//      digitalWrite(leftButtonPin, LOW);
//      Serial.println("LLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTT");
      delay(150);
      if (currPage > 0) {
        --currPage;
        break;
      }
    }
    else if (rightButtonState == HIGH) {
//      digitalWrite(rightButtonPin, LOW);
//      Serial.println("RRRRRRRRRRRRRRRRIIIIIIIIIIIIIIIIIIIIIIIIIIIIGGGGGGGGGGGGGGGGGGGGGGGGGGGGHHHHHHHHHHHHHHHHHHHHHHHHHTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTT");
      delay(150);
      if (currPage + 1 < numPages) {
        ++currPage;
        break;
      }
    }
    else if (WiFi.status() == WL_CONNECTED) {
      HTTPClient http;  //Object of class HTTPClient
      http.begin("http://104.131.22.37/recipe.json");
      int httpCode = http.GET();
      String currContent = http.getString();
      if (currContent != content) {
        content = currContent;
        currPage = 0;
        break;
      }
    }
    else{
      delay(100);
      Serial.println(currPage);
    }

    
    
  }
}


