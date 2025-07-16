import serial
import time
import json

ser = serial.Serial('/dev/tty.usbmodem144401', 9600, timeout=1)
ser.flush()

while True:
    data = {
        "type": "rele_management",
        "id": 1,
        "status": 1
    }

    my_json = json.dumps(data)
    ser.write((my_json + "\n").encode('utf-8'))
    
    # ser.write(b"Hello from Raspberry Pi!\n")
    line = ser.readline().decode('utf-8').rstrip()
    print(line)
    time.sleep(1)