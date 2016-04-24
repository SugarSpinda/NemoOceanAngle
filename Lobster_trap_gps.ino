//*****************Lobster    GPS  System**********************************//
//  This is Linkit One Side,Resbonse for  sending ID and Gps  to   //   
//  php server while receiveing data from Arduino side                  //
//********************************************************************************//
#include <LTask.h>
#include <LWiFi.h>
#include <LWiFiClient.h>
#include <LDateTime.h>
#define per 50
#define per1 3
#define WIFI_AP "Make11F"
#define WIFI_PASSWORD "synMakeEl"
#define WIFI_AUTH LWIFI_WPA  // choose from LWIFI_OPEN, LWIFI_WPA, or LWIFI_WEP.
#define SITE_URL "10.187.4.1" //server
#include <HttpClient.h>
LWiFiClient content;
unsigned int rtc;
unsigned int lrtc;
unsigned int rtc1;
unsigned int lrtc1;
int id=122582;
int A=0;

double latitude=45.327842,longitude=-64.937197;
HttpClient http(content);
void setup()
{
  LTask.begin();
  LWiFi.begin();
  Serial.begin(9600);
  Serial.println("Connecting to AP");
  while (0 == LWiFi.connect(WIFI_AP, LWiFiLoginInfo(WIFI_AUTH, WIFI_PASSWORD)))
  {
    Serial.println("Connecting to AP...");
    delay(1000);
  }
pinMode(2,INPUT);

}



void loop()
{
  
  // Make sure we are connected, and dump the response content to Serial

  while (content)
  {
    int v = content.read();
    if (v != -1)
    {
      Serial.print((char)v);
    }
    else
    {
      Serial.println("no more content, disconnect");
      content.stop();
      while (1)
      {
        delay(1);
      }
    }

  }

  //Check for report datapoint status interval
  LDateTime.getRtc(&rtc1);
  if ((rtc1 - lrtc1) >= per1) {
    if(digitalRead(2)==1){
    upload(id,latitude,longitude);
    latitude+=double(0.00001);
    longitude+=double(0.00001);
    lrtc1=rtc1;}
    else{
    latitude=45.327842;
    longitude=-64.937197;
    Serial.println(digitalRead(2));
    lrtc1 = rtc1;
    }
  }

}

void upload(int id,double latitude,double longitude){
  Serial.println("calling connection");

  LWiFiClient content;  
   HttpClient http(content);

  while (!content.connect(SITE_URL, 80))
  {
    Serial.println("Re-Connecting to WebSite");
    delay(1000);
  }
  
  String postData="id="+String(id)+"&latitude="+String(latitude,6)+"&longitude="+String(longitude,6);
  content.println(String("POST /medit.php HTTP/1.1\r\n")+"Host: 10.187.4.1\r\n"+"Content-Length: "+postData.length()+"\r\n"+"Content-Type: application/x-www-form-urlencoded; charset=UFT-8\r\n"+"Connection: close\r\n\r\n"+postData);
  
  delay(500);

  int errorcount = 0;
  while (!content.available())
  {
    Serial.print("waiting HTTP response: ");
    Serial.println(errorcount);
    errorcount += 1;
    if (errorcount > 10) {
      content.stop();
      return;
    }
    delay(100);
  }
  int err = http.skipResponseHeaders();

  int bodyLen = http.contentLength();
  Serial.print("Content length is: ");
  Serial.println(bodyLen);
  Serial.println();
    while (content)
  {
    int v = content.read();
    if (v != -1)
    {
      Serial.print(char(v));
    }
    else
    {
      Serial.println("no more content, disconnect");
      content.stop();

    }
    
  }
  
}
  
  
