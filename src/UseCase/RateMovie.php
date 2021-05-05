<?php


namespace App\UseCase;


use App\Entity\Movie;
use App\Entity\Rating;
use App\Entity\User;
use App\Model\RatingModel;

class RateMovie
{
    private RatingModel $ratingModel;

    public function __construct(RatingModel $ratingModel) {
        $this->ratingModel = $ratingModel;
    }

    public function execute(User $user, Movie $movie, int $value): Rating {
        $rating=$this->rateMovie($user, $movie, $value);
        return $rating;
    }

    private function rateMovie(User $user, Movie $movie, int $value): Rating {
        $rating = $this->ratingModel->findBy(["user_id"=>$user->getId(), "movie_id"=>$movie->getId()]);
        if (empty($rating)) {
            $rating = new Rating();
            $rating->setMovieId($movie->getId());
            $rating->setUserId($user->getId());
        }
        $rating->setValue($value);
        return $rating;
    }

}