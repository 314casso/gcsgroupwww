from django.conf import settings
from django.conf.urls.defaults import patterns, include, url
from django.contrib import admin

from django.contrib.staticfiles.urls import staticfiles_urlpatterns

admin.autodiscover()

urlpatterns = patterns('',
    url(r'^jsi18n/(?P<packages>\S+?)/$', 'django.views.i18n.javascript_catalog'),
)

urlpatterns += staticfiles_urlpatterns()


#urlpatterns += patterns('',
#    url(r'^weblog/', include('zinnia.urls')),
#    url(r'^comments/', include('django.contrib.comments.urls')),
#)


urlpatterns += patterns('',
    url(r'^admin/', include(admin.site.urls)),
    url(r'^', include('cms.urls')), # <--------- include the django cms urls via i18n_patterns
)

if settings.DEBUG:
    urlpatterns = patterns('',
        url(r'^media/(?P<path>.*)$', 'django.views.static.serve',
        {'document_root': settings.MEDIA_ROOT, 'show_indexes': True}),
        url(r'', include('django.contrib.staticfiles.urls')),
    ) + urlpatterns