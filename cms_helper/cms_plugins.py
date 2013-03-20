from django.utils.translation import ugettext_lazy as _
from django.core.mail import EmailMessage
from django.template.loader import render_to_string

from cms.plugin_pool import plugin_pool

from cmsplugin_contact.cms_plugins import ContactPlugin
from models import CustomContact
from forms import CustomContactForm
from cmsplugin_filer_folder.cms_plugins import FilerFolderPlugin
from cmsplugin_zinnia.cms_plugins import CMSQueryEntriesPlugin
from zinnia.models.entry import Entry
from rusconwww.local_settings import DEFAULT_FROM_EMAIL
from django.core.paginator import Paginator, PageNotAnInteger, EmptyPage

class CustomContactPlugin(ContactPlugin):
    name = _("Custom Contact Form")
    
    model = CustomContact
    contact_form = CustomContactForm
    
    # We're using the original cmsplugin_contact templates here which
    # works fine but requires that the original plugin is in INSTALLED_APPS.
    render_template = "cmsplugin_contact/contact.html"
    email_template = "cmsplugin_contact/email.txt"
    
    def send(self, form, site_email):
        subject = form.cleaned_data['subject']
        if not subject:
            subject = _('No subject')
        email_message = EmailMessage(
            render_to_string(self.subject_template, {
                'subject': subject,
            }).splitlines()[0],
            render_to_string(self.email_template, {
                'data': form.cleaned_data,
            }),
            DEFAULT_FROM_EMAIL,
            [site_email],
            headers = {
                'Reply-To': form.cleaned_data['email']
            },)
        email_message.send(fail_silently=False)
    
    fieldsets = (
        (None, {
                'fields': ('site_email', 'name_label', 'email_label',  'phone_label', 'town_label', 
                           'subject_label', 'content_label', 'thanks',
                           'submit'),
        }),
        (_('Spam Protection'), {
                'fields': ('spam_protection_method', 'akismet_api_key',
                           'recaptcha_public_key', 'recaptcha_private_key',
                           'recaptcha_theme')
        })
    )
    
plugin_pool.register_plugin(CustomContactPlugin)

class FilerGalleryPlugin(FilerFolderPlugin):
    name = _("Gallery")
    render_template = "cmsplugin_filer_folder/gallery.html"
    
plugin_pool.register_plugin(FilerGalleryPlugin)

class CMSCategoryEntriesPlugin(CMSQueryEntriesPlugin):
    name = _('Category entries')
    def render(self, context, instance, placeholder):
        """Update the context with plugin's data"""
        entries = Entry.published.filter(categories__id__in=[instance.query]) #@UndefinedVariable
        if instance.number_of_entries:
            entries = entries[:instance.number_of_entries]
        
        paginator = Paginator(entries, 10)  
        self.request = context['request']          
        page = self.request.GET.get('page')
        try:
            objects = paginator.page(page)
        except PageNotAnInteger:        
            objects = paginator.page(1)
        except EmptyPage:        
            objects = paginator.page(paginator.num_pages)        
        context.update({
                'paginator': paginator,
                'page_obj': objects,
                'is_paginated': objects.has_other_pages(),
                'entries': objects.object_list
            })  
        return context  
        context.update({
                        'object': instance,
                        'placeholder': placeholder})
        return context

plugin_pool.register_plugin(CMSCategoryEntriesPlugin)
    