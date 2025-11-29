 $(document).ready(function () {
    $('.ck-editor').each(function () {
      if (this.tagName === 'TEXTAREA') {
        CKEDITOR.replace(this, {
          on: {
            contentDom: function (evt) {
              evt.editor.editable().on(
                'contextmenu',
                function (contextEvent) {
                  var path = evt.editor.elementPath();
                  if (!path.contains('table')) {
                    contextEvent.cancel();
                  }
                },
                null,
                null,
                5
              );
            }
          }
        });
      }
    });
  });
