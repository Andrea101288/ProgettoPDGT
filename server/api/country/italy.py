"""
Italy Earthquakes info from ingv.it
"""
import requests
import xml.etree.ElementTree
from .basic_country import BasicCountry


class Italy(BasicCountry):
    def __init__(self):
        """
        Costructor
        """
        self.url = "http://webservices.ingv.it/fdsnws/event/1/query?starttime={0}&endtime={1}&minmag=2&maxmag=10"

    def return_json(self, start_date, end_date):
        """
        Return JSON formatted data
        """
        url = self.url.format(start_date, end_date)

        # Do request
        r = requests.get(url)

        # Init empty JSON
        rv = {}

        # Check status
        if r.status_code == 200:
            # Parse XML
            e = xml.etree.ElementTree.fromstring(r.text)

            # Get last update_time
            rv['updated'] = e[0][0][4][2].text

            # Loop on events
            for event in e[0]:
                if event.tag == "{http://quakeml.org/xmlns/bed/1.2}event":
                    # Get event ID
                    event_id = event.attrib['publicID'].split('?eventId=')[1]

                    # Init object
                    rv[event_id] = {}

                    for field in event:
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

        # Return final JSON
        return rv