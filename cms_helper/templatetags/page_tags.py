# -*- coding: utf-8 -*-
from django import template
import datetime
from cms.models.pagemodel import Page
from django.template.context import Context
from gcsgroupwww.settings import STATIC_URL

register = template.Library()
    
@register.simple_tag
def get_copyright(value):
    return u'© %s—%s' % (value, datetime.datetime.now().year)

@register.inclusion_tag('includes/page_list.html')
def get_pages(value):
    pages = Page.objects.filter(parent__reverse_id=value)
    result = []
    for page in pages:
        obj = {
               'title': page.get_title() ,
               'description': page.get_title_obj_attribute('meta_description') , 
               'url': page.get_absolute_url()
               }     
        result.append(obj)       
    return {'page_list': result}
    
@register.filter()
def human_lang(lang):    
    from django.utils.translation import get_language
    postfix = '_'        
    if get_language() == lang:
        postfix = ''            
    mapper = {'en': (u'English language', 'lang_eng'), 'ru': (u'Русская версия', 'lang_rus'), 'zh-cn': (u'China language', 'lang_china')}
    from django.template import Template
    t = Template('<img src="{{ STATIC_URL }}ruscon/images/{{ url }}{{ postfix }}.{{ ext }}" alt="{{ hint }}" title="{{ hint }}">')
    c = Context({
                 'STATIC_URL': STATIC_URL,
                 'url': mapper[lang][1],
                 'hint': mapper[lang][0],
                 'postfix': postfix,
                 'ext': 'gif'
                 })    
    return t.render(c) 
