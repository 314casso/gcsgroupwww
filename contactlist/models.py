from django.db import models
from filer.fields.image import FilerImageField
from django.utils.translation import ugettext_lazy as _
from modeltranslation.utils import get_language
from orderedmodel.models import OrderedModel

class BaseList(models.Model):
    published = models.BooleanField(_('Published'), default=True)    
    image = FilerImageField(blank=True, null=True)
    class Meta:
        abstract = True    

class Contact(OrderedModel, BaseList):
    last_name = models.CharField(_('Last name'), max_length=50)
    first_name = models.CharField(_('First name'), max_length=50)        
    middle_name = models.CharField(_('Middle name'), max_length=50)
    post = models.CharField(_('Job'), max_length=50)    
    @property
    def fio(self):        
        if get_language() == 'ru':
            return '%s %s %s' % (self.last_name, self.first_name, self.middle_name)
        else:
            return '%s %s. %s' % (self.first_name, str(self.middle_name)[:1] , self.last_name)
    
class Partner(OrderedModel, BaseList):
    title = models.CharField(_('Title'), max_length=150)
    description = models.TextField(_('Description'))
    url = models.URLField(_('Web site'))             
    
    