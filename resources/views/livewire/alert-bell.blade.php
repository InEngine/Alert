<div class="alert-bell" wire:poll.120s="refreshUnreadCount" wire:click.outside="closeDropdown">
    <button
        type="button"
        class="alert-bell__toggle"
        wire:click="toggleDropdown"
        aria-label="Alerts"
        aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
    >
        <span class="alert-bell__bell {{ $bellBackgroundClasses }}">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
                class="alert-bell__svg {{ $bellOutlineClasses }}"
                aria-hidden="true"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M14.857 17.082a23.848 23.848 0 0 1 5.454 1.31A8.967 8.967 0 0 1 18 9.75v-.7V9a6 6 0 1 0-12 0v.05.7a8.967 8.967 0 0 1-2.312 8.642 23.848 23.848 0 0 1 5.454-1.31m5.715 0a24.255 24.255 0 0 0-5.714 0m5.714 0a3 3 0 1 1-5.714 0"
                />
            </svg>

            @if ($unreadCount > 0)
                <span
                    class="alert-bell__badge {{ $countBackgroundClasses }} {{ $countTextClasses }}"
                >
                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                </span>
            @endif
        </span>
    </button>
    @if($isOpen)
        @include('alert::livewire.alert-dropdown')
    @endif
</div>
