from django.contrib import admin
from .models import Damage, User
from django.utils.translation import ugettext_lazy as _


class DamageAdmin(admin.ModelAdmin):
    list_display = ('user', 'lat', 'lon', 'date')
    search_fields = ['user__username', 'dat']


class UserAdmin(admin.ModelAdmin):
    list_display = ('username', 'email', 'is_enabled')
    search_fields = ('username', 'email')
    actions = ['enable_account', 'disable_account']

    # Enable account function
    def enable_account(modeladmin, request, queryset):
        rows_updated = queryset.update(enabled=True)
        if rows_updated == 1:
            message = _("1_account_enabled")
        else:
            message = _("%s_accounts_enabled") % rows_updated
        modeladmin.message_user(request, message)
    enable_account.short_description = _("enable_accounts")

    # Disable account function
    def disable_account(modeladmin, request, queryset):
        rows_updated = queryset.update(enabled=False)
        if rows_updated == 1:
            message = _("1_account_disabled")
        else:
            message = _("%s_accounts_disabled") % rows_updated
        modeladmin.message_user(request, message)
    disable_account.short_description = _("disable_accounts")


admin.site.register(Damage, DamageAdmin)
admin.site.register(User, UserAdmin)
