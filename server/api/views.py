import urllib
from datetime import datetime, timedelta
from dateutil.parser import parse
from django.views import generic
from django.http import JsonResponse
# from .models import Damage, User, TelegramUser
from .country.all import COUNTRY_LIST


class Earthquakes(generic.View):
    # This value is used to determinate the default period to search
    default_days_delta = 7

    def get(self, request, country):
        # Check if reqeusted country in implemented
        if country in COUNTRY_LIST.keys():
            # Get requested country data
            req_country = COUNTRY_LIST[country]()

            if request.GET.get('endtime') is None:
                # Get current date
                to_day = datetime.now()
            else:
                # Set the date request by user
                to_day = parse(request.GET.get('endtime'))

            if request.GET.get('starttime') is None:
                # Get delta date
                from_day = to_day - timedelta(days=self.default_days_delta)
            else:
                # Set the date request by user
                from_day = parse(request.GET.get('starttime'))

            # URL encode
            to_day = urllib.parse.quote_plus(to_day.isoformat())
            from_day = urllib.parse.quote_plus(from_day.isoformat())

            # Request and parse in JSON
            rv = req_country.return_json(from_day, to_day)

        return JsonResponse(rv)
