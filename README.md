# 🏠 SmartHeat: A Custom Home Heating Control System

SmartHeat is a fully custom smart heating control system I developed for my family home. The system integrates multiple sensors and devices to monitor and manage the temperature in each room independently, allowing for efficient and remote control of heating.

🔗 **[View full project details on my website](https://ceradini.github.io/home-app.html)**

## Overview

The setup includes:

- **Arduino microcontroller** with temperature and humidity sensors in each room
- **Relay module** to switch heaters on and off individually (connected to the Arduino board)
- **A Raspberry Pi** hosting a local web interface for real-time monitoring and control

## Development

I developed the entire system from scratch:

- The **web interface** was built using PHP (CodeIgniter framework) and MySQL, enabling user-friendly control of heating zones through a tablet
- The **Arduino board** handles sensor data acquisition and heater control via relays
- The **Raspberry Pi** acts as a hub, serving the web app and coordinating communication between devices

SmartHeat provides an affordable, tailored smart home experience, offering insights into home automation, embedded systems, and full-stack development.

## Arduino Code

The Arduino component consists of two main programs that handle sensor readings and relay control:

### Temperature Testing (`check_temperature.ino`)

This is a testing program designed to verify the functionality of DHT22 temperature and humidity sensors connected to the Arduino board. The code performs basic sensor readings and outputs the data to the serial monitor for debugging purposes.

**Key Features:**
- Reads temperature and humidity from up to 4 DHT22 sensors
- Provide code for calculating heat index (perceived temperature) for enhanced environmental monitoring
- Connects sensors to analog pins for easy breadboard prototyping
- Outputs sensor data every 5 seconds via serial communication
- Includes error handling for sensor reading failures

**Hardware Setup:**
- DHT22 sensors connected to analog pins A0, A1, A2, A3
- Serial communication at 9600 baud rate
- Basic error detection for sensor malfunctions

### Main Control System (`main.ino`)

The main Arduino program that orchestrates the complete heating control system. This code handles both sensor data collection and relay management through JSON-based serial communication with the Raspberry Pi.

**Key Features:**
- **Multi-sensor support**: Manages 6 DHT22 sensors connected to pins A1-A5 and digital pin 2
- **Relay control**: Controls 6 individual relays (pins 7-12) for independent heater switching
- **Power management**: Uses a dedicated relay (pin 6) to control sensor power supply, reducing energy consumption and sensors continuos activation time
- **JSON commands on serial communication**: Receives commands and sends data in JSON format via serial connection
- **Command handling**: Processes three types of commands:
  - `rele_management`: Controls individual relay states (ON/OFF)
  - `send_data_temp`: Triggers temperature and humidity readings from all sensors
  - `send_data_rele`: Reports current status of all relays

**Communication Protocol:**
- Commands received as JSON objects via serial (9600 baud)
- Temperature data sent as JSON with room ID, temperature, humidity, and heat index
- Relay status reported as JSON with room ID and current state
- Error handling for sensor reading failures with dedicated error messages

**Hardware Configuration:**
- 6 DHT22 sensors for temperature/humidity monitoring
- 6 relays for individual heater control
- 1 power management relay for sensor supply
- Optimized pin layout for reliable operation and easy wiring

## Backend System

The backend runs on a Raspberry Pi 2 and consists of Python scripts that handle communication between the Arduino and the web interface, along with bash scripts for system initialization.

### System Startup Scripts

**`arduino_executor_1.sh`**
- Starts the command reader service for relay management
- Runs a continuous loop that calls the web app's `check_rules` API every 4 seconds
- Handles automatic heating rule synchronization and execution

**`arduino_executor_2.sh`**
- Launches the temperature data collection service
- Runs as a background daemon process for continuous monitoring

### Python Backend Services

**`main_read.py` - Temperature Data Handler**

This script manages the continuous reading of temperature and humidity data from the Arduino board and stores it in the MySQL database.

**Key Features:**
- **Serial Communication**: Maintains connection with Arduino on `/dev/ttyACM0` at 9600 baud
- **JSON Data Processing**: Parses incoming temperature readings and relay status updates
- **Database Integration**: Stores temperature, humidity, and heat index values for each room
- **Real-time Monitoring**: Processes data as it arrives from the Arduino
- **Status Tracking**: Updates room thermostat status based on relay states

**Data Flow:**
- Receives `temp_read` JSON messages with room ID, temperature, humidity, and heat index
- Receives `rele_status` JSON messages with relay state information
- Automatically stores all sensor data in MySQL database for historical tracking

**`commands_reader.py` - Relay Control & Communication Hub**

This script orchestrates the heating system by managing relay commands and coordinating periodic data requests.

**Key Features:**
- **Command Processing**: Handles relay control commands from the web interface via UDP socket
- **Periodic Data Requests**: Sends temperature reading requests every 120 seconds
- **Relay Status Updates**: Requests relay status every 4 seconds
- **Multi-threading**: Uses separate threads for socket communication and serial handling
- **Command Types Supported**:
  - `turn_on`/`turn_off`: Controls individual room heaters
  - `turn_all_on`/`turn_all_off`: Controls all heaters simultaneously
  - `rele_management`: Direct relay state management

**Communication Architecture:**
- **UDP Socket**: Receives commands from web interface on a specific port (customizable)
- **Serial Communication**: Sends JSON commands to Arduino
- **Database Integration**: Retrieves room configurations and updates status
- **Threaded Processing**: Ensures responsive command handling without blocking operations

**System Integration:**
- Both scripts work together to provide real-time heating control
- Temperature data collection runs independently of command processing
- Automatic recovery and error handling for reliable 24/7 operation
- Seamless integration with the PHP web interface and MySQL database

## Web Application

The web interface is built using the CodeIgniter PHP framework and provides a user-friendly dashboard for controlling and monitoring the heating system. The application runs on the Raspberry Pi and can be accessed via any web browser on the local network.

### Core Features

**Dashboard Interface:**
- Real-time temperature and humidity monitoring for each room
- Individual room heater control with on/off switches
- Global system control for turning all heaters on/off simultaneously
- Manual override mode with configurable duration timers
- Rule-based automation with scheduling capabilities

**API Endpoints:**
- **Room Management**: APIs for individual room control, temperature settings, and status updates
- **Rule System**: Automated heating rules with time-based scheduling and temperature thresholds
- **System Synchronization**: Backend integration through the `check_rules` API for automatic heating control
- **Settings Management**: Global system settings and configuration management

**Key Controllers:**
- **Home Controller**: Main dashboard with room overview and real-time data
- **Rooms Controller**: Individual room management and heater control
- **Rules Controller**: Automated heating rule configuration
- **Sync Controller**: System synchronization and rule execution
- **Settings Controller**: System configuration and global settings

**Database Integration:**
- MySQL database for storing temperature history, room configurations, and heating rules
- Real-time data updates from the backend Python scripts
- Historical data tracking for monitoring and analysis

**User Experience:**
- Responsive web interface optimized for tablet control
- Intuitive room-by-room heating management
- Real-time status updates and temperature monitoring
- Automated scheduling with manual override capabilities

The web application serves as the central control hub, providing an accessible interface for managing the entire SmartHeat system while maintaining seamless integration with the Arduino hardware and Python backend services.
