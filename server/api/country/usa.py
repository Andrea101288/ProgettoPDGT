"""
USA Earthquakes info from usgs.gov
"""
import requests
import xml.etree.ElementTree
from .basic_country import BasicCountry


class Usa(BasicCountry):
    def __init__(self):
        """
        Costructor
        """
        self.url = "https://earthquake.usgs.gov/fdsnws/event/1/query?format=xml&starttime={0}&endtime={1}"

    def return_json(self, start_date, end_date):
        """
        Return JSON formatted data
        """
        url = self.url.format(start_date, end_date)

        # Do request
        r = requests.get(url)

        # Check status
        if r.status_code == 200:
            # Parse XML
            e = xml.etree.ElementTree.fromstring(r.text)

            # Init empty JSON
            rv = {}

            # Get last update_time
            rv['updated'] = e[0][-1][0].text

            # Init events array in JSON
            rv['events'] = []

            # Loop on events
            for event in e[0]:
                if event.tag == "{http://quakeml.org/xmlns/bed/1.2}event":
                    # Init temporary object
                    tmp = {}

                    # Get event ID
                    event_id = event.attrib['{http://anss.org/xmlns/catalog/0.1}eventid']
                    tmp.update({'event_id': event_id})

                    for field in event:
                        # Get description
                        if field.tag == "{http://quakeml.org/xmlns/bed/1.2}description":
                            tmp.update({'description': field[1].text})
                        # Get information from origin
                        elif field.tag == "{http://quakeml.org/xmlns/bed/1.2}origin":
                            for field2 in field:
                                if field2.tag == "{http://quakeml.org/xmlns/bed/1.2}time":
                                    tmp.update({'time': field2[0].text})
                                elif field2.tag == "{http://quakeml.org/xmlns/bed/1.2}latitude":
                                    tmp.update({'latitude': field2[0].text})
                                elif field2.tag == "{http://quakeml.org/xmlns/bed/1.2}longitude":
                                    tmp.update({'longitude': field2[0].text})
                                elif field2.tag == "{http://quakeml.org/xmlns/bed/1.2}depth":
                                    tmp.update({'depth': field2[0].text})
                        # Get magnitude
                        elif field.tag == "{http://quakeml.org/xmlns/bed/1.2}magnitude":
                            for field2 in field:
                                if field2.tag == "{http://quakeml.org/xmlns/bed/1.2}mag":
                                    tmp.update({'magnitude': field2[0].text})

                    # Append the new event
                    rv['events'].append(tmp)

        # Return final JSON
        return rv
