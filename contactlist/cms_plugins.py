from cms.plugin_base import CMSPluginBase
from cms.models.pluginmodel import CMSPlugin
from contactlist.models import Contact, Partner
from django.core.paginator import Paginator, PageNotAnInteger, EmptyPage
from cms.plugin_pool import plugin_pool
from django.utils.translation import ugettext_lazy as _
from django.contrib.sites.models import Site

class BaseListPlugin(CMSPluginBase):
    model = CMSPlugin
    name = None
    render_template = None
    limit = 10
    
    def get_qset(self):
        raise 'You must implement %s!' % 'get_qset'
    
    def render(self, context, instance, placeholder):
        entries = self.get_qset(instance=instance)
                    
        paginator = Paginator(entries, self.limit)  
        self.request = context['request']          
        page = self.request.GET.get('page')
        try:
            objects = paginator.page(page)
        except PageNotAnInteger:        
            objects = paginator.page(1)
        except EmptyPage:        
            objects = paginator.page(paginator.num_pages)
            
        current_site = Site.objects.get_current()                
        context.update({
                'paginator': paginator,
                'page_obj': objects,
                'is_paginated': objects.has_other_pages(),
                'entries': objects.object_list,
                'domain' : current_site.domain,
            })  
        return context  
        context.update({
                        'object': instance,
                        'placeholder': placeholder})
        return context


class ContactlistPlugin(BaseListPlugin):
    model = CMSPlugin
    name = _("Persons")
    render_template = "contactlist/person.html"

    def get_qset(self, **kwargs):
        return Contact.objects.filter(published=True)
    
class PartnerPlugin(BaseListPlugin):
    model = CMSPlugin
    name = _("Partners")
    render_template = "contactlist/partner.html"

    def get_qset(self, **kwargs):
        return Partner.objects.filter(published=True)    

plugin_pool.register_plugin(ContactlistPlugin)    
plugin_pool.register_plugin(PartnerPlugin)
