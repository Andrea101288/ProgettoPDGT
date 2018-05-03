from django.db import models
from django.utils.translation import ugettext_lazy as _


class Damage(models.Model):
    user = models.ForeignKey('User', on_delete=models.CASCADE, verbose_name=_("user"))

    # Position
    lat = models.FloatField(verbose_name=_("latitude"))
    lon = models.FloatField(verbose_name=_("longitude"))

    # Date & time
    date = models.DateTimeField(verbose_name=_("date"))

    # Damage image
    damage_photo = models.ImageField(verbose_name=_("photo"), blank=True)

    # Damage description
    damage_dsc = models.TextField(verbose_name=_("dsc"), blank=True)


class User(models.Model):
    # User credentials
    username = models.CharField(primary_key=True, max_length=128, verbose_name=_("username"))
    password = models.CharField(max_length=128, verbose_name=_("password"))
    email = models.CharField(max_length=128, verbose_name=_("email"))

    # User state
    enabled = models.BooleanField(default=True, verbose_name=_("enabled"))

    def is_enabled(self):
        return self.enabled

    # Set boolean icon and description
    is_enabled.boolean = True
    is_enabled.short_description = _("enabled")


class NotificationArea(models.Model):
    # Owner username
    owner = models.ForeignKey('User', on_delete=models.CASCADE, verbose_name=_("username"))

    # Position
    lat = models.FloatField(verbose_name=_("latitude"), blank=True)
    lon = models.FloatField(verbose_name=_("longitude"), blank=True)

    # Search radius
    rad = models.FloatField(verbose_name=_("radius"), blank=True)
