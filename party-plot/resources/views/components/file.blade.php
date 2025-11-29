<div class="card mb-3">
    <div class="card-header pb-0">
        @isset($label)
            <label for="{{ $id ?? $name }}" class="form-label d-block {{ isset($labelClass)? $labelClass : '' }}">
                {!! $label ?? ucfirst(str_replace('_', ' ', $name)) !!}
                @if ($required)
                    <span class="text-danger">*</span>
                @endif
            </label>
        @endisset
    </div>

    @php
        $isMultiple = false;
        if (strpos($name,'[') || strpos($name,']')) {
            $isMultiple = true;
        }
        $imagePaths = $isMultiple ? ($file ?? []) : [($file ?? null)];
        $files = collect($imagePaths)
            ->filter() // skip null
            ->values()
            ->map(function ($imageName, $index) use ($name, $path, $tableId, $table, $column, $isMultiple) {
                if (isset($imageName)) {
                    $fileName = explode(",",$path);
                    $FilePath = 'uploads/' . $fileName[1] . '/' . $fileName[0];
                    $imagePath = $FilePath . '/' .$imageName;
                    // Only include if file exists
                    if (file_exists(public_path($imagePath))) {
                        return [
                            'url' => asset($imagePath),
                            'path' => $FilePath,
                            'id' => $tableId,
                            'table' => $table,
                            'column' => $column ?? $name,
                            'type' => $isMultiple ? 'multiple-image' : 'image',
                            'arrayKey' => $isMultiple ? $index : null,
                        ];
                    }
                }
                return null;
            })
            ->filter() // Remove null values
            ->toJson();
    @endphp
    <div class="card-body">
        <input
            type="file"
            name="{{ $name }}"
            id="{{ $id ?? $name }}"
            data-files='{{ $files }}'
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'show-preview' . ( isset($errors) && $errors->has($name) ? ' is-invalid' : '')]) }}
            accept="{{ $attributes['accept'] ?? 'image/*,video/*' }}"
        />

        @if (isset($errors) && $errors->has($name))
            <div class="invalid-feedback d-block">
                {{ $errors->first($name) }}
            </div>
        @endif

        {{-- pdf preview --}}
        @if (isset($file) && is_array($file) && count($file) > 0)
            @foreach ($imagePaths as $index => $imageName)
                @if ($imageName)
                    @php
                        $fileName = explode(",",$path);
                        $FilePath = 'uploads/' . $fileName[1] . '/' . $fileName[0];
                    @endphp
                    @if (pathinfo($imageName, PATHINFO_EXTENSION) === 'pdf')
                        <div class="mt-3 filepond-preview">
                            <a href="{{ asset($FilePath . '/' . $imageName) }}" target="_blank" class="img-thumbnail">
                                <i class="fa fa-file-pdf text-danger"></i> {{ $imageName }}
                            </a>
                        </div>
                    @endif
                @endif
            @endforeach
        @elseif (isset($file) && is_string($file))
            @php
                $fileName = explode(",",$path);
                $FilePath = 'uploads/' . $fileName[1] . '/' . $fileName[0];
            @endphp
            @if (pathinfo($file, PATHINFO_EXTENSION) === 'pdf')
                <div class="mt-3 filepond-preview">
                    <a href="{{ asset($FilePath . '/' . $file) }}" target="_blank" class="img-thumbnail">
                        <i class="fa fa-file-pdf text-danger"></i> {{ $file }}
                    </a>
                </div>
            @endif
        @endif
    </div>
</div>
