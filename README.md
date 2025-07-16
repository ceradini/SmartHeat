# 🏠 SmartHeat: A Custom Home Heating Control System

SmartHeat is a fully custom smart heating control system I developed for my family home. The system integrates multiple sensors and devices to monitor and manage the temperature in each room independently, allowing for efficient and remote control of heating.

## Overview

The setup includes:

- **Arduino microcontrollers** with temperature and humidity sensors in each room
- **Relay modules** to switch heaters on and off individually
- **A Raspberry Pi** hosting a local web interface for real-time monitoring and control

## Development

I developed the entire system from scratch:

- The **web interface** was built using PHP (CodeIgniter) and MySQL, enabling user-friendly control of heating zones through a tablet
- The **Arduino board** handles sensor data acquisition and heater control via relays
- The **Raspberry Pi** acts as a hub, serving the web app and coordinating communication between devices

SmartHeat provides an affordable, tailored smart home experience, offering insights into home automation, embedded systems, and full-stack development.

## Arduino Code

The Arduino component consists of two main programs that handle sensor readings and relay control:

### Temperature Testing (`check_temperature.ino`)

This is a testing program designed to verify the functionality of DHT22 temperature and humidity sensors connected to the Arduino board. The code performs basic sensor readings and outputs the data to the serial monitor for debugging purposes.

**Key Features:**
- Reads temperature and humidity from up to 4 DHT22 sensors
- Calculates heat index (perceived temperature) for enhanced environmental monitoring
- Connects sensors to analog pins A0-A3 for easy breadboard prototyping
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
- **Power management**: Uses a dedicated relay (pin 6) to control sensor power supply, reducing energy consumption
- **JSON communication**: Receives commands and sends data in JSON format via serial connection
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
