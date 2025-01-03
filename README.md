# Net Command

**Net Command** is a proof-of-concept project that enables users to control an ESP8266 device from anywhere in the world using a website. It demonstrates the integration of a web application with IoT hardware, using a database and APIs for seamless communication.

---

## Features
- Host a website to control your ESP8266 device.
- Store device control data in a MySQL database.
- Simple setup and deployment process.
- PlatformIO project for ESP8266 firmware development.

---

## Requirements
- Web server (e.g., XAMPP, WAMP, or any hosting service with PHP and MySQL support).
- ESP8266 board.
- PlatformIO IDE for firmware upload.

---

## Setup Instructions

### 1. Clone the Repository
```bash
git clone https://github.com/ktauchathuranga/net-command.git
```

### 2. Setup the Web Application
1. Navigate to the `net-command/public_html` folder.
2. Copy the contents of the folder to your web server's public directory.
3. Create a database named `netcommand` in your MySQL server.
4. Import the SQL file located in the `net-command/sql_database` folder:
   ```bash
   mysql -u [username] -p netcommand < path/to/sql_file.sql
   ```

### 3. Configure the ESP8266 Firmware
1. Open the `net-command/netcommand_8266` folder in PlatformIO.
2. Update the Wi-Fi credentials and other I/O details in the firmware code.
3. Replace the placeholder API URL with your hosted website URL.
   ```cpp
    const char* serverUrl = "https://YOUR-DOMAIN.com/api/command";
   ```
4. Upload the code to your ESP8266 board.

---

## How to Use
1. Access the hosted website.
2. Interact with the controls on the website to send commands to your ESP8266.
3. The ESP8266 device will execute the commands based on the website inputs.

---

## Contributing
Feel free to fork the repository and contribute to the project. Create a pull request with detailed changes to improve functionality.

---

## License
This project is licensed under the MIT License. See the LICENSE file for details.

---

https://youtu.be/5gpqcNvchWo <br>
https://www.youtube.com/shorts/QJ2y6UhsK5I