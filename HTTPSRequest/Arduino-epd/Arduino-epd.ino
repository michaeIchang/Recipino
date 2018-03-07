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

/*******************************************************************************
  Function Name  : void base_draw(void)
  Description    :
  Input          : None
  Output         : None
  Return         : None
*******************************************************************************/

void draw_text_demo(void)
{
  char buff[] = {'G', 'B', 'K', '3', '2', ':', ' ', 0xc4, 0xe3, 0xba, 0xc3, 0xca, 0xc0, 0xbd, 0xe7, 0};
  epd_set_color(BLACK, WHITE);
  epd_clear();
  //  epd_set_ch_font(GBK32);
  //  epd_set_en_font(ASCII32);
  //  epd_disp_string(buff, 0, 50);
  //  epd_disp_string("ASCII32: Hello, World!", 0, 300);

  //  epd_set_ch_font(GBK48);
  //  epd_set_en_font(ASCII48);
  //  buff[3] = '4';
  //  buff[4] = '8';
  //  epd_disp_string(buff, 0, 100);
  //  epd_disp_string("ASCII48: Hello, World!", 0, 350);

  //  String s = "";
  //  StaticJsonBuffer<200> jsonBuffer;
  //  JsonObject& root = jsonBuffer.createObject();
  //  root["sensor"] = "gps";
  //  root["time"] = 1351824120;
  //  JsonObject& decoded = jsonBuffer.parseObject(root);
  //  if (!root.success()) {
  // Parsing failed :-(
  //  } else {
  //    int i = decoded["time"];
  //    const char* s = root["sensor"];
  //  }



  if (WiFi.status() == WL_CONNECTED) {
    char buff[] = {'G', 'B', 'K', '3', '2', ':', ' ', 0xc4, 0xe3, 0xba, 0xc3, 0xca, 0xc0, 0xbd, 0xe7, 0};
    epd_set_color(BLACK, WHITE);
    epd_clear();
    epd_set_ch_font(GBK48);
    epd_set_en_font(ASCII48);
    //    buff[3] = '6';
    //    buff[4] = '4';

    HTTPClient http;  //Object of class HTTPClient
    http.begin("http://104.131.22.37/recipe.json");
    int httpCode = http.GET();
    //Check the returning code
    if (httpCode > 0) {
      // Parsing
      const size_t bufferSize = 20000;
      DynamicJsonBuffer jsonBuffer(bufferSize);
      JsonObject& root = jsonBuffer.parseObject(http.getString());
      const char* stepNo = root["Step Number"];
      const char* ingredient1 = root["Ingredients"]["1"];
      const char* ingredient2 = root["Ingredients"]["2"];
      const char* ingredient3 = root["Ingredients"]["3"];
      const char* ingredient4 = root["Ingredients"]["4"];
      const char* ingredient5 = root["Ingredients"]["5"];
      const char* ingredient6 = root["Ingredients"]["6"];
      const char* ingredient7 = root["Ingredients"]["7"];
      const char* ingredient8 = root["Ingredients"]["8"];
      const char* ingredient9 = root["Ingredients"]["9"];
      const char* ingredient10 = root["Ingredients"]["10"];
      const char* ingredient11 = root["Ingredients"]["11"];
      // Output to serial monitor
      //      Serial.print("Step Number:");
//      epd_disp_string("Step Number:", 0, 0);
//      epd_disp_string(stepNo, 175, 0);
      //      Serial.println(stepNo);
      if ((*stepNo - '0') == 0) {
//        Serial.print("Ingredients:");
        //      const char s = ingredients[0];
        epd_disp_string("Ingredients:", 0, 0);
        epd_disp_string(ingredient1, 0, 48);
        epd_disp_string(ingredient2, 0, 48 * 2);
        epd_disp_string(ingredient3, 0, 48 * 3);
        epd_disp_string(ingredient4, 0, 48 * 4);
        epd_disp_string(ingredient5, 0, 48 * 5);
        epd_disp_string(ingredient6, 0, 48 * 6);
        epd_disp_string(ingredient7, 0, 48 * 7);
        epd_disp_string(ingredient8, 0, 48 * 8);
        epd_disp_string(ingredient9, 0, 48 * 9);
        epd_disp_string(ingredient10, 0, 48 * 10);
        epd_disp_string(ingredient11, 0, 48 * 11);
      } else {
//        const char* step = root["Steps"][stepNo];
        for (int j = 0; j < root["Steps"][*stepNo - '0'].size(); ++j) {
//          const char * subStepNo = '';
//            String subStepNo = "";
//            subStepNo += j;
          const char* stepDetail = root["Steps"][(*stepNo) - '0'][j];
          epd_disp_string(stepDetail, 0, 48 * j);
//          epd_disp_string("hello", 0, 0);
        }
      }
      //      for (int i = 1; i <= 11; ++i) {
      //        String s = "" + i;
      //        const char* ingredient = root["Ingredients"][s];
      //        epd_disp_string(ingredient, 0, 25 * i + 25);
      //      }
      //      epd_disp_string(ingredients, 0, 225);
      //      Serial.println(ingredients);
      //      Serial.print("Steps:");
      //      Serial.println(steps);
      //        Serial.println(http.getString());
    }
    http.end();   //Close connection
  }



  epd_set_ch_font(GBK64);
  epd_set_en_font(ASCII64);
  buff[3] = '6';
  buff[4] = '4';
  //  epd_disp_string(buff, 0, 160);
  //  epd_disp_char(root["sensor"], 0, 0);
  //    epd_disp_string("test", 0, 0);
  //  epd_disp_string("Hello, World!", 0, 75);
  //  epd_disp_string("Hello, World!", 0, 150);
  //  epd_disp_string("Hello, World!", 0, 225);
  //  epd_disp_string("Hello, World!", 0, 300);
  //  epd_disp_string("Hello, World!", 0, 375);
  //  epd_disp_string("Hello, World!", 0, 450);
  //  epd_disp_string("Hello, World!", 0, 525);
  //  epd_disp_string("Hello, World!", 0, 600);




  //30 characters per line. ~8 or 9 lines


  epd_udpate();
  delay(3000);
}

void setup(void)
{
  /*
    user led init
  */
  pinMode(led, OUTPUT);
  digitalWrite(led, LOW);

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
  
  draw_text_demo();
  delay(5000);
//  epd_enter_stopmode();
//  
//  while (1)
//  {
//    if (flag)
//    {
//      flag = 0;
//      digitalWrite(led, LOW);
//    }
//    else
//    {
//      flag = 1;
//      digitalWrite(led, HIGH);
//    }
//    delay(500);
//  }
}


