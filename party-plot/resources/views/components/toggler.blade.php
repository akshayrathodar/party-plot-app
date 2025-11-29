<div class="form-check form-switch">
    <input type="hidden" name="{{ $name }}" value="0" />

    <input
        class="form-check-input"
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        type="checkbox"
        role="switch"
        value="1"
        {{ isset($checked) && $checked ? 'checked' : '' }}>

    <label class="form-check-label" for="{{ $name }}">{{ $label }}</label>
</div>
