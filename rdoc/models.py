# -*- coding: utf-8 -*-
from django.db import models
from django.utils.translation import ugettext_lazy as _
import datetime
from rdoc.util import attachment_path

class DocCategory(models.Model):
    """
    Doc category    
    """
    title = models.CharField(
        _('Title'),
        help_text=_('Document category title'),
        max_length=255,
        )
    def __unicode__(self):
        return u"%s" % self.title
    
    class Meta:
        verbose_name = _('document category')
        verbose_name_plural = _('document categories')
        ordering = ('title',)   

class Doc(models.Model):
    """
    Docs for site
    """

    title = models.CharField(
        _('Title'),
        help_text=_('Document title'),
        max_length=255,
        )

    desciption = models.CharField(
        _('Description'),
        help_text=_('Document description'),
        max_length=500,
        blank=True,
        null=True,
        )
    
    issue_date = models.DateField(
        _('Date'),
        help_text=_('Document date'),
        blank=True,
        null=True,
        )
    
    attachment = models.FileField(
        _('Attachment'),
        help_text=_('Document attachment'),
        upload_to=attachment_path,
    )
    
    pub_date = models.DateField(
        _('Modification date'),
        help_text=_('Document modification date'),
        default=datetime.date.today(),
        )    
        
    doc_category = models.ForeignKey(DocCategory)
    
    def __unicode__(self):
        return u"%s" % self.title
    
    def get_info(self):
        info =  '%s: %s\n' % (unicode(_('Title')), self.title)
        if self.desciption:
            info += '%s: %s\n' % (unicode(_('Description')), self.desciption)
        if self.issue_date:    
            info += '%s: %s\n' % (unicode(_('Date')), self.issue_date.strftime('%d.%m.%Y'))  
        info += '%s: %s\n' % ('id', self.id)
        return info

    class Meta:
        verbose_name = _('document entry')
        verbose_name_plural = _('document entries')
        ordering = ('-issue_date', 'title',)                
