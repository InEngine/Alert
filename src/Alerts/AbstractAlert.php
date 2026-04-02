<?php

namespace InEngine\Alert\Alerts;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

/**
 * AbstractAlert
 * This is the base Alert class that all Alert
 * subclasses and objects are based upon.
 */
abstract class AbstractAlert extends Notification
{
    use Queueable;

    /**
     * Alert heading persisted on the notification.
     *
     * @var string
     */
    protected string $title;

    /**
     * Alert body text persisted on the notification.
     *
     * @var string
     */
    protected string $body;

    /**
     * Optional action URL persisted on the notification.
     *
     * @var string
     */
    protected string $link;

    /**
     * Optional link label persisted on the notification.
     *
     * @var string
     */
    protected string $linkText;

    /**
     * Optional icon markup or key persisted on the notification.
     *
     * @var string
     */
    protected string $icon = '';

    /**
     * __construct
     * Stores title, body, optional link label and URL, and optional icon key for database notifications.
     *
     * @param  string  $title  Alert heading.
     * @param  string  $body  Alert message body.
     * @param  string  $link  Optional action URL.
     * @param  string  $linkText  Optional link label.
     * @param  string  $icon  Optional icon markup or identifier.
     * @return void
     */
    public function __construct(
        string $title,
        string $body,
        string $link = '',
        string $linkText = '',
        string $icon = ''
    ) {
        $this->title = $title;
        $this->body = $body;
        $this->link = $link;
        $this->linkText = $linkText;
        $this->icon = $icon;
    }

    /**
     * name
     * Get the name of the Alert from the Class name
     *
     * @return string
     */
    public static function name(): string
    {
        $elements = explode('\\', static::class);
        $class = end($elements);

        return implode(' ', Str::ucsplit($class));
    }

    /**
     * title
     * Alert heading stored on the notification payload.
     *
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * body
     * Main message body stored on the notification payload.
     *
     * @return string
     */
    public function body(): string
    {
        return $this->body;
    }

    /**
     * link
     * Optional URL associated with the alert.
     *
     * @return string
     */
    public function link(): string
    {
        return $this->link;
    }

    /**
     * linkText
     * Optional label for the alert link.
     *
     * @return string
     */
    public function linkText(): string
    {
        return $this->linkText;
    }

    /**
     * icon
     * Optional icon identifier from the alert type configuration.
     *
     * @return string
     */
    public function icon(): string
    {
        return $this->icon;
    }

    /**
     * via
     * Laravel notification delivery channels for this alert.
     *
     * @return string[]
     */
    public function via(): array
    {
        return ['database'];
    }

    /**
     * toJson
     * JSON-encodes the same structure as {@see self::toArray()}.
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * toArray
     * Payload written to the database notifications table for this alert.
     *
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'link' => $this->link,
            'linkText' => $this->linkText,
            'icon' => $this->icon,
        ];
    }
}
