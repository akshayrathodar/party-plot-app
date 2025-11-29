<div class="form-group mb-3">
    @isset($label)
        <label for="{{ $id ?? $name }}" class="form-label d-block {{ isset($labelClass)? $labelClass : '' }}">
            {{ $label ?? ucfirst(str_replace('_', ' ', $name)) }}
            @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endisset

    <textarea
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        placeholder="{{ $placeholder ?? 'Enter '. str_replace('_', ' ', $name) }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'ck-editor form-control' . ( isset($errors) && $errors->has($name) ? ' is-invalid' : '')]) }}
    >{!! trim(old($name, $value ?? '')) !!}</textarea>

    @if (isset($errors) && $errors->has($name))
        <div class="invalid-feedback d-block">
            {{ $errors->first($name) }}
        </div>
    @endif
</div>
