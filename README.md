# universal model package

![laravel-universal](https://img.shields.io/badge/stable-v0.01-success)![universal meta model](https://img.shields.io/badge/asddaniel-universal-blue)

Universal est un package Package laravel permettant de gerer vos models sans liens avec les tables de la base de données, donc pas de gestion de migrtion à chue nouveu model crée



## Installation

vous pouvez installer ce package via composer:

```bash
composer require asddaniel/laravel-universal
```
vous devez ensuite publier les migrations des 4 tables de base avec la commande suivante

```bash
php artisan vendor:publish --tag="universal-migrations"

```
ceci va copier les fichiers des migrtions dans le bon dossier



## Usage
pour crée un model universel vous devez lancer la commande suivante suivit du nom du model (l'exemple de Post ci-dessous)
```php
    php artisan make:universalmodel Post
```
 la commande va crée un nouveau model universel dans le dossier universalModels à l'interieur du dossier App.

 ensuite il ne vous reste qu'à ouvrir le model et ajouter les attribut qui seront directement pris en compte dans la persistnce comme s'ils étaient des colonnes d'une table de meme nom
en voici un exemple ci-dessous
```php
<?php

declare(strict_types=1);

namespace App\UniversalModels;

use Asddaniel\UniversalLaravel\universal\UniversalModel;

class Post extends UniversalModel
{
    public $auteur;
    public $content;
}


```
## Usage
pour lire les données il y a la méthode all et get
```php
$posts = Post::all();// liste tous les posts
$post = Post::get(1);//récupere un post suivant son id
Post::delete(1);//supprime un post suivant son id
Post::update($array); // modifie un post avec un tableau associatif de chaque attribut avec sa valeur 
Post::update(3, ["title"=>"mon titre", "content"=>"mon contenu"]);

```
pour enregistrer des nouvelles données 

```php
Post::create(["title"=>"mon titre", "content"=>"contenu ajouté"]);

```
on lie chaque attribut à sa valeur à travers le tableau associatif


## Contributing

contactez-nous pour voir comment contribuez u projet

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Daniel Assani](https://github.com/asddaniel)
- [All Contributors](../../contributors)

## License

la License MIT  (MIT). voir [License File](LICENSE.md) pour plus d'information.
