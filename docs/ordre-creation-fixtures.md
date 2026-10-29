# Ordre de création des données (fixtures)

Les données de test sont chargées par une classe de fixtures par entité (`src/DataFixtures/`).
Chaque classe déclare ses dépendances avec `getDependencies()` : Doctrine charge donc les
fixtures dans le bon ordre, quel que soit l'ordre des fichiers.

Commande de chargement (elle vide la base avant de la remplir) :

```
php bin/console doctrine:fixtures:load --no-interaction
```

## Ordre

| Étape | Fixture | Dépend de | Pourquoi cet ordre |
|---|---|---|---|
| 1 | `GroupementFixtures` | rien | Un groupement n'a besoin d'aucune autre donnée |
| 1 | `FonctionFixtures` | rien | Table de référence (présidente, secrétaire, trésorière, membre simple) |
| 1 | `RoleFixtures` | rien | Table de référence (Admin, MembreSimple, SupAdmin) |
| 1 | `PeriodiciteFixtures` | rien | Table de référence (hebdomadaire, mensuelle, bimensuelle, quinzaine) |
| 2 | `MembreFixtures` | Groupement, Fonction, Role | Un membre référence un rôle, et un groupement et une fonction (sauf le SupAdmin) |
| 2 | `ExerciceFixtures` | Groupement | Un exercice appartient à un groupement |
| 3 | `CampagneFixtures` | Groupement, Exercice, Periodicite, Membre | Une campagne appartient à un groupement et à un exercice, a deux périodicités, et reçoit ses participants |
| 4 | `ModeCotisationFixtures` | Campagne, Membre | Le mode de cotisation lie un membre à une épargne |
| 4 | `SeanceFixtures` | Campagne | Une séance appartient à une campagne |
| 5 | `CotisationFixtures` | Campagne, Seance, Membre | Une cotisation est versée par un membre pendant une séance ; ses montants de caisse sociale et d'amende viennent de la campagne |
| 5 | `PretFixtures` | Membre, Exercice | Un prêt est demandé par un membre pendant un exercice |

## Règles de cohérence respectées par les données

- Le SupAdmin n'a ni groupement ni fonction, et ne participe à aucune campagne.
- La tontine n'a pas de mode de cotisation : tout le monde cotise le même montant.
- Seules les épargnes ont un mode de cotisation (`isLibre`), renseigné pour chaque membre participant dès le début.
- L'épargne calebasse couvre toute la durée de l'exercice, avec tous les membres.
- L'épargne à durée précise a une participation optionnelle (deux membres sur quatre).
- Un membre n'a jamais deux prêts non remboursés en même temps.
- Les dates `createdAt` et `updatedAt` ne sont pas renseignées dans les fixtures : elles sont posées automatiquement par le trait `DateTimeTrait` (callbacks `PrePersist` et `PreUpdate`).
- Pour une séance, trois cas de cotisation sont représentés : membre présente (épargne + caisse présente), absente avec cotisation envoyée (épargne + caisse absente), absente sans cotisation (épargne payée plus tard + amende journalière cumulée).