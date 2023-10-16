<div class="mb-4 mt-4">
    <nav aria-label="Page navigation example">
        <ul class="pagination mb-0">
            @if ($contexts->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link border-primary bg-primary text-white" aria-hidden="true">Previous</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link border-primary bg-primary text-white" href="{{ $contexts->previousPageUrl() }}">Previous</a>
                </li>
            @endif
            @if($contexts->currentPage() !== $contexts->firstItem())

                <li class="page-item">
                    <a class="page-link border-primary" href="{{ $contexts->url(1) }}">{{ 1 }}</a>
                </li>
                <li class="page-item disabled">
                    <a class="page-link border-primary" href="#" disabled="">...</a>
                </li>
            @endif

            @foreach ($contexts->getUrlRange($contexts->currentPage(), $contexts->currentPage()+3) as $page => $url)
                @if($page <= $contexts->lastPage())
                    <li class="page-item {{ $page == $contexts->currentPage() ? 'active' : '' }}">
                        <a class="page-link border-primary" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endif
            @endforeach
            @if($contexts->currentPage() !== $contexts->lastPage())
                <li class="page-item disabled">
                    <a class="page-link border-primary" href="#" disabled="">...</a>
                </li>
                <li class="page-item">
                    <a class="page-link border-primary" href="{{ $contexts->url($contexts->lastPage()) }}">{{ $contexts->lastPage() }}</a>
                </li>
            @endif

            @if ($contexts->hasMorePages())
                <li class="page-item">
                    <a class="page-link border-primary bg-primary text-white" href="{{ $contexts->nextPageUrl() }}">Next</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link border-primary bg-primary text-white" aria-hidden="true">Next</span>
                </li>
            @endif
        </ul>
    </nav>
</div>
