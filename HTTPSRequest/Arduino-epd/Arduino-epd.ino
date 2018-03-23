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

const int led = 13;                           //user led
const char* ssid = "wustl-guest-2.0";
const char* password = "";
int currPage = 0;
const int leftButtonPin = 5; 
const int rightButtonPin = 6; 

/*******************************************************************************
  Function Name  : void base_draw(void)
  Description    :
  Input          : None
  Output         : None
  Return         : None
*******************************************************************************/

void draw_page(void)
{
  char buff[] = {'G', 'B', 'K', '3', '2', ':', ' ', 0xc4, 0xe3, 0xba, 0xc3, 0xca, 0xc0, 0xbd, 0xe7, 0};
  epd_set_color(BLACK, WHITE);
  epd_clear();

  if (WiFi.status() == WL_CONNECTED) {
    char buff[] = {'G', 'B', 'K', '3', '2', ':', ' ', 0xc4, 0xe3, 0xba, 0xc3, 0xca, 0xc0, 0xbd, 0xe7, 0};
    epd_set_color(BLACK, WHITE);
    epd_clear();
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
      const size_t bufferSize = 20000;
      DynamicJsonBuffer jsonBuffer(bufferSize);
      JsonObject& root = jsonBuffer.parseObject(http.getString());
      const char* stepNo = root["Pages"];
      for (int j = 1; j < root["Pages"][currPage].size(); ++j) {
        const char* ingredient = root["Pages"][currPage][j];
        epd_disp_string(ingredient, 0, 64 * j);
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
  pinMode(led, OUTPUT);
  digitalWrite(led, LOW);
  
  pinMode(buttonPin, INPUT);

  epd_init();
  epd_wakeup();
  epd_set_memory(MEM_NAND);

  Serial.begin(115200);
  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting...");
  }
}

void loop(void)
{
  char flag = 0;

  /*
    Draw text demo
  */
  
  draw_page();
  delay(5000);
  epd_enter_stopmode();
  
  while (1)
  {
    buttonState = digitalRead(buttonPin);
    if (buttonState == HIGH)
    {
      flag = 0;
      digitalWrite(led, LOW);
      //this may not be the right function to call...
      epd_wakeup();
      break;
    }
    else
    {
      flag = 1;
      digitalWrite(led, HIGH);
    }
    delay(500);
  }
}


