# -*- coding: utf-8 -*-
import datetime
from south.db import db
from south.v2 import SchemaMigration
from django.db import models


class Migration(SchemaMigration):

    def forwards(self, orm):
        # Adding model 'Doc'
        db.create_table('rdoc_doc', (
            ('id', self.gf('django.db.models.fields.AutoField')(primary_key=True)),
            ('title', self.gf('django.db.models.fields.CharField')(max_length=255)),
            ('desciption', self.gf('django.db.models.fields.CharField')(max_length=500, null=True, blank=True)),
            ('issue_date', self.gf('django.db.models.fields.DateField')(null=True, blank=True)),
            ('attachment', self.gf('django.db.models.fields.files.FileField')(max_length=100)),
            ('pub_date', self.gf('django.db.models.fields.DateField')(default=datetime.datetime(2013, 4, 3, 0, 0))),
        ))
        db.send_create_signal('rdoc', ['Doc'])


    def backwards(self, orm):
        # Deleting model 'Doc'
        db.delete_table('rdoc_doc')


    models = {
        'rdoc.doc': {
            'Meta': {'ordering': "('-issue_date', 'title')", 'object_name': 'Doc'},
            'attachment': ('django.db.models.fields.files.FileField', [], {'max_length': '100'}),
            'desciption': ('django.db.models.fields.CharField', [], {'max_length': '500', 'null': 'True', 'blank': 'True'}),
            'id': ('django.db.models.fields.AutoField', [], {'primary_key': 'True'}),
            'issue_date': ('django.db.models.fields.DateField', [], {'null': 'True', 'blank': 'True'}),
            'pub_date': ('django.db.models.fields.DateField', [], {'default': 'datetime.datetime(2013, 4, 3, 0, 0)'}),
            'title': ('django.db.models.fields.CharField', [], {'max_length': '255'})
        }
    }

    complete_apps = ['rdoc']