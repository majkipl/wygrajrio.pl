<?php

namespace App\Factory;

use App\Entity\Where;
use App\Repository\WhereRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Where>
 *
 * @method        Where|Proxy                     create(array|callable $attributes = [])
 * @method static Where|Proxy                     createOne(array $attributes = [])
 * @method static Where|Proxy                     find(object|array|mixed $criteria)
 * @method static Where|Proxy                     findOrCreate(array $attributes)
 * @method static Where|Proxy                     first(string $sortedField = 'id')
 * @method static Where|Proxy                     last(string $sortedField = 'id')
 * @method static Where|Proxy                     random(array $attributes = [])
 * @method static Where|Proxy                     randomOrCreate(array $attributes = [])
 * @method static WhereRepository|RepositoryProxy repository()
 * @method static Where[]|Proxy[]                 all()
 * @method static Where[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Where[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Where[]|Proxy[]                 findBy(array $attributes)
 * @method static Where[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Where[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class WhereFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
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
        return [
            'name' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Where $where): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Where::class;
    }
}
