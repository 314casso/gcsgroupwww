from django.contrib import admin

from django.contrib.admin.models import LogEntry
from rdoc.models import Doc, DocCategory
from cms_helper.admin import ModelTranslationMedia
from modeltranslation.admin import TranslationAdmin

class LogEntryAdmin(admin.ModelAdmin):
    list_display = ('action_time', 'user', 'action_flag', 'change_message', )

admin.site.register(LogEntry,LogEntryAdmin)
    

class DocAdmin(TranslationAdmin, ModelTranslationMedia):
    list_display = ('issue_date', 'title', 'description', )    
    list_filter = ('doc_category__title', )
    search_fields = ['title', 'description']
    fields = ['issue_date', 'title', 'doc_category','description','attachment']
    
class DocCategoryAdmin(TranslationAdmin, ModelTranslationMedia):
    list_display = ('title',)   
    fields = ['title',]    

admin.site.register(Doc,DocAdmin)
admin.site.register(DocCategory,DocCategoryAdmin)