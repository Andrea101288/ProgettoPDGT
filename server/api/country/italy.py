"""
Italy Earthquakes info from ingv.it
"""
import requests
import xml.etree.ElementTree
from datetime import datetime, timedelta
from .basic_country import BasicCountry


class Italy(BasicCountry):
    def __init__(self):
        """
        Costructor
        """
        # URL where get raw data
        self.url = "http://webservices.ingv.it/fdsnws/event/1/query?starttime={0}&endtime={1}&minmag=2&maxmag=10"

    def return_json(self, start_date, end_date, lon=None, lat=None, rad=None):
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
            try:
                # Parse XML
                e = xml.etree.ElementTree.fromstring(r.text)
            except xml.etree.ElementTree.ParseError:
                return rv

            # Get last update_time
            rv['updated'] = e[0][0][4][2].text

            # Set data type
            rv['type'] = 'FeatureCollection'

            # Init events array in JSON
            rv['features'] = []

            # Loop on events
            for event in e[0]:
                if event.tag == "{http://quakeml.org/xmlns/bed/1.2}event":
                    # Init temporary object
                    tmp = {}

                    # Set data type
                    tmp['type'] = 'Feature'

                    # Init more stuff
                    tmp['properties'] = {}
                    tmp['geometry'] = {}
                    tmp['geometry'].update({'type': 'Point'})
                    tmp['geometry']['coordinates'] = []

                    # Get event ID
                    event_id = event.attrib['publicID'].split('?eventId=')[1]
                    tmp.update({'id': event_id})

                    for field in event:
                        # Get description
                        if field.tag == "{http://quakeml.org/xmlns/bed/1.2}description":
                            tmp['properties'].update({'description': field[1].text})
                        # Get information from origin
                        elif field.tag == "{http://quakeml.org/xmlns/bed/1.2}origin":
                            for field2 in field:
                                if field2.tag == "{http://quakeml.org/xmlns/bed/1.2}time":
                                    tmp['properties'].update({'time': field2[0].text})
                                elif field2.tag == "{http://quakeml.org/xmlns/bed/1.2}latitude":
                                    tmp['geometry']['coordinates'].append(float(field2[0].text))
                                    tmp_lat = float(field2[0].text)
                                elif field2.tag == "{http://quakeml.org/xmlns/bed/1.2}longitude":
                                    tmp['geometry']['coordinates'].append(float(field2[0].text))
                                    tmp_lon = float(field2[0].text)
                                elif field2.tag == "{http://quakeml.org/xmlns/bed/1.2}depth":
                                    tmp['properties'].update({'depth': field2[0].text})
                        # Get magnitude
                        elif field.tag == "{http://quakeml.org/xmlns/bed/1.2}magnitude":
                            for field2 in field:
                                if field2.tag == "{http://quakeml.org/xmlns/bed/1.2}mag":
                                    tmp['properties'].update({'magnitude': field2[0].text})

                    # Reverse coordinates to have lon-lat standard
                    tmp['geometry']['coordinates'].reverse()

                    if rad is not None and lon is not None and lat is not None:
                        if self.is_in_range(lon, lat, tmp_lon, tmp_lat, rad):
                            # Append the new event
                            rv['features'].append(tmp)
                    else:
                        # Append the new event
                        rv['features'].append(tmp)

        # Return final JSON
        return rv

    def search_event(self, search_id, timeout=12):
        """
        Search and event looping months X time (timeout)
        """
        # Exit condition
        not_found = True

        # Start date
        to_day = datetime.now()

        # Init empty JSON
        rv = {}

        while not_found and timeout:
            from_day = to_day - timedelta(days=30)

            url = self.url.format(from_day, to_day)

            # Do request
            r = requests.get(url)

            # Check status
            if r.status_code == 200:
                try:
                    # Parse XML
                    e = xml.etree.ElementTree.fromstring(r.text)
                except xml.etree.ElementTree.ParseError:
                    continue

                # Get last update_time
                rv['updated'] = e[0][0][4][2].text

                # Set data type
                rv['type'] = 'FeatureCollection'

                # Init events array in JSON
                rv['features'] = []

                # Loop on events
                for event in e[0]:
                    if event.tag == "{http://quakeml.org/xmlns/bed/1.2}event":
                        # Init temporary object
                        tmp = {}

                        # Set data type
                        tmp['type'] = 'Feature'

                        # Init more stuff
                        tmp['properties'] = {}
                        tmp['geometry'] = {}
                        tmp['geometry'].update({'type': 'Point'})
                        tmp['geometry']['coordinates'] = []

                        # Get event ID
                        event_id = event.attrib['publicID'].split('?eventId=')[1]
                        tmp.update({'id': event_id})

                        # Check if is the correct one
                        if search_id == event_id:
                            for field in event:
                                # Get description
                                if field.tag == "{http://quakeml.org/xmlns/bed/1.2}description":
                                    tmp['properties'].update({'description': field[1].text})
                                # Get information from origin
                                elif field.tag == "{http://quakeml.org/xmlns/bed/1.2}origin":
                                    for field2 in field:
                                        if field2.tag == "{http://quakeml.org/xmlns/bed/1.2}time":
                                            tmp['properties'].update({'time': field2[0].text})
                                        elif field2.tag == "{http://quakeml.org/xmlns/bed/1.2}latitude":
                                            tmp['geometry']['coordinates'].append(float(field2[0].text))
                                        elif field2.tag == "{http://quakeml.org/xmlns/bed/1.2}longitude":
                                            tmp['geometry']['coordinates'].append(float(field2[0].text))
                                        elif field2.tag == "{http://quakeml.org/xmlns/bed/1.2}depth":
                                            tmp['properties'].update({'depth': field2[0].text})
                                # Get magnitude
                                elif field.tag == "{http://quakeml.org/xmlns/bed/1.2}magnitude":
                                    for field2 in field:
                                        if field2.tag == "{http://quakeml.org/xmlns/bed/1.2}mag":
                                            tmp['properties'].update({'magnitude': field2[0].text})

                            # Reverse coordinates to have lon-lat standard
                            tmp['geometry']['coordinates'].reverse()

                            # Append the new event
                            rv['features'].append(tmp)

                            # Exit while
                            not_found = False

            # Set new date to search
            to_day = from_day
            timeout -= 1

        return rv

        # Redefine father class function
        def is_in_range(self, lon1, lat1, lon2, lat2, radius):
            return super(Italy, self).is_in_range(lon1, lat1, lon2, lat2, radius)
