from django.urls import path
from . import views

urlpatterns = [
    path('earthquakes/<slug:country>', views.EarthquakesView.as_view(), name='earthquake'),
    path('damages/', views.DamagesView.as_view(), name='damages'),
]
