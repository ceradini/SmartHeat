import mysql.connector
import datetime

class Database:
    def __init__(self):
        self.mydb = mysql.connector.connect(
            host="localhost",
            user="admin",
            password="admin",
            database="home_app"
        )
        
        self.mycursor = self.mydb.cursor()
        
    def get_commands_to_execute(self):
        sql = "SELECT * FROM commands WHERE executed = 0"
        
        self.mycursor.execute(sql)        
        result = self.mycursor.fetchall()        
        self.mydb.commit()

        return result
    
    def get_rooms(self):
        sql = "SELECT * FROM rooms"
        
        self.mycursor.execute(sql)        
        result = self.mycursor.fetchall()        
        self.mydb.commit()

        return result
        
    def add_temperature(self, room, t, h, hi):
        sql = "INSERT INTO rooms_temperature (room_id, temp, humidity, heat_index) VALUES (%s, %s, %s, %s)"
        val = (room, t, h, hi)
        
        self.mycursor.execute(sql, val)
        self.mydb.commit()
        
    def edit_room_status(self, room, status):
        sql = "UPDATE rooms SET thermostat_status = %s WHERE id = %s"
        val = (status, room)
        
        self.mycursor.execute(sql, val)
        self.mydb.commit()
    
    def set_command_executed(self, command_id):
        execution_time = datetime.datetime.now()
        
        sql = "UPDATE commands SET executed = 1, execution_time = %s WHERE id = %s"
        val = (execution_time, command_id)
        
        self.mycursor.execute(sql, val)
        self.mydb.commit()
        
    def close(self):
        self.mydb.close()