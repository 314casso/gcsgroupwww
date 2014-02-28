from modeltranslation.translator import translator, TranslationOptions
from zinnia import models as zinnia_models 
from rdoc.models import DocCategory, Doc

 
class ZinniaEntryTranslationOptions(TranslationOptions):
    fields = ('title', 'content', 'excerpt')
 
class ZinniaCategoryTranslationOptions(TranslationOptions):
    fields = ('title', 'description')

class DocCategoryTranslationOptions(TranslationOptions):
    fields = ('title',)
 
class DocTranslationOptions(TranslationOptions):
    fields = ('title', 'description')
 
translator.register(zinnia_models.Entry, ZinniaEntryTranslationOptions)
translator.register(zinnia_models.Category, ZinniaCategoryTranslationOptions)

translator.register(DocCategory, DocCategoryTranslationOptions)
translator.register(Doc, DocTranslationOptions)