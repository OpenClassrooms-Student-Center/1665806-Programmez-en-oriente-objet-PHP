# 1665806-Programmez-en-oriente-objet-PHP

## TP P1C3 Suite de l'exercice

Vous avez une classe Encounter :) Il ne faut pas s'arrêter là !  
Vous trouverez une class Encounter dans le fichier index.php.

Votre mission à présent, est de :

- Créer une classe Player
- Et de lui ajouter les propriétés et méthodes nécessaires :)

Une fois que vous avez ajouté votre classe,
Le code suivant doit fonctionner :)

```php
<?php

// Vos classes ici.

$greg = new Player;
$jade = new Player;

$greg->level = 400;
$jade->level = 800;

$encounter = new Encounter;

echo sprintf(
	'Greg à %.2f%% chance de gagner face a Jade', 
	$encounter->probabilityAgainst($greg, $jade)*100
).PHP_EOL;

// Imaginons que greg l'emporte tout de même.
$encounter->setNewLevel($greg, $jade, RESULT_WINNER);
$encounter->setNewLevel($jade, $greg, RESULT_LOSER);

echo sprintf(
	'les niveaux des joueurs ont évolués vers %s pour Greg et %s pour Jade', 
	$greg->level,
	$jade->level
);

exit(0);
```
