# 1665806-Programmez-en-oriente-objet-PHP

## TP P3C3

Créez des interfaces pour les classes `Player`, `QueuingPlayer` et `Lobby`.
Puis, remplacez les arguments attendus en utilisant les interfaces :)

## Correction

Pour ne pas répéter les méthodes entre les interfaces des classes Player et QueuingPlayer, j'ai choisi de concentrer les méthodes dans 2 interfaces différentes `PlayerInterface` et `QueingPlayerInterface`, puis de les lier entre-elles dans une troisième interface `InLobbyPlayerInterface`.
