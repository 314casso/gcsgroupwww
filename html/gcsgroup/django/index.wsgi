import os, sys

project_path = ('/home/picasso/djcode','/home/picasso/djcode/gcsdoc')

for p in project_path:
    if p not in sys.path:
        sys.path.append(p)
	

os.environ['DJANGO_SETTINGS_MODULE'] = 'gcsdoc.settings'

import django.core.handlers.wsgi
application = django.core.handlers.wsgi.WSGIHandler()
