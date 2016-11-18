import pygame
import time
from pygame.locals import *


pygame.mixer.pre_init(44100, -16, 1, 4096)
pygame.init()

#volume = 0.5
#playtime = 30000
pin = 11
#soundfile = "rainforest.wav"
soundfile = "./sound/rf01.ogg"


def playSound(volume, playtime):
    volume = volume
    playtime = playtime

    channel1 = pygame.mixer.Sound(soundfile)
    channel1.play(loops=0, maxtime=playtime, fade_ms=0)
    channel1.set_volume(volume)
    print(("volume:", volume))
    while pygame.mixer.get_busy():
        #print("busy")
        time.sleep(1)


def stopSound():
    try:
        #pygame.mixer.pause()
        pygame.mixer.quit()
    except:
        pass


def playMusic(soundfile):
    pygame.mixer.music.load(soundfile)
    pygame.mixer.music.play()
    print("playing:", pygame.mixer.music.get_busy())


def stopMusic():
    try:
        pygame.mixer.music.fadeout(10000)
    except:
        pass


#stopSound()
#playSound(soundfile, volume)





