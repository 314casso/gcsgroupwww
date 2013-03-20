from django.db import models
from django.utils.translation import ugettext_lazy as _
from cmsplugin_contact.models import BaseContact

class CustomContact(BaseContact):
    name_label = models.CharField(_('Name'), default=_('Your name'), max_length=100)
    phone_label = models.CharField(_('Phone'), default=_('Phone'), max_length=30)            
    town_label = models.CharField(_('Town'), default=_('Town'), max_length=30)     