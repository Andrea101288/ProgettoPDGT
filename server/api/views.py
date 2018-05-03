import json
import urllib
from datetime import datetime, timedelta
from dateutil.parser import parse
from django.views import generic
from django.http import JsonResponse, HttpResponse
from django.views.decorators.csrf import csrf_exempt
from django.shortcuts import get_object_or_404
from .models import Damage, User, NotificationArea
from .country.all import COUNTRY_LIST


class EarthquakesView(generic.View):
    # This value is used to determinate the default period to search
    default_days_delta = 30

    def get(self, request, country):
        # Check if reqeusted country in implemented
        if country in COUNTRY_LIST.keys():
            # Get requested country data
            req_country = COUNTRY_LIST[country]()

            # Get requested ID
            if request.GET.get('id') is None:
                # Get current date
                search_id = ""
            else:
                search_id = request.GET.get('id')

            # Get requested ID
            if request.GET.get('timeout') is None:
                # Get current date
                timeout = None
            else:
                timeout = int(request.GET.get('timeout'))

            # Get period to seach
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

            # Check if user set latitude, longitude and radius
            if request.GET.get('lon') is not None and\
               request.GET.get('lat') is not None and\
               request.GET.get('rad') is not None:

                # Get position
                lon = float(request.GET.get('lon'))
                lat = float(request.GET.get('lat'))
                rad = float(request.GET.get('rad'))

                # Request and parse in JSON with position filter
                rv = req_country.return_json(from_day, to_day, lon, lat, rad)
            elif request.GET.get('id') is not None:
                # Search for given ID earthquake
                rv = req_country.search_event(search_id, timeout)
            else:
                # Request and parse in JSON
                rv = req_country.return_json(from_day, to_day)

        return JsonResponse(rv)


class DamagesView(generic.View):
    def get(self, request):
        rv = {}

        for damage in Damage.objects.all():
            rv[str(damage.user)] = 2

        return JsonResponse(rv)

    def post(self, request):
        obj = Damage()

        # Parse request body
        body_unicode = request.body.decode('utf-8')
        body = json.loads(body_unicode)

        # Get user
        obj.user = get_object_or_404(User, pk=body['user'])

        # Get coordinates
        obj.lat = body['lat']
        obj.lon = body['lon']

        # Get date
        obj.date = datetime.now()

        # Get info
        obj.damage_photo = body['photo']
        obj.damage_dsc = body['dsc']

        obj.save()

        return HttpResponse('OK')

    @csrf_exempt
    def dispatch(self, *args, **kwargs):
        return super(DamagesView, self).dispatch(*args, **kwargs)
