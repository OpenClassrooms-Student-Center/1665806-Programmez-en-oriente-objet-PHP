# 1665806-Programmez-en-oriente-objet-PHP

## TP P3C1

Dans le cadre du projet MatchMaker, il serait bon de séparer nos classes dans des espaces de nom dédiés et de les organiser de manière logique.
Partons du principe que nos espaces de nom seront préfixées par `App` pour désigner toutes les classes appartenant à notre application MatchMaker.

Ajoutez autant d'espaces de nom que nécessaires et placez les classes logiquement sous ces espaces :) 

## Correction

J'ai choisi d'utiliser 2 espaces. Plus précisément, 1 espace de nom, ainsi qu'un sous-espace. `App\MatchMaker` et `App\MatchMaker\Player`. Ces choix sont complètement arbitraire. Mais ils ont une logique. J'ai choisi de regrouper l'ensemble des classes en lien avec les joueurs sous le même espace. Puisque nous sommes dans l'application MatchMaker, j'ai regroupé l'ensemble sous un espace commun. L'idée étant de pouvoir m'autoriser d'avoir autre chose que `MatchMaker` sous `App`.
