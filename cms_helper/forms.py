from django import forms
from cmsplugin_contact.forms import ContactForm

class CustomContactForm(ContactForm):
    name = forms.CharField()    
    town = forms.CharField(required=False)
    phone = forms.CharField(required=False)