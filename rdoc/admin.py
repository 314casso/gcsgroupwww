from django.contrib import admin

from django.contrib.admin.models import LogEntry
from rdoc.models import Doc, DocCategory

class LogEntryAdmin(admin.ModelAdmin):
    list_display = ('action_time', 'user', 'action_flag', 'change_message', )

admin.site.register(LogEntry,LogEntryAdmin)
    

class DocAdmin(admin.ModelAdmin):
    list_display = ('issue_date', 'title', 'desciption', )    
    list_filter = ('title', 'desciption', )
    fields = ['issue_date', 'title', 'desciption','attachment']
    
class DocCategoryAdmin(admin.ModelAdmin):
    list_display = ('title',)   
    fields = ['title',]    

admin.site.register(Doc,DocAdmin)
admin.site.register(DocCategory,DocCategoryAdmin)