# Challenge

1. Créer le endpoint pour afficher le détail d'un movie !
   > /api/v10/movies/{id}
2. Créer le endpoint pour lister les utilisateurs
   > /api/v10/users

## Bonus

1. Créer le endpoint pour ajouter un utilisateur ( en POST )
   1. Il faudra récupérer le json dans la Request
   2. Il faudra désérialiser le json en un objet pour pouvoir faire un persist et flush
2. Gérer les roles dans la BDD en tant qu'entité ( avec une relation inverse !!! )
   1. supprimer l'existant sur les roles ( ne pas de faire de migration )
   2. créer une entité role avec une association avec user ( ManyToMany )
   3. créer la migration ( ! c'est une migration qui risque de faire perdre des données, il faut la modifier avant de la jouer )
   4. modifier les fixtures pour prendre en compte ce changement de structure
3. Corriger le endpoint qui liste les utilisateurs
