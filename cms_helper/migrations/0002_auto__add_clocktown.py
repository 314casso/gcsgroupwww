# -*- coding: utf-8 -*-
import datetime
from south.db import db
from south.v2 import SchemaMigration
from django.db import models


class Migration(SchemaMigration):

    def forwards(self, orm):
        # Adding model 'ClockTown'
        db.create_table('cms_helper_clocktown', (
            ('id', self.gf('django.db.models.fields.AutoField')(primary_key=True)),
            ('town', self.gf('django.db.models.fields.CharField')(unique=True, max_length=255, db_index=True)),
            ('hour_shift', self.gf('django.db.models.fields.IntegerField')()),
        ))
        db.send_create_signal('cms_helper', ['ClockTown'])


    def backwards(self, orm):
        # Deleting model 'ClockTown'
        db.delete_table('cms_helper_clocktown')


    models = {
        'cms_helper.clocktown': {
            'Meta': {'ordering': "['town']", 'object_name': 'ClockTown'},
            'hour_shift': ('django.db.models.fields.IntegerField', [], {}),
            'id': ('django.db.models.fields.AutoField', [], {'primary_key': 'True'}),
            'town': ('django.db.models.fields.CharField', [], {'unique': 'True', 'max_length': '255', 'db_index': 'True'})
        }
    }

    complete_apps = ['cms_helper']