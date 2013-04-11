from modeltranslation.translator import translator, TranslationOptions
from contactlist.models import Contact, Partner
 
class ContactlistTranslationOptions(TranslationOptions):
    fields = ('first_name', 'last_name', 'middle_name', 'post')
    
class PartnerTranslationOptions(TranslationOptions):
    fields = ('title', 'description' )
 
translator.register(Contact, ContactlistTranslationOptions)
translator.register(Partner, PartnerTranslationOptions)