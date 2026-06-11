<?php

namespace App\Support;

/**
 * Questions dédiées du TEST GLOBAL de fin de formation.
 * Stockées en code (pas en base) → aucune migration ni re-seed nécessaire.
 * Indexées par l'outil de la formation (Excel, Teams, ERP, Email).
 */
class TestGlobal
{
    public static function pour(string $outil): array
    {
        return self::TESTS[$outil] ?? [];
    }

    public const TESTS = [

        'Excel' => [
            ['id' => 1, 'type' => 'qcm', 'question' => "Quelle est l'adresse de la cellule située colonne D, ligne 5 ?",
             'options' => ['5D', 'D5', 'D-5', '5-D'], 'bonne_reponse' => 1,
             'explication' => "On note d'abord la colonne (lettre) puis la ligne (chiffre) : D5."],
            ['id' => 2, 'type' => 'qcm', 'question' => "Quelle formule additionne les cellules de B2 à B20 ?",
             'options' => ['=TOTAL(B2:B20)', '=SOMME(B2:B20)', '=ADD(B2:B20)', '=B2+B20'], 'bonne_reponse' => 1,
             'explication' => "=SOMME(B2:B20) additionne toute la plage."],
            ['id' => 3, 'type' => 'qcm', 'question' => "Comment figer la cellule C1 pour qu'elle ne bouge pas à la recopie ?",
             'options' => ['C1', '$C$1', '#C1', 'C1!'], 'bonne_reponse' => 1,
             'explication' => "Le signe \$ rend la référence absolue : \$C\$1."],
            ['id' => 4, 'type' => 'qcm', 'question' => "Quel graphique est le mieux adapté à une évolution sur 12 mois ?",
             'options' => ['Secteurs', 'Courbe', 'Histogramme empilé', 'Nuage de points'], 'bonne_reponse' => 1,
             'explication' => "La courbe montre une évolution dans le temps."],
            ['id' => 5, 'type' => 'vrai_faux', 'question' => "Filtrer un tableau supprime définitivement les lignes non concernées.",
             'bonne_reponse' => 'Faux',
             'explication' => "Le filtre masque temporairement les lignes : elles reviennent dès qu'on l'enlève."],
        ],

        'Teams' => [
            ['id' => 1, 'type' => 'qcm', 'question' => "Teams fait partie de quelle suite ?",
             'options' => ['Google Workspace', 'Microsoft 365', 'Adobe', 'LibreOffice'], 'bonne_reponse' => 1,
             'explication' => "Teams est la plateforme de collaboration de Microsoft 365."],
            ['id' => 2, 'type' => 'qcm', 'question' => "Comment notifier précisément une personne dans un message ?",
             'options' => ['En gras', 'Avec une @mention', 'Par email', 'En majuscules'], 'bonne_reponse' => 1,
             'explication' => "La @mention envoie une notification ciblée."],
            ['id' => 3, 'type' => 'vrai_faux', 'question' => "Un canal privé est accessible à tous les membres de l'équipe.",
             'bonne_reponse' => 'Faux',
             'explication' => "Un canal privé est réservé aux membres invités."],
            ['id' => 4, 'type' => 'qcm', 'question' => "Où planifie-t-on une réunion ?",
             'options' => ['Fichiers', 'Calendrier', 'Activité', 'Appels'], 'bonne_reponse' => 1,
             'explication' => "Calendrier > Nouvelle réunion."],
            ['id' => 5, 'type' => 'vrai_faux', 'question' => "Plusieurs personnes peuvent co-éditer un document Office en même temps dans Teams.",
             'bonne_reponse' => 'Vrai',
             'explication' => "C'est la co-édition en temps réel."],
        ],

        'ERP' => [
            ['id' => 1, 'type' => 'qcm', 'question' => "Que signifie ERP ?",
             'options' => ['Espace RH Personnel', 'Enterprise Resource Planning', 'Extranet Ressources Paie', 'Employé Recrutement Paie'], 'bonne_reponse' => 1,
             'explication' => "ERP = Enterprise Resource Planning (Progiciel de Gestion Intégré)."],
            ['id' => 2, 'type' => 'qcm', 'question' => "Quel montant correspond à ce qui est réellement versé sur le compte ?",
             'options' => ['Le brut', 'Le net à payer', 'Le total des cotisations', 'Le net imposable'], 'bonne_reponse' => 1,
             'explication' => "Le net à payer est la somme effectivement virée."],
            ['id' => 3, 'type' => 'qcm', 'question' => "Après avoir soumis une demande de congé, que se passe-t-il ?",
             'options' => ['Accordée automatiquement', 'Envoyée au manager pour validation', 'Imprimée', 'Supprimée'], 'bonne_reponse' => 1,
             'explication' => "Elle suit un circuit de validation par le manager."],
            ['id' => 4, 'type' => 'qcm', 'question' => "Qu'est-il indispensable pour chaque ligne d'une note de frais ?",
             'options' => ['Un email', 'Le justificatif', 'Un badge', 'Rien'], 'bonne_reponse' => 1,
             'explication' => "Sans justificatif, la dépense est refusée."],
            ['id' => 5, 'type' => 'qcm', 'question' => "Un email demande de « confirmer vos identifiants ERP » via un lien. Vous :",
             'options' => ['Cliquez et saisissez', 'Ne cliquez pas, passez par le portail officiel', 'Transférez à un collègue', 'Répondez avec le mot de passe'], 'bonne_reponse' => 1,
             'explication' => "C'est de l'hameçonnage : on passe par l'adresse officielle."],
        ],

        'Email' => [
            ['id' => 1, 'type' => 'qcm', 'question' => "Quel élément résume le message en une phrase ?",
             'options' => ['La signature', "L'objet", "La formule d'appel", 'La pièce jointe'], 'bonne_reponse' => 1,
             'explication' => "L'objet résume le contenu de l'email."],
            ['id' => 2, 'type' => 'qcm', 'question' => "Dans quel champ mettre une personne à informer sans action attendue ?",
             'options' => ['À', 'Cc', 'Cci', 'Objet'], 'bonne_reponse' => 1,
             'explication' => "Le Cc sert à informer sans attendre de réponse."],
            ['id' => 3, 'type' => 'qcm', 'question' => "Quel champ masque les adresses des destinataires entre eux ?",
             'options' => ['À', 'Cc', 'Cci', 'Objet'], 'bonne_reponse' => 2,
             'explication' => "Le Cci (copie cachée) protège les adresses lors d'un envoi groupé."],
            ['id' => 4, 'type' => 'vrai_faux', 'question' => "Avant d'envoyer un email annonçant un document, il faut vérifier que la pièce jointe est attachée.",
             'bonne_reponse' => 'Vrai',
             'explication' => "L'oubli de pièce jointe est l'erreur la plus fréquente."],
            ['id' => 5, 'type' => 'qcm', 'question' => "Quand utiliser « Répondre à tous » ?",
             'options' => ['Toujours', 'Seulement si tout le monde est concerné', 'Jamais', 'Pour dire merci'], 'bonne_reponse' => 1,
             'explication' => "On l'utilise uniquement si l'ensemble des destinataires est concerné."],
        ],
    ];
}
