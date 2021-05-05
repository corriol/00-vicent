<?php

namespace UseCase;

use App\Entity\Movie;
use App\Entity\Rating;
use App\Entity\User;
use App\Model\MovieModel;
use App\Model\RatingModel;
use App\UseCase\RateMovie;
use PDO;
use PHPUnit\Framework\TestCase;

class RateMovieTest extends TestCase
{
    /**
     * @test
     * @covers
     */
    public function usersCanRateMovies() {
        $pdoDummy = $this->createPartialMock(PDO::class, []);
        $ratingDummy = $this->createPartialMock(Rating::class, []);

        $ratingModelStub = $this->createStub(RatingModel::class);
        $ratingModelStub->method("findOneBy")->willReturn($ratingDummy);


        $userStub = $this->createStub(User::class);
        $userStub->method("getId")->willReturn(1);

        $movieStub = $this->createStub(Movie::class);
        $movieStub->method("getId")->willReturn(1);

        $rateMovie = new RateMovie($ratingModelStub);
        $rating = $rateMovie->execute($userStub, $movieStub, 2);

        $this->assertInstanceOf(Rating::class, $rating);

    }
}
