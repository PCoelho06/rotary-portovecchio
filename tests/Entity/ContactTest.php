<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ContactTest extends KernelTestCase
{
    public function getEntity(): Contact
    {
        $user = (new Contact())
            ->setEmail('test@test.fr')
            ->setFirstname('Test')
            ->setLastname('Test')
            ->setMessage('Petit message de test.');

        return $user;
    }

    public function assertHasErrors(Contact $contact, int $nbErrors = 0)
    {
        self::bootKernel();
        $error = self::getContainer()->get('validator')->validate($contact);

        $this->assertCount($nbErrors, $error);
    }

    public function testValidContact()
    {
        $this->assertHasErrors($this->getEntity(), 0);
        $this->assertHasErrors($this->getEntity()->setFirstname('Gérard')->setLastname('Lenôtre'), 0);
    }

    public function testInvalidEmail()
    {
        $this->assertHasErrors($this->getEntity()->setEmail('test'), 1);
        $this->assertHasErrors($this->getEntity()->setEmail('test@test'), 1);
        $this->assertHasErrors($this->getEntity()->setEmail('test.fr'), 1);
    }

    public function testInvalidBlankEmail()
    {
        $this->assertHasErrors($this->getEntity()->setEmail(''), 1);
    }

    public function testInvalidFirstname()
    {
        $this->assertHasErrors($this->getEntity()->setFirstname('123'), 1);
        $this->assertHasErrors($this->getEntity()->setFirstname('Test1'), 1);
    }

    public function testInvalidBlankFirstname()
    {
        $this->assertHasErrors($this->getEntity()->setFirstname(''), 1);
    }

    public function testInvalidLastName()
    {
        $this->assertHasErrors($this->getEntity()->setLastname('123'), 1);
        $this->assertHasErrors($this->getEntity()->setLastname('Test1'), 1);
    }

    public function testInvalidBlankLastName()
    {
        $this->assertHasErrors($this->getEntity()->setLastname(''), 1);
    }

    public function testInvalidBlankMessage()
    {
        $this->assertHasErrors($this->getEntity()->setMessage(''), 1);
    }
}
