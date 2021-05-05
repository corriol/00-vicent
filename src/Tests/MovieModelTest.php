<?php

namespace App\Tests;

use App\Entity\Movie;
use App\Model\MovieModel;
use PDO;
use PHPUnit\Framework\TestCase;

class MovieModelTest extends TestCase
{
    /**
     * @covers
     */
    public function testValidate()
    {
        $pdoDummy = $this->createPartialMock(PDO::class, []);
        $movieStub = $this->createStub(Movie::class);

        $movieModel = new movieModel($pdoDummy);

        $movieStub->method("getTitle")
            ->willReturn("Acme Corporation");

        $movieStub->method("getOverview")
            ->willReturn("Acme Corporation");

        $movieStub->method("getReleaseDate")
            ->willReturn("2021-01-25");

        $errors = $movieModel->validate($movieStub);
        $this->assertCount(0, $errors);
    }

    /**
     * @covers
     */
    public function testValidateWithFails()
    {
        $pdoDummy = $this->createPartialMock(PDO::class, []);
        $movieStub = $this->createStub(Movie::class);

        $movieModel = new movieModel($pdoDummy);

        $movieStub->method("getReleaseDate")
            ->willReturn("12/01/2021");

        $errors = $movieModel->validate($movieStub);
        $this->assertCount(3, $errors);
    }

}
