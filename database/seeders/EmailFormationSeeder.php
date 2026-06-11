<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parcours;
use Database\Seeders\Concerns\CreeModulesFormation;

class EmailFormationSeeder extends Seeder
{
    use CreeModulesFormation;

    public function run(): void
    {
        $email = Parcours::where('outil', 'Email')->firstOrFail();

        $modules = [

            // ── Module 1 ──────────────────────────────────────────────
            [
                'titre'         => "Anatomie et structure d'un email professionnel",
                'type'          => 'mixte',
                'niveau'        => 'debutant',
                'xp_recompense' => 10,
                'contenu_json'  => [
                    'objectif' => "Identifier les composants d'un email et structurer un message professionnel.",
                    'lecon' => [
                        'titre' => "La structure d'un email professionnel",
                        'duree' => '6 min',
                        'intro' => "Un email professionnel répond à une structure claire. La maîtriser, c'est gagner immédiatement en crédibilité et en efficacité auprès de vos interlocuteurs.",
                        'sections' => [
                            [
                                'titre' => "Les composants d'un email",
                                'corps' => "Tout message comporte des champs et des parties bien identifiés. Les connaître permet de remplir chacun à bon escient.",
                                'liste' => [
                                    "Destinataires : À, Cc, Cci",
                                    "Objet : résumé du message en une phrase",
                                    "Corps : appel, message, formule de politesse",
                                    "Signature : nom, fonction, coordonnées",
                                ],
                            ],
                            [
                                'titre' => 'Structurer le corps du message',
                                'corps' => "Commencez par une formule d'appel (« Bonjour Madame Durand, »), puis allez à l'essentiel dès la première phrase. Aérez le texte : un paragraphe par idée, des phrases courtes, éventuellement une liste à puces. Terminez par une formule de politesse adaptée (« Cordialement, », « Bien à vous, »).",
                            ],
                            [
                                'titre' => 'La signature professionnelle',
                                'corps' => "Elle vous identifie et facilite le recontact : nom, fonction, entreprise et coordonnées utiles. Configurée une fois en signature automatique, elle s'ajoute à chaque message sans effort et donne une image soignée.",
                                'astuce' => "Rédigez vos emails comme s'ils pouvaient être transférés ou relus plus tard : clarté, courtoisie et structure avant tout.",
                            ],
                            [
                                'titre' => 'En pratique',
                                'corps' => "Vous écrivez à un client pour la première fois : objet « Proposition commerciale – Société X », appel « Bonjour Madame Martin, », message clair en deux paragraphes, formule « Cordialement, » et votre signature complète. En un coup d'œil, le client sait qui écrit et pourquoi.",
                            ],
                        ],
                        'resume' => [
                            "Champs (À/Cc/Cci), objet, corps structuré et signature forment l'email",
                            "Aérer le corps : un paragraphe par idée, des phrases courtes",
                            "Une signature automatique donne une image professionnelle et facilite le recontact",
                        ],
                    ],
                    'questions' => [
                        [
                            'id' => 1, 'type' => 'qcm',
                            'question' => "Quel élément résume le message en une phrase ?",
                            'options' => ['La signature', "L'objet", "La formule d'appel", 'La pièce jointe'],
                            'bonne_reponse' => 1,
                            'explication' => "L'objet est la ligne qui résume le message en une phrase : c'est lui qui s'affiche dans la liste de réception et décide souvent de l'ouverture. La signature identifie l'expéditeur, la formule d'appel ouvre le message et la pièce jointe est un fichier annexe : aucun ne joue le rôle de résumé.",
                        ],
                        [
                            'id' => 2, 'type' => 'vrai_faux',
                            'question' => "Un corps d'email aéré (un paragraphe par idée) est plus facile à lire.",
                            'bonne_reponse' => 'Vrai',
                            'explication' => "Un corps aéré — un paragraphe par idée, des phrases courtes — se lit et se comprend bien plus vite qu'un bloc compact. Le lecteur repère immédiatement le contexte et la demande, ce qui augmente vos chances d'obtenir une réponse rapide et juste.",
                        ],
                        [
                            'id' => 3, 'type' => 'qcm',
                            'question' => "À quoi sert la signature ?",
                            'options' => [
                                'À résumer le message',
                                "À identifier l'expéditeur et faciliter le recontact",
                                'À masquer les destinataires',
                                'À joindre un fichier',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "La signature sert à identifier l'expéditeur et à faciliter le recontact : nom, fonction, entreprise, coordonnées. Elle ne résume pas le message, ne masque pas les destinataires (c'est le rôle du Cci) et n'est pas une pièce jointe : sa fonction est purement d'identification.",
                        ],
                        [
                            'id' => 4, 'type' => 'qcm',
                            'question' => "Quelle formule convient pour conclure un email professionnel ?",
                            'options' => ['« À plus ! »', '« Cordialement, »', '« Salut »', 'Aucune formule'],
                            'bonne_reponse' => 1,
                            'explication' => "« Cordialement, » est une formule de politesse adaptée au contexte professionnel pour clore un email. « À plus ! » ou « Salut » sont trop familiers, et ne mettre aucune formule donne une impression abrupte, voire impolie, surtout avec un interlocuteur que l'on connaît peu.",
                        ],
                        [
                            'id' => 5, 'type' => 'qcm',
                            'question' => "Vous rédigez un premier email à un client important. Quel ensemble est complet et professionnel ?",
                            'options' => [
                                'Juste le message, sans objet ni signature',
                                'Objet clair + appel + message + politesse + signature',
                                'Un objet en majuscules + le message',
                                'Le message + un emoji',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Un premier email à un client important doit être complet : un objet clair, une formule d'appel, le message, une formule de politesse et une signature. Se limiter au message sans objet ni signature, ou ajouter un emoji, donnerait une impression peu professionnelle pour un premier contact.",
                        ],
                    ],
                ],
            ],

            // ── Module 2 ──────────────────────────────────────────────
            [
                'titre'         => 'Rédiger un objet et un message efficaces',
                'type'          => 'mixte',
                'niveau'        => 'debutant',
                'xp_recompense' => 10,
                'contenu_json'  => [
                    'objectif' => "Écrire un objet percutant et un message clair qui obtient une réponse.",
                    'lecon' => [
                        'titre' => "Objet et message qui vont à l'essentiel",
                        'duree' => '7 min',
                        'intro' => "Un destinataire décide en quelques secondes s'il ouvre et traite votre email. Un objet précis et un message clair font toute la différence.",
                        'sections' => [
                            [
                                'titre' => 'Un objet précis et concret',
                                'corps' => "L'objet doit décrire le contenu en quelques mots. Comparez « Réunion » à « Compte-rendu réunion budget – 12 mai » : le second informe et se retrouve facilement. Bannissez l'objet vide et les MAJUSCULES continues, perçues comme un cri.",
                                'liste' => [
                                    "✓ « Demande de validation devis – Projet Alpha »",
                                    "✓ « Compte-rendu réunion budget – 12 mai »",
                                    "✗ « Info », « Urgent !!! », ou un objet vide",
                                ],
                            ],
                            [
                                'titre' => "Aller à l'essentiel",
                                'corps' => "Annoncez l'objectif dès la première phrase (« Je vous écris pour… »). Donnez le contexte nécessaire, puis la demande précise, et si possible une échéance. Un email = un sujet principal : pour un autre sujet, mieux vaut un autre email.",
                            ],
                            [
                                'titre' => 'Faciliter la réponse',
                                'corps' => "Formulez une demande claire et, si besoin, listez des questions numérotées. Si vous attendez une action pour une date, dites-le explicitement. Un message dont l'action attendue est évidente obtient une réponse plus rapide.",
                                'astuce' => "Avant d'envoyer, relisez l'objet : résume-t-il bien le message et permettra-t-il de retrouver l'email dans six mois ?",
                            ],
                            [
                                'titre' => 'En pratique',
                                'corps' => "Vous voulez faire valider un devis pour jeudi. Objet : « Validation devis Projet Alpha – avant jeudi 12 ». Première phrase : « Pourriez-vous valider le devis ci-joint avant jeudi ? ». L'action et l'échéance sont claires : la réponse arrive vite.",
                            ],
                        ],
                        'resume' => [
                            "Objet court, concret et jamais vide ; pas de MAJUSCULES continues",
                            "Annoncer l'objectif dès la première phrase ; un email = un sujet",
                            "Rendre l'action attendue explicite (demande claire, échéance)",
                        ],
                    ],
                    'questions' => [
                        [
                            'id' => 1, 'type' => 'qcm',
                            'question' => "Quel est le meilleur objet d'email ?",
                            'options' => ['Urgent !!!', 'Compte-rendu réunion budget – 12 mai', 'Info', '(vide)'],
                            'bonne_reponse' => 1,
                            'explication' => "« Compte-rendu réunion budget – 12 mai » est précis et concret : le destinataire sait immédiatement de quoi il s'agit et retrouvera facilement l'email plus tard. « Urgent !!! », « Info » ou un objet vide n'apportent aucune information utile et nuisent à votre crédibilité.",
                        ],
                        [
                            'id' => 2, 'type' => 'vrai_faux',
                            'question' => "Il est conseillé de traiter plusieurs sujets sans rapport dans un seul email.",
                            'bonne_reponse' => 'Faux',
                            'explication' => "Mélanger plusieurs sujets sans rapport dans un même email complique le suivi : répondre à l'un fait oublier les autres, et l'archivage devient confus. La bonne règle est « un email = un sujet principal », quitte à envoyer deux messages distincts.",
                        ],
                        [
                            'id' => 3, 'type' => 'qcm',
                            'question' => "Pour obtenir une réponse rapide, il faut :",
                            'options' => [
                                'Noyer la demande dans un long texte',
                                "Rendre l'action attendue explicite (demande claire, échéance)",
                                'Écrire en majuscules',
                                'Mettre tout le monde en copie',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Pour une réponse rapide, on rend l'action attendue explicite : une demande claire, si possible avec une échéance. Noyer la demande dans un long texte, écrire en majuscules ou copier tout le monde ne fait que ralentir ou brouiller la réponse.",
                        ],
                        [
                            'id' => 4, 'type' => 'qcm',
                            'question' => "Écrire l'objet entièrement en MAJUSCULES :",
                            'options' => [
                                "Est recommandé pour l'urgence",
                                'Est perçu comme crier et à éviter',
                                'Améliore la lisibilité',
                                'Est obligatoire',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Écrire entièrement en MAJUSCULES équivaut, dans les codes de l'email, à crier : c'est perçu comme agressif et fatigant à lire. Ce n'est ni recommandé pour l'urgence, ni un gain de lisibilité — on réserve les majuscules à un ou deux mots clés au maximum.",
                        ],
                        [
                            'id' => 5, 'type' => 'qcm',
                            'question' => "Vous attendez une validation pour une date précise. La formulation la plus efficace :",
                            'options' => [
                                '« Voici un document. »',
                                '« Pourriez-vous valider le devis ci-joint avant jeudi 12 ? »',
                                '« Urgent, répondez ! »',
                                '« Quand vous voulez. »',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "« Pourriez-vous valider le devis ci-joint avant jeudi 12 ? » est efficace : la demande est précise et l'échéance explicite, le destinataire sait quoi faire et pour quand. « Voici un document » ou « Quand vous voulez » n'appellent aucune action datée, et « Urgent, répondez ! » agace sans informer.",
                        ],
                    ],
                ],
            ],

            // ── Module 3 ──────────────────────────────────────────────
            [
                'titre'         => 'Destinataires : À, Cc, Cci et Répondre à tous',
                'type'          => 'mixte',
                'niveau'        => 'intermediaire',
                'xp_recompense' => 20,
                'contenu_json'  => [
                    'objectif' => "Choisir le bon champ de destinataire et utiliser « Répondre à tous » à bon escient.",
                    'lecon' => [
                        'titre' => 'Maîtriser À, Cc, Cci et les réponses',
                        'duree' => '7 min',
                        'intro' => "Mal adresser un email peut créer des maladresses, voire exposer des adresses confidentielles. Le bon usage des champs est une compétence professionnelle clé.",
                        'sections' => [
                            [
                                'titre' => 'À, Cc, Cci : à chacun son rôle',
                                'corps' => "Chaque champ de destinataire a une fonction précise qu'il faut respecter.",
                                'liste' => [
                                    "À → destinataires directs, dont on attend une action ou une réponse",
                                    "Cc → personnes informées, sans action attendue (adresses visibles de tous)",
                                    "Cci → copie cachée : les destinataires ne se voient pas entre eux",
                                ],
                            ],
                            [
                                'titre' => 'Quand utiliser le Cci',
                                'corps' => "Le Cci protège les adresses lors d'un envoi à un grand groupe (information externe, message à des personnes qui ne se connaissent pas). Il évite aussi les « Répondre à tous » en chaîne. À l'inverse, l'utiliser pour observer discrètement un échange est une mauvaise pratique : préférez la transparence.",
                            ],
                            [
                                'titre' => 'Répondre ou Répondre à tous',
                                'corps' => "« Répondre » écrit à l'expéditeur seul ; « Répondre à tous » écrit à l'ensemble des destinataires. N'utilisez « Répondre à tous » que si votre message concerne réellement tout le groupe. Le réflexe systématique encombre les boîtes et agace.",
                                'astuce' => "Pour écrire à de nombreuses personnes qui ne se connaissent pas, mettez-les en Cci : vous protégez leurs adresses et évitez les réponses groupées intempestives.",
                            ],
                            [
                                'titre' => 'En pratique',
                                'corps' => "Vous envoyez le compte-rendu d'une réunion : les participants qui doivent agir vont en « À », votre responsable « pour information » va en Cc. Pour une invitation à 60 clients externes, vous les placez tous en Cci afin de protéger leurs adresses.",
                            ],
                        ],
                        'resume' => [
                            "À = action attendue ; Cc = pour information ; Cci = copie cachée",
                            "Le Cci protège les adresses lors d'envois groupés",
                            "« Répondre à tous » uniquement si tout le groupe est concerné",
                        ],
                    ],
                    'questions' => [
                        [
                            'id' => 1, 'type' => 'qcm',
                            'question' => "Dans quel champ placer une personne à informer, sans action attendue ?",
                            'options' => ['À', 'Cc', 'Cci', 'Objet'],
                            'bonne_reponse' => 1,
                            'explication' => "Le champ Cc (copie) sert à tenir une personne informée, sans attendre d'action de sa part, et son adresse reste visible de tous. Le champ À est réservé aux destinataires dont on attend une réponse ; l'objet, lui, n'a rien à voir avec le choix des destinataires.",
                        ],
                        [
                            'id' => 2, 'type' => 'qcm',
                            'question' => "Quel champ masque les adresses des destinataires entre eux ?",
                            'options' => ['À', 'Cc', 'Cci', 'Objet'],
                            'bonne_reponse' => 2,
                            'explication' => "Le Cci (copie cachée) masque les adresses des destinataires entre eux : personne ne voit qui d'autre a reçu le message, ce qui est idéal pour un envoi groupé. Dans les champs À et Cc, au contraire, toutes les adresses sont visibles de chacun.",
                        ],
                        [
                            'id' => 3, 'type' => 'vrai_faux',
                            'question' => "Il faut utiliser « Répondre à tous » par défaut, à chaque réponse.",
                            'bonne_reponse' => 'Faux',
                            'explication' => "« Répondre à tous » ne doit pas être un réflexe systématique : on ne l'utilise que si l'ensemble des destinataires est réellement concerné par la réponse. L'employer par défaut encombre inutilement des boîtes et finit par agacer les destinataires.",
                        ],
                        [
                            'id' => 4, 'type' => 'qcm',
                            'question' => "Pour un message d'information envoyé à 50 contacts externes, le bon réflexe est :",
                            'options' => [
                                'Tout mettre en À',
                                'Tout mettre en Cc',
                                'Mettre les destinataires en Cci',
                                'Envoyer 50 emails identiques',
                            ],
                            'bonne_reponse' => 2,
                            'explication' => "Pour un message d'information à 50 contacts externes, on met les destinataires en Cci : leurs adresses restent protégées et invisibles les unes des autres, et on évite les « Répondre à tous » en cascade. Les mettre en À ou Cc exposerait toutes les adresses à tout le monde.",
                        ],
                        [
                            'id' => 5, 'type' => 'qcm',
                            'question' => "Vous informez votre responsable d'un échange, sans attendre d'action de sa part. Vous le mettez :",
                            'options' => ['En À', 'En Cc', 'En Cci', "Dans l'objet"],
                            'bonne_reponse' => 1,
                            'explication' => "On informe le responsable sans attendre d'action de sa part : sa place est donc en Cc (pour information), où son adresse reste visible. Le mettre en À sous-entendrait qu'on attend une réponse de lui, et le Cci serait inadapté pour un simple collègue interne.",
                        ],
                    ],
                ],
            ],

            // ── Module 4 ──────────────────────────────────────────────
            [
                'titre'         => 'Pièces jointes et gestion des échanges',
                'type'          => 'mixte',
                'niveau'        => 'intermediaire',
                'xp_recompense' => 20,
                'contenu_json'  => [
                    'objectif' => "Gérer correctement les pièces jointes et suivre des échanges clairs.",
                    'lecon' => [
                        'titre' => "Pièces jointes et fil d'échanges maîtrisé",
                        'duree' => '7 min',
                        'intro' => "Les pièces jointes et la gestion des fils d'échange sont sources d'erreurs courantes. Quelques réflexes évitent les oublis et les malentendus.",
                        'sections' => [
                            [
                                'titre' => 'Bien gérer les pièces jointes',
                                'corps' => "Annoncez toujours la pièce jointe dans le corps (« Vous trouverez ci-joint… »), nommez-la clairement, et vérifiez qu'elle est bien attachée avant l'envoi — l'oubli est l'erreur la plus fréquente. Pour les fichiers volumineux, préférez un lien de partage qui n'encombre pas la boîte du destinataire.",
                                'liste' => [
                                    "Mentionner la pièce jointe dans le texte",
                                    "Lui donner un nom explicite (« Devis_ProjetAlpha.pdf »)",
                                    "Vérifier qu'elle est bien attachée avant d'envoyer",
                                    "Fichiers lourds → lien de partage plutôt que pièce jointe",
                                ],
                            ],
                            [
                                'titre' => "Garder un fil d'échange lisible",
                                'corps' => "Répondez dans le même fil pour conserver l'historique, et gardez un objet cohérent. Si le sujet change vraiment, créez un nouvel email avec un nouvel objet plutôt que de détourner une ancienne conversation. Citez l'essentiel du message précédent si nécessaire.",
                            ],
                            [
                                'titre' => 'Délais et accusés de réception',
                                'corps' => "Répondez dans un délai raisonnable, même par un court message d'attente (« Bien reçu, je reviens vers vous avant vendredi »). Si une réponse tarde, une relance courtoise vaut mieux qu'un renvoi sec du même email.",
                                'astuce' => "Prenez l'habitude de joindre le fichier AVANT de rédiger le message : l'oubli de pièce jointe devient impossible.",
                            ],
                            [
                                'titre' => 'En pratique',
                                'corps' => "Vous envoyez un rapport de 30 Mo. Plutôt que de l'attacher et de saturer la boîte du destinataire, déposez-le sur l'espace partagé et envoyez le lien, en l'annonçant dans le message. Et joignez toujours le fichier avant d'écrire, pour ne pas l'oublier.",
                            ],
                        ],
                        'resume' => [
                            "Annoncer, nommer et vérifier la pièce jointe ; lien pour les gros fichiers",
                            "Répondre dans le même fil avec un objet cohérent ; nouvel objet si nouveau sujet",
                            "Accuser réception et relancer avec courtoisie",
                        ],
                    ],
                    'questions' => [
                        [
                            'id' => 1, 'type' => 'vrai_faux',
                            'question' => "Avant d'envoyer un email annonçant un document, il faut vérifier que la pièce jointe est bien attachée.",
                            'bonne_reponse' => 'Vrai',
                            'explication' => "Avant d'envoyer un email annonçant un document, on vérifie que la pièce jointe est bien attachée : l'oubli est l'erreur la plus fréquente et oblige à renvoyer un message gêné. Une simple relecture avant l'envoi suffit à l'éviter — d'où l'astuce de joindre le fichier en premier.",
                        ],
                        [
                            'id' => 2, 'type' => 'qcm',
                            'question' => "Pour un fichier très volumineux, mieux vaut :",
                            'options' => [
                                "L'envoyer en pièce jointe quand même",
                                'Partager un lien de téléchargement',
                                'Le découper en dix emails',
                                "Ne pas l'envoyer",
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Pour un fichier volumineux, on partage un lien de téléchargement plutôt qu'une pièce jointe : on évite de saturer la boîte du destinataire et les rejets pour taille dépassée. Le découper en dix emails serait pénible, et ne pas l'envoyer ne résout évidemment rien.",
                        ],
                        [
                            'id' => 3, 'type' => 'qcm',
                            'question' => "Quand le sujet d'un échange change complètement, il vaut mieux :",
                            'options' => [
                                'Continuer dans le même fil',
                                'Créer un nouvel email avec un nouvel objet',
                                "Supprimer l'ancien fil",
                                'Répondre à tous',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Quand le sujet change complètement, on crée un nouvel email avec un nouvel objet : les fils restent clairs et faciles à retrouver. Continuer dans un ancien fil « détourné » rend la recherche et le suivi confus pour tous les participants.",
                        ],
                        [
                            'id' => 4, 'type' => 'qcm',
                            'question' => "Que faire si vous ne pouvez pas répondre tout de suite à une demande ?",
                            'options' => [
                                "Ignorer jusqu'à pouvoir traiter",
                                'Envoyer un court accusé de réception avec un délai',
                                "Supprimer l'email",
                                'Répondre par un seul mot',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Si l'on ne peut pas répondre tout de suite, un court accusé de réception avec un délai (« Bien reçu, je reviens avant vendredi ») rassure l'interlocuteur et évite les relances inutiles. Ignorer le message ou répondre par un seul mot laisse l'autre dans l'incertitude.",
                        ],
                        [
                            'id' => 5, 'type' => 'qcm',
                            'question' => "Vous devez envoyer un fichier de 40 Mo à un client. La meilleure approche :",
                            'options' => [
                                "L'attacher tel quel",
                                'Partager un lien de téléchargement, annoncé dans le message',
                                "L'envoyer en huit emails",
                                "Ne pas l'envoyer",
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Pour un fichier de 40 Mo, la meilleure approche est de partager un lien de téléchargement, annoncé dans le message : on évite de saturer la boîte du client et les blocages liés à la taille. L'attacher tel quel risque d'être rejeté, et le découper en huit emails serait laborieux et peu professionnel.",
                        ],
                    ],
                ],
            ],

            // ── Module 5 ──────────────────────────────────────────────
            [
                'titre'         => 'Ton, étiquette et communication interculturelle',
                'type'          => 'mixte',
                'niveau'        => 'expert',
                'xp_recompense' => 30,
                'contenu_json'  => [
                    'objectif' => "Adopter le ton juste, respecter l'étiquette et adapter sa communication aux contextes et cultures.",
                    'lecon' => [
                        'titre' => 'Ton professionnel et étiquette',
                        'duree' => '8 min',
                        'intro' => "Au-delà du contenu, le ton et l'étiquette déterminent la façon dont votre message est reçu. Un email engage et se conserve : il mérite la même attention qu'une parole publique.",
                        'sections' => [
                            [
                                'titre' => 'Le ton juste',
                                'corps' => "Restez courtois, factuel et concis, même en cas de désaccord ou d'urgence. Évitez l'ironie et le second degré, qui passent mal à l'écrit. Adaptez le niveau de formalité au destinataire (un dirigeant externe n'est pas un collègue proche). Le tutoiement ou le vouvoiement suit les usages de l'entreprise.",
                                'liste' => [
                                    "Courtois et factuel, même sous pression",
                                    "Pas d'ironie ni de second degré à l'écrit",
                                    "Sujet sensible → relire à froid, ou préférer un appel",
                                    "Adapter la formalité au destinataire",
                                ],
                            ],
                            [
                                'titre' => 'Gérer les situations sensibles',
                                'corps' => "Pour un sujet délicat ou émotionnel, prenez du recul : rédigez, puis relisez à tête reposée avant d'envoyer. Souvent, un appel ou un échange de vive voix règle mieux un conflit qu'une chaîne d'emails. Ne mettez jamais par écrit ce que vous ne diriez pas en réunion.",
                            ],
                            [
                                'titre' => 'Étiquette et culture',
                                'corps' => "Tenez compte des fuseaux horaires et des heures de travail (un email tard le soir peut attendre l'envoi du lendemain). Avec des interlocuteurs internationaux, soyez explicite, évitez les abréviations et l'argot, et tenez compte des usages locaux de politesse. La clarté prime sur le style.",
                                'astuce' => "Avant d'envoyer un email écrit sous le coup de l'émotion, enregistrez-le en brouillon et relisez-le quelques minutes plus tard.",
                            ],
                            [
                                'titre' => 'En pratique',
                                'corps' => "Un collègue vous écrit un message qui vous agace. Ne répondez pas à chaud : rédigez un brouillon factuel, relisez-le dix minutes plus tard, retirez toute pointe d'ironie. Si la tension persiste, proposez un appel : l'oral désamorce mieux qu'une chaîne d'emails.",
                            ],
                        ],
                        'resume' => [
                            "Ton courtois, factuel et concis, sans ironie, adapté au destinataire",
                            "Sujets sensibles : relire à froid ou privilégier l'oral",
                            "Communication internationale : être explicite, tenir compte des usages et fuseaux",
                        ],
                    ],
                    'questions' => [
                        [
                            'id' => 1, 'type' => 'qcm',
                            'question' => "Quel ton adopter même en cas de désaccord dans un email ?",
                            'options' => ['Ironique', 'Courtois et factuel', 'Familier', 'Agressif pour marquer le coup'],
                            'bonne_reponse' => 1,
                            'explication' => "Même en cas de désaccord, on reste courtois et factuel : un email se conserve, se transfère et peut resurgir longtemps après. Un ton ironique, familier ou agressif se retourne vite contre son auteur et abîme la relation professionnelle.",
                        ],
                        [
                            'id' => 2, 'type' => 'vrai_faux',
                            'question' => "Pour un sujet sensible ou émotionnel, mieux vaut parfois un appel qu'une chaîne d'emails.",
                            'bonne_reponse' => 'Vrai',
                            'explication' => "Pour un sujet sensible ou émotionnel, un appel ou un échange de vive voix règle souvent mieux les choses qu'une longue chaîne d'emails, où le ton se durcit et les malentendus s'accumulent. L'oral permet d'ajuster immédiatement et de désamorcer la tension.",
                        ],
                        [
                            'id' => 3, 'type' => 'qcm',
                            'question' => "Avec des interlocuteurs internationaux, il faut :",
                            'options' => [
                                "Utiliser beaucoup d'argot",
                                'Être explicite et éviter les abréviations',
                                'Écrire plus vite',
                                'Ignorer les fuseaux horaires',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Avec des interlocuteurs internationaux, on est explicite et on évite les abréviations, l'argot et l'humour local, qui passent mal. On tient aussi compte des fuseaux horaires et des usages de politesse : la clarté prime toujours sur le style.",
                        ],
                        [
                            'id' => 4, 'type' => 'qcm',
                            'question' => "Quel réflexe pour un email rédigé sous le coup de l'émotion ?",
                            'options' => [
                                "L'envoyer immédiatement",
                                "L'enregistrer en brouillon et le relire à froid",
                                'Le mettre en majuscules',
                                "L'envoyer à tout le service",
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Un email rédigé sous le coup de l'émotion gagne à être enregistré en brouillon et relu à froid : on en retire les formulations qu'on regretterait. L'envoyer immédiatement, en majuscules ou à tout le service ne ferait qu'amplifier les dégâts.",
                        ],
                        [
                            'id' => 5, 'type' => 'qcm',
                            'question' => "Un email vous met en colère. La meilleure réaction professionnelle :",
                            'options' => [
                                'Répondre immédiatement et sèchement',
                                'Rédiger un brouillon, le relire à froid, rester factuel',
                                'Répondre à tous pour prendre des témoins',
                                'Ignorer définitivement',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Face à un email qui vous met en colère, la meilleure réaction est de rédiger un brouillon, de le relire à froid et de rester factuel : on évite ainsi les messages regrettables, qui se conservent et se transfèrent. Répondre sèchement ou prendre des témoins en « répondre à tous » ne ferait qu'envenimer la situation.",
                        ],
                    ],
                ],
            ],

            // ── Module 6 ──────────────────────────────────────────────
            [
                'titre'         => 'Gérer sa boîte : tri, règles et priorisation',
                'type'          => 'mixte',
                'niveau'        => 'expert',
                'xp_recompense' => 30,
                'contenu_json'  => [
                    'objectif' => "Organiser sa boîte de réception avec dossiers, règles et priorisation pour rester maître de ses emails.",
                    'lecon' => [
                        'titre' => 'Organiser et maîtriser sa boîte de réception',
                        'duree' => '8 min',
                        'intro' => "Une boîte de réception saturée fait perdre du temps et des informations. Quelques méthodes simples permettent de la garder sous contrôle et de prioriser l'essentiel.",
                        'sections' => [
                            [
                                'titre' => 'Trier avec dossiers et catégories',
                                'corps' => "Classez les messages traités dans des dossiers (par projet, client ou thème) ou avec des catégories de couleur. L'objectif n'est pas de tout archiver, mais de retrouver vite : une recherche bien faite vaut souvent mieux que dix sous-dossiers.",
                            ],
                            [
                                'titre' => 'Automatiser avec des règles',
                                'corps' => "Les règles (ou filtres) trient automatiquement les emails à l'arrivée : déplacer les newsletters dans un dossier, signaler les messages d'un client clé, classer les notifications. Bien réglées, elles allègent la boîte principale et mettent en avant ce qui compte.",
                                'liste' => [
                                    "Dossiers / catégories → classer par projet ou thème",
                                    "Règles / filtres → trier automatiquement à l'arrivée",
                                    "Drapeaux / rappels → marquer ce qui demande une action",
                                    "Recherche → retrouver vite plutôt que sur-classer",
                                ],
                            ],
                            [
                                'titre' => 'Prioriser (méthode Inbox Zero)',
                                'corps' => "Traitez chaque email selon quatre options : répondre tout de suite si c'est rapide (moins de deux minutes), planifier l'action (drapeau, tâche) si c'est plus long, déléguer si ce n'est pas pour vous, ou archiver/supprimer s'il n'appelle aucune action. L'idée n'est pas d'avoir zéro email, mais zéro email non traité qui traîne.",
                                'astuce' => "Réservez deux ou trois plages dédiées aux emails dans la journée plutôt que de réagir à chaque notification : vous gagnez en concentration.",
                            ],
                            [
                                'titre' => 'En pratique',
                                'corps' => "Le lundi matin, votre boîte déborde. Créez une règle qui classe les newsletters dans un dossier, traitez d'abord les emails qui demandent moins de deux minutes, mettez un drapeau sur ceux qui demandent une action plus longue, et archivez le reste. Réservez deux plages d'emails dans la journée.",
                            ],
                        ],
                        'resume' => [
                            "Classer avec dossiers/catégories et s'appuyer sur la recherche",
                            "Automatiser le tri avec des règles ou filtres",
                            "Prioriser (répondre, planifier, déléguer, archiver) et traiter par plages",
                        ],
                    ],
                    'questions' => [
                        [
                            'id' => 1, 'type' => 'qcm',
                            'question' => "À quoi servent les règles (ou filtres) d'une messagerie ?",
                            'options' => [
                                'À supprimer la boîte',
                                "À trier automatiquement les emails à l'arrivée",
                                'À changer la police',
                                "À bloquer l'envoi",
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Les règles (ou filtres) trient automatiquement les emails à l'arrivée : déplacer les newsletters dans un dossier, signaler un client clé, classer les notifications. Elles n'ont pas pour rôle de supprimer la boîte, de changer la police ni de bloquer l'envoi.",
                        ],
                        [
                            'id' => 2, 'type' => 'vrai_faux',
                            'question' => "Traiter ses emails par plages dédiées plutôt qu'à chaque notification améliore la concentration.",
                            'bonne_reponse' => 'Vrai',
                            'explication' => "Traiter ses emails par plages dédiées, plutôt que de réagir à chaque notification, limite les interruptions et préserve la concentration. On reste maître de son temps au lieu d'être interrompu en permanence, ce qui améliore nettement l'efficacité.",
                        ],
                        [
                            'id' => 3, 'type' => 'qcm',
                            'question' => "Selon la méthode de priorisation, que faire d'un email dont la réponse prend moins de deux minutes ?",
                            'options' => [
                                'Le reporter à plus tard',
                                'Y répondre tout de suite',
                                'Le supprimer sans lire',
                                'Le transférer à tous',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Selon la méthode de priorisation, un email dont la réponse prend moins de deux minutes se traite tout de suite : c'est plus rapide que de le reporter, de le relire plus tard et d'y revenir. Le reporter ou le supprimer sans répondre ne ferait que déplacer la charge.",
                        ],
                        [
                            'id' => 4, 'type' => 'qcm',
                            'question' => "Quel est l'objectif d'une boîte bien gérée ?",
                            'options' => [
                                'Avoir littéralement zéro email',
                                'Zéro email non traité qui traîne',
                                'Ne jamais archiver',
                                'Tout garder en gras',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "L'objectif d'une boîte bien gérée n'est pas d'avoir littéralement zéro email, mais qu'aucun message nécessitant une action ne reste en suspens : tout est soit traité, soit planifié, soit délégué, soit archivé. Garder tout en gras ou ne jamais archiver irait à l'encontre de cette logique.",
                        ],
                        [
                            'id' => 5, 'type' => 'qcm',
                            'question' => "Un email demande une réponse qui prend 30 secondes. Selon la méthode de priorisation :",
                            'options' => [
                                'Le reporter à demain',
                                'Y répondre tout de suite',
                                "L'archiver sans répondre",
                                'Le transférer à tous',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Un email qui se règle en 30 secondes entre dans la catégorie « moins de deux minutes » : on y répond immédiatement, plutôt que de le laisser traîner ou de le reporter. L'archiver sans répondre ou le transférer à tous serait contre-productif.",
                        ],
                    ],
                ],
            ],

        ];

        $this->creerModules($email, $modules);
    }
}
