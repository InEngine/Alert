<?php

namespace InEngine\Alert\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use InEngine\Alert\Facades\Alert;

use function Laravel\Prompts\multisearch;

/**
 * SendAlert
 * Interactive Artisan command that sends a configured alert type to one or many notifiable models.
 */
class SendAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public $signature = 'alert:send';

    /**
     * The console command description.
     *
     * @var string
     */
    public $description = 'Send a new alert to the model defined in the config with a specified type and message';

    /**
     * handle
     * Prompts for recipient(s), alert type, title, message, and optional link, then dispatches database notifications.
     *
     * @return int
     */
    public function handle(): int
    {
        $model_name = config('alert.model.FQN');

        $model_name = explode('\\', $model_name);

        $model_name = end($model_name);

        $field = config('alert.model.search_property');

        $model = null;

        $models = null;

        $single = $this->confirm('Would you like to send a single alert?', true);

        /** Send this Alert to only a single Model */
        if ($single == true) {
            $field = $this->anticipate("What $model_name would you like to send a new alert?",
                function (string $input) {
                    return config('alert.model.FQN')::whereLike(config('alert.model.search_property'), "$input%")
                        ->limit(5)
                        ->pluck(config('alert.model.search_property'))
                        ->all();
                });

            $model = config('alert.model.FQN')::where(config('alert.model.search_property'), $field)->first();

        } else {
            /** Send this Alert to multiple models at the same time */
            $models = multisearch(
                label: "Search for the $model_name's that should receive the Alert",
                options: fn (string $value) => strlen($value) > 0
                    ? config('alert.model.FQN')::whereLike(config('alert.model.search_property'),
                        "%{$value}%")->pluck(config('alert.model.search_property'))->all()
                    : [],
            );

            $models = config('alert.model.FQN')::wherein(config('alert.model.search_property'),
                $models)->get();
        }

        $alerts = Alert::getAlertTypesClassNames();
        $type = $this->choice('What type of Alert would you like to send?', $alerts, 0);

        $title = $this->ask('What is the title of the alert?');

        $message = $this->ask('What is the message you would like to send?');

        $addLink = $this->confirm('Would you like to add a link to this alert?', false);

        $link = '';
        $linkText = '';

        if ($addLink) {
            $linkText = $this->ask('What is the text label for the link?');

            $link = $this->ask('What is the link?');
        }

        if ($single == true) {
            $this->info('You are sending an Alert to: '.$model->$field);
        } else {
            $this->info('You are sending an Alert to: ');
            foreach ($models as $item) {
                $this->info($item->$field);
            }
        }

        $this->info('With an Alert of type: '.$type);
        $this->info('With an Title of: '.$title);
        $this->info('With a Message of: '.$message);
        if ($addLink) {
            $this->info("With a link: $link labeled: $linkText");
        }

        $correct = $this->confirm('Is this correct?', true);

        if ($correct) {
            $alert = Alert::createAlertByTypeClassName($type, $title, $message, $link, $linkText);

            if ($single) {
                Notification::sendNow($model, $alert);
                $this->info('Alert sent!');
            } else {
                Notification::sendNow($models, $alert);
                $this->info('Alerts sent!');
            }

        } else {
            $this->info('Alert not sent!');
        }

        return self::SUCCESS;
    }
}
