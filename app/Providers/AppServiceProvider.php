<?php

namespace App\Providers;

use App\Repository\Customer\CustomerRepository;
use App\Repository\Item\ItemRepository;
use App\Repository\Purchase\PurchaseRepository;
use App\Repository\Reservation\ReservationRepository;
use App\Servises\CustomerService;
use App\Servises\ItemService;
use App\Servises\PurchaseService;
use App\Servises\ReservationService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->bind(CustomerService::class, CustomerRepository::class);
    $this->app->bind(ReservationService::class, ReservationRepository::class);
    $this->app->bind(ItemService::class, ItemRepository::class);
    $this->app->bind(PurchaseService::class, PurchaseRepository::class);
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    if (config('app.env') === 'production') {
      URL::forceScheme('https');
    }
  }
}
