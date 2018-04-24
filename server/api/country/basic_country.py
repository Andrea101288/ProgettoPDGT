"""
Basic country class
"""
from abc import ABCMeta
from math import radians, cos, sin, asin, sqrt


class BasicCountry(metaclass=ABCMeta):
    def __init__(self):
        """
        Costructor
        """
        self.url = "http://example.org/"

    def return_json(self, start_date, end_date, lon=None, lat=None, rad=None):
        """
        Return JSON formatted data
        To be implemented in child class
        """
        raise NotImplemented

    def search_event(self, search_id, timeout=12):
        """
        Search and event looping months X time (timeout)
        """
        raise NotImplemented

    def is_in_range(self, lon1, lat1, lon2, lat2, radius):
        """
        Calculate the great circle distance between two points
        on the earth (specified in decimal degrees)
        """
        # Convert decimal degrees to radians
        lon1, lat1, lon2, lat2 = map(radians, [lon1, lat1, lon2, lat2])

        # Haversine formula
        dlon = lon2 - lon1
        dlat = lat2 - lat1
        a = sin(dlat/2)**2 + cos(lat1) * cos(lat2) * sin(dlon/2)**2
        c = 2 * asin(sqrt(a))

        # Distance between 2 points
        km = 6371 * c

        return km <= radius
