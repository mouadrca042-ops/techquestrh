<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parcours;
use Database\Seeders\Concerns\CreeModulesFormation;

class ErpFormationSeeder extends Seeder
{
    use CreeModulesFormation;

    public function run(): void
    {
        $erp = Parcours::where('outil', 'ERP')->firstOrFail();

        $modules = [

            // ── Module 1 ──────────────────────────────────────────────
            [
                'titre'         => "Comprendre l'ERP et le libre-service",
                'type'          => 'mixte',
                'niveau'        => 'debutant',
                'xp_recompense' => 10,
                'contenu_json'  => [
                    'objectif' => "Comprendre ce qu'est un ERP, le libre-service employé et s'y connecter en sécurité.",
                    'lecon' => [
                        'titre' => "L'ERP et le libre-service employé",
                        'duree' => '6 min',
                        'intro' => "De plus en plus de démarches RH passent par un seul outil : l'ERP. Comprendre son rôle et le périmètre du libre-service vous rend autonome sur vos démarches courantes.",
                        'sections' => [
                            [
                                'titre' => "Qu'est-ce qu'un ERP",
                                'corps' => "ERP signifie Enterprise Resource Planning, en français Progiciel de Gestion Intégré. C'est un logiciel unique qui regroupe et fait communiquer les grandes fonctions de l'entreprise — ressources humaines, paie, congés, achats, comptabilité — autour d'une base de données commune. L'information est saisie une fois, puis partagée par tous les services concernés.",
                            ],
                            [
                                'titre' => 'Le libre-service employé',
                                'corps' => "Le portail libre-service (Employee Self-Service) est votre espace personnel dans l'ERP. Il vous permet de réaliser vos démarches sans formulaire papier ni passage systématique par les RH.",
                                'liste' => [
                                    "Consulter ses bulletins de paie et documents RH",
                                    "Demander des congés et suivre leur statut",
                                    "Déclarer des notes de frais",
                                    "Mettre à jour ses coordonnées et son RIB",
                                ],
                            ],
                            [
                                'titre' => 'Se connecter en sécurité',
                                'corps' => "L'accès se fait avec vos identifiants professionnels, souvent renforcés par une double authentification (code reçu sur mobile). Ces accès sont strictement personnels : vos données de paie et personnelles y sont visibles. Pensez à vous déconnecter sur un poste partagé.",
                                'astuce' => "Au premier accès, vérifiez et complétez vos informations personnelles : elles alimentent la paie et les documents officiels.",
                            ],
                            [
                                'titre' => 'En pratique',
                                'corps' => "À votre arrivée, on vous donne un accès à l'ERP. Connectez-vous avec vos identifiants, validez la double authentification reçue sur votre mobile, puis ouvrez la rubrique « Mes informations » pour vérifier que votre adresse et votre RIB sont corrects.",
                            ],
                        ],
                        'resume' => [
                            "ERP = Progiciel de Gestion Intégré : un outil unique sur une base commune",
                            "Le libre-service (ESS) rend l'employé autonome sur ses démarches RH",
                            "Accès personnels et confidentiels, souvent avec double authentification",
                        ],
                    ],
                    'questions' => [
                        [
                            'id' => 1, 'type' => 'qcm',
                            'question' => "Que signifie ERP ?",
                            'options' => [
                                'Espace RH Personnel',
                                'Enterprise Resource Planning (Progiciel de Gestion Intégré)',
                                'Extranet des Ressources et de la Paie',
                                'Employé, Recrutement, Paie',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "ERP signifie Enterprise Resource Planning, soit Progiciel de Gestion Intégré : un logiciel unique qui réunit les grandes fonctions de l'entreprise (RH, paie, achats, comptabilité…) autour d'une base de données commune. Les autres propositions sont des inventions : le sigle est international et toujours le même.",
                        ],
                        [
                            'id' => 2, 'type' => 'vrai_faux',
                            'question' => "Le libre-service permet de gérer ses congés sans passer par un formulaire papier.",
                            'bonne_reponse' => 'Vrai',
                            'explication' => "Le libre-service (Employee Self-Service) permet justement de réaliser ses démarches — congés, paie, frais — directement depuis son espace personnel, sans formulaire papier ni passage systématique par les RH. C'est tout son intérêt : autonomie et rapidité pour le salarié.",
                        ],
                        [
                            'id' => 3, 'type' => 'qcm',
                            'question' => "Pourquoi ne faut-il pas partager ses identifiants ERP ?",
                            'options' => [
                                'Pour économiser des licences',
                                "Parce qu'ils donnent accès à des données personnelles et de paie",
                                "Parce que c'est plus rapide",
                                "Il n'y a aucun risque",
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Le portail donne accès à des données personnelles et de paie : c'est pourquoi les identifiants sont strictement personnels et ne se partagent jamais. Ce n'est pas une question de licences ou de rapidité, mais de confidentialité et de responsabilité — toute action est tracée sous votre identité.",
                        ],
                        [
                            'id' => 4, 'type' => 'qcm',
                            'question' => "Sur quel principe repose un ERP ?",
                            'options' => [
                                'Un outil différent par service',
                                'Une base de données commune partagée entre les fonctions',
                                'Uniquement la comptabilité',
                                'Des fichiers Excel séparés',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Un ERP repose sur une base de données commune partagée entre les fonctions : une information saisie une seule fois (votre adresse, par exemple) devient aussitôt disponible pour la paie, les RH, etc. C'est l'inverse d'outils séparés ou de fichiers Excel isolés, qui se désynchronisent vite.",
                        ],
                        [
                            'id' => 5, 'type' => 'qcm',
                            'question' => "Au tout premier accès à l'ERP, quel est le bon réflexe ?",
                            'options' => [
                                'Partager ses identifiants avec un collègue',
                                'Vérifier et compléter ses informations personnelles',
                                'Ignorer le portail',
                                'Désactiver la double authentification',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Au premier accès, on vérifie et complète ses informations personnelles : elles alimentent la paie et les documents officiels, donc la moindre erreur s'y propage. Partager ses identifiants ou désactiver la double authentification reviendrait au contraire à affaiblir la sécurité de son compte.",
                        ],
                    ],
                ],
            ],

            // ── Module 2 ──────────────────────────────────────────────
            [
                'titre'         => 'Consulter et comprendre sa fiche de paie',
                'type'          => 'mixte',
                'niveau'        => 'debutant',
                'xp_recompense' => 10,
                'contenu_json'  => [
                    'objectif' => "Retrouver ses bulletins et comprendre les montants clés d'une fiche de paie.",
                    'lecon' => [
                        'titre' => 'Lire et comprendre son bulletin de salaire',
                        'duree' => '7 min',
                        'intro' => "Le bulletin de paie n'est plus un papier : il est archivé dans l'ERP. Savoir où le trouver et lire ses montants clés est essentiel pour vérifier sa rémunération.",
                        'sections' => [
                            [
                                'titre' => 'Où trouver ses bulletins',
                                'corps' => "Dans une rubrique dédiée (« Mes documents », « Paie » ou « Bulletins »), vos fiches sont disponibles au format PDF, consultables et téléchargeables, souvent plusieurs années en arrière. Une nouvelle fiche est généralement déposée chaque mois, après la clôture de la paie.",
                            ],
                            [
                                'titre' => 'Les montants clés',
                                'corps' => "Plusieurs montants se distinguent et ne doivent pas être confondus pour bien lire son bulletin.",
                                'liste' => [
                                    "Salaire brut → rémunération avant cotisations sociales",
                                    "Salaire net → ce qui reste après cotisations",
                                    "Net à payer → la somme effectivement versée sur le compte",
                                    "Net imposable → base utilisée pour l'impôt sur le revenu",
                                ],
                            ],
                            [
                                'titre' => 'Vérifier et conserver',
                                'corps' => "Contrôlez chaque mois les éléments variables : heures supplémentaires, primes, absences, congés. En cas de doute, contactez le service paie via l'ERP. Conservez vos bulletins sans limite de durée : ils servent de justificatifs et comptent pour la retraite.",
                                'astuce' => "Téléchargez systématiquement votre bulletin et archivez-le de votre côté : on doit pouvoir le présenter des dizaines d'années plus tard.",
                            ],
                            [
                                'titre' => 'En pratique',
                                'corps' => "En fin de mois, votre bulletin apparaît dans « Mes documents ». Téléchargez-le, vérifiez que les heures supplémentaires du mois y figurent, repérez le net à payer, puis archivez le PDF dans un dossier personnel pour le conserver durablement.",
                            ],
                        ],
                        'resume' => [
                            "Bulletins en PDF dans « Mes documents / Paie », archivés sur plusieurs années",
                            "Brut (avant cotisations), Net (après), Net à payer (versé), Net imposable (impôt)",
                            "Vérifier les éléments variables chaque mois et conserver durablement",
                        ],
                    ],
                    'questions' => [
                        [
                            'id' => 1, 'type' => 'qcm',
                            'question' => "Quel montant correspond à la somme réellement versée sur le compte ?",
                            'options' => ['Le salaire brut', 'Le net à payer', 'Le total des cotisations', 'Le net imposable'],
                            'bonne_reponse' => 1,
                            'explication' => "Le net à payer est le montant réellement viré sur votre compte, une fois toutes les cotisations déduites. Le salaire brut est la rémunération avant cotisations et le net imposable sert de base à l'impôt : ce sont trois montants distincts qu'il ne faut pas confondre.",
                        ],
                        [
                            'id' => 2, 'type' => 'qcm',
                            'question' => "Le salaire brut correspond à :",
                            'options' => [
                                'Ce qui reste après cotisations',
                                'La rémunération avant cotisations sociales',
                                'Le montant des primes seulement',
                                "La base de l'impôt",
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Le salaire brut est la rémunération avant déduction des cotisations sociales. C'est à partir de lui que l'on calcule les cotisations, puis le net : ce n'est donc ni le montant des primes seul, ni la base de l'impôt (qui est le net imposable).",
                        ],
                        [
                            'id' => 3, 'type' => 'vrai_faux',
                            'question' => "On peut généralement consulter ses bulletins de paie de plusieurs années dans l'ERP.",
                            'bonne_reponse' => 'Vrai',
                            'explication' => "L'ERP archive les bulletins au format PDF et les conserve sur plusieurs années : on peut les consulter et les télécharger à tout moment, sans dépendre d'un envoi papier. C'est l'un des grands avantages de la dématérialisation de la paie.",
                        ],
                        [
                            'id' => 4, 'type' => 'qcm',
                            'question' => "Combien de temps faut-il conserver ses bulletins de salaire ?",
                            'options' => [
                                'Un mois',
                                'Un an',
                                "Jusqu'au prochain bulletin",
                                'Sans limite (ils servent notamment pour la retraite)',
                            ],
                            'bonne_reponse' => 3,
                            'explication' => "Les bulletins de salaire se conservent sans limite de durée : ils servent de justificatifs (logement, prêt) et comptent surtout pour le calcul de la retraite, parfois des dizaines d'années plus tard. Les garder seulement un mois ou un an serait nettement insuffisant.",
                        ],
                        [
                            'id' => 5, 'type' => 'qcm',
                            'question' => "Vous avez fait des heures supplémentaires ce mois-ci. Où le vérifier ?",
                            'options' => [
                                'Dans votre agenda',
                                'Sur le bulletin de paie, parmi les éléments variables',
                                'Dans un canal Teams',
                                'Nulle part',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Les heures supplémentaires, comme les primes, font partie des éléments variables qui figurent sur le bulletin de paie : c'est donc là qu'on les vérifie, chaque mois. Un agenda ou un canal Teams ne sont pas des sources officielles de votre rémunération.",
                        ],
                    ],
                ],
            ],

            // ── Module 3 ──────────────────────────────────────────────
            [
                'titre'         => 'Gérer ses congés et absences',
                'type'          => 'mixte',
                'niveau'        => 'intermediaire',
                'xp_recompense' => 20,
                'contenu_json'  => [
                    'objectif' => "Déposer une demande d'absence, comprendre le circuit de validation et suivre son solde.",
                    'lecon' => [
                        'titre' => 'Demander et suivre ses congés',
                        'duree' => '7 min',
                        'intro' => "Poser un congé dans l'ERP suit un circuit précis. Le comprendre vous évite les mauvaises surprises et vous aide à planifier sereinement vos absences.",
                        'sections' => [
                            [
                                'titre' => 'Déposer une demande',
                                'corps' => "Dans « Mes absences » > « Nouvelle demande », choisissez le type (congés payés, RTT, sans solde, maladie, événement familial…), indiquez les dates de début et de fin, le cas échéant la demi-journée, puis soumettez. Un commentaire peut accompagner la demande.",
                            ],
                            [
                                'titre' => 'Le circuit de validation',
                                'corps' => "La demande est transmise automatiquement au valideur (votre manager). Vous suivez son statut en temps réel ; en cas de refus, un motif est généralement indiqué.",
                                'liste' => [
                                    "En attente → demande soumise, en cours d'examen",
                                    "Validée → absence accordée, jours décomptés du solde",
                                    "Refusée → non accordée, souvent avec un motif",
                                    "Annulée → demande retirée par l'employé avant la date",
                                ],
                            ],
                            [
                                'titre' => 'Comprendre son solde',
                                'corps' => "L'ERP affiche votre solde de jours acquis et pris, parfois distinct selon le type (congés payés vs RTT). Le solde se met à jour à la validation. Anticipez : déposez vos demandes assez tôt et tenez compte des règles internes (délais, périodes de forte activité).",
                                'astuce' => "Vérifiez votre solde AVANT de réserver des vacances : une demande peut être refusée si le solde est insuffisant ou si la période est restreinte.",
                            ],
                            [
                                'titre' => 'En pratique',
                                'corps' => "Vous voulez poser une semaine en juillet. Vérifiez d'abord votre solde, déposez la demande dans « Mes absences » avec les dates, puis suivez le statut. Tant qu'elle est « En attente », n'achetez pas vos billets : attendez la validation du manager.",
                            ],
                        ],
                        'resume' => [
                            "« Mes absences » > Nouvelle demande : type d'absence + dates",
                            "Circuit de validation par le manager ; statuts En attente / Validée / Refusée",
                            "Le solde se met à jour après validation ; anticiper les demandes",
                        ],
                    ],
                    'questions' => [
                        [
                            'id' => 1, 'type' => 'qcm',
                            'question' => "À qui est transmise une demande de congé après sa soumission ?",
                            'options' => ['À la comptabilité', 'Au manager (valideur)', 'À personne, elle est automatique', 'Aux collègues'],
                            'bonne_reponse' => 1,
                            'explication' => "Une demande de congé est transmise automatiquement à votre manager (le valideur), qui l'approuve ou la refuse. Elle ne s'accorde pas toute seule et ne part pas directement à la comptabilité : le circuit passe d'abord par la validation hiérarchique.",
                        ],
                        [
                            'id' => 2, 'type' => 'vrai_faux',
                            'question' => "Le solde de congés se met à jour automatiquement une fois la demande validée.",
                            'bonne_reponse' => 'Vrai',
                            'explication' => "Le solde de congés se met à jour automatiquement dès que la demande est validée : les jours correspondants sont alors décomptés. Tant que la demande reste « En attente », rien n'est encore retiré de votre solde.",
                        ],
                        [
                            'id' => 3, 'type' => 'qcm',
                            'question' => "Que signifie le statut « En attente » ?",
                            'options' => [
                                'La demande est refusée',
                                "La demande est soumise et en cours d'examen",
                                'Le congé est terminé',
                                'La demande a été supprimée',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Le statut « En attente » indique que la demande a bien été soumise et qu'elle est en cours d'examen par le valideur. Ce n'est ni un refus, ni une suppression, ni un congé terminé : il faut patienter jusqu'à la décision du manager.",
                        ],
                        [
                            'id' => 4, 'type' => 'qcm',
                            'question' => "Bonne pratique avant de poser une longue absence :",
                            'options' => [
                                "Partir d'abord, demander ensuite",
                                'Vérifier son solde et respecter les délais internes',
                                'Demander à un collègue de valider',
                                'Ne rien déclarer',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Avant une longue absence, on vérifie son solde de jours disponibles et on respecte les délais et règles internes (préavis, périodes de forte activité). Partir d'abord et déclarer ensuite, ou faire valider par un collègue, ne respecterait pas le circuit officiel.",
                        ],
                        [
                            'id' => 5, 'type' => 'qcm',
                            'question' => "Vous prévoyez des vacances mais votre demande est encore « En attente ». Avant de réserver :",
                            'options' => [
                                'Réserver immédiatement',
                                'Attendre que la demande passe « Validée »',
                                'Annuler la demande',
                                'Partir sans validation',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Tant que la demande est « En attente », le manager peut encore la refuser : il ne faut donc pas engager de frais (billets, réservations) avant qu'elle ne passe « Validée ». Réserver immédiatement, c'est risquer de payer pour un congé qui ne sera finalement pas accordé.",
                        ],
                    ],
                ],
            ],

            // ── Module 4 ──────────────────────────────────────────────
            [
                'titre'         => 'Notes de frais et remboursements',
                'type'          => 'mixte',
                'niveau'        => 'intermediaire',
                'xp_recompense' => 20,
                'contenu_json'  => [
                    'objectif' => "Constituer une note de frais conforme et comprendre le circuit de remboursement.",
                    'lecon' => [
                        'titre' => 'Déclarer ses frais professionnels',
                        'duree' => '8 min',
                        'intro' => "Quand vous avancez des dépenses pour le travail, la note de frais permet leur remboursement. Une note bien constituée, avec ses justificatifs, est remboursée sans accroc.",
                        'sections' => [
                            [
                                'titre' => 'Constituer une note',
                                'corps' => "Dans la rubrique « Notes de frais », créez une note puis ajoutez chaque dépense ligne par ligne. Chaque ligne précise les informations attendues — et surtout le justificatif, qui est obligatoire.",
                                'liste' => [
                                    "Date de la dépense",
                                    "Catégorie (repas, transport, hébergement, péage…)",
                                    "Montant TTC (et TVA si demandée)",
                                    "Justificatif joint (photo du reçu ou facture) — indispensable",
                                ],
                            ],
                            [
                                'titre' => 'Les règles à respecter',
                                'corps' => "L'entreprise fixe des plafonds (par exemple un montant maximum par repas) et des règles d'éligibilité (frais réellement professionnels). Une dépense sans justificatif, hors plafond ou non professionnelle sera rejetée. En cas de doute, référez-vous à la politique de frais interne.",
                            ],
                            [
                                'titre' => 'Le circuit de remboursement',
                                'corps' => "Une fois soumise, la note suit un circuit : validation par le manager, puis contrôle par la comptabilité. Après accord, le remboursement est versé, souvent avec la paie du mois suivant. Il n'est ni immédiat ni automatique : vous pouvez en suivre le statut dans l'ERP.",
                                'astuce' => "Photographiez chaque justificatif dès la dépense et déclarez régulièrement : une note trop ancienne ou un justificatif perdu peut être refusé.",
                            ],
                            [
                                'titre' => 'En pratique',
                                'corps' => "De retour d'un déplacement, créez une note de frais : ajoutez le train, l'hôtel et les repas, joignez une photo de chaque justificatif, et vérifiez que chaque montant respecte le plafond. Soumettez : la note part au manager, puis à la comptabilité.",
                            ],
                        ],
                        'resume' => [
                            "Une note regroupe des dépenses pro, chacune avec un justificatif obligatoire",
                            "Respecter plafonds et règles d'éligibilité, sinon rejet",
                            "Circuit : manager → comptabilité → remboursement (souvent sur la paie)",
                        ],
                    ],
                    'questions' => [
                        [
                            'id' => 1, 'type' => 'qcm',
                            'question' => "Qu'est-ce qui est indispensable pour chaque ligne d'une note de frais ?",
                            'options' => ['Un email de validation', 'Le justificatif (reçu ou facture)', 'La signature du collègue', 'Le numéro de badge'],
                            'bonne_reponse' => 1,
                            'explication' => "Le justificatif (reçu ou facture) est indispensable pour chaque ligne : il prouve la réalité de la dépense. Sans lui, la dépense ne peut être contrôlée et sera rejetée. Un email de validation ou un numéro de badge ne remplacent en rien une preuve d'achat.",
                        ],
                        [
                            'id' => 2, 'type' => 'vrai_faux',
                            'question' => "Une note de frais est remboursée immédiatement après sa soumission.",
                            'bonne_reponse' => 'Faux',
                            'explication' => "Une note de frais n'est jamais remboursée immédiatement : elle passe d'abord par la validation du manager, puis par le contrôle de la comptabilité, avant le versement — souvent avec la paie du mois suivant. C'est un circuit de validation, pas un paiement automatique.",
                        ],
                        [
                            'id' => 3, 'type' => 'qcm',
                            'question' => "Que se passe-t-il pour une dépense qui dépasse le plafond fixé par l'entreprise ?",
                            'options' => [
                                'Elle est remboursée intégralement',
                                'Elle peut être rejetée ou partiellement remboursée',
                                'Elle est doublée',
                                "Rien, il n'y a pas de plafond",
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Une dépense qui dépasse le plafond fixé par l'entreprise peut être refusée, ou remboursée seulement à hauteur du plafond. Ces plafonds (par repas, par nuit d'hôtel…) font partie de la politique de frais : mieux vaut les connaître avant d'engager la dépense.",
                        ],
                        [
                            'id' => 4, 'type' => 'qcm',
                            'question' => "Bonne pratique de gestion des justificatifs :",
                            'options' => [
                                'Les jeter après paiement',
                                'Les photographier dès la dépense et déclarer régulièrement',
                                'Attendre un an pour tout déclarer',
                                'Ne garder que les gros montants',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "La bonne pratique est de photographier chaque justificatif dès la dépense et de déclarer régulièrement : on évite ainsi les pertes et les refus liés à des notes trop anciennes. Attendre un an ou ne garder que les gros montants expose à voir des lignes rejetées.",
                        ],
                        [
                            'id' => 5, 'type' => 'qcm',
                            'question' => "Vous avez perdu le reçu d'un repas. Que va-t-il probablement arriver à cette ligne ?",
                            'options' => [
                                'Elle sera remboursée sans problème',
                                "Elle risque d'être rejetée faute de justificatif",
                                'Elle sera doublée',
                                'Elle deviendra un congé',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Sans justificatif, une dépense ne peut pas être prouvée : la ligne du repas dont vous avez perdu le reçu risque donc d'être rejetée. C'est précisément pourquoi on prend l'habitude de photographier chaque reçu immédiatement, avant de risquer de l'égarer.",
                        ],
                    ],
                ],
            ],

            // ── Module 5 ──────────────────────────────────────────────
            [
                'titre'         => 'Données personnelles, sécurité et autonomie',
                'type'          => 'mixte',
                'niveau'        => 'expert',
                'xp_recompense' => 30,
                'contenu_json'  => [
                    'objectif' => "Gérer ses informations personnelles, comprendre la confidentialité (RGPD) et adopter les bons réflexes de sécurité.",
                    'lecon' => [
                        'titre' => 'Données personnelles, confidentialité et bons réflexes',
                        'duree' => '7 min',
                        'intro' => "Le portail RH contient des données sensibles. Les tenir à jour et adopter de bons réflexes de sécurité protège à la fois vos intérêts et l'entreprise.",
                        'sections' => [
                            [
                                'titre' => 'Tenir ses informations à jour',
                                'corps' => "Adresse, RIB, contact d'urgence, situation familiale : ces données alimentent la paie et les documents officiels. Une coordonnée bancaire erronée retarde un salaire ; une adresse périmée égare un courrier officiel. Mettez-les à jour dès qu'elles changent, via la rubrique « Mes informations ».",
                            ],
                            [
                                'titre' => 'Confidentialité et RGPD',
                                'corps' => "Vos données personnelles sont protégées par la réglementation (le RGPD en Europe). L'entreprise ne les traite que dans un cadre défini. De votre côté, ne consultez que vos propres données et ne diffusez pas d'informations sur autrui obtenues via l'outil.",
                                'liste' => [
                                    "Ne consulter et modifier que ses propres données",
                                    "Mettre à jour RIB, adresse et contacts sans tarder",
                                    "Ne pas diffuser d'informations RH concernant des collègues",
                                    "Signaler toute anomalie au service RH",
                                ],
                            ],
                            [
                                'titre' => 'Réflexes de sécurité',
                                'corps' => "Protégez vos accès : mot de passe robuste et unique, double authentification activée, déconnexion sur les postes partagés. Méfiez-vous des emails imitant l'ERP (hameçonnage) : ne saisissez jamais vos identifiants via un lien reçu par message ; passez toujours par l'adresse officielle du portail.",
                                'astuce' => "Face à un email vous demandant de « confirmer vos identifiants ERP », ne cliquez pas : connectez-vous directement au portail et signalez le message à la sécurité informatique.",
                            ],
                            [
                                'titre' => 'En pratique',
                                'corps' => "Vous changez de banque. Mettez à jour votre RIB dans « Mes informations » sans tarder, pour que le prochain salaire soit versé au bon endroit. Et si un email vous demande de « confirmer vos identifiants » via un lien, ne cliquez pas : connectez-vous directement au portail officiel.",
                            ],
                        ],
                        'resume' => [
                            "Garder ses informations (RIB, adresse, contacts) à jour : elles alimentent la paie",
                            "Données protégées par le RGPD : ne consulter que les siennes",
                            "Sécurité : mot de passe fort, double authentification, vigilance face à l'hameçonnage",
                        ],
                    ],
                    'questions' => [
                        [
                            'id' => 1, 'type' => 'qcm',
                            'question' => "Pourquoi tenir son RIB à jour dans l'ERP ?",
                            'options' => ['Pour gagner des points', "Parce qu'il sert au versement du salaire", "Ce n'est pas utile", 'Pour changer de poste'],
                            'bonne_reponse' => 1,
                            'explication' => "Le RIB enregistré dans l'ERP sert à verser votre salaire : un RIB erroné ou périmé retarde, voire empêche, le virement. C'est pourquoi on le met à jour dès qu'on change de banque — ce n'est ni un détail ni un moyen de « gagner des points ».",
                        ],
                        [
                            'id' => 2, 'type' => 'vrai_faux',
                            'question' => "Les données personnelles dans l'ERP sont encadrées par la réglementation sur la protection des données (RGPD).",
                            'bonne_reponse' => 'Vrai',
                            'explication' => "Les données personnelles des salariés dans l'ERP sont encadrées par la réglementation sur la protection des données (le RGPD en Europe) : l'entreprise ne peut les traiter que dans un cadre défini et pour des finalités précises, et vous disposez de droits sur ces données.",
                        ],
                        [
                            'id' => 3, 'type' => 'qcm',
                            'question' => "Vous recevez un email imitant l'ERP qui demande vos identifiants. Que faire ?",
                            'options' => [
                                'Saisir ses identifiants via le lien',
                                'Ne pas cliquer, se connecter via le portail officiel et signaler',
                                "Transférer l'email à ses collègues",
                                'Répondre avec son mot de passe',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Face à un email imitant l'ERP qui réclame vos identifiants, on ne clique pas sur le lien : on se connecte directement via l'adresse officielle du portail, et on signale le message. C'est une tentative d'hameçonnage classique ; saisir ses identifiants ou transférer l'email ne ferait qu'aggraver le risque.",
                        ],
                        [
                            'id' => 4, 'type' => 'qcm',
                            'question' => "Quel réflexe renforce la sécurité de votre compte ?",
                            'options' => [
                                'Un mot de passe simple et réutilisé',
                                'La double authentification',
                                'Partager son accès avec un collègue de confiance',
                                'Rester connecté sur tous les postes',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "La double authentification ajoute une protection forte : même si quelqu'un connaît votre mot de passe, il lui manque le second facteur (code reçu sur mobile). À l'inverse, un mot de passe simple et réutilisé, le partage d'accès ou les sessions laissées ouvertes affaiblissent fortement la sécurité.",
                        ],
                        [
                            'id' => 5, 'type' => 'qcm',
                            'question' => "Vous recevez un SMS avec un lien « Mettez à jour votre compte RH maintenant ». Le réflexe sûr :",
                            'options' => [
                                'Cliquer et saisir ses identifiants',
                                'Ne pas cliquer et se connecter via le portail officiel',
                                'Transférer le SMS à ses collègues',
                                'Répondre avec son mot de passe',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Un SMS pressant avec un lien « Mettez à jour votre compte RH maintenant » est un signal typique d'hameçonnage : on ne clique pas, on se connecte via le portail officiel et on signale. Cliquer, transférer le SMS ou répondre avec son mot de passe exposerait directement le compte.",
                        ],
                    ],
                ],
            ],

        ];

        $this->creerModules($erp, $modules);
    }
}
