<?php

namespace App\Tests;

use App\Entity\Partner;
use App\Model\PartnerModel;
use PDO;
use PHPUnit\Framework\TestCase;

class PartnerModelTest extends TestCase
{
    /**
     * @covers
     */
    function testCreateNewPartnerValid(){
        // crea una conexión ficticia
        $pdo = new PDO( 'sqlite::memory:');

        // creamos el model para accedir a base de datos
        $partnerModel = new PartnerModel($pdo);
        // loadData crea un objeto $partner con los datos del array. El array suele ser $_POST.
        $partner = $partnerModel->loadData(["name"=>"Acte"], new Partner());
        // validate devuelve un array con los errores
        $errors = $partnerModel->validate($partner);
        // esperamos que no haya errores
        $this->assertCount(0, $errors);
    }

    /**
     * @covers
     */
    function testCreateNewPartnerFailed(){
        // crea una conexión ficticia
        $pdo = new PDO( 'sqlite::memory:');
        // creamos el model para accedir a base de datos
        $partnerModel = new PartnerModel($pdo);
        // loadData crea un objeto $partner con los datos del array. El array suele ser $_POST.
        $partner = $partnerModel->loadData(["name"=>""], new Partner());
        // validate devuelve un array con los errores
        $errors = $partnerModel->validate($partner);
        // esperamos que hay un error
        $this->assertCount(1, $errors);
    }

    /**
     * el objetivo es comprobar que el modelo valida correctamente
     * @test
     * @covers
     */
    function shouldNotReturnErrorsAfterSession6() {
        $pdoDummy = $this->createPartialMock(PDO::class, []);
        $partnerStub = $this->createStub(Partner::class);

        $partnerModel = new partnerModel($pdoDummy);

        $partnerStub->method("getName")
            ->willReturn("Acme Corporation");

        $errors = $partnerModel->validate($partnerStub);
        $this->assertCount(0, $errors);
    }

    /**
     *  el objetivo es comprobar que el modelo valida correctamente fallando porque
     *  el nombre del partner esta vacío.
     *  @test
     *  @covers
     */
    function shouldReturnOneErrorAfterSession6() {
        $pdoDummy = $this->createPartialMock(PDO::class, []);

        $partnerStub = $this->createStub(Partner::class);

        $partnerModel = new partnerModel($pdoDummy);

        $partnerStub->method("getName")
            ->willReturn("");

        $errors = $partnerModel->validate($partnerStub);
        $this->assertCount(1, $errors);
    }
}

