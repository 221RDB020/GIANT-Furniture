@if ($paginator->hasPages())
    <nav class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="disabled" aria-disabled="true">Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a>
        @endif

        {{-- Page Links --}}
        @if ($paginator->lastPage() > 1)
            {{-- First Page Link --}}
            <a href="{{ $paginator->url(1) }}" class="{{ $paginator->currentPage() == 1 ? 'active' : '' }}">1</a>

            @if ($paginator->lastPage() > 6)
                {{-- "..." Separator if the range skips pages after the first --}}
                @if ($paginator->currentPage() > 6)
                    <span>...</span>
                @endif

                {{-- Pages within 5 before and 5 after the current page --}}
                @foreach (range(max(2, $paginator->currentPage() - 5), min($paginator->lastPage() - 1, $paginator->currentPage() + 5)) as $page)
                    @if ($page == $paginator->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $paginator->url($page) }}">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- "..." Separator if the range skips pages before the last --}}
                @if ($paginator->currentPage() < $paginator->lastPage() - 5)
                    <span>...</span>
                @endif
            @else
                @if ($paginator->lastPage() > 2)
                    {{-- All Page Links --}}
                    @foreach ($paginator->getUrlRange(2, $paginator->lastPage() - 1) as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endif

            {{-- Last Page Link --}}
            <a href="{{ $paginator->url($paginator->lastPage()) }}" class="{{ $paginator->currentPage() == $paginator->lastPage() ? 'active' : '' }}">{{ $paginator->lastPage() }}</a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>
        @else
            <span class="disabled" aria-disabled="true">Next</span>
        @endif
    </nav>
@endif
