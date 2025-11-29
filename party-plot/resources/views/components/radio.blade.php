<div class="form-check">
    <input
        type="radio"
        name="{{ $name }}"
        id="{{ $id ?? $name.'_'.($value ?? old($name)) }}"
        value="{{ $value ?? '' }}"
        {{ $checked ? 'checked' : '' }}
        {{ $attributes->merge(['class' => 'form-check-input ' . (isset($errors) && $errors->has($name) ? ' is-invalid' : '')]) }}
    />

    <label for="{{ $id ?? $name.'_'.($value ?? old($name)) }}" class="form-check-label {{ $labelClass ?? '' }}">{{ $label }}</label>

    @if (isset($errors) && $errors->has($name))
        <div class="invalid-feedback">
            {{ $errors->first($name) }}
        </div>
    @endif
</div>
