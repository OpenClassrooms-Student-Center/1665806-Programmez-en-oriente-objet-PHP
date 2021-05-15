# 1665806-Programmez-en-oriente-objet-PHP

## TP P2C5

Le chef de projet rentre dans la pièce et il sourit ! ce n'est pas bon signe, il a eu une idée...
Une compétition spéciale est organisée, c'est un serveur en mode rapide. Il va rester en ligne pendant 1 semaine.
Les joueurs doivent commencer à 1200 au lieu de 400 et leur ratio doit évoluer 4x plus vite.
Créez une classe `BlitzPlayer` pour l'occasion. Si vous voyez d'autres modifications utiles, effectuez les :)

## Correction

La solution que j'ai choisi est : 

```php
class BlitzPlayer extends Player
{
    public function __construct(public string $name = 'anonymous', public float $ratio = 1200.0)
    {
        parent::__construct($name, $ratio);
    }

    public function updateRatioAgainst(Player $player, int $result): void
    {
        $this->ratio += 128 * ($result - $this->probabilityAgainst($player));
    }
}
```

Et j'ai également modifié la visibilité de la méthode `probabilityAgainst` en `protected`.

Malheureusement ce n'est pas suffisant.
La classe BlitzPlayer repose sur Player, mais la classe QueuingPlayer aussi ! Ce n'est pas cohérent. Il faut aussi créer la classe BlitzQueuingPlayer. Or, c'est la classe Lobby qui est en charge de créer les joueurs en attente, il faut surcharger la méthode addPlayer, et donc étendre la classe Lobby en BlitzLobby.

Soudainement pour 1 besoin qui ne concerne que les joueurs, toutes nos classes ont dû subir un changement. Ce n'est pas idéal ! Et si un nouveau type de compétition arrive à nouveau, alors que de nouvelles classes sont appparues. Faudra-t'il tout dupliquer à nouveau malgré l'héritage ? Il y a de forte chances, oui. En tout cas dans l'état.

Nous venons de toucher les limites de l'héritage simple !
Nous allons apprendre à mieux structurer notre code dans la prochaine partie de ce cours :)
