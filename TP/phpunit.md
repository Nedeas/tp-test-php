PHPUnit
=======

Outils de test unitaire.

Site officiel : https://phpunit.de/  
Documentation : https://phpunit.readthedocs.io/

## Installation

```shell
composer require --dev phpunit/phpunit 
```

Cela install le binaire de `phpunit` dans le répertoire `./vendor/bin/phpunit` du projet.  
Et cela uniquement lors de l'installation en mode "dev".

## Faire les tests pour la classe `App\Util\ChainedList\Element`

1. Créez la même arborescence de répertoire présent pour `src` dans `tests`
2. Créez une classe de test portant le nom de l'objet et finissant par `Test` (ex. : `ElementTest`)
3. Le namespace doit être `Tests\Util\ChainedList` (voir le `composer.json`, section `autoload-dev > psr-4`)
4. La classe doit étendre `PHPUnit\Framework\TestCase`. Cette classe fournit un ensemble de méthode permettant de vérifier le résultat de votre test.  
Ces méthodes sont documentées dans l'`APPENDIX` de la documentation partie `Assertions` : https://phpunit.readthedocs.io/en/9.5/assertions.html  
5. Créer les méthodes de test (voir l'exemple si dessous). Attention :
     - Une méthode égale un test.
     - Le nom de la méthode doit commencer par `test` obligatoirement.

Exemple : 
```injectablephp
<?php

namespace Tests\Util\ChainedList;

use App\Util\ChainedList\Element;
use PHPUnit\Framework\TestCase;

class ElementTest extends TestCase
{
// ...
    public function testGetElement()
    {
        $element = new Element('item_1');
        $this->assertSame('item_1', $element->getElement());
    }
// ...
}
```

### Lancement de vos tests

```shell
php ./vendor/bin/phpunit tests
```

Le paramètre `tests` est le répertoire dans lequel `phpunit` va chercher les fichiers nommés `*Test.php`.

### Annotation utils

Lorsqu'un test dépends d'un autre, il est possible d'ajouter l'annotation suitante :

```injectablephp
// ...
    /**
     * @depends testGetElement
     */
    public function testSetElement()
    {
        // ...
    }
// ...
```

Dans ce cas, si `testGetElement` échoue alors `testSetElement` ne sera pas jouée (`skipped`).

### Tips

Ajouter l'option `--testdox` à la commande pour avoir un affichage plus détaillé.
```shell
php ./vendor/bin/phpunit --testdox tests
```

## Faire les tests pour la classe `App\Util\ChainedList\ChainedList`

Faite la classe de test pour chainedList.

### Utiliser un `dataProvider`

Un `dataProvider` permet de passer un ensemble d'élément à notre fonction de test. Il doit retouner un tableau à 2 dimensions :
   - La 1ière dimension est un cas de test. Elle peut avoir une clé de type texte. Cette clé sera le nom du cas de test.
   - Le 2d sont les paramètres passés à la méthode utilisant ce `provider`

Pour qu'une méthode de test utilise un provider, il faut ajouter l'annotation `dataprovider` sur la méthode.

Attention : prêter bien attention aux nombres de paramètre de votre méthode de teste, l'ordre et le nombre d'élément présent dans la seconde dimension du tableau retourné par le `provider`.

#### Exemple

```injectablephp
<?php

namespace Tests\Util\ChainedList;

use App\Util\ChainedList\ChainedList;
use PHPUnit\Framework\TestCase;

class ChainedListTest extends TestCase
{
// ...
    /**
     * @dataProvider sizeProvider
     */
    public function testSize(ChainedList $chainedList, int $size)
    {
        $this->assertSame($size, $chainedList->size());
    }

    public function sizeProvider(): array
    {
        $dataTest = [];

        $chainedList = new ChainedList();
        $dataTest['Zero'] = [$chainedList, 0];

        $chainedList = new ChainedList();
        $chainedList->add('1');
        $dataTest['One'] = [$chainedList, 1];

        $chainedList = new ChainedList();
        $chainedList->add('1');
        $chainedList->add('2');
        $chainedList->add('3');
        $dataTest['Three'] = [$chainedList, 3];

        return $dataTest;
    }
// ...
}
```