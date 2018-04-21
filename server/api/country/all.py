"""
List of implemented coutries
"""
from .italy import Italy
from .usa import Usa
from .latest_world import LatestWorld

COUNTRY_LIST = {
    'italy': Italy,
    'usa': Usa,
    'latest_world': LatestWorld
}
