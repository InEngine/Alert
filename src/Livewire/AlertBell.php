<?php

namespace InEngine\Alert\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use InEngine\Alert\Alert;
use InEngine\Alert\Facades\Alert as AlertFacade;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

/**
 * AlertBell
 * Livewire bell control: unread count, dropdown list, mark-read actions, and Tailwind class hooks for styling.
 */
class AlertBell extends Component
{
    /**
     * Number of unread alerts for the authenticated user.
     *
     * @var int
     */
    public int $unreadCount = 0;

    /**
     * Whether the dropdown panel is visible.
     *
     * @var bool
     */
    public bool $isOpen = false;

    /**
     * Recent unread alerts shown in the dropdown (empty when closed).
     *
     * @var list<array{id: string, title: string, body: string, link: string, linkText: string, icon: string, created_at: string|null}>
     */
    public array $unreadAlerts = [];

    /**
     * Resolved "view all alerts" URL from {@see Alert::viewAllAlertsUrl()}.
     *
     * @var string
     */
    public string $viewAllAlertsUrl;

    /**
     * Tailwind classes for the unread count badge background.
     *
     * @var string
     */
    public string $countBackgroundClasses = 'bg-red-600';

    /**
     * Tailwind classes for the unread count badge text.
     *
     * @var string
     */
    public string $countTextClasses = 'text-white';

    /**
     * Tailwind classes for the bell chip background (defaults to inheriting the parent).
     *
     * @var string
     */
    public string $bellBackgroundClasses = 'bg-inherit';

    /**
     * Tailwind classes for the SVG stroke color (via currentColor).
     *
     * @var string
     */
    public string $bellOutlineClasses = 'text-gray-500';

    /**
     * mount
     * Applies styling class props, loads the view-all URL, and refreshes the unread count from the database.
     *
     * @param  string  $countBackgroundClasses  Tailwind classes for the unread badge background.
     * @param  string  $countTextClasses  Tailwind classes for the unread badge text.
     * @param  string  $bellBackgroundClasses  Tailwind classes for the bell chip background.
     * @param  string  $bellOutlineClasses  Tailwind classes for the bell icon stroke color.
     * @return void
     */
    public function mount(
        string $countBackgroundClasses = 'bg-red-600',
        string $countTextClasses = 'text-white',
        string $bellBackgroundClasses = 'bg-inherit',
        string $bellOutlineClasses = 'text-gray-500'
    ): void {
        $this->countBackgroundClasses = $countBackgroundClasses;
        $this->countTextClasses = $countTextClasses;
        $this->bellBackgroundClasses = $bellBackgroundClasses;
        $this->bellOutlineClasses = $bellOutlineClasses;
        $this->refreshUnreadCount();
        $this->viewAllAlertsUrl = AlertFacade::viewAllAlertsUrl();
    }

    /**
     * refreshUnreadCount
     * Recomputes unread total; when the dropdown is open, loads up to five latest unread rows for display.
     *
     * @return void
     */
    public function refreshUnreadCount(): void
    {
        $user = auth()->user();

        if (! $user) {
            $this->unreadCount = 0;
            $this->unreadAlerts = [];

            return;
        }

        $query = $user->alerts()
            ->whereNull('read_at')
            ->latest();

        $this->unreadCount = (clone $query)->count();

        if (! $this->isOpen) {
            $this->unreadAlerts = [];

            return;
        }

        $this->unreadAlerts = $query
            ->limit(5)
            ->get()
            ->map(fn ($alert): array => [
                'id' => (string) $alert->id,
                'title' => (string) data_get($alert->data, 'title', 'Alert'),
                'body' => (string) data_get($alert->data, 'body', ''),
                'link' => (string) data_get($alert->data, 'link', ''),
                'linkText' => (string) data_get($alert->data, 'linkText', ''),
                'icon' => (string) data_get($alert->data, 'icon', ''),
                'created_at' => $alert->created_at?->diffForHumans(),
            ])
            ->all();
    }

    /**
     * markAllAsRead
     * Marks every unread package alert as read for the current user.
     *
     * @return void
     */
    public function markAllAsRead(): void
    {
        $user = auth()->user();

        if (! $user) {
            return;
        }

        $user->alerts()
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $this->refreshUnreadCount();
    }

    /**
     * markAlertAsRead
     * Marks a single notification read if it belongs to the user and is an alert type from config.
     *
     * @param  string  $notificationId  Database notifications.id for the row to mark read.
     * @return void
     */
    public function markAlertAsRead(string $notificationId): void
    {
        $user = auth()->user();

        if (! $user) {
            return;
        }

        $notification = $user->notifications()
            ->whereKey($notificationId)
            ->whereIn('type', AlertFacade::getAlertTypes())
            ->whereNull('read_at')
            ->first();

        if (! $notification) {
            return;
        }

        $notification->markAsRead();
        $this->refreshUnreadCount();
    }

    /**
     * markAlertAsReadAndFollow
     * Marks the notification read then redirects to its link, or home when missing or invalid.
     *
     * @param  string  $notificationId  Database notifications.id for the row to mark read.
     * @return RedirectResponse|Redirector
     */
    public function markAlertAsReadAndFollow(string $notificationId): RedirectResponse|Redirector
    {
        $user = auth()->user();

        if (! $user) {
            return Redirect::to('/');
        }

        $notification = $user->notifications()
            ->whereKey($notificationId)
            ->whereIn('type', AlertFacade::getAlertTypes())
            ->whereNull('read_at')
            ->first();

        if (! $notification) {
            return Redirect::to('/');
        }

        $link = (string) data_get($notification->data, 'link', '');

        if ($link === '') {
            return Redirect::to('/');
        }

        $notification->markAsRead();
        $this->refreshUnreadCount();

        return Redirect::to($link);
    }

    /**
     * toggleDropdown
     * Opens or closes the dropdown; opening triggers a refresh so the list is current.
     *
     * @return void
     */
    public function toggleDropdown(): void
    {
        $this->isOpen = ! $this->isOpen;

        if ($this->isOpen) {
            $this->refreshUnreadCount();
        }
    }

    /**
     * closeDropdown
     * Hides the dropdown (e.g. on outside click).
     *
     * @return void
     */
    public function closeDropdown(): void
    {
        $this->isOpen = false;
    }

    /**
     * render
     * Renders the alert bell Blade view from this package.
     *
     * @return View
     */
    public function render(): View
    {
        return view('alert::livewire.alert-bell');
    }
}
