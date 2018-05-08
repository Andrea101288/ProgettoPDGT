"""
PiattaSisma - Damage notifier bot
"""
import os
import sys
import requests
import telepot
from time import sleep
from settings import TOKEN


# Message handle funtion
def handle(msg):
    """
    This function handle all incoming messages
    """
    content_type, chat_type, chat_id = telepot.glance(msg)

    # Check what type of content was sent
    if content_type == 'text':
        command_input = msg['text']

        if command_input == '/start':
            # Send start message
            msg = "Benvenuto " + msg['from']['first_name']
            bot.sendMessage(chat_id, msg)
        elif command_input == '/get_damages':
            # Ask user for location
            msg = "Inviami la tua posizione"
            bot.sendMessage(chat_id, msg)

            # Go in state 1
            USER_STATE[chat_id] = 1
    elif content_type == 'location' and USER_STATE[chat_id] == 1:
        # Default search radius
        default_rad = "10"

        # Get location
        lat = msg['location']['latitude']
        lon = msg['location']['longitude']

        url = 'http://piattasisma.ddns.net/api/damages?lat=' + str(lat) + '&lon=' + str(lon) + '&rad=' + default_rad

        # Request data from PiattaSisma
        r = requests.get(url).json()

        for damage in r['damages']:
            caption = damage['fields']['damage_dsc']
            url = "http://piattasisma.ddns.net/media/" + damage['fields']['damage_photo']

            # Send all stuff
            bot.sendPhoto(chat_id, url, caption)
            bot.sendLocation(chat_id, damage['fields']['lat'], damage['fields']['lon'])

        # Return to state 0
        USER_STATE[chat_id] = 0


# Main
print("Starting TechSismaBot...")

# PID file
PID = str(os.getpid())
PIDFILE = "/tmp/techsismabot.pid"

# Check if PID exist
if os.path.isfile(PIDFILE):
    print("%s already exists, exiting!" % PIDFILE)
    sys.exit()

# Create PID file
with open(PIDFILE, 'w') as f:
    f.write(PID)
    f.close()

# Variables
USER_STATE = {}

# Start working
try:
    bot = telepot.Bot(TOKEN)
    bot.message_loop(handle)

    while 1:
        sleep(10)
finally:
    # Remove PID file on exit
    os.unlink(PIDFILE)
