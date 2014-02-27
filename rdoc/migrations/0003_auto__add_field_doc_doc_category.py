# -*- coding: utf-8 -*-
import datetime
from south.db import db
from south.v2 import SchemaMigration
from django.db import models


class Migration(SchemaMigration):

    def forwards(self, orm):
        # Adding field 'Doc.doc_category'
        db.add_column('rdoc_doc', 'doc_category',
                      self.gf('django.db.models.fields.related.ForeignKey')(to=orm['rdoc.DocCategory'], null=True, blank=True),
                      keep_default=False)


    def backwards(self, orm):
        # Deleting field 'Doc.doc_category'
        db.delete_column('rdoc_doc', 'doc_category_id')


    models = {
        'rdoc.doc': {
            'Meta': {'ordering': "('-issue_date', 'title')", 'object_name': 'Doc'},
            'attachment': ('django.db.models.fields.files.FileField', [], {'max_length': '100'}),
            'desciption': ('django.db.models.fields.CharField', [], {'max_length': '500', 'null': 'True', 'blank': 'True'}),
            'doc_category': ('django.db.models.fields.related.ForeignKey', [], {'to': "orm['rdoc.DocCategory']", 'null': 'True', 'blank': 'True'}),
            'id': ('django.db.models.fields.AutoField', [], {'primary_key': 'True'}),
            'issue_date': ('django.db.models.fields.DateField', [], {'null': 'True', 'blank': 'True'}),
            'pub_date': ('django.db.models.fields.DateField', [], {'default': 'datetime.datetime(2014, 2, 27, 0, 0)'}),
            'title': ('django.db.models.fields.CharField', [], {'max_length': '255'})
        },
        'rdoc.doccategory': {
            'Meta': {'ordering': "('title',)", 'object_name': 'DocCategory'},
            'id': ('django.db.models.fields.AutoField', [], {'primary_key': 'True'}),
            'title': ('django.db.models.fields.CharField', [], {'max_length': '255'})
        }
    }

    complete_apps = ['rdoc']