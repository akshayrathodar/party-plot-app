FilePond.registerPlugin(
  FilePondPluginFileRename,
  FilePondPluginImagePreview,
  FilePondPluginImageTransform,
  FilePondPluginFileValidateType
);

document.querySelectorAll('input[type="file"]').forEach((input) => {

  if (input.classList.contains("no-preview")) {
    // distroy the filepond instance
    FilePond.destroy(input);
  } else {
    const acceptAttr = input.getAttribute('accept');
    const acceptedTypes = acceptAttr ? acceptAttr.split(',').map(type => type.trim()) : [];

    const options = {
      // allowMultiple: true,
      storeAsFile: true,
      acceptedFileTypes: acceptedTypes,
    };

    if (input.classList.contains("show-preview")) {
      options.imagePreviewHeight = 170;
    }

    // Enable transform
    if (input.classList.contains("transform-preview")) {
      options.imageTransformOutputQuality = 80;
    }

      const filesJson = input.dataset.files;

    if (filesJson) {
      try {
        const filesData = JSON.parse(filesJson);

        if (filesData && filesData.length > 0) {
          options.files = filesData.map(file => ({
            source: file.url,
            options: {
              type: 'local',
              metadata: {
                ...file // include id, table, column, type, arrayKey, etc.
              }
            }
          }));
        }

        options.server = {
          load: (source, load, error, progress, abort) => {
            fetch(source)
              .then(res => {
                if (!res.ok) throw new Error(`Failed to load: ${res.statusText}`);
                return res.blob();
              })
              .then(load)
              .catch(e => error(e.message));
            return { abort };
          }
        };

        options.onremovefile = (error, file) => {
          if (error) return;

          const meta = file.getMetadata(); // 👈 get all from metadata

          const payload = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            ...meta // contains id, table, column, type, arrayKey, etc.
          };

          if (payload.table && payload.id) {
            $.ajax({
              url: window.location.origin+"/media-delete",
              method: "POST",
              data: payload,
              success: () => console.log(`Deleted file: ${file.source}`),
              error: (xhr) => console.error("Delete failed:", xhr.responseText)
            });
          }

          return false;

        };

      } catch (err) {
        console.error("Invalid JSON in data-files", err);
      }
    }

    FilePond.create(input, options);
  }
});
