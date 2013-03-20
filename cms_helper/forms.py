from django import forms
from cmsplugin_contact.forms import ContactForm
from cms.plugins.text.models import Text
from django.forms.models import ModelForm

class CustomContactForm(ContactForm):
    name = forms.CharField()    
    town = forms.CharField(required=False)
    phone = forms.CharField(required=False)


class PlainTextForm(ModelForm):
    body = forms.Textarea()    
    class Meta:
        model = Text
        exclude = ('page', 'position', 'placeholder', 'language', 'plugin_type')    
    
    
