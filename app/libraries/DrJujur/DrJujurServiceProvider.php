<?php namespace DrJujur;

use Illuminate\Support\ServiceProvider;


class DrJujurServiceProvider extends ServiceProvider {

    /**
     * Registers the bindings with IoC
     * @return void
     */
    public function register() {

       // $parameters['ratableEntity'] instance of model that implements App\Models\RatableEntity
       // $parameters['ratingsModel'] App\Models\Rating
       $this->app->bind('RatingCalculator', function ($app, $parameters) {
           return new \Ratings\RatingCalculator($parameters["ratableEntity"], $parameters["ratingModel"]);
       });
    }
}