<div>
    <label for="{{ $id ?? $name }}" class="form-label">
        {!! $label ?? ucfirst(str_replace('_', ' ', $name)) !!}
        @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>

    <select
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        data-placeholder="{{ $placeholder ?? 'Select '. str_replace('_', ' ', $name) }}"
        data-close-on-select="{{ $attributes->has('multiple') ? 'false' : 'true' }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'select2' . ($errors->has($name) ? ' is-invalid' : '')]) }}
    >
        @if ($placeholder && !isset($selected) && !$attributes->has('multiple'))
            <option value="" disabled selected> {{  $placeholder }} </option>
        @endif
        @if (strpos($name,'[') || strpos($name,']'))
            @foreach ($options as $key => $option)
                <option value="{{ $key }}" {{ in_array($key, $selected ?? []) ? 'selected' : '' }}>
                    {{ $option }}
                </option>
            @endforeach
        @else
            @foreach ($options as $key => $option)
                <option value="{{ $key }}" @if($key == (old($name,$selected) ?? "")) selected @endif>
                    {{ $option }}
                </option>
            @endforeach
        @endif
    </select>
    @if ($errors->has($name))
        <div class="invalid-feedback">
            {{ $errors->first($name) }}
        </div>
    @endif
</div>
