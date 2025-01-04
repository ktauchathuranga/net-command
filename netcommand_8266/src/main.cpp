#include <Arduino.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

void sendAPIRequest();

const char* ssid = "wifi-name";  // Your Wi-Fi SSID
const char* password = "wifi-pass";         // Your Wi-Fi password
const char* apiUrl = "http://192.168.254.155:8080/api/command"; // Your API URL

String token = "your-token"; // Your JWT token

int previousState = -1; // Initialize with an invalid state to detect the first response

void setup() {
  Serial.begin(115200);

  // Connect to Wi-Fi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");
}

void loop() {
  sendAPIRequest();
  delay(2000); // Wait for 2 seconds before sending the next request
}

void sendAPIRequest() {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;

    // Use WiFiClient to start the HTTP client
    WiFiClient client;
    http.begin(client, apiUrl);  // Start the HTTP request

    // Set timeout and headers to make the request look like it's coming from a Windows machine
    http.setTimeout(5000);  // 5 seconds timeout
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");  // Change content type to form-urlencoded
    http.addHeader("Authorization", "Bearer " + token);  // Add JWT token in the Authorization header

    // Simulating a request coming from a Windows machine (e.g., Chrome on Windows)
    http.addHeader("User-Agent", "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36");
    http.addHeader("Accept", "application/json, text/plain, */*");
    http.addHeader("Accept-Language", "en-US,en;q=0.9");
    http.addHeader("Accept-Encoding", "gzip, deflate, br");

    // Create the form data payload (to match your server's expected POST structure)
    String payload = "readstate=1"; // Adjust according to what you need (e.g., "writestate=2")

    // Send the POST request
    int httpCode = http.POST(payload);

    // Check the response code
    if (httpCode > 0) {
      String response = http.getString();
      // Serial.println("HTTP Response Code: " + String(httpCode));

      // Parse the response to extract the "state"
      int currentState = parseStateFromResponse(response);
      if (currentState != -1 && currentState != previousState) {
        Serial.print("Received ");
        Serial.println(currentState);
        previousState = currentState; // Update the previous state
      }
    } else {
      Serial.println("Error on sending POST request: " + String(httpCode));
    }

    // End the HTTP request
    http.end();
  } else {
    Serial.println("WiFi not connected");
  }
}

int parseStateFromResponse(String response) {
  // Extract the "state" from the JSON response
  int stateIndex = response.indexOf("\"state\":");
  if (stateIndex != -1) {
    int valueStart = stateIndex + 8; // Length of '"state":'
    int valueEnd = response.indexOf(",", valueStart);
    if (valueEnd == -1) {
      valueEnd = response.indexOf("}", valueStart);
    }
    return response.substring(valueStart, valueEnd).toInt();
  }
  return -1; // Return -1 if "state" is not found
}
