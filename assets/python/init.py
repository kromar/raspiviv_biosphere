''' project tropicus '''

class Sensor(object):
    """
    class description
    """
    def __init__(self, sensor):
        pass    
        
    
class Override(object):
    pass
    
    
class ReoteControl(object):
    def remote_mist(self):
        pass    
    def remote_light(self):
        pass    
    def remote_override(self):
        pass
    def remote_sound(self):
        pass
        
    
class Sound(object):
    def sound_start(self):
        pass    
    def sound_stop(self):
        pass    
    def sound_track(self):
        pass    
    def sound_volume(self):
        pass
        

class Humidity(object):
    def hum_night(self):
        pass        
    def hum_day(self):
        pass        
    def hum_tank(self):
        pass        
    def hum_room(self):
        pass        
    def hum_min(self):
        pass        
    def hum_good(self):
        pass        
    def hum_max(self):
        pass        
    def hum_calibration(self):
        pass
    
   
    
class Temperature(object):
    def temp_night(self):
        pass        
    def temp_day(self):
        pass        
    def temp_tank(self):
        pass        
    def temp_room(self):
        pass        
    def temp_min(self):
        pass        
    def temp_good(self):
        pass        
    def temp_max(self):
        pass        
    def temp_calibration(self):
        pass
     

class Mist(object):
    def mist_on(self):
        pass       
    def mist_off(self):
        pass        
    def mist_shedule(self):
        pass

    
class Air(object):
    def air_in(self):
        pass        
    def air_out(self):
        pass    
    def air_circulation(self):
        pass
  
  
class Light(object):
    def light_night(self):
        pass        
    def light_moon(self):
        pass        
    def light_day(self):
        pass        
    def light_low(self):
        pass        
    def light_med(self):
        pass
    def light_high(self):
        pass        
    def light_max(self):
        pass

    
class WaterLevel(object):
    def water_low(self):
        pass        
    def water_good(self):
        pass
    
    
class Status(object):
    def status_air(self):
        pass        
    def status_mist(self):
        pass        
    def status_heat(self):
        pass        
    def status_waterlevel(self):
        pass
    

class DynamicLearning(object):
    def optimize_misting(self):
        pass        
    def optimize_air(self):
        pass        
    def optimize_circulation(self):
        pass
    
    
class Interface(object):
    def create(self):
        pass    

        
        