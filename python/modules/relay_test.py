try:
    import RPi.GPIO as GPIO
except RuntimeError:
    print("probably missing sudo")
import time

GPIO.setmode(GPIO.BOARD)
GPIO.setwarnings(False)

pin_list = (13, 15)
chan_state = 1

while True:
    for pin in pin_list:
        GPIO.setup(pin, GPIO.OUT)
        print(GPIO.input(pin))

        if GPIO.input(pin) == 1:
            GPIO.output(pin, 0)
        elif GPIO.input(pin) == 0:
            GPIO.output(pin, 1)
    time.sleep(3)





