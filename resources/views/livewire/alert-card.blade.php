@php
    $hasLink = ($alert['link'] ?? '') !== '';
@endphp
<div wire:key="alert-{{ $alert['id'] }}" class="alert-card">
    <div class="alert-card__stack">
        <div class="alert-card__row">
            <div @class(['alert-card__main', 'alert-card__main--linked' => $hasLink])>
                @if (! empty($alert['icon'] ?? ''))
                    <span class="alert-card__icon">
                        {!! $alert['icon'] !!}
                    </span>
                @endif
                <p class="alert-card__title">{{ $alert['title'] }}</p>
            </div>
            <div class="alert-card__actions">
                <button
                    type="button"
                    wire:click.stop="markAlertAsRead(@js($alert['id']))"
                    class="alert-card__dismiss"
                    aria-label="Mark as read"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                         stroke="currentColor"
                         class="alert-card__dismiss-icon"
                         aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        @if ($alert['body'] !== '')
            <p @class(['alert-card__body', 'alert-card__body--linked' => $hasLink])>{{ $alert['body'] }}</p>
        @endif
        @if (! empty($alert['created_at']))
            <div @class(['alert-card__meta', 'alert-card__meta--linked' => $hasLink])>
                <span class="alert-card__time">{{ $alert['created_at'] }}</span>
            </div>
        @endif
    </div>
    @if ($hasLink)
        <a href="{{ $alert['link'] }}"
           wire:click.prevent="markAlertAsReadAndFollow(@js($alert['id']))"
           class="alert-card__overlay"
           aria-label="{{ e($alert['title']) }}"></a>
    @endif
</div>
