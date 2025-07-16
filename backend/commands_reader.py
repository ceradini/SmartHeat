#!/usr/bin/env python3

import serial
import time
import json
import socket
from threading import Thread
from queue import Queue

from utils.database import *

def commandsSocketThread():
    global stop_program
    global commands_socket
    global commands_received
    
    while not stop_program:
        try:
            # Attempt to receive up to 1024 bytes of data
            data = commands_socket.recv(1024)
            
            print("received command from interface: ", data)  
            
            commands_received.put(data)  
        except socket.timeout:
            print('socket timeout')
            pass
        except socket.error:
            #If no data is received, you get here, but it's not an error => ignore and continue
            print('socket error')
            pass
     
stop_program = False 
commands_received = Queue()  
device_address_commands = "127.0.0.1"
device_port_commands = 65432

# create transmit socket object for the commands (from web interface)
commands_socket = socket.socket(socket.AF_INET,socket.SOCK_DGRAM)
commands_socket.bind((device_address_commands, device_port_commands))
commands_socket.setblocking(1) # block when looking for received data 

# starting the thread to manage the read operations on commands socket
commandsSocketThread = Thread(target=commandsSocketThread)    
commandsSocketThread.start()

ser = serial.Serial('/dev/ttyACM0', 9600, timeout=1)
# ser = serial.Serial('/dev/tty.usbmodem146401', 9600, timeout=1)
ser.flush()
my_db = Database()
time.sleep(1.5)

sleep_interval = 1

time_tick_temp = 0
time_tick_rele = 0

debug_interval_count = 0
temp_interval = 120
rele_interval = 4

# requesting the first data
ser.write((json.dumps({"type": "send_data"}) + "\n").encode('utf-8'))

while not stop_program:
    try:
        '''if debug_interval_count == 300:
            print('main_read active')
            debug_interval_count = 0
            
        debug_interval_count += sleep_interval'''
        
        while not commands_received.empty():
            command = json.loads(commands_received.get())
            
            if command['type'] == 'turn_on' or command['type'] == 'turn_off':
                status = 1 if command['type'] == 'turn_on' else 0
                
                data = {
                    "type": "rele_management",
                    "id": command['room_id'],
                    "status": status
                }
                
                execution_command = json.dumps(data)            
                ser.write((execution_command + "\n").encode('utf-8'))
                            
                # my_db.set_command_executed(command_id)
            elif command['type'] == 'turn_all_on' or command['type'] == 'turn_all_off':
                status = 1 if command['type'] == 'turn_all_on' else 0
                
                rooms = my_db.get_rooms()
                
                for room in rooms:
                    data = {
                        "type": "rele_management",
                        "id": room[0],
                        "status": status
                    }
                
                    execution_command = json.dumps(data)            
                    ser.write((execution_command + "\n").encode('utf-8'))
                    
                    # my_db.set_command_executed(command_id)
            
        time_tick_temp += sleep_interval
        time_tick_rele += sleep_interval
        
        # every 5 seconds => send a request for reading the data of the sensors
        if time_tick_temp == temp_interval:
            # print('requesting send_data_temp')            
            command = json.dumps({"type": "send_data_temp"})
            ser.write((command + "\n").encode('utf-8'))
            time_tick_temp = 0
            
        if time_tick_rele == rele_interval:
            # print('requesting send_data_rele')            
            command = json.dumps({"type": "send_data_rele"})
            ser.write((command + "\n").encode('utf-8'))
            time_tick_rele = 0

        time.sleep(sleep_interval)
    except KeyboardInterrupt:
        stop_program = True 
        my_db.close()  