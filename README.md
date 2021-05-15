# 1665806-Programmez-en-oriente-objet-PHP

## TP P2C4

Reprenons la solution du précédent exercice.  
Modifiez le code pour garantir l'extensibilité des méthodes, créez une classe abstraite pour les joueurs et utilisez le mot clé final.

Si vous voyez d'autres modifications utiles, effectuez-les :)

## Correction

Le solution que j'ai choisi est : 

```php
abstract class AbstractPlayer {
    public function __construct(public string $name = 'anonymous', public float $ratio = 400.0)
    {
    }

    abstract protected function getName(): string;
    abstract protected function getRatio(): float;
    abstract protected function probabilityAgainst(AbstractPlayer $player): float;
    abstract public function updateRatioAgainst(AbstractPlayer $player, int $result): void;
}
```

La classe `Player` hérite désormais de la classe abstraite, et toutes les références à la classe `Player` font maintenant référence à la classe `AbstractPlayer`.
