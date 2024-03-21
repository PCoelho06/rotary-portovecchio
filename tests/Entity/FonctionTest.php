<?php

namespace App\Tests\Entity;

use App\Entity\Fonction;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FonctionTest extends KernelTestCase
{
    public function getEntity(): Fonction
    {
        return (new Fonction())->setName('President');
    }

    public function assertHasErrors(Fonction $fonction, int $nbErrors = 0)
    {
        self::bootKernel();
        $error = self::getContainer()->get('validator')->validate($fonction);

        $this->assertCount($nbErrors, $error);
    }

    public function testValidFonction()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidFonction()
    {
        $this->assertHasErrors($this->getEntity()->setName('123'), 1);
        $this->assertHasErrors($this->getEntity()->setName('Président1'), 1);
    }

    public function testInvalidBlankFonction()
    {
        $this->assertHasErrors($this->getEntity()->setName(''), 1);
    }
}
