#include <Arduino.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

const char* ssid = "YOUR-WIFI-NAME";
const char* password = "YOUR-WIFI-PASSWORD";
const char* serverUrl = "https://YOUR-DOMAIN.com/api/command";
const String jwtToken = "YOUR_JWT_TOKEN"; // Set your JWT token here

void setup() {
  Serial.begin(115200);

  // Connect to Wi-Fi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }

  Serial.println("WiFi connected");
}

void loop() {
  static String previousResponse;

  if (WiFi.status() == WL_CONNECTED) {
    WiFiClient client;
    HTTPClient http;

    http.begin(client, serverUrl);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    http.addHeader("Authorization", "Bearer " + jwtToken); // Add the JWT token here

    String payload = "readstate=1";

    int statusCode = http.POST(payload);
    if (statusCode == HTTP_CODE_OK) {
      String response = http.getString();
      Serial.print("Response: ");
      Serial.println(response);

      if (response != previousResponse) {
        previousResponse = response;

        if (response == "#1") {
          Serial.println("Performing action for HIGH");
          // Add your HIGH logic here
        } else if (response == "#0") {
          Serial.println("Performing action for LOW");
          // Add your LOW logic here
        } else {
          Serial.println("Unexpected response format");
        }
      }
    } else {
      Serial.print("HTTP Error: ");
      Serial.println(statusCode);
    }

    http.end();
  } else {
    Serial.println("WiFi not connected, attempting to reconnect...");
    WiFi.begin(ssid, password);
  }

  delay(5000); // Adjust as needed
}
