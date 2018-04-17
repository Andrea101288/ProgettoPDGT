from django.urls import path
from . import views

urlpatterns = [
    path('terremoti/<slug:country>', views.Earthquakes.as_view(), name='earthquake'),
]
