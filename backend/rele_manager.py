'''
#!/usr/bin/env python3
'''
import serial
import time
import json

from utils.database import *

my_db = Database()
# ser = serial.Serial('/dev/ttyACM0', 9600, timeout=1)
ser = serial.Serial('/dev/tty.usbmodem146401', 9600, timeout=1)
ser.flush()

data = {
    "type": "rele_management",
    "id": 1,
    "status": 0
}

time.sleep(1.5)
command = json.dumps(data)
ser.write((command + "\n").encode('utf-8'))