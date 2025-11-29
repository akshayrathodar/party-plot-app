<div class="form-check">
    <input
        type="checkbox"
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        value="{{ $value ?? '' }}"
        {{ ($checked ?? false) ? 'checked' : '' }}
        {{ $attributes->merge(['class' => 'form-check-input ' . (isset($errors) && $errors->has($name) ? ' is-invalid' : '')]) }}
    />

    <label for="{{ $id ?? $name }}" class="form-check-label {{ $labelClass ?? '' }}">{{ $label }}</label>

    @if (isset($errors) && $errors->has($name))
        <div class="invalid-feedback">
            {{ $errors->first($name) }}
        </div>
    @endif
</div>
