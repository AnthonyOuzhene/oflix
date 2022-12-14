# Récap'

## Event Maintenance

Objectif : afficher un message d'alerte sur toutes les pages

Comment mettre du html sur toutes les pages sans passer par twig ?

Pour afficher quelque chose dans toutes les pages, on peut d'inspirer de ce qui [est fait pour 'injecter' la toolbar de profiler.](https://github.com/symfony/web-profiler-bundle/blob/c779222d5a87b7d947e56ac09b02adb34cf8b610/EventListener/WebDebugToolbarListener.php#L137)

On remarque de suite que c'est un [KernelEvent](https://github.com/symfony/web-profiler-bundle/blob/c779222d5a87b7d947e56ac09b02adb34cf8b610/EventListener/WebDebugToolbarListener.php#L162)

Chouette, on sait faire les subscriber. 😍

```bash
bin/console make:subscriber
```

On choisit `Kernel.response` comme on l'a vu dans le code de la barre de profiler.

Mais ensuite 🤔 ?
le code de la barre de profiler n'est pas très explicite 😅

Réfléchissons, on est sur l'event `response`, on a donc accès à la réponse HTML juste avant qu'elle soit envoyée.
Si on modifiait le contenu du HTML ? un peu comme en JS on manipule le DOM.

Pour ça on veut obtenir quoi ?
une balise `<div class="alert alert-danger m-3">Maintenance prévue mardi 10 janvier à 17h00</div>` mais où ?

C'est subjectif, mais choissisons un endroit visible 🤓, disons juste après la `<nav>`

On va donc rechercher la `nav` dans le contenu de la page, que l'on obtient avec le `ResponseEvent` passé en paramètre.

On y insère notre message juste après.

```php
// la réponse HTTP
$response = $event->getResponse();
// le contenu HTML
$content = $response->getContent();
// On ajoute le code de la bannière après la balise nav du contenu HTML
$newHtml = str_replace(
    // Qu'est-ce qu'on cherche ?
    '</nav>',
    // Par quoi on remplace ?
    '</nav><div class="alert alert-danger m-3">Maintenance prévue mardi 10 janvier à 17h00</div>',
    // Dans quelle chaine ?
    $content
);
// On assigne le nouveau contenu à la réponse
$response->setContent($newHtml);

// /!\ Nul besoin de retourner quoique ce soit ou d'appeler une méthode spécifique
// l'objet $reponse a été manipulé directement et sera envoyé par le Kernel
```