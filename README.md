# 1665806-Programmez-en-oriente-objet-PHP

## TP P1C5

Transformez les méthodes de la classe `Encounter` pour utiliser le mot clé statique et mettez en place des constantes de classe pour les valeurs immuables.

Lorsque vous avez terminé, ajoutez le code suivant sous votre classe.
Il ne doit pas y avoir d'erreur à l'exécution.

```php
<?php

// vos classes ici.

$greg = new Player;
$jade = new Player;

$greg->level = 400;
$jade->level = 800;

echo sprintf(
	'Greg à %.2f%% chance de gagner face a Jade', 
	Encounter::probabilityAgainst($greg, $jade)*100
).PHP_EOL;

// Imaginons que greg l'emporte tout de même.
Encounter::setNewLevel($greg, $jade, Encounter::RESULT_WINNER);
Encounter::setNewLevel($jade, $greg, Encounter::RESULT_LOSER);

echo sprintf(
	'les niveaux des joueurs ont évolués vers %s pour Greg et %s pour Jade', 
	$greg->level,
	$jade->level
);

exit(0);
```

Vous trouverez un exemple de solution sur la branche `p1c5-correction` :)
