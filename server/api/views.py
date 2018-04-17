import urllib
import requests
import xml.etree.ElementTree
from datetime import datetime, timedelta
from django.views import generic
# from django.middleware.csrf import get_token
# from django.shortcuts import render
from django.http import JsonResponse
# from .models import Damage, User, TelegramUser


class Earthquakes(generic.View):
    def get(self, request, country):
        # TODO: Country check
        # Get current date
        today = datetime.now()
        # Get last year date
        last_year = today - timedelta(days=90)
        # last_year = today - timedelta(days=1)

        # Url encode
        today = urllib.parse.quote_plus(today.isoformat())
        last_year = urllib.parse.quote_plus(last_year.isoformat())

        url = "http://webservices.ingv.it/fdsnws/event/1/query?starttime={0}&endtime={1}&minmag=2&maxmag=10".format(last_year, today)

        # Do request
        r = requests.get(url)

        # Init empty JSON
        rv = {}

        # Check status
        if r.status_code == 200:
            # Parse XML
            e = xml.etree.ElementTree.fromstring(r.text)

            # Loop on events
            for event in e[0]:
                # Get event link
                link = event.items()[0][1].replace('smi:', 'http://')
                print(link)

                # Get event ID
                event_id = link.split('eventId=')[1]

                # Do request for specific data
                r = requests.get(link)

                rv[event_id] = {}

                # Parse new XML
                e = xml.etree.ElementTree.fromstring(r.text)
                import time
                time.sleep(0.1)

                for field in e[0][0]:
                    # Get description
                    if field.tag == "{http://quakeml.org/xmlns/bed/1.2}description":
                        rv[event_id].update({'description': field[1].text})
                    # Get information from origin
                    elif field.tag == "{http://quakeml.org/xmlns/bed/1.2}origin":
                        for field2 in field:
                            if field2.tag == "{http://quakeml.org/xmlns/bed/1.2}time":
                                rv[event_id].update({'time': field2[0].text})
                            elif field2.tag == "{http://quakeml.org/xmlns/bed/1.2}latitude":
                                rv[event_id].update({'latitude': field2[0].text})
                            elif field2.tag == "{http://quakeml.org/xmlns/bed/1.2}longitude":
                                rv[event_id].update({'longitude': field2[0].text})
                            elif field2.tag == "{http://quakeml.org/xmlns/bed/1.2}depth":
                                rv[event_id].update({'depth': field2[0].text})
                    # Get magnitude
                    elif field.tag == "{http://quakeml.org/xmlns/bed/1.2}magnitude":
                        for field2 in field:
                            if field2.tag == "{http://quakeml.org/xmlns/bed/1.2}mag":
                                rv[event_id].update({'magnitude': field2[0].text})

        return JsonResponse(rv)
