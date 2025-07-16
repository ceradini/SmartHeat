import socket
import json

device_address_commands = "127.0.0.1"
device_port_commands = 65432

commands_socket = socket.socket(socket.AF_INET,socket.SOCK_DGRAM)

commands_socket.bind((device_address_commands, device_port_commands))
commands_socket.setblocking(1)

stop_program = False

while not stop_program:
    try:
        print("Listening socket for commands")
        data = commands_socket.recv(1024)
        
        if data:
            print("I received: ", data)
            command = json.loads(data)            
            print(command['type'])
    except KeyboardInterrupt:
        print("Bye")
        stop_program = True