# Net Command

**Net Command** is a proof-of-concept project that enables users to control an ESP8266 device from anywhere in the world using a website. It demonstrates the integration of a web application with IoT hardware, using a database and APIs for seamless communication.

---

## Features
- Host a website to control your ESP8266 device inside a Docker container.
- Store device control data in a MySQL database.
- Secure API with JWT authentication for authorized access.
- Simple setup and deployment process.
- PlatformIO project for ESP8266 firmware development.
- Easy to scale and deploy using Docker.

---

## Requirements
- Docker
- Web server (handled by Docker)
- ESP8266 board
- PlatformIO IDE for firmware upload
- PHP (for the API)
- MySQL (for the database)
- **JWT** for API authentication

---

## Setup Instructions

### 1. Clone the Repository
```bash
git clone https://github.com/ktauchathuranga/net-command.git
```

### 2. Setup Docker Container for the Web Application
1. Navigate to the `net-command/public_html` folder.
2. Build and run the Docker container:
   ```bash
   docker-compose up --build
   ```
3. Once the container is running, the website will be accessible locally at `http://localhost` (or your external domain if deployed).
4. The MySQL database will be automatically set up and populated with the necessary data during the container initialization, so there's no need to manually import the SQL file.

### 3. Configure the ESP8266 Firmware
1. Open the `net-command/netcommand_8266` folder in PlatformIO.
2. Update the Wi-Fi credentials and other I/O details in the firmware code.
3. Replace the placeholder API URL with your hosted website URL (use your Docker container's IP or a domain name if hosted externally):
   ```cpp
   const char* serverUrl = "http://localhost/api/command";  // or use your public domain
   ```
4. Upload the code to your ESP8266 board.

---

## Authentication

### JWT Authentication for Secure API Access

1. **Login to obtain a JWT Token**:
   To authenticate users before accessing the API, they must first log in by sending their username and password. Here's how to obtain a JWT token:
   
   **API Endpoint**: `POST /api/login.php`  
   **Parameters**: `username`, `password`  
   
   **Example request** using `curl`:
   ```bash
   curl -X POST -d "username=your_user&password=your_pass" http://localhost/api/login.php
   ```

   **Response**:
   ```json
   {
       "jwt": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
   }
   ```

2. **Accessing the Command API**:
   To interact with the command API, users must include the JWT token in the `Authorization` header. For example:

   **API Endpoint**: `POST /api/command.php`  
   **Parameters**: `readstate`, `writestate`  
   
   **Example request** using `curl`:
   ```bash
   curl -X POST -H "Authorization: Bearer YOUR_JWT_TOKEN" -d "readstate=1" http://localhost/api/command.php
   ```

   - Replace `YOUR_JWT_TOKEN` with the token you received after login.
   - Replace `readstate=1` with the appropriate data for the API request.

---

## How to Use
1. Access the hosted website at `http://localhost` (or your external domain if deployed).
2. Log in using your credentials to obtain a JWT token.
3. Interact with the controls on the website to send commands to your ESP8266 device via the secure API.

---

## Contributing
Feel free to fork the repository and contribute to the project. Create a pull request with detailed changes to improve functionality.

---

## License
This project is licensed under the MIT License. See the LICENSE file for details.

---

[Watch the demo](https://youtu.be/5gpqcNvchWo)  
[View a short version](https://www.youtube.com/shorts/QJ2y6UhsK5I)
