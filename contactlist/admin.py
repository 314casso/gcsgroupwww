from django.contrib import admin
from contactlist.models import Contact, Partner
from modeltranslation.admin import TranslationAdmin
from cms_helper.admin import ModelTranslationMedia
from orderedmodel.admin import OrderedModelAdmin

class ContactAdmin(TranslationAdmin, ModelTranslationMedia, OrderedModelAdmin):
    list_display = ('first_name', 'last_name', 'post', 'reorder')    

class PartnerAdmin(TranslationAdmin, ModelTranslationMedia, OrderedModelAdmin):
    list_display = ('title', 'reorder')    


admin.site.register(Contact,ContactAdmin)
admin.site.register(Partner,PartnerAdmin)