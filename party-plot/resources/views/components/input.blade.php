<div class="form-group mb-3">
    @isset($label)
        <label for="{{ $id ?? $name }}" class="form-label d-block {{ isset($labelClass)? $labelClass : '' }}">
            {!! $label ?? ucfirst(str_replace('_', ' ', $name)) !!}
            @if (isset($required) && $required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endisset

    <div class="@isset($appendIcon) input-group @endisset">
        <input
            type="{{ $type ?? 'text' }}"
            name="{{ $name }}"
            id="{{ $id ?? $name }}"
            value="{{ old($name, $value ?? '') }}"
            placeholder="{{ $placeholder ?? 'Enter '. str_replace('_', ' ', $name) }}"
            {{ (isset($required) && $required) ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'form-control' . ( isset($errors) && $errors->has($name) ? ' is-invalid' : '')]) }}
        />

        @isset($appendIcon)
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas {{ $appendIcon }}"></span>
                </div>
            </div>
        @endisset
    </div>


    @if (isset($errors) && $errors->has($name))
        <div class="invalid-feedback d-block">
            {{ $errors->first($name) }}
        </div>
    @endif
</div>
