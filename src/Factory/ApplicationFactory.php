<?php

namespace App\Factory;

use App\Entity\Application;
use App\Entity\Category;
use App\Entity\Shop;
use App\Entity\Where;
use App\Repository\ApplicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Application>
 *
 * @method        Application|Proxy                     create(array|callable $attributes = [])
 * @method static Application|Proxy                     createOne(array $attributes = [])
 * @method static Application|Proxy                     find(object|array|mixed $criteria)
 * @method static Application|Proxy                     findOrCreate(array $attributes)
 * @method static Application|Proxy                     first(string $sortedField = 'id')
 * @method static Application|Proxy                     last(string $sortedField = 'id')
 * @method static Application|Proxy                     random(array $attributes = [])
 * @method static Application|Proxy                     randomOrCreate(array $attributes = [])
 * @method static ApplicationRepository|RepositoryProxy repository()
 * @method static Application[]|Proxy[]                 all()
 * @method static Application[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Application[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Application[]|Proxy[]                 findBy(array $attributes)
 * @method static Application[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Application[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class ApplicationFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(private EntityManagerInterface $manager)
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        $shops = $this->manager->getRepository(Shop::class)->findAll();
        $category = $this->manager->getRepository(Category::class)->findAll();
        $where = $this->manager->getRepository(Where::class)->findAll();

        return [
            'birth' => self::faker()->dateTime(),
            'category' => $category[array_rand($category)],
            'email' => self::faker()->email,
            'firstname' => self::faker()->firstName,
            'from_where' => $where[array_rand($where)],
            'img_receipt' => '00d7a0da6471a1e66b14029e93d48997.jpg',
            'lastname' => self::faker()->lastName,
            'legal_a' => self::faker()->boolean(true),
            'legal_b' => self::faker()->boolean(true),
            'legal_c' => self::faker()->boolean(true),
            'legal_d' => self::faker()->boolean(),
            'paragon' => self::faker()->text(8),
            'phone' => self::faker()->numerify('#########'),
            'product' => self::faker()->text(255),
            'shop' => $shops[array_rand($shops)],
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Application $application): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Application::class;
    }
}
