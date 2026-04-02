<div
    class="alert-dropdown"
    style="width: 20rem; top: calc(100% + 1rem)">
    <div class="alert-dropdown__header">
        <a href="{{ $viewAllAlertsUrl }}"
           class="alert-dropdown__view-all">
            View all alerts
        </a>
        <span class="alert-dropdown__separator"> | </span>
        @if ($unreadCount > 0)
            <button
                type="button"
                wire:click="markAllAsRead"
                class="alert-dropdown__mark-all"
            >
                Mark all as read
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1"
                     stroke="currentColor" class="alert-dropdown__mark-all-icon" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z" />
                </svg>
            </button>
        @endif
    </div>

    <div class="alert-dropdown__body">
        <div class="alert-dropdown__list">
            @forelse ($unreadAlerts as $alert)
                @include('alert::livewire.alert-card', ['alert' => $alert])
            @empty
                <div class="alert-dropdown__empty">
                    No unread alerts.
                </div>
            @endforelse
        </div>
    </div>
</div>
