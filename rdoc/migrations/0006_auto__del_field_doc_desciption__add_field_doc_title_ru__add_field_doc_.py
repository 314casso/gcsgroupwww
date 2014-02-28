# -*- coding: utf-8 -*-
import datetime
from south.db import db
from south.v2 import SchemaMigration
from django.db import models


class Migration(SchemaMigration):

    def forwards(self, orm):
        # Deleting field 'Doc.desciption'
        db.delete_column('rdoc_doc', 'desciption')

        # Adding field 'Doc.title_ru'
        db.add_column('rdoc_doc', 'title_ru',
                      self.gf('django.db.models.fields.CharField')(max_length=255, null=True, blank=True),
                      keep_default=False)

        # Adding field 'Doc.title_en'
        db.add_column('rdoc_doc', 'title_en',
                      self.gf('django.db.models.fields.CharField')(max_length=255, null=True, blank=True),
                      keep_default=False)

        # Adding field 'Doc.title_zh_cn'
        db.add_column('rdoc_doc', 'title_zh_cn',
                      self.gf('django.db.models.fields.CharField')(max_length=255, null=True, blank=True),
                      keep_default=False)

        # Adding field 'Doc.description'
        db.add_column('rdoc_doc', 'description',
                      self.gf('django.db.models.fields.CharField')(max_length=500, null=True, blank=True),
                      keep_default=False)

        # Adding field 'Doc.description_ru'
        db.add_column('rdoc_doc', 'description_ru',
                      self.gf('django.db.models.fields.CharField')(max_length=500, null=True, blank=True),
                      keep_default=False)

        # Adding field 'Doc.description_en'
        db.add_column('rdoc_doc', 'description_en',
                      self.gf('django.db.models.fields.CharField')(max_length=500, null=True, blank=True),
                      keep_default=False)

        # Adding field 'Doc.description_zh_cn'
        db.add_column('rdoc_doc', 'description_zh_cn',
                      self.gf('django.db.models.fields.CharField')(max_length=500, null=True, blank=True),
                      keep_default=False)

        # Adding field 'DocCategory.title_ru'
        db.add_column('rdoc_doccategory', 'title_ru',
                      self.gf('django.db.models.fields.CharField')(max_length=255, null=True, blank=True),
                      keep_default=False)

        # Adding field 'DocCategory.title_en'
        db.add_column('rdoc_doccategory', 'title_en',
                      self.gf('django.db.models.fields.CharField')(max_length=255, null=True, blank=True),
                      keep_default=False)

        # Adding field 'DocCategory.title_zh_cn'
        db.add_column('rdoc_doccategory', 'title_zh_cn',
                      self.gf('django.db.models.fields.CharField')(max_length=255, null=True, blank=True),
                      keep_default=False)


    def backwards(self, orm):
        # Adding field 'Doc.desciption'
        db.add_column('rdoc_doc', 'desciption',
                      self.gf('django.db.models.fields.CharField')(max_length=500, null=True, blank=True),
                      keep_default=False)

        # Deleting field 'Doc.title_ru'
        db.delete_column('rdoc_doc', 'title_ru')

        # Deleting field 'Doc.title_en'
        db.delete_column('rdoc_doc', 'title_en')

        # Deleting field 'Doc.title_zh_cn'
        db.delete_column('rdoc_doc', 'title_zh_cn')

        # Deleting field 'Doc.description'
        db.delete_column('rdoc_doc', 'description')

        # Deleting field 'Doc.description_ru'
        db.delete_column('rdoc_doc', 'description_ru')

        # Deleting field 'Doc.description_en'
        db.delete_column('rdoc_doc', 'description_en')

        # Deleting field 'Doc.description_zh_cn'
        db.delete_column('rdoc_doc', 'description_zh_cn')

        # Deleting field 'DocCategory.title_ru'
        db.delete_column('rdoc_doccategory', 'title_ru')

        # Deleting field 'DocCategory.title_en'
        db.delete_column('rdoc_doccategory', 'title_en')

        # Deleting field 'DocCategory.title_zh_cn'
        db.delete_column('rdoc_doccategory', 'title_zh_cn')


    models = {
        'rdoc.doc': {
            'Meta': {'ordering': "('-issue_date', 'title')", 'object_name': 'Doc'},
            'attachment': ('django.db.models.fields.files.FileField', [], {'max_length': '100'}),
            'description': ('django.db.models.fields.CharField', [], {'max_length': '500', 'null': 'True', 'blank': 'True'}),
            'description_en': ('django.db.models.fields.CharField', [], {'max_length': '500', 'null': 'True', 'blank': 'True'}),
            'description_ru': ('django.db.models.fields.CharField', [], {'max_length': '500', 'null': 'True', 'blank': 'True'}),
            'description_zh_cn': ('django.db.models.fields.CharField', [], {'max_length': '500', 'null': 'True', 'blank': 'True'}),
            'doc_category': ('django.db.models.fields.related.ForeignKey', [], {'to': "orm['rdoc.DocCategory']"}),
            'id': ('django.db.models.fields.AutoField', [], {'primary_key': 'True'}),
            'issue_date': ('django.db.models.fields.DateField', [], {'null': 'True', 'blank': 'True'}),
            'pub_date': ('django.db.models.fields.DateField', [], {'default': 'datetime.datetime(2014, 2, 28, 0, 0)'}),
            'title': ('django.db.models.fields.CharField', [], {'max_length': '255'}),
            'title_en': ('django.db.models.fields.CharField', [], {'max_length': '255', 'null': 'True', 'blank': 'True'}),
            'title_ru': ('django.db.models.fields.CharField', [], {'max_length': '255', 'null': 'True', 'blank': 'True'}),
            'title_zh_cn': ('django.db.models.fields.CharField', [], {'max_length': '255', 'null': 'True', 'blank': 'True'})
        },
        'rdoc.doccategory': {
            'Meta': {'ordering': "('title',)", 'object_name': 'DocCategory'},
            'id': ('django.db.models.fields.AutoField', [], {'primary_key': 'True'}),
            'title': ('django.db.models.fields.CharField', [], {'max_length': '255'}),
            'title_en': ('django.db.models.fields.CharField', [], {'max_length': '255', 'null': 'True', 'blank': 'True'}),
            'title_ru': ('django.db.models.fields.CharField', [], {'max_length': '255', 'null': 'True', 'blank': 'True'}),
            'title_zh_cn': ('django.db.models.fields.CharField', [], {'max_length': '255', 'null': 'True', 'blank': 'True'})
        }
    }

    complete_apps = ['rdoc']