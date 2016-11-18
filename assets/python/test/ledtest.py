import time
try:
    import RPi.GPIO as GPIO
except RuntimeError:
    print("probably missing sudo")

#channel setups
#    1  power 3.3v sensor1
#    6  ground sensor1
#    3  GPIO sensor1

#    2  power 5v fan1
#    14 ground fan1
#    5  GPIO FAN01

#chan_list = (1, 6, 3, 2, 14)

GPIO.setmode(GPIO.BOARD)
GPIO.setwarnings(False)

pin = 5
chan_state = 1
GPIO.setup(pin, GPIO.OUT)

print(GPIO.input(pin))
if GPIO.input(pin) == 1:
    GPIO.output(pin, 0)
elif GPIO.input(pin) == 0:
    GPIO.output(pin, 1)






