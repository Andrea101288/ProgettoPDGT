"""
Basic country class
"""
from abc import ABCMeta


class BasicCountry(metaclass=ABCMeta):
    def __init__(self):
        """
        Costructor
        """
        self.url = "http://example.org/"

    def return_json(self, start_date, end_date):
        """
        Return JSON formatted data
        To be implemented in child class
        """
        raise NotImplemented
