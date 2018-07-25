# -*- coding: utf-8 -*-

import time
try:
    import RPi.GPIO as GPIO
except RuntimeError:
    print("probably missing sudo")

GPIO.setmode(GPIO.BOARD)
GPIO.setwarnings(False)

#pin = 3
#GPIO.setup(pin, GPIO.IN)

# sht21 connections:
#
## 11 yellow
## 13 white

## i2cdetect -y 1

# AM2320B
#1 Red: VDD power supply (3.1-5.5V)
#2 SDA Serial data, biderectional port
#3 Black: Ground
#4 SCL Serial clock input port (single bus ground)

#print(GPIO.input(pin))
print(GPIO.RPI_INFO)