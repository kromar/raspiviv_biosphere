''' 
here we going to build the logic for temperature and humidity
we might split this later into separate modules

'''
import time

sensor_active = True
fan_active = False
fan_active_time = 10
mist_active = False
mist_active_time = 10
heat_active = False
heat_active_time = 10

temp_good_min = 21.0
temp_good_max = 26.6
#temp_low < temp_good_min
#temp_high > temp_good_max

hum_good_min = 70
hum_good_max =95
#hum_low < hum_good_min
#hum_high > hum_good_max

temp = 0
hum = 0

#hum/temp
#---------#
#low/low        >> mist_active = True / heat_active = True
#low/good       >> mist_active = True
#low/high       >> mist_active = True / fan_active = True

#good/low       >> heat_active = True
#good/good      >> None
#good/high      >> mist_active = True

#high/low       >> fan_active = True/ heat_active = True
#high/good      >> fan_active = True
#high/high      >> fan_active = True


while sensor_active:
    if (hum < hum_good_min) and (temp < temp_good_min):
        mist_active = True
        heat_active = True
    elif (hum < hum_good_min):
        mist_active = True
    elif (hum < hum_good_min) and (temp > temp_good_max):
        mist_active = True
        fan_active = True
    
    elif (temp < temp_good_min):
        heat_active = True
    elif (temp > temp_good_max):
        mist_active = True
    
    elif (hum > hum_good_max) and (temp < hum_good_min):
        fan_active = True
        heat_active = True
    elif (hum > hum_good_max):
        fan_active = True
    elif (hum > hum_good_max) and (temp > temp_good_max):
        fan_active = True
    
    if sensor_active == False:
        break
    
    
    
    
    
    
    
    
        