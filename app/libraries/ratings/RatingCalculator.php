<?php namespace Ratings;

use \App\Models\RatableEntity;
use \App\Models\Rating;

/**
 * Class Rating base class for all ratings for doctors, hospitals, etc
 */

class RatingCalculator {

    /**
     * @var \App\Models\RatableEntity;
     */
    private $ratableEntity;

    /**
    * @var \App\Models\Rating;
     */
    private $ratingModel;

    public function __construct(RatableEntity $ratableEntity, Rating $ratingModel) {
        $this->ratableEntity = $ratableEntity;
        $this->ratingModel = $ratingModel;
    }

    /**
     * @return mixed averaged rating for all rating fields or null if doctor has no ratings
     */
    public function getCombinedAverage() {
        $ratings = $this->ratableEntity->ratings()->get();
        if(isset($ratings[0])) {
            $ratableFields = $ratings[0]->getRatableFields();
            $avgRatingPerUser = array();
            foreach ($ratings as &$rating) {
                foreach ($rating as $field => $value) {
                    if (!in_array($field, $ratableFields) || $value == false) {
                        unset($rating[$field]);
                    }
                }
                //$nonZeroRatings = array_filter($rating, function($rating) { return $rating !== null; });
                $avgRatingPerUser[] = array_sum($rating)/count($rating);
            }
                $average = array_sum($avgRatingPerUser)/count($avgRatingPerUser);
                $average = (int) round($average, 0, PHP_ROUND_HALF_UP);
        } else {
            $average = null;
        }
        return $average;
    }

    /**
     * @return array key value pair of rating field and the average value for that field for all users
     */
    public function getAverageRatingByField() {
        $ratableFields = $this->ratingModel->getRatableFields();
        $ratings = $this->ratableEntity->ratings()->get($ratableFields);
        $averages = array();
        foreach ($ratings as $rating) {
            foreach ($ratableFields as $field) {
                if ($rating[$field] !== null) {
                    $averages[$field][] = $rating[$field];
                }
            }
        }
        foreach ($ratableFields as $field) {
            if (!isset($averages[$field])) {
                $averages[$field] = null;
            } else {
                $average = array_sum($average[$field])/count($average[$field]);
                $averages[$field] = (int) round($average, 0, PHP_ROUND_HALF_UP);
            }
        }
        return $averages;
    }

    /**
     * @return int total number of ratings
     */
    public function getRatingCount() {
        return $this->ratableEntity->ratings()->get()->count();
    }
}