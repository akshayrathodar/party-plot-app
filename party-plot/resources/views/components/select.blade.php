<div>
    <label for="{{ $id ?? $name }}" class="form-label">
        {!! $label ?? ucfirst(str_replace('_', ' ', $name)) !!}
        @if (isset($required) && $required)
            <span class="text-danger">*</span>
        @endif
    </label>

    @php
        $errorClass = (isset($errors) && $errors->has($name)) ? ' is-invalid' : '';
        
        // Handle attributes - check if it's an object or array
        if (is_object($attributes) && method_exists($attributes, 'get')) {
            $existingClass = is_string($attributes->get('class', '')) ? $attributes->get('class', '') : '';
            $hasMultiple = $attributes->has('multiple');
        } else {
            $existingClass = isset($attributes['class']) && is_string($attributes['class']) ? $attributes['class'] : '';
            $hasMultiple = isset($attributes['multiple']);
        }
        
        $selectClass = trim('select2 ' . $existingClass . ' ' . $errorClass);
        
        // Filter attributes to only include string/numeric values to avoid trim() errors
        // Exclude component props that shouldn't be HTML attributes
        $excludedKeys = ['class', 'options', 'selected', 'placeholder', 'label', 'required', 'id', 'name'];
        $filteredAttributes = [];
        
        // Get attributes array safely
        if (is_object($attributes) && method_exists($attributes, 'getAttributes')) {
            $attrsArray = $attributes->getAttributes();
        } elseif (is_array($attributes)) {
            $attrsArray = $attributes;
        } else {
            $attrsArray = [];
        }
        
        foreach ($attrsArray as $key => $value) {
            if (!in_array($key, $excludedKeys) && (is_string($value) || is_numeric($value) || is_bool($value))) {
                $filteredAttributes[$key] = $value;
            }
        }
    @endphp
    <select
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        class="{{ $selectClass }}"
        data-placeholder="{{ $placeholder ?? 'Select '. str_replace('_', ' ', $name) }}"
        data-close-on-select="{{ $hasMultiple ? 'false' : 'true' }}"
        {{ (isset($required) && $required) ? 'required' : '' }}
        @foreach($filteredAttributes as $key => $value)
            @if(is_bool($value))
                @if($value) {{ $key }} @endif
            @else
                {{ $key }}="{{ $value }}"
            @endif
        @endforeach
    >
        @if (isset($placeholder) && $placeholder && !isset($selected) && !$hasMultiple)
            <option value="" disabled selected> {{  $placeholder }} </option>
        @endif
        @if (isset($options) && is_array($options))
            @if (strpos($name,'[') || strpos($name,']'))
                @foreach ($options as $key => $option)
                    <option value="{{ $key }}" {{ in_array($key, $selected ?? []) ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @endforeach
            @else
                @foreach ($options as $key => $option)
                    <option value="{{ $key }}" @if($key == (old($name,$selected ?? ""))) selected @endif>
                        {{ $option }}
                    </option>
                @endforeach
            @endif
        @endif
    </select>
    @if (isset($errors) && $errors->has($name))
        <div class="invalid-feedback">
            {{ $errors->first($name) }}
        </div>
    @endif
</div>
