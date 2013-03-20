# -*- coding: utf-8 -*-
import datetime
from south.db import db
from south.v2 import SchemaMigration
from django.db import models


class Migration(SchemaMigration):

    def forwards(self, orm):
        # Adding field 'ClockTown.order'
        db.add_column('cms_helper_clocktown', 'order',
                      self.gf('django.db.models.fields.PositiveIntegerField')(default=1, unique=True, blank=True),
                      keep_default=False)


    def backwards(self, orm):
        # Deleting field 'ClockTown.order'
        db.delete_column('cms_helper_clocktown', 'order')


    models = {
        'cms_helper.clocktown': {
            'Meta': {'ordering': "['town']", 'object_name': 'ClockTown'},
            'hour_shift': ('django.db.models.fields.IntegerField', [], {}),
            'id': ('django.db.models.fields.AutoField', [], {'primary_key': 'True'}),
            'order': ('django.db.models.fields.PositiveIntegerField', [], {'unique': 'True', 'blank': 'True'}),
            'town': ('django.db.models.fields.CharField', [], {'unique': 'True', 'max_length': '255', 'db_index': 'True'}),
            'town_en': ('django.db.models.fields.CharField', [], {'db_index': 'True', 'max_length': '255', 'unique': 'True', 'null': 'True', 'blank': 'True'}),
            'town_ru': ('django.db.models.fields.CharField', [], {'db_index': 'True', 'max_length': '255', 'unique': 'True', 'null': 'True', 'blank': 'True'})
        }
    }

    complete_apps = ['cms_helper']