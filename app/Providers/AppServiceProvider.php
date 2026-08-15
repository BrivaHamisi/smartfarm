<?php

namespace App\Providers;

use App\Listeners\RecordAuthActivity;
use App\Models\ActivityLog;
use App\Models\Calf;
use App\Models\Cattle;
use App\Models\Checkup;
use App\Models\CropField;
use App\Models\CropHarvest;
use App\Models\CropInput;
use App\Models\DorperAnimal;
use App\Models\DorperBreedingRecord;
use App\Models\ErrorLog;
use App\Models\Finances;
use App\Models\Insemination;
use App\Models\Invoice;
use App\Models\MilkProduction;
use App\Models\Poultry;
use App\Models\Rabbit;
use App\Models\RabbitBreedingRecord;
use App\Models\User;
use App\Models\Workers;
use App\Observers\AuditObserver;
use App\Policies\ActivityLogPolicy;
use App\Policies\CalfPolicy;
use App\Policies\CattlePolicy;
use App\Policies\CheckupPolicy;
use App\Policies\CropFieldPolicy;
use App\Policies\CropHarvestPolicy;
use App\Policies\CropInputPolicy;
use App\Policies\DorperAnimalPolicy;
use App\Policies\DorperBreedingRecordPolicy;
use App\Policies\ErrorLogPolicy;
use App\Policies\FinancesPolicy;
use App\Policies\InseminationPolicy;
use App\Policies\InvoicePolicy;
use App\Policies\MilkProductionPolicy;
use App\Policies\PoultryPolicy;
use App\Policies\RabbitBreedingRecordPolicy;
use App\Policies\RabbitPolicy;
use App\Policies\UserPolicy;
use App\Policies\WorkersPolicy;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends AuthServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        ActivityLog::class => ActivityLogPolicy::class,
        Calf::class => CalfPolicy::class,
        Cattle::class => CattlePolicy::class,
        Checkup::class => CheckupPolicy::class,
        CropField::class => CropFieldPolicy::class,
        CropHarvest::class => CropHarvestPolicy::class,
        CropInput::class => CropInputPolicy::class,
        DorperAnimal::class => DorperAnimalPolicy::class,
        DorperBreedingRecord::class => DorperBreedingRecordPolicy::class,
        ErrorLog::class => ErrorLogPolicy::class,
        Finances::class => FinancesPolicy::class,
        Insemination::class => InseminationPolicy::class,
        Invoice::class => InvoicePolicy::class,
        MilkProduction::class => MilkProductionPolicy::class,
        Poultry::class => PoultryPolicy::class,
        Rabbit::class => RabbitPolicy::class,
        RabbitBreedingRecord::class => RabbitBreedingRecordPolicy::class,
        User::class => UserPolicy::class,
        Workers::class => WorkersPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        foreach ([
            Calf::class,
            Cattle::class,
            Checkup::class,
            CropField::class,
            CropHarvest::class,
            CropInput::class,
            DorperAnimal::class,
            DorperBreedingRecord::class,
            Finances::class,
            Insemination::class,
            MilkProduction::class,
            Poultry::class,
            Rabbit::class,
            RabbitBreedingRecord::class,
            Workers::class,
        ] as $model) {
            $model::observe(AuditObserver::class);
        }

        $listener = new RecordAuthActivity();

        Event::listen(Login::class, [$listener, 'onLogin']);
        Event::listen(Logout::class, [$listener, 'onLogout']);
        Event::listen(Failed::class, [$listener, 'onFailed']);
        Event::listen(Registered::class, [$listener, 'onRegistered']);
        Event::listen(PasswordReset::class, [$listener, 'onPasswordReset']);
    }
}
