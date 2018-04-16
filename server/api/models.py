from django.db import models
from django.utils.translation import ugettext_lazy as _


class Damage(models.Model):
    user = models.ForeignKey('User', on_delete=models.CASCADE)

    # Position
    lat = models.IntegerField(verbose_name=_("latitude"))
    lon = models.IntegerField(verbose_name=_("longitude"))

    # Date & time
    date = models.DateTimeField(verbose_name=_("date"))

    # Earthquake ID
    earthquake_id = models.IntegerField(verbose_name=_("earthquake_id"))

    # Damage image
    damage_photo = models.ImageField(verbose_name=_("photo"))


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
