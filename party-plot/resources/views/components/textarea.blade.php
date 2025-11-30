<div class="form-group mb-3">
    @isset($label)
        <label for="{{ $id ?? $name }}" class="form-label d-block {{ isset($labelClass)? $labelClass : '' }}">
            {{ $label ?? ucfirst(str_replace('_', ' ', $name)) }}
            @if (isset($required) && $required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endisset

    @php
        $textareaValue = old($name, $value ?? '');
        // Handle arrays (e.g., video_links, gallery_images)
        if (is_array($textareaValue)) {
            $textareaValue = implode(', ', array_filter($textareaValue));
        }
        $textareaValue = trim((string) $textareaValue);
        
        // Handle attributes safely
        $errorClass = (isset($errors) && $errors->has($name)) ? ' is-invalid' : '';
        $baseClass = 'form-control' . $errorClass;
        
        // Get rows from direct prop or attributes
        $rowsValue = $rows ?? null;
        if (!$rowsValue && is_object($attributes) && method_exists($attributes, 'get') && $attributes->has('rows')) {
            $rowsValue = $attributes->get('rows');
        } elseif (!$rowsValue && is_array($attributes) && isset($attributes['rows'])) {
            $rowsValue = $attributes['rows'];
        }
        
        // Handle class from attributes
        if (is_object($attributes) && method_exists($attributes, 'get') && $attributes->has('class')) {
            $baseClass = trim($baseClass . ' ' . $attributes->get('class'));
        } elseif (is_array($attributes) && isset($attributes['class'])) {
            $baseClass = trim($baseClass . ' ' . $attributes['class']);
        }
    @endphp
    <textarea
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        class="{{ $baseClass }}"
        placeholder="{{ $placeholder ?? 'Enter '. str_replace('_', ' ', $name) }}"
        @if($rowsValue) rows="{{ $rowsValue }}" @endif
        {{ (isset($required) && $required) ? 'required' : '' }}
        @if(is_object($attributes) && method_exists($attributes, 'except'))
            {{ $attributes->except(['class', 'rows']) }}
        @endif
    >{!! $textareaValue !!}</textarea>

    @if (isset($errors) && $errors->has($name))
        <div class="invalid-feedback d-block">
            {{ $errors->first($name) }}
        </div>
    @endif
</div>
