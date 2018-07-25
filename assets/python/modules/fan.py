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


def initFan(pin):
    GPIO.setmode(GPIO.BOARD)
    GPIO.setwarnings(False)
    GPIO.setup(pin, GPIO.OUT)


def toggleFan(pin):
    if GPIO.input(pin) == 1:
        GPIO.output(pin, 0)
        print("fan disabled")
    elif GPIO.input(pin) == 0:
        GPIO.output(pin, 1)
        print("fan enabled")


def runFan(pin, seconds):
    GPIO.output(pin, 1)
    print("fan enabled")
    time.sleep(seconds)
    GPIO.output(pin, 0)
    print("fan disabled")

initFan(5)
#runFan(5, 10)
toggleFan(5)





