<div class="container-fluid">
    <div class="page-title">
        <div class="row">
        <div class="col-xl-7 col-sm-7 box-col-3">
            <h3>{{ $title }}</h3>
        </div>

        <div class="col-xl-5 col-sm-5 box-col-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/admin/svg/icon-sprite.svg#stroke-home') }}"></use>
                        </svg>
                    </a>
                </li>

                @isset($paths)
                    @foreach ($paths as $key => $value)
                        <li class="breadcrumb-item">
                            <a href="{{ route($key) }}"> {{ $value }} </a>
                        </li>
                    @endforeach
                @endisset

                <li class="breadcrumb-item active">
                    {{ $title }}
                </li>
            </ol>
        </div>
        </div>
    </div>
</div>
