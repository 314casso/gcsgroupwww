from django.contrib import admin
from zinnia import models as zinnia_models
from zinnia import admin as zinnia_admin
from modeltranslation.admin import TranslationAdmin
from cms_helper.models import ClockTown, MenuImage
from orderedmodel.admin import OrderedModelAdmin
from zinnia.models.author import Author
from django.utils import timezone
from django.utils.text import Truncator
from django.utils.html import strip_tags
from zinnia.managers import PUBLISHED
from sitetree.admin import TreeItemAdmin, TreeAdmin, override_item_admin
from sitetree.models import Tree, TreeItem
from django.utils.translation import ugettext_lazy as _

class ModelTranslationMedia(object):    
    class Media:
        js = (
            'modeltranslation/js/force_jquery.js',
            'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.24/jquery-ui.min.js',
            'modeltranslation/js/tabbed_translation_fields.js',
            'ruscon/js/wymeditor.js'
        )
        css = {
            'screen': ('modeltranslation/css/tabbed_translation_fields.css',),
        } 

class ZinniaEntryTranslatedAdmin(zinnia_admin.EntryAdmin, TranslationAdmin, ModelTranslationMedia):
    fieldsets = ((_('Content'), {'fields': ('title', 'excerpt', 'content',
                                            'image', 'status')}),
                 (_('Options'), {'fields': ('featured', 
                                            'related', 'authors',
                                            'creation_date',
                                            'start_publication',
                                            'end_publication'),
                                 'classes': ('collapse', 'collapse-closed')}),
                 (_('Privacy'), {'fields': ('password', 'login_required',),
                                 'classes': ('collapse', 'collapse-closed')}),
                 (_('Discussions'), {'fields': ('comment_enabled',
                                                'pingback_enabled',
                                                'trackback_enabled'),
                                     'classes': ('collapse',
                                                 'collapse-closed')}),
                 (_('Publication'), {'fields': ('categories', 'tags',
                                                'sites', 'slug')}))

    list_display = ('title',)
    def formfield_for_dbfield(self, db_field, **kwargs):
        field = super(ZinniaEntryTranslatedAdmin, self).formfield_for_dbfield(db_field, **kwargs)
        self.patch_translation_field(db_field, field, **kwargs)
        return field
    def save_model(self, request, entry, form, change):
        """Save the authors, update time, make an excerpt"""
        
        if not entry.excerpt and entry.status == PUBLISHED:
            entry.excerpt = Truncator(strip_tags(entry.content)).words(50)        

        if entry.pk and not request.user.has_perm('zinnia.can_change_author'):
            form.cleaned_data['authors'] = entry.authors.all()

        if not form.cleaned_data.get('authors'):
            form.cleaned_data['authors'] = Author.objects.filter(
                pk=request.user.pk)

        entry.last_update = timezone.now()
        entry.save()
 
class ZinniaCategoryTranslatedAdmin(zinnia_admin.CategoryAdmin, TranslationAdmin, ModelTranslationMedia):
    list_display = ('title',)
    def formfield_for_dbfield(self, db_field, **kwargs):
        field = super(ZinniaCategoryTranslatedAdmin, self).formfield_for_dbfield(db_field, **kwargs)
        self.patch_translation_field(db_field, field, **kwargs)
        return field

class ClockTownTranslatedAdmin(TranslationAdmin, ModelTranslationMedia, OrderedModelAdmin):
    list_display = ('town', 'reorder')
  
admin.site.unregister(zinnia_models.Entry)
admin.site.unregister(zinnia_models.Category)
admin.site.register(zinnia_models.Entry, ZinniaEntryTranslatedAdmin)
admin.site.register(zinnia_models.Category, ZinniaCategoryTranslatedAdmin)
admin.site.register(ClockTown, ClockTownTranslatedAdmin)


class TreeItemTranslatedAdmin(TreeItemAdmin, TranslationAdmin, ModelTranslationMedia):
    pass

override_item_admin(TreeItemTranslatedAdmin)
admin.site.register(MenuImage)
