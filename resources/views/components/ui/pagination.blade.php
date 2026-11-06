@props([
    'paginator' => null,
    'elements' => null,
])

@php
    $paginator = $paginator ?? $elementsPaginator ?? null;
    $elements = $elements ?? ($paginator && method_exists($paginator, 'elements') ? $paginator->elements() : []);
@endphp

@if ($paginator && $paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" {{ $attributes->merge(['class' => 'mx-auto flex w-full justify-center']) }}>
        <ul class="flex flex-row items-center gap-1">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="inline-flex items-center justify-center gap-1 rounded-md px-3 py-2 text-sm font-medium text-muted-foreground opacity-50 cursor-not-allowed select-none">
                        <x-ui.icon name="chevron-left" class="w-4 h-4" />
                        <span>Sebelumnya</span>
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center justify-center gap-1 rounded-md px-3 py-2 text-sm font-medium hover:bg-accent hover:text-accent-foreground select-none transition-colors">
                        <x-ui.icon name="chevron-left" class="w-4 h-4" />
                        <span>Sebelumnya</span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span class="inline-flex items-center justify-center h-9 w-9 text-sm text-muted-foreground select-none">
                            {{ $element }}
                        </span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span aria-current="page" class="inline-flex items-center justify-center h-9 w-9 rounded-md border border-primary bg-primary text-primary-foreground text-sm font-medium shadow-sm select-none">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" class="inline-flex items-center justify-center h-9 w-9 rounded-md border border-input bg-background hover:bg-accent hover:text-accent-foreground text-sm font-medium transition-colors select-none">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center justify-center gap-1 rounded-md px-3 py-2 text-sm font-medium hover:bg-accent hover:text-accent-foreground select-none transition-colors">
                        <span>Selanjutnya</span>
                        <x-ui.icon name="chevron-right" class="w-4 h-4" />
                    </a>
                </li>
            @else
                <li>
                    <span class="inline-flex items-center justify-center gap-1 rounded-md px-3 py-2 text-sm font-medium text-muted-foreground opacity-50 cursor-not-allowed select-none">
                        <span>Selanjutnya</span>
                        <x-ui.icon name="chevron-right" class="w-4 h-4" />
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif

