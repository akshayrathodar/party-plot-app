@if ($paginator->hasPages())
    <div class="pagination-area mt-60 wow animate fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
        {{-- Previous Page Link --}}
        <div class="paginations-button">
            @if ($paginator->onFirstPage())
                <span class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <path
                                d="M7.86133 9.28516C7.14704 7.49944 3.57561 5.71373 1.43276 4.99944C3.57561 4.28516 6.7899 3.21373 7.86133 0.713728" stroke-width="1.5" stroke-linecap="round" />
                        </g>
                    </svg>
                    Prev
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                    <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <path
                                d="M7.86133 9.28516C7.14704 7.49944 3.57561 5.71373 1.43276 4.99944C3.57561 4.28516 6.7899 3.21373 7.86133 0.713728" stroke-width="1.5" stroke-linecap="round" />
                        </g>
                    </svg>
                    Prev
                </a>
            @endif
        </div>

        {{-- Pagination Elements --}}
        <ul class="paginations">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span>{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <a href="#">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a href="{{ $url }}">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </ul>

        {{-- Next Page Link --}}
        <div class="paginations-button">
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                    Next
                    <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <path
                                d="M1.42969 9.28613C2.14397 7.50042 5.7154 5.7147 7.85826 5.00042C5.7154 4.28613 2.50112 3.21471 1.42969 0.714705" stroke-width="1.5" stroke-linecap="round" />
                        </g>
                    </svg>
                </a>
            @else
                <span class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    Next
                    <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <path
                                d="M1.42969 9.28613C2.14397 7.50042 5.7154 5.7147 7.85826 5.00042C5.7154 4.28613 2.50112 3.21471 1.42969 0.714705" stroke-width="1.5" stroke-linecap="round" />
                        </g>
                    </svg>
                </span>
            @endif
        </div>
    </div>
@endif

