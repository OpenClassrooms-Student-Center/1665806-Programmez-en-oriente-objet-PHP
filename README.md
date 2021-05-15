# 1665806-Programmez-en-oriente-objet-PHP

## TP P3C2

Utilisez la fonction `spl_autoload_register` pour charger automatiquement vos classes, et répartissez-les dans une arborescence correspondant à vos espaces de noms afin de respecter PSR-4.

## Correction

Toujours dans l'idée de ne pas me fermer à des évolutions futures, j'ai choisi de placer l'ensemble de mes classes dans un répertoire source nommé `src`. Pour faire fonctionner le chargement automatisé, j'ai considéré `App` comme un Alias de `src`.

```php
spl_autoload_register(static function(string $fqcn){
    // je remplace App par src et les \ par des /.
    $path = sprintf('%s.php', str_replace(['App','\\'], ['src', '/'], $fqcn));
    require_once ($path);
});
```
