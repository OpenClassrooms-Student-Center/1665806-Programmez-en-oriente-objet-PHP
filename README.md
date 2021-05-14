# 1665806-Programmez-en-oriente-objet-PHP

## Correction du TP P2C2

Dans cet exercice, le code de la salle d'attente (la classe `Lobby`) existe ainsi que le code d'un joueur (la classe `Player`). Lorsqu'un joueur s'enregistre dans le Lobby, il devient un Joueur en Attente. Un joueur en attente possède une propriété `range` qui est un entier. Le but de cette propriété, est d'accroitre la portée de la recherche d'un adversaire, lorsqu'aucun ne correspond au niveau du joueur. Le but étant de trouver un adversaire quitte à ce qu'il soit plus faible ou plus fort.

Votre tâche est de créer une classe `QueuingPlayer` qui étends la classe `Player`.
Et de lui ajouter la propriété `range`.

## Solution

La solution que j'ai choisi est : 

```php
class QueuingPlayer extends Player
{
    public function __construct(Player $player, protected int $range = 1)
    {
        parent::__construct($player->getName(), $player->getRatio());
    }

    public function getRange(): int
    {
        return $this->range;
    }

    public function upgradeRange(): void
    {
        $this->range = min($this->range + 1, 40);
    }
}
```

Seule la méthode upgradeRange permet de mettre à jour la portée de recherche avec un maximum de 40 niveaux d'écart (c'est complètement arbitraire)

Le constructeur est mon moyen de reprendre les données du joueur dans ma nouvelle classe.
