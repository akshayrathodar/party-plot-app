@if (isset($image))
    <div class="d-flex mt-3">
        <div
            class="position-relative media-section"
            data-id="{{ $id }}"
            data-arrayKey="{{ $arrayKey }}"
            data-table="{{ $table }}"
            data-column="{{ $column }}"
            data-path="{{ $path }}"
            data-type="{{ $type ?? 'image' }}"
        >
            <a href="{{ url($path . '/' . $image) }}" data-toggle="lightbox" data-title="{{ $image }}" data-gallery="gallery">
                <img src="{{ url($path . '/' . $image) }}" width="100%">
            </a>

            <!-- Show delete button only if condition is true (e.g. $showDelete is passed as true) -->
            @if($showDelete)
                <button class="media-delete-btn" type="button">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            @endif
        </div>
    </div>
@endif
