import urllib
from datetime import datetime, timedelta
from django.views import generic
from django.http import JsonResponse
# from .models import Damage, User, TelegramUser
from .country.all import COUNTRY_LIST

class Earthquakes(generic.View):
    # This value is used to determinate the default period to search
    default_days_delta = 7

    def get(self, request, country):
        # Return value
        rv = {}

        # Check if reqeusted country in implemented
        if country in COUNTRY_LIST.keys():
            # Get requested country data
            req_country = COUNTRY_LIST[country]()

            # Get current date
            today = datetime.now()

            # Get delta date
            the_other_day = today - timedelta(days=self.default_days_delta)

            # URL encode
            today = urllib.parse.quote_plus(today.isoformat())
            the_other_day = urllib.parse.quote_plus(the_other_day.isoformat())

            # Request and parse in JSON
            rv = req_country.return_json(the_other_day, today)

        return JsonResponse(rv)
