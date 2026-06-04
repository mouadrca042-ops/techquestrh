<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parcours;
use Database\Seeders\Concerns\CreeModulesFormation;

class TeamsFormationSeeder extends Seeder
{
    use CreeModulesFormation;

    public function run(): void
    {
        $teams = Parcours::where('outil', 'Teams')->firstOrFail();

        $modules = [

            // ── Module 1 ──────────────────────────────────────────────
            [
                'titre'         => "Découvrir Teams et son interface",
                'type'          => 'mixte',
                'niveau'        => 'debutant',
                'xp_recompense' => 10,
                'contenu_json'  => [
                    'objectif' => "Comprendre le rôle de Teams et se repérer dans son interface.",
                    'lecon' => [
                        'titre' => "Microsoft Teams, le hub du travail d'équipe",
                        'duree' => '6 min',
                        'intro' => "Microsoft Teams est la plateforme de collaboration de Microsoft 365. Elle réunit en un seul endroit la messagerie, les réunions, les appels et les fichiers. Bien la prendre en main, c'est réduire les emails internes et centraliser l'information.",
                        'sections' => [
                            [
                                'titre' => 'Une plateforme tout-en-un',
                                'corps' => "Teams combine plusieurs services autrefois dispersés. C'est une application cloud : tout est synchronisé et accessible depuis le bureau, le web ou le mobile, avec le même compte professionnel.",
                                'liste' => [
                                    "Conversations (chat) : messages instantanés, individuels ou de groupe",
                                    "Équipes et canaux : espaces de travail organisés par sujet",
                                    "Réunions et appels : audio, vidéo, partage d'écran",
                                    "Fichiers : partage et co-édition de documents",
                                ],
                            ],
                            [
                                'titre' => 'La barre latérale de navigation',
                                'corps' => "À gauche, une barre d'icônes donne accès aux grandes zones : Activité (notifications), Conversation (chats privés), Équipes (vos espaces et canaux), Calendrier (réunions), Appels et Fichiers. C'est votre point de repère permanent.",
                            ],
                            [
                                'titre' => 'Présence et statut',
                                'corps' => "Votre pastille de statut (Disponible, Occupé, Ne pas déranger, Absent) informe vos collègues de votre disponibilité. Elle se met à jour automatiquement (en réunion, par exemple) mais peut aussi être définie manuellement.",
                                'astuce' => "Le mode « Ne pas déranger » suspend les notifications : idéal pendant une présentation ou une période de concentration.",
                            ],
                            [
                                'titre' => 'En pratique',
                                'corps' => "Premier jour avec Teams : ouvrez l'application, vérifiez que votre statut est sur « Disponible », parcourez la barre de gauche pour repérer Conversation, Équipes et Calendrier, puis envoyez un message de test à un collègue pour prendre vos marques.",
                            ],
                        ],
                        'resume' => [
                            "Teams centralise chat, équipes/canaux, réunions et fichiers dans Microsoft 365",
                            "La barre latérale gauche donne accès à Activité, Conversation, Équipes, Calendrier",
                            "Le statut de présence signale votre disponibilité aux collègues",
                        ],
                    ],
                    'questions' => [
                        [
                            'id' => 1, 'type' => 'qcm',
                            'question' => "Teams fait partie de quelle suite ?",
                            'options' => ['Google Workspace', 'Microsoft 365', 'Adobe Creative Cloud', 'LibreOffice'],
                            'bonne_reponse' => 1,
                            'explication' => "Teams est la plateforme de collaboration intégrée à Microsoft 365 : elle utilise le même compte professionnel que Word, Excel, Outlook et SharePoint, avec lesquels elle communique directement. Ce n'est ni un produit Google ni Adobe : c'est cette intégration à l'écosystème Microsoft qui fait sa force.",
                        ],
                        [
                            'id' => 2, 'type' => 'qcm',
                            'question' => "Où accède-t-on à ses chats privés dans Teams ?",
                            'options' => ['Calendrier', 'Conversation', 'Fichiers', 'Activité'],
                            'bonne_reponse' => 1,
                            'explication' => "Les chats privés et de groupe se trouvent sous l'icône Conversation, dans la barre latérale gauche. Les autres icônes ont chacune leur rôle : le Calendrier gère les réunions, Fichiers regroupe les documents et Activité affiche le flux de notifications.",
                        ],
                        [
                            'id' => 3, 'type' => 'vrai_faux',
                            'question' => "Le statut « Ne pas déranger » suspend les notifications.",
                            'bonne_reponse' => 'Vrai',
                            'explication' => "Le statut « Ne pas déranger » met les notifications en sourdine pour préserver votre concentration, par exemple pendant une présentation. Il renseigne en plus vos collègues sur votre disponibilité, ce qui limite les sollicitations au mauvais moment.",
                        ],
                        [
                            'id' => 4, 'type' => 'qcm',
                            'question' => "Teams est accessible :",
                            'options' => [
                                'Uniquement sur ordinateur de bureau',
                                'Sur ordinateur, navigateur web et mobile',
                                'Uniquement via Outlook',
                                'Seulement pendant une réunion',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Teams est une application cloud : on s'y connecte avec le même compte depuis l'ordinateur (application ou navigateur) comme depuis le mobile, et tout reste synchronisé d'un appareil à l'autre. On n'est donc ni limité au poste de bureau ni dépendant d'Outlook.",
                        ],
                        [
                            'id' => 5, 'type' => 'qcm',
                            'question' => "Vous partez en pause déjeuner et ne voulez pas être dérangé. Que faites-vous ?",
                            'options' => [
                                "Fermer l'ordinateur",
                                'Passer son statut en « Ne pas déranger » ou « Absent »',
                                'Désinstaller Teams',
                                'Bloquer ses collègues',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Le bon réflexe est d'ajuster votre statut (« Absent » ou « Ne pas déranger ») : vos collègues voient que vous n'êtes pas disponible et les notifications se calment, sans vous couper de Teams. Fermer l'ordinateur ou bloquer ses collègues serait à la fois inutile et excessif.",
                        ],
                    ],
                ],
            ],

            // ── Module 2 ──────────────────────────────────────────────
            [
                'titre'         => 'Communiquer par chat et mentions',
                'type'          => 'mixte',
                'niveau'        => 'debutant',
                'xp_recompense' => 10,
                'contenu_json'  => [
                    'objectif' => "Échanger efficacement par messages : mise en forme, mentions, réactions et bonnes pratiques.",
                    'lecon' => [
                        'titre' => 'Bien communiquer dans les conversations',
                        'duree' => '7 min',
                        'intro' => "Le chat est l'usage quotidien le plus courant de Teams. Quelques réflexes rendent vos messages clairs, faciles à suivre et respectueux du temps de chacun.",
                        'sections' => [
                            [
                                'titre' => 'Messages privés et de groupe',
                                'corps' => "Une conversation peut être individuelle ou de groupe. Pour démarrer, cliquez sur « Nouvelle conversation » et saisissez un ou plusieurs noms. Vous pouvez nommer une conversation de groupe pour la retrouver facilement par la suite.",
                            ],
                            [
                                'titre' => 'Mentions, réactions et mise en forme',
                                'corps' => "Sous la zone de saisie, des options permettent de mettre en forme un message ou d'y ajouter un objet. Plusieurs outils aident à communiquer juste, sans surcharger les autres de notifications.",
                                'liste' => [
                                    "@mention → notifier précisément une personne",
                                    "@équipe ou @canal → alerter tout un groupe (avec parcimonie)",
                                    "Réactions (👍, ✓) → accuser réception sans alourdir le fil",
                                    "Marquer « Important » → signaler un message urgent",
                                ],
                            ],
                            [
                                'titre' => 'Les mentions, avec mesure',
                                'corps' => "Une @mention envoie une notification ciblée : utilisez-la pour solliciter une personne précise. Mentionner tout un canal pour un message qui ne concerne que deux personnes génère du bruit inutile. Une simple réaction suffit souvent à confirmer « lu » ou « d'accord ».",
                                'astuce' => "Plutôt que d'écrire « bonjour » puis d'attendre, formulez votre demande complète en un seul message : votre interlocuteur peut répondre immédiatement.",
                            ],
                            [
                                'titre' => 'En pratique',
                                'corps' => "Vous avez besoin d'une validation de Marie sur un devis. Au lieu d'écrire « bonjour » et d'attendre, envoyez : « Bonjour Marie, peux-tu valider le devis ci-joint avant jeudi ? » en ajoutant une @mention de Marie. Elle est notifiée et peut répondre tout de suite.",
                            ],
                        ],
                        'resume' => [
                            "Le chat gère messages privés et de groupe ; on peut nommer un groupe",
                            "@mention notifie une personne ; @canal alerte tout le monde (à doser)",
                            "Réactions et mise en forme rendent les échanges clairs et économes en notifications",
                        ],
                    ],
                    'questions' => [
                        [
                            'id' => 1, 'type' => 'qcm',
                            'question' => "Comment notifier une personne précise dans un message Teams ?",
                            'options' => ['En écrivant son nom en gras', 'Avec une @mention', 'En envoyant un email', 'En changeant de canal'],
                            'bonne_reponse' => 1,
                            'explication' => "Pour qu'une personne soit réellement prévenue, on la cite avec une @mention : Teams lui envoie alors une notification ciblée. Écrire son nom en gras ne déclenche aucune alerte, et passer par l'email irait à l'encontre de l'intérêt même de Teams.",
                        ],
                        [
                            'id' => 2, 'type' => 'vrai_faux',
                            'question' => "Mentionner tout un canal (@canal) pour un sujet qui ne concerne que deux personnes est une bonne pratique.",
                            'bonne_reponse' => 'Faux',
                            'explication' => "Mentionner @canal envoie une notification à tous les membres du canal : le faire pour un sujet qui ne concerne que deux personnes génère du bruit inutile et finit par lasser. On réserve @canal aux messages réellement collectifs, et on cite nominativement les personnes concernées le reste du temps.",
                        ],
                        [
                            'id' => 3, 'type' => 'qcm',
                            'question' => "Quel est le moyen le plus léger d'accuser réception d'un message ?",
                            'options' => ['Répondre par un long message', 'Ajouter une réaction (👍)', 'Créer une réunion', 'Transférer le message'],
                            'bonne_reponse' => 1,
                            'explication' => "Une réaction (👍, ✓) confirme que vous avez lu, sans ajouter de message dans le fil : c'est la façon la plus légère d'accuser réception. Répondre par un long message ou, pire, créer une réunion pour cela serait totalement disproportionné.",
                        ],
                        [
                            'id' => 4, 'type' => 'qcm',
                            'question' => "Pour une demande, la bonne pratique est :",
                            'options' => [
                                "Écrire « bonjour » et attendre une réponse avant de poser sa question",
                                'Formuler la demande complète en un seul message',
                                'Téléphoner systématiquement',
                                "Envoyer plusieurs messages d'un mot",
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Formuler sa demande complète en un seul message permet à l'interlocuteur de répondre immédiatement. Le « bonjour » envoyé seul, suivi d'une attente, fait perdre du temps des deux côtés et multiplie les notifications pour rien.",
                        ],
                        [
                            'id' => 5, 'type' => 'qcm',
                            'question' => "Vous devez obtenir une réponse de Paul dans un canal très actif. Le plus efficace :",
                            'options' => [
                                'Écrire son nom en gras',
                                'Le mentionner avec @Paul',
                                'Envoyer un email en parallèle',
                                "Attendre qu'il lise le canal",
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Dans un canal très actif, un message ordinaire risque de défiler sans être vu. La @mention de Paul lui envoie une notification personnelle, ce qui maximise les chances d'une réponse rapide. Le gras ne notifie pas, et doubler par email ne ferait que disperser la conversation.",
                        ],
                    ],
                ],
            ],

            // ── Module 3 ──────────────────────────────────────────────
            [
                'titre'         => 'Travailler en équipes et canaux',
                'type'          => 'mixte',
                'niveau'        => 'intermediaire',
                'xp_recompense' => 20,
                'contenu_json'  => [
                    'objectif' => "Organiser le travail collectif avec les équipes, les canaux et les onglets.",
                    'lecon' => [
                        'titre' => 'Structurer la collaboration : équipes et canaux',
                        'duree' => '8 min',
                        'intro' => "Quand un groupe grandit, tout regrouper dans un seul fil devient ingérable. Les équipes et les canaux structurent durablement le travail collectif.",
                        'sections' => [
                            [
                                'titre' => 'Équipe, canaux, onglets',
                                'corps' => "Une équipe rassemble des personnes autour d'un objectif (un service, un projet). À l'intérieur, les canaux découpent le travail par sujet (« Général », « Budget », « Communication »). Chaque canal a son fil de Publications, son onglet Fichiers et des onglets personnalisables.",
                            ],
                            [
                                'titre' => 'Canaux standard et privés',
                                'corps' => "Le type de canal conditionne qui voit les échanges et les fichiers. Le choix se fait à la création.",
                                'liste' => [
                                    "Canal standard → visible par tous les membres de l'équipe",
                                    "Canal privé → membres invités uniquement (icône cadenas)",
                                    "Onglet Publications → discussions du canal",
                                    "Onglet Fichiers → documents partagés (stockés dans SharePoint)",
                                ],
                            ],
                            [
                                'titre' => 'Répondre plutôt que créer un nouveau fil',
                                'corps' => "Dans un canal, répondez toujours sous le message concerné (bouton « Répondre ») plutôt que de créer un nouveau fil : les échanges restent regroupés par sujet. Donnez un objet aux discussions importantes.",
                                'astuce' => "Réservez un canal à un thème durable (un projet, un domaine). Pour une discussion ponctuelle entre deux personnes, un simple chat suffit.",
                            ],
                            [
                                'titre' => 'En pratique',
                                'corps' => "Votre service lance le « Projet Alpha ». Au lieu de tout poster dans le canal Général, créez un canal dédié « Projet Alpha », rangez-y les documents via l'onglet Fichiers, et répondez sous chaque sujet pour garder des fils clairs et faciles à retrouver.",
                            ],
                        ],
                        'resume' => [
                            "Une équipe contient des canaux thématiques (Publications, Fichiers, onglets)",
                            "Canal standard = tous les membres ; canal privé = sur invitation",
                            "Répondre sous le bon message garde les échanges organisés par sujet",
                        ],
                    ],
                    'questions' => [
                        [
                            'id' => 1, 'type' => 'qcm',
                            'question' => "Qu'est-ce qu'un canal dans Teams ?",
                            'options' => ['Un fichier partagé', "Un espace thématique au sein d'une équipe", 'Une réunion vidéo', 'Un statut de présence'],
                            'bonne_reponse' => 1,
                            'explication' => "Un canal est un espace de discussion thématique à l'intérieur d'une équipe — par exemple un canal « Budget » dans l'équipe Finance. Ce n'est ni un fichier, ni une réunion, ni un statut : c'est le découpage qui permet d'organiser le travail d'une équipe par sujet.",
                        ],
                        [
                            'id' => 2, 'type' => 'vrai_faux',
                            'question' => "Un canal privé est accessible à tous les membres de l'équipe.",
                            'bonne_reponse' => 'Faux',
                            'explication' => "Un canal privé n'est PAS ouvert à toute l'équipe : seuls les membres explicitement invités y ont accès, et il porte une icône cadenas. C'est le canal standard, lui, qui est visible par l'ensemble des membres de l'équipe.",
                        ],
                        [
                            'id' => 3, 'type' => 'qcm',
                            'question' => "Pour garder les échanges organisés dans un canal, il faut :",
                            'options' => [
                                'Créer un nouveau fil à chaque message',
                                'Répondre sous le message concerné',
                                'Envoyer un email en parallèle',
                                'Supprimer les anciens messages',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "On répond sous le message concerné (bouton « Répondre ») plutôt que d'ouvrir un nouveau fil à chaque intervention : ainsi les échanges d'un même sujet restent regroupés et lisibles. Multiplier les nouveaux fils éparpille la discussion et rend le canal confus.",
                        ],
                        [
                            'id' => 4, 'type' => 'qcm',
                            'question' => "Où sont stockés les fichiers partagés dans un canal d'équipe ?",
                            'options' => ["Sur le PC de l'expéditeur", 'Dans SharePoint', 'Dans Outlook', 'Nulle part, ils sont temporaires'],
                            'bonne_reponse' => 1,
                            'explication' => "Les fichiers partagés dans un canal d'équipe sont rangés automatiquement dans SharePoint, l'espace de stockage de l'équipe, et restent accessibles à tous via l'onglet Fichiers. Ils ne dépendent donc pas du PC de l'expéditeur et ne disparaissent pas une fois la conversation passée.",
                        ],
                        [
                            'id' => 5, 'type' => 'qcm',
                            'question' => "Une discussion sur le budget se mélange à dix autres sujets dans le canal Général. La bonne pratique :",
                            'options' => [
                                'Supprimer le canal Général',
                                'Créer ou utiliser un canal dédié au budget',
                                'Envoyer des emails',
                                'Mettre tout le monde en @canal',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Quand un sujet se noie dans le canal Général, on lui dédie un canal (« Budget ») : les échanges y sont regroupés durablement et faciles à retrouver. Supprimer le Général ou abuser des @canal ne ferait qu'aggraver la confusion et le bruit.",
                        ],
                    ],
                ],
            ],

            // ── Module 4 ──────────────────────────────────────────────
            [
                'titre'         => 'Organiser et animer des réunions',
                'type'          => 'mixte',
                'niveau'        => 'intermediaire',
                'xp_recompense' => 20,
                'contenu_json'  => [
                    'objectif' => "Planifier, rejoindre et animer efficacement une réunion Teams.",
                    'lecon' => [
                        'titre' => 'Réunions : de la planification à l\'animation',
                        'duree' => '8 min',
                        'intro' => "La réunion est un moment coûteux en temps collectif. Bien la préparer et maîtriser les outils d'animation de Teams en fait un véritable levier de productivité.",
                        'sections' => [
                            [
                                'titre' => 'Planifier une réunion',
                                'corps' => "Depuis le Calendrier > Nouvelle réunion, renseignez un titre clair, les participants, la date et l'heure. Ajoutez un ordre du jour dans la description : c'est ce qui distingue une réunion utile d'une réunion subie. Chaque invité reçoit l'invitation et un bouton Rejoindre.",
                            ],
                            [
                                'titre' => 'Les outils pendant la réunion',
                                'corps' => "Une barre d'outils réunit les commandes essentielles pour participer et présenter.",
                                'liste' => [
                                    "Micro → à couper quand on ne parle pas",
                                    "Partage d'écran → présenter un document ou une application",
                                    "Lever la main → demander la parole sans interrompre",
                                    "Enregistrement / transcription → garder une trace (avec accord)",
                                ],
                            ],
                            [
                                'titre' => 'Animer avec méthode',
                                'corps' => "Coupez votre micro hors prise de parole pour limiter le bruit. En tant qu'organisateur, suivez l'ordre du jour, donnez la parole à ceux qui lèvent la main, et terminez par un récapitulatif des décisions et des actions (qui fait quoi, pour quand).",
                                'astuce' => "Pour les grands groupes, utilisez les salles pour petits groupes (breakout rooms) afin de faire travailler les participants en sous-équipes, puis revenir en plénière.",
                            ],
                            [
                                'titre' => 'En pratique',
                                'corps' => "Vous organisez un point hebdomadaire : créez la réunion dans le Calendrier, ajoutez l'ordre du jour dans la description, et le jour J coupez votre micro entre vos prises de parole. À la fin, récapitulez les décisions prises et qui fait quoi.",
                            ],
                        ],
                        'resume' => [
                            "Planifier via Calendrier > Nouvelle réunion, avec un ordre du jour clair",
                            "Micro, partage d'écran, lever la main et enregistrement structurent la réunion",
                            "Conclure par un récapitulatif des décisions et des actions",
                        ],
                    ],
                    'questions' => [
                        [
                            'id' => 1, 'type' => 'qcm',
                            'question' => "Où planifie-t-on une réunion dans Teams ?",
                            'options' => ['Onglet Fichiers', 'Onglet Calendrier', 'Onglet Activité', 'Onglet Appels'],
                            'bonne_reponse' => 1,
                            'explication' => "On planifie une réunion depuis l'onglet Calendrier, via « Nouvelle réunion », où l'on saisit le titre, les participants, la date et l'heure. Les onglets Fichiers, Activité et Appels remplissent d'autres fonctions et ne servent pas à organiser une réunion.",
                        ],
                        [
                            'id' => 2, 'type' => 'vrai_faux',
                            'question' => "Indiquer un ordre du jour dans l'invitation aide à rendre la réunion plus efficace.",
                            'bonne_reponse' => 'Vrai',
                            'explication' => "Un ordre du jour dans l'invitation cadre les échanges et permet à chacun de se préparer : la réunion va à l'essentiel et ne s'éternise pas. C'est l'un des leviers les plus simples et les plus efficaces pour rendre une réunion réellement utile.",
                        ],
                        [
                            'id' => 3, 'type' => 'qcm',
                            'question' => "Quelle fonctionnalité permet de demander la parole sans couper celui qui parle ?",
                            'options' => ["Le partage d'écran", 'Lever la main', 'Couper son micro', 'Le chat privé'],
                            'bonne_reponse' => 1,
                            'explication' => "« Lever la main » signale que vous souhaitez intervenir sans interrompre la personne qui parle : l'animateur vous donne ensuite la parole au bon moment. Le partage d'écran et la coupure du micro répondent, eux, à d'autres besoins de la réunion.",
                        ],
                        [
                            'id' => 4, 'type' => 'qcm',
                            'question' => "Avant d'enregistrer une réunion, il convient de :",
                            'options' => ['Couper toutes les caméras', "Obtenir l'accord des participants", 'Quitter puis revenir', 'Supprimer le chat'],
                            'bonne_reponse' => 1,
                            'explication' => "Avant d'enregistrer, on obtient l'accord des participants : l'enregistrement capte les voix et les propos, et son usage est encadré par les règles internes et la protection des données. C'est une question de respect et de conformité, bien au-delà d'un simple réglage technique.",
                        ],
                        [
                            'id' => 5, 'type' => 'qcm',
                            'question' => "Pendant une réunion à dix participants, un fond sonore gêne quand personne ne parle. La bonne pratique :",
                            'options' => [
                                'Quitter la réunion',
                                'Chacun coupe son micro quand il ne parle pas',
                                'Couper toutes les caméras',
                                'Parler plus fort',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Quand plusieurs micros restent ouverts, les bruits de fond s'additionnent et gênent l'écoute. La bonne pratique collective est que chacun coupe son micro tant qu'il ne parle pas. Quitter la réunion ou couper les caméras ne réglerait en rien le problème de son.",
                        ],
                    ],
                ],
            ],

            // ── Module 5 ──────────────────────────────────────────────
            [
                'titre'         => 'Gérer et co-éditer les fichiers',
                'type'          => 'mixte',
                'niveau'        => 'expert',
                'xp_recompense' => 30,
                'contenu_json'  => [
                    'objectif' => "Partager, co-éditer et retrouver les documents dans Teams en s'appuyant sur SharePoint et OneDrive.",
                    'lecon' => [
                        'titre' => 'Les fichiers : partage et co-édition',
                        'duree' => '8 min',
                        'intro' => "Teams n'est pas qu'une messagerie : c'est un espace de travail documentaire. Comprendre où vivent les fichiers et comment les co-éditer évite la multiplication des versions par email.",
                        'sections' => [
                            [
                                'titre' => 'Où vivent les fichiers',
                                'corps' => "Le lieu de stockage dépend du contexte du partage. Rien ne se perd quand la conversation défile : tout reste rangé.",
                                'liste' => [
                                    "Chat privé → OneDrive de l'expéditeur",
                                    "Canal d'équipe → bibliothèque SharePoint de l'équipe",
                                    "Onglet Fichiers du canal → tous les documents au même endroit",
                                ],
                            ],
                            [
                                'titre' => 'La co-édition en temps réel',
                                'corps' => "Plusieurs personnes ouvrent et modifient le même document Word, Excel ou PowerPoint simultanément, directement dans Teams. On voit le curseur des autres et chaque modification apparaît en direct. L'historique des versions permet de revenir à un état antérieur si besoin.",
                            ],
                            [
                                'titre' => 'Partager proprement',
                                'corps' => "Pour partager un document, préférez un lien (avec les droits adaptés : lecture ou modification) plutôt qu'une pièce jointe, qui crée une copie figée. Vous gardez ainsi une source unique et à jour. Nommez clairement vos fichiers pour les retrouver.",
                                'astuce' => "Plutôt que d'envoyer dix versions par email, partagez le lien du document : tout le monde travaille sur la même source, toujours à jour.",
                            ],
                            [
                                'titre' => 'En pratique',
                                'corps' => "Trois collègues doivent contribuer à une présentation. Au lieu de s'envoyer des versions par email, déposez le fichier dans le canal de l'équipe et co-éditez-le ensemble : chacun voit les modifications en direct, et l'historique des versions permet de revenir en arrière en cas d'erreur.",
                            ],
                        ],
                        'resume' => [
                            "Fichier de chat → OneDrive ; fichier de canal → SharePoint",
                            "Co-édition en temps réel à plusieurs, avec historique des versions",
                            "Partager un lien (droits adaptés) plutôt qu'une copie en pièce jointe",
                        ],
                    ],
                    'questions' => [
                        [
                            'id' => 1, 'type' => 'qcm',
                            'question' => "Où est stocké un fichier partagé dans un canal d'équipe ?",
                            'options' => ['Dans OneDrive personnel', 'Dans SharePoint', 'Sur le bureau Windows', 'Dans la corbeille'],
                            'bonne_reponse' => 1,
                            'explication' => "Un fichier partagé dans un canal d'équipe est stocké dans la bibliothèque SharePoint de cette équipe, accessible à tous ses membres. Il ne reste pas sur le bureau de l'expéditeur ni dans une corbeille : il est centralisé et rangé durablement. (Un fichier envoyé en chat privé, lui, va dans votre OneDrive.)",
                        ],
                        [
                            'id' => 2, 'type' => 'vrai_faux',
                            'question' => "Plusieurs personnes peuvent modifier le même document Office en même temps dans Teams.",
                            'bonne_reponse' => 'Vrai',
                            'explication' => "C'est la co-édition en temps réel : plusieurs personnes ouvrent et modifient le même document Word, Excel ou PowerPoint simultanément dans Teams, en voyant les curseurs et les changements des autres en direct. Cela supprime les allers-retours de versions par email.",
                        ],
                        [
                            'id' => 3, 'type' => 'qcm',
                            'question' => "Pour partager un document en gardant une source unique à jour, il vaut mieux :",
                            'options' => ['Envoyer une pièce jointe', 'Partager un lien avec les droits adaptés', 'Imprimer le document', 'Copier le texte dans le chat'],
                            'bonne_reponse' => 1,
                            'explication' => "Partager un lien (avec les droits de lecture ou de modification adaptés) garantit une source unique et toujours à jour : tout le monde travaille sur le même fichier. Une pièce jointe crée au contraire une copie figée, qui se périme dès la première modification de l'original.",
                        ],
                        [
                            'id' => 4, 'type' => 'qcm',
                            'question' => "À quoi sert l'historique des versions d'un document ?",
                            'options' => ['À supprimer le fichier', 'À revenir à un état antérieur du document', 'À changer le format', 'À verrouiller le canal'],
                            'bonne_reponse' => 1,
                            'explication' => "L'historique des versions conserve les états successifs d'un document : en cas d'erreur ou de suppression malheureuse, on restaure une version précédente en quelques clics. Ce n'est ni un moyen de supprimer le fichier, ni de changer son format.",
                        ],
                        [
                            'id' => 5, 'type' => 'qcm',
                            'question' => "Une équipe s'échange par email « presentation_v1 », « v2 », « v2_final »… Comment éviter ce désordre ?",
                            'options' => [
                                "Numéroter jusqu'à v10",
                                'Partager un seul fichier dans le canal et le co-éditer',
                                'Imprimer chaque version',
                                'Renommer après chaque envoi',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Le désordre des « v1, v2, v2_final » vient de l'envoi de copies par email. En partageant un fichier unique dans le canal et en le co-éditant, tout le monde travaille sur la même source : la multiplication des versions disparaît, et l'historique garde la trace de chaque modification.",
                        ],
                    ],
                ],
            ],

            // ── Module 6 ──────────────────────────────────────────────
            [
                'titre'         => 'Bonnes pratiques, notifications et sécurité',
                'type'          => 'mixte',
                'niveau'        => 'expert',
                'xp_recompense' => 30,
                'contenu_json'  => [
                    'objectif' => "Maîtriser ses notifications, sa disponibilité et les règles de sécurité pour un usage professionnel sain.",
                    'lecon' => [
                        'titre' => 'Travailler sainement et en sécurité',
                        'duree' => '7 min',
                        'intro' => "Un outil de collaboration mal réglé devient une source de distraction permanente. Quelques réglages et réflexes de sécurité font la différence entre subir Teams et le maîtriser.",
                        'sections' => [
                            [
                                'titre' => 'Maîtriser ses notifications',
                                'corps' => "Dans Paramètres > Notifications, choisissez ce qui mérite une alerte, canal par canal. Le statut et les heures de calme protègent votre concentration et votre vie personnelle.",
                                'liste' => [
                                    "Personnaliser les notifications par canal",
                                    "Mettre en sourdine les canaux peu pertinents",
                                    "Heures de calme → couper les notifications mobiles le soir",
                                    "Statut « Ne pas déranger » pendant les périodes de concentration",
                                ],
                            ],
                            [
                                'titre' => 'Sécurité et confidentialité',
                                'corps' => "Teams est un outil professionnel : n'y partagez que des informations appropriées au contexte et aux destinataires. Vérifiez qui compose une équipe ou un canal (notamment les invités externes) avant de partager un document sensible. Ne communiquez jamais vos identifiants, même à un message qui semble interne.",
                            ],
                            [
                                'titre' => 'Étiquette professionnelle',
                                'corps' => "Respectez la disponibilité affichée par vos collègues, choisissez le bon canal au bon moment, et gardez un ton courtois : tout reste tracé. Pour les sujets longs ou sensibles, un appel ou une réunion vaut mieux qu'une longue chaîne de messages.",
                                'astuce' => "Avant de partager un fichier dans un canal, vérifiez s'il contient des invités externes : ils auront accès au document.",
                            ],
                            [
                                'titre' => 'En pratique',
                                'corps' => "Vous êtes submergé de notifications. Ouvrez Paramètres > Notifications, mettez en sourdine les canaux secondaires, activez les heures de calme le soir sur mobile, et passez en « Ne pas déranger » pendant vos plages de concentration : vous reprenez le contrôle de votre attention.",
                            ],
                        ],
                        'resume' => [
                            "Personnaliser les notifications par canal et activer les heures de calme",
                            "Vérifier les membres (et invités externes) avant de partager un document sensible",
                            "Respecter la disponibilité affichée ; privilégier l'appel pour les sujets complexes",
                        ],
                    ],
                    'questions' => [
                        [
                            'id' => 1, 'type' => 'qcm',
                            'question' => "Comment réduire les distractions liées à un canal peu important ?",
                            'options' => ["Quitter l'entreprise", 'Le mettre en sourdine', "Supprimer l'équipe", 'Bloquer ses collègues'],
                            'bonne_reponse' => 1,
                            'explication' => "Pour réduire les distractions d'un canal peu important, on le met en sourdine : on n'en reçoit plus les notifications, tout en gardant la possibilité de le consulter quand on le souhaite. Quitter l'entreprise ou supprimer l'équipe seraient évidemment des réactions hors de propos.",
                        ],
                        [
                            'id' => 2, 'type' => 'vrai_faux',
                            'question' => "Il faut vérifier la présence d'invités externes avant de partager un document sensible dans un canal.",
                            'bonne_reponse' => 'Vrai',
                            'explication' => "Avant de partager un document sensible, on vérifie qui est membre du canal, et en particulier la présence d'invités externes : ceux-ci auront accès au fichier comme tout le monde. C'est un réflexe de base de protection de l'information de l'entreprise.",
                        ],
                        [
                            'id' => 3, 'type' => 'qcm',
                            'question' => "Que faire d'un message demandant vos identifiants, même s'il paraît interne ?",
                            'options' => ['Les communiquer rapidement', 'Ne jamais les communiquer', 'Les envoyer par email à la place', 'Les partager dans un canal privé'],
                            'bonne_reponse' => 1,
                            'explication' => "On ne communique jamais ses identifiants, même à un message qui semble interne : c'est une règle de sécurité fondamentale, car un message peut être usurpé ou un compte compromis. Les transmettre par email ou en canal privé ne les rendrait pas plus sûrs — au contraire.",
                        ],
                        [
                            'id' => 4, 'type' => 'qcm',
                            'question' => "Pour un sujet long ou sensible, mieux vaut souvent :",
                            'options' => ['Une longue chaîne de messages', 'Un appel ou une réunion', 'Mentionner tout le monde', 'Ne rien faire'],
                            'bonne_reponse' => 1,
                            'explication' => "Pour un sujet long ou sensible, un appel ou une réunion est souvent plus clair et plus rapide qu'une longue chaîne de messages écrits, où les malentendus s'accumulent. L'écrit reste utile ensuite, pour tracer brièvement la décision prise une fois l'échange terminé.",
                        ],
                        [
                            'id' => 5, 'type' => 'qcm',
                            'question' => "Un canal contient des invités externes et vous devez y partager un document interne confidentiel. Vous :",
                            'options' => [
                                'Le partagez sans regarder',
                                "Vérifiez d'abord les membres et évitez d'exposer le document aux externes",
                                'Mentionnez tout le monde',
                                'Supprimez les externes sans prévenir',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Face à un document confidentiel dans un canal contenant des invités externes, on vérifie d'abord la liste des membres et on évite d'exposer le document aux personnes extérieures — par exemple en passant par un canal privé ou un partage ciblé. Le partager sans regarder reviendrait à provoquer une fuite d'information.",
                        ],
                    ],
                ],
            ],

        ];

        $this->creerModules($teams, $modules);
    }
}
