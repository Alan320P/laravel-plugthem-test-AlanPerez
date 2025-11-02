<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Events\SurveyAnswered;
use App\Listeners\SendSurveyAnsweredNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * El mapa de eventos a listeners.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        SurveyAnswered::class => [
            SendSurveyAnsweredNotification::class,
        ],
    ];

    /**
     * Registrar cualquier evento para la aplicación.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determinar si debe auto-descubrir listeners.
     *
     * @return array<int, class-string>
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
