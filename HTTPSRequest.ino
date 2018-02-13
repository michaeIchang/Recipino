#include <ESP8266WiFi.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>

#define LCD_ROWS 4
#define LCD_COLS 20
const char* ssid = "Samsung Galaxy S6 3825";
const char* password = "unloqlog";

const char* host = "recipino.herokuapp.com";

LiquidCrystal_I2C lcd(0x27, 20, 4);
void setup()
{
  lcd.init();
  lcd.backlight();
  Serial.begin(115200);
  Serial.println();

  Serial.printf("Connecting to %s ", ssid);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED)
  {
    delay(500);
    Serial.print(".");
  }
  Serial.println(" connected");
}


void loop()
{
  WiFiClient client;

  Serial.printf("\n[Connecting to %s ... ", host);
  if (client.connect(host, 80))
  {
    Serial.println("connected]");

    Serial.println("[Sending a request]");
    client.print(String("GET /") + " HTTP/1.1\r\n" +
                 "Host: " + host + "\r\n" +
                 "Connection: close\r\n" +
                 "\r\n"
                );

    Serial.println("[Response:]");
    boolean reading = false;
    int cnt = 0;
    int ln = 0;
    while (client.connected())
    {
      if (client.available())
      {
        String line = client.readStringUntil('\n');
        if (reading == true) {
          display(line, ln);
          Serial.println(line);
          ++ln;  
        }
        
        if (line.substring(1,5) == "body") {         
          reading = true;
        }
        if (line.substring(2,6) == "body") {
           reading = false;
        }
        
      }
    }
    client.stop();
    Serial.println("\n[Disconnected]");
  }
  else
  {
    Serial.println("connection failed!]");
    client.stop();
  }
  delay(5000);
}

void display(String resp, int ln) {
//  for (int i = 0; i < LCD_ROWS; i++) {
    lcd.setCursor(0, ln);
    String part = resp.substring(ln * LCD_COLS, ln * LCD_COLS + LCD_COLS);
    lcd.print(part);
//  }
}
