<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Phone;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use phpDocumentor\Reflection\Types\Object_;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    const NUMBER_OF_PRODUCTS = 31;
    const NUMBER_OF_CUSTOMER = 11;
    const NUMBER_OF_USERS = 31;
    const BRANDS = array(
        "Apple",
        "Samsung",
        "Huawei",
        "Xiaomi",
        "OnePlus",
        "Google",
        "Sony",
        "LG",
        "Motorola",
        "Nokia",
        "HTC",
        "Oppo",
        "Vivo",
        "Asus",
        "BlackBerry",
        "Lenovo",
        "ZTE",
        "Alcatel",
        "Panasonic",
        "Honor"
    );

    const SCREENS_SIZES = array(
        "5 pouces",
        "5.5 pouces",
        "6 pouces",
        "6.2 pouces",
        "6.5 pouces",
        "6.7 pouces",
        "6.9 pouces",
        "7 pouces",
        "7.2 pouces",
        "7.5 pouces"
    );
    private UserPasswordHasherInterface $userPasswordHasher;
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');
        for ($c = 1; $c < self::NUMBER_OF_CUSTOMER; $c++) {
            $customer = new Customer();
            $customer->setName($faker->name);
            $customer->setEmail($faker->email);
            $customer->setPassword($this->userPasswordHasher->hashPassword($customer, 'password'));
            $customer->setRoles(['ROLE_USER']);
            $manager->persist($customer);
            $this->addReference($c, $customer);
            $customers[] = $c;
        }

        for ($u = 1; $u < self::NUMBER_OF_USERS; $u++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setPhone($faker->phoneNumber);
            $user->setCustomer($this->getReference($faker->randomElement($customers)));
            $user->setCreatedAt($faker->dateTimeBetween('-6 months'));
            $user->setUpdatedAt($faker->dateTimeBetween('-1 months'));
            $manager->persist($user);
        }

        for ($p = 1; $p < self::NUMBER_OF_PRODUCTS; $p++) {
            $product = new Phone();
            $product->setBrand($faker->randomElement(self::BRANDS));
            $product->setPrice($faker->randomFloat(2, 100, 1000));
            $product->setModel($faker->word);
            $product->setScreenSize($faker->randomElement(self::SCREENS_SIZES));
            $product->setColors([$faker->safeColorName(), $faker->safeColorName(), $faker->safeColorName()]);
            $product->setDescription($faker->text);
            $manager->persist($product);
        }


        $manager->flush();
    }
}
