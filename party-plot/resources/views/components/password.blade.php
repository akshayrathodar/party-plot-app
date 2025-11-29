<div class="form-group mb-3">

    @php
        $name = $name ?? 'password';
    @endphp

    @isset($label)
        <label for="{{ $id ?? $name }}" class="form-label d-block {{ isset($labelClass)? $labelClass : '' }}">
            {{ $label ?? ucfirst(str_replace('_', ' ', $name)) }}
            @if ($required ?? false)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endisset

    <div class="form-input position-relative">
        <input
            type="password"
            name="{{ $name }}"
            id="{{ $id ?? $name }}"
            value="{{ $value ?? old($name) }}"
            placeholder="{{ $placeholder ?? '*********' }}"
            {{ ($required ?? false) ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'form-control' . ( isset($errors) && $errors->has($name) ? ' is-invalid' : '')]) }}
        />

        <div class="show-hide"><span class="show"></span></div>
    </div>

    @if (isset($errors) && $errors->has($name))
        <div class="invalid-feedback d-block">
            {{ $errors->first($name) }}
        </div>
    @endif
</div>
