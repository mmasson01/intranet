<?php

namespace Intra\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Intra\UserBundle\Entity\User;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
	/**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        for($i=1; $i <= 5; $i++) {
            ${'user' . $i} = $i;

            ${'user' . $i}= new User();
            ${'user' . $i}->setUsername('user-ok'.$i);
            ${'user' . $i}->setEmail('user-ok'.$i.'@gmail.com');
            ${'user' . $i}->getSalt();
            ${'user' . $i}->setEnabled(true);
            $encoder = $this->container
            ->get('security.encoder_factory')
            ->getEncoder(${'user' . $i})
            ;
            ${'user' . $i}->setPassword($encoder->encodePassword('user-ok'.$i, ${'user' . $i}->getSalt()));

            $manager->persist(${'user' . $i});
        }
        $manager->flush();
    }
}