from modules import sound
import time

try:
    import RPi.GPIO as GPIO
except RuntimeError:
    print("probably missing sudo")


GPIO.setmode(GPIO.BOARD)
GPIO.setwarnings(False)
pin = 11
GPIO.setup(pin, GPIO.IN)


def triggerSound(volume, playtime):
    while True:
        #print(GPIO.input(pin))
        if GPIO.input(pin) == 1:
            print(("playing sound for", playtime * 0.001, "s"))
            sound.playSound(volume, playtime)
        time.sleep(0.1)

volume = 1.0
playtime = 30000
triggerSound(volume, playtime)
