#!/usr/bin/env python3
import serial
import time
import json

from utils.database import Database

ser = serial.Serial('/dev/ttyACM0', 9600, timeout=1)
# ser = serial.Serial('/dev/tty.usbmodem146401', 9600, timeout=1)
ser.flush()
my_db = Database()
sleep_interval = 0.2
interval_count = 0

time.sleep(1.5)

while True:
    if interval_count > 15:
        print('main_read active')
        interval_count = 0
        
    interval_count += sleep_interval
    
    line = ser.readline().decode('utf-8').rstrip()
    
    # print(line)

    if line:
        data = json.loads(line)
                
        if(data['type'] == "temp_read"):
            my_db.add_temperature(data['room'], data['t'], data['h'], data['hi'])
            print('temp_read')
        elif(data['type'] == "rele_status"):
            thermostat_status = 1 if data['status'] == 0 else 0
            my_db.edit_room_status(data['room'], thermostat_status)
        
    # time.sleep(sleep_interval)