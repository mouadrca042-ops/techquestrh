<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parcours;
use Database\Seeders\Concerns\CreeModulesFormation;

class ExcelFormationSeeder extends Seeder
{
    use CreeModulesFormation;

    public function run(): void
    {
        $excel = Parcours::where('outil', 'Excel')->firstOrFail();

        $modules = [

            // ── Module 1 ──────────────────────────────────────────────
            [
                'titre'         => "S'orienter dans Excel",
                'type'          => 'mixte',
                'niveau'        => 'debutant',
                'xp_recompense' => 10,
                'contenu_json'  => [
                    'objectif' => "Comprendre l'interface, le classeur et la structure d'une feuille pour travailler sans hésitation.",
                    'lecon' => [
                        'titre' => "L'environnement de travail d'Excel",
                        'duree' => '6 min',
                        'intro' => "Excel est l'outil de référence pour organiser, calculer et analyser des données au bureau. Avant toute manipulation, il faut maîtriser son environnement de travail : c'est ce qui fera la différence sur votre productivité au quotidien.",
                        'sections' => [
                            [
                                'titre' => 'Classeur, feuilles et onglets',
                                'corps' => "Un fichier Excel s'appelle un classeur (extension .xlsx). Il contient une ou plusieurs feuilles de calcul, accessibles par les onglets en bas de l'écran. On crée une feuille avec le bouton « + » et on la renomme d'un double-clic sur son onglet. Regrouper des données liées dans un même classeur, réparties sur des feuilles distinctes, est une bonne pratique d'organisation.",
                            ],
                            [
                                'titre' => 'Le ruban et les onglets de commandes',
                                'corps' => "En haut, le ruban regroupe les commandes par onglets thématiques. Chaque onglet rassemble des groupes logiques de boutons. La barre d'outils Accès rapide, tout en haut, permet d'épingler les commandes les plus utilisées pour y accéder en un clic.",
                                'liste' => [
                                    "Accueil → mise en forme et édition courante",
                                    "Insertion → tableaux, graphiques, illustrations",
                                    "Formules → bibliothèque de fonctions",
                                    "Données → tri, filtres, import de données",
                                ],
                            ],
                            [
                                'titre' => 'Se repérer dans la grille',
                                'corps' => "Chaque feuille est une grille de colonnes (lettres) et de lignes (numéros). La zone de nom, en haut à gauche, affiche l'adresse de la cellule active ; la barre de formule, juste à côté, en montre le contenu réel. Pour de grands tableaux, la commande Affichage > Figer les volets garde les en-têtes visibles pendant le défilement.",
                                'astuce' => "Ctrl + Début ramène à la cellule A1 ; Ctrl + une touche fléchée saute directement au bord d'une plage de données.",
                            ],
                            [
                                'titre' => 'En pratique',
                                'corps' => "On vous transmet un classeur de suivi des ventes. Le bon réflexe : repérer les onglets (souvent une feuille par mois), figer la ligne d'en-tête pour garder les intitulés visibles, puis utiliser Ctrl + touches fléchées pour mesurer l'étendue des données avant de commencer à travailler.",
                            ],
                        ],
                        'resume' => [
                            "Un classeur (.xlsx) contient plusieurs feuilles, accessibles par les onglets du bas",
                            "Le ruban organise les commandes par onglets (Accueil, Insertion, Formules, Données…)",
                            "La zone de nom et la barre de formule indiquent l'adresse et le contenu de la cellule active",
                        ],
                    ],
                    'questions' => [
                        [
                            'id' => 1, 'type' => 'qcm',
                            'question' => "Comment s'appelle un fichier Excel ?",
                            'options' => ['Un document', 'Un classeur', 'Une feuille', 'Une cellule'],
                            'bonne_reponse' => 1,
                            'explication' => "Un fichier Excel porte le nom de « classeur » (extension .xlsx), car il peut réunir plusieurs feuilles de calcul, comme un classeur physique réunit plusieurs intercalaires. Le mot « feuille » désigne un seul onglet à l'intérieur, et « cellule » une simple case : ce sont trois niveaux différents qu'il ne faut pas confondre.",
                        ],
                        [
                            'id' => 2, 'type' => 'qcm',
                            'question' => "Dans quel onglet du ruban trouve-t-on le tri et les filtres ?",
                            'options' => ['Accueil', 'Insertion', 'Données', 'Affichage'],
                            'bonne_reponse' => 2,
                            'explication' => "L'onglet Données rassemble tout ce qui concerne la manipulation des données : trier, filtrer, supprimer les doublons, importer un fichier externe. À ne pas confondre avec Accueil (mise en forme et édition) ni Affichage (zoom, figeage des volets) : chaque onglet a un rôle bien précis.",
                        ],
                        [
                            'id' => 3, 'type' => 'vrai_faux',
                            'question' => "Un même classeur peut contenir plusieurs feuilles de calcul.",
                            'bonne_reponse' => 'Vrai',
                            'explication' => "Un classeur peut contenir autant de feuilles que nécessaire, ajoutées via le bouton « + » en bas de l'écran. C'est très pratique pour séparer des données liées — par exemple une feuille par mois ou par service — tout en les conservant dans un seul et même fichier.",
                        ],
                        [
                            'id' => 4, 'type' => 'qcm',
                            'question' => "À quoi sert la commande « Figer les volets » ?",
                            'options' => [
                                'Verrouiller le fichier par mot de passe',
                                'Garder les en-têtes visibles pendant le défilement',
                                'Empêcher toute modification des cellules',
                                'Masquer une feuille',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "« Figer les volets » maintient certaines lignes ou colonnes — le plus souvent la ligne d'en-tête — affichées en permanence pendant que l'on fait défiler le reste du tableau. C'est un simple confort d'affichage : cela n'a rien à voir avec un verrouillage par mot de passe ni avec la protection des cellules.",
                        ],
                        [
                            'id' => 5, 'type' => 'qcm',
                            'question' => "Vous ouvrez un fichier de 2 000 lignes et les en-têtes disparaissent dès que vous descendez. Que faites-vous ?",
                            'options' => [
                                'Réduire la taille de la police',
                                "Affichage > Figer les volets (figer la ligne d'en-tête)",
                                'Supprimer des lignes',
                                'Imprimer le fichier',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Sur un tableau long, on perd vite les intitulés de colonnes en descendant. La solution est Affichage > Figer les volets > Figer la ligne supérieure : l'en-tête reste collé en haut quoi qu'il arrive. Réduire la police rendrait le texte illisible et supprimer des lignes ferait perdre des données : ni l'un ni l'autre ne résout le problème.",
                        ],
                    ],
                ],
            ],

            // ── Module 2 ──────────────────────────────────────────────
            [
                'titre'         => 'Saisir et mettre en forme des données',
                'type'          => 'mixte',
                'niveau'        => 'debutant',
                'xp_recompense' => 10,
                'contenu_json'  => [
                    'objectif' => "Saisir des données proprement et les présenter de façon claire et professionnelle.",
                    'lecon' => [
                        'titre' => 'Saisie et mise en forme professionnelle',
                        'duree' => '7 min',
                        'intro' => "Un tableau lisible se comprend en quelques secondes. Une saisie rigoureuse et une mise en forme sobre rendent vos données crédibles et exploitables par vos collègues.",
                        'sections' => [
                            [
                                'titre' => 'Saisir le bon type de donnée',
                                'corps' => "Excel distingue les nombres, les dates et le texte. Un nombre bien saisi s'aligne à droite et peut être calculé ; un nombre tapé avec une lettre ou un mauvais séparateur devient du texte et fausse les calculs. Pour les dates, respectez le format reconnu par votre système. N'inscrivez pas l'unité dans la cellule (« 50 DH ») : saisissez 50 et appliquez un format monétaire (Dirham marocain).",
                            ],
                            [
                                'titre' => 'Mettre en forme avec sobriété',
                                'corps' => "La mise en forme se trouve dans l'onglet Accueil : police, gras, bordures, remplissage, alignement. Pour des montants, utilisez les formats Nombre ou Monétaire plutôt que de taper les symboles. Restez sobre : une ligne d'en-tête en gras, des bordures fines et une couleur d'accent suffisent.",
                                'liste' => [
                                    "Format Nombre → séparateur de milliers, décimales",
                                    "Format Monétaire / Comptabilité → montants alignés",
                                    "Format Date → dates cohérentes et triables",
                                    "Format Pourcentage → ratios lisibles (12 %)",
                                ],
                            ],
                            [
                                'titre' => 'Gagner du temps : recopie et largeur',
                                'corps' => "La poignée de recopie (le petit carré en bas à droite de la cellule) étend une valeur ou une série en glissant. Un double-clic sur la bordure d'un en-tête de colonne ajuste sa largeur au contenu. La commande « Renvoyer à la ligne automatiquement » évite de masquer un texte long.",
                                'astuce' => "Tapez « lundi » puis tirez la poignée de recopie : Excel complète mardi, mercredi… Idem pour les mois ou pour une suite 1, 2, 3.",
                            ],
                            [
                                'titre' => 'En pratique',
                                'corps' => "Vous créez un tableau de dépenses en dirhams. Saisissez les montants en nombres bruts (1500, 2300…), sélectionnez la colonne, puis appliquez le format Monétaire (DH) avec séparateur de milliers. Les totaux resteront calculables — ce qui ne serait pas le cas si vous tapiez « 1 500 DH » à la main.",
                            ],
                        ],
                        'resume' => [
                            "Le bon type (nombre, date, texte) conditionne les calculs et le tri",
                            "Privilégier les formats Nombre / Monétaire / Date plutôt que taper les symboles",
                            "Mise en forme sobre + poignée de recopie pour la rapidité",
                        ],
                    ],
                    'questions' => [
                        [
                            'id' => 1, 'type' => 'qcm',
                            'question' => "Pour afficher un montant en dirhams, il vaut mieux :",
                            'options' => [
                                'Taper « 50 DH » directement dans la cellule',
                                'Saisir 50 puis appliquer un format Monétaire',
                                'Écrire « cinquante dirhams »',
                                'Mettre la cellule en gras',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "On saisit le nombre brut (50) puis on applique un format Monétaire : la cellule reste un véritable nombre, donc utilisable dans les calculs, tout en s'affichant « 50,00 DH ». Taper « 50 DH » au clavier transforme la cellule en texte, ce qui casse les totaux et les formules.",
                        ],
                        [
                            'id' => 2, 'type' => 'vrai_faux',
                            'question' => "La poignée de recopie peut compléter automatiquement une série comme janvier, février, mars.",
                            'bonne_reponse' => 'Vrai',
                            'explication' => "La poignée de recopie reconnaît les séries courantes : tapez « janvier » puis tirez-la, et Excel poursuit avec février, mars, etc. Le mécanisme fonctionne aussi pour les jours de la semaine, les dates et les suites de nombres — un vrai gain de temps pour remplir un tableau.",
                        ],
                        [
                            'id' => 3, 'type' => 'qcm',
                            'question' => "Un nombre qui s'aligne à gauche dans la cellule indique souvent :",
                            'options' => [
                                'Qu\'il est en gras',
                                "Qu'Excel l'a interprété comme du texte",
                                'Qu\'il est négatif',
                                'Qu\'il est trop grand',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Par défaut, Excel aligne les nombres à droite et le texte à gauche. Un « nombre » collé à gauche est donc en réalité du texte — généralement à cause d'un espace, d'une lettre ou d'un mauvais séparateur décimal. Conséquence : il ne sera pas pris en compte dans les calculs tant qu'on ne l'aura pas corrigé.",
                        ],
                        [
                            'id' => 4, 'type' => 'qcm',
                            'question' => "Comment ajuster automatiquement la largeur d'une colonne à son contenu ?",
                            'options' => [
                                "Double-clic sur la bordure de l'en-tête de colonne",
                                'Appuyer sur Entrée',
                                'Clic droit puis Supprimer',
                                'Touche F1',
                            ],
                            'bonne_reponse' => 0,
                            'explication' => "Un double-clic sur la bordure droite de l'en-tête de colonne ajuste instantanément sa largeur au contenu le plus long. C'est plus rapide et plus précis que de tirer la bordure à la main, et cela évite les « ##### » qui apparaissent quand une colonne est trop étroite.",
                        ],
                        [
                            'id' => 5, 'type' => 'qcm',
                            'question' => "La colonne « Montant » contient des « 1 500 DH » saisis à la main et =SOMME() renvoie 0. Pourquoi ?",
                            'options' => [
                                'Excel est en panne',
                                'Les valeurs sont du texte, pas des nombres',
                                'La colonne est masquée',
                                'Il manque un graphique',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Quand =SOMME() renvoie 0 sur une colonne de montants, c'est presque toujours parce que les valeurs sont du texte : ici le « DH » tapé manuellement a transformé chaque cellule en chaîne de caractères, qu'Excel ne sait pas additionner. La solution : saisir les nombres seuls (1500) et appliquer un format Monétaire pour l'affichage.",
                        ],
                    ],
                ],
            ],

            // ── Module 3 ──────────────────────────────────────────────
            [
                'titre'         => 'Formules et références',
                'type'          => 'mixte',
                'niveau'        => 'intermediaire',
                'xp_recompense' => 20,
                'contenu_json'  => [
                    'objectif' => "Écrire des formules fiables et comprendre la différence entre référence relative et absolue.",
                    'lecon' => [
                        'titre' => 'Formules, opérateurs et types de références',
                        'duree' => '8 min',
                        'intro' => "Les formules transforment Excel en moteur de calcul. Comprendre comment les références se comportent à la recopie est la compétence qui sépare l'utilisateur débutant de l'utilisateur efficace.",
                        'sections' => [
                            [
                                'titre' => 'Construire une formule',
                                'corps' => "Toute formule commence par =. On combine des références de cellules et des opérateurs : + - * / pour les calculs, et des parenthèses pour gérer la priorité. Excel calcule d'abord les parenthèses, puis les multiplications et divisions, enfin les additions et soustractions. Exemple : =(A1+A2)*B1.",
                            ],
                            [
                                'titre' => 'Référence relative, absolue ou mixte',
                                'corps' => "À la recopie, les références s'adaptent par défaut : c'est la référence relative (=A1 devient =A2 en descendant). Pour figer une cellule, on la rend absolue avec le signe dollar : \$B\$1 ne bouge jamais. On peut figer seulement la colonne (\$B1) ou la ligne (B\$1) : c'est la référence mixte. La touche F4 bascule entre ces modes pendant la saisie.",
                                'liste' => [
                                    "A1 → relative : s'adapte à la recopie",
                                    "\$A\$1 → absolue : reste figée",
                                    "\$A1 ou A\$1 → mixte : colonne ou ligne figée",
                                    "Touche F4 → faire défiler les modes \$",
                                ],
                            ],
                            [
                                'titre' => "Comprendre les messages d'erreur",
                                'corps' => "Excel signale les problèmes par des messages explicites : #DIV/0! (division par zéro), #REF! (référence supprimée), #VALEUR! (mauvais type de donnée), #NOM? (nom de fonction mal orthographié). Ces messages ne sont pas des bugs mais des indices qui pointent la cause à corriger.",
                                'astuce' => "Pour appliquer un taux unique (cellule B1) à toute une colonne, écrivez =A2*\$B\$1 puis recopiez : le taux reste figé grâce au \$.",
                            ],
                            [
                                'titre' => 'En pratique',
                                'corps' => "Vous calculez la TVA d'une liste de prix avec un taux unique placé en B1. Écrivez =A2*\$B\$1 sur la première ligne, puis recopiez vers le bas : grâce au \$, le taux reste figé sur B1 tandis que A2 s'adapte automatiquement (A3, A4…).",
                            ],
                        ],
                        'resume' => [
                            "Priorité des opérateurs : parenthèses, puis × ÷, puis + −",
                            "Référence relative (A1) s'adapte ; absolue (\$A\$1) reste figée ; F4 bascule",
                            "Les messages #DIV/0!, #REF!, #VALEUR! indiquent la cause de l'erreur",
                        ],
                    ],
                    'questions' => [
                        [
                            'id' => 1, 'type' => 'qcm',
                            'question' => "Que devient la référence A1 quand on recopie =A1 d'une ligne vers le bas ?",
                            'options' => ['Elle reste A1', 'Elle devient A2', 'Elle devient B1', 'Elle provoque une erreur'],
                            'bonne_reponse' => 1,
                            'explication' => "Une référence relative se décale dans le même sens que la recopie. En recopiant =A1 d'une ligne vers le bas, elle suit le mouvement et devient =A2. C'est le comportement par défaut d'Excel, idéal pour appliquer un même calcul à toute une colonne sans tout réécrire.",
                        ],
                        [
                            'id' => 2, 'type' => 'qcm',
                            'question' => "Comment figer la cellule B1 pour qu'elle ne change pas lors d'une recopie ?",
                            'options' => ['B1!', '$B$1', '#B1', 'B1*'],
                            'bonne_reponse' => 1,
                            'explication' => "Le signe dollar rend la référence absolue : \$B\$1 pointera toujours vers B1, quel que soit l'endroit où on recopie la formule. On l'utilise pour un élément fixe partagé par toutes les lignes — un taux, une constante. La touche F4 ajoute ces \$ automatiquement pendant la saisie.",
                        ],
                        [
                            'id' => 3, 'type' => 'vrai_faux',
                            'question' => "L'erreur #DIV/0! apparaît quand une formule divise par une cellule vide ou égale à zéro.",
                            'bonne_reponse' => 'Vrai',
                            'explication' => "#DIV/0! signifie littéralement « division par zéro » : la formule divise par une cellule vide ou contenant 0. Ce n'est pas un bug mais un signal utile ; on le corrige en réglant la cellule en cause, ou en protégeant le calcul (par exemple avec une fonction SI qui teste si le diviseur est nul).",
                        ],
                        [
                            'id' => 4, 'type' => 'qcm',
                            'question' => "Dans =(A1+A2)*B1, qu'est-ce qu'Excel calcule en premier ?",
                            'options' => [
                                'A2*B1',
                                'A1+A2 (la parenthèse)',
                                'B1 seul',
                                'De gauche à droite, sans priorité',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Excel respecte les priorités mathématiques : d'abord les parenthèses, puis les multiplications et divisions, enfin les additions et soustractions. Dans =(A1+A2)*B1, la somme entre parenthèses est donc calculée en premier, avant d'être multipliée par B1. Sans les parenthèses, c'est A2*B1 qui serait calculé d'abord.",
                        ],
                        [
                            'id' => 5, 'type' => 'qcm',
                            'question' => "Vous recopiez =A2*B1 vers le bas et les résultats deviennent faux dès la 2e ligne. La bonne correction :",
                            'options' => [
                                'Tout réécrire à la main',
                                'Figer le taux : =A2*$B$1',
                                'Supprimer la colonne B',
                                'Changer de feuille',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Le problème vient de la référence au taux : en recopiant =A2*B1, le « B1 » se décale lui aussi (B2, B3…) et pointe vers des cellules vides, d'où des résultats faux. La correction est de rendre cette référence absolue, =A2*\$B\$1, pour que le taux reste toujours figé sur B1 pendant que A2 s'adapte normalement.",
                        ],
                    ],
                ],
            ],

            // ── Module 4 ──────────────────────────────────────────────
            [
                'titre'         => 'Les fonctions essentielles',
                'type'          => 'mixte',
                'niveau'        => 'intermediaire',
                'xp_recompense' => 20,
                'contenu_json'  => [
                    'objectif' => "Automatiser les calculs courants avec SOMME, MOYENNE, NB, MIN/MAX et SI.",
                    'lecon' => [
                        'titre' => 'Les fonctions qui couvrent 90 % des besoins',
                        'duree' => '9 min',
                        'intro' => "Une poignée de fonctions suffit à couvrir l'immense majorité des besoins de bureau. Les maîtriser, c'est remplacer des heures de calcul manuel par quelques formules fiables.",
                        'sections' => [
                            [
                                'titre' => 'Statistiques de base',
                                'corps' => "Sur une plage de cellules, =SOMME() additionne, =MOYENNE() calcule la moyenne, =MIN() et =MAX() donnent les extrêmes. =NB() compte les cellules contenant un nombre, =NBVAL() compte celles qui ne sont pas vides.",
                                'liste' => [
                                    "=SOMME(plage) → total",
                                    "=MOYENNE(plage) → moyenne",
                                    "=MIN(plage) / =MAX(plage) → plus petite / plus grande valeur",
                                    "=NB(plage) → compte les nombres ; =NBVAL(plage) → compte les cellules non vides",
                                ],
                            ],
                            [
                                'titre' => 'La fonction SI : décider automatiquement',
                                'corps' => "=SI(test ; valeur_si_vrai ; valeur_si_faux) renvoie un résultat selon qu'une condition est remplie ou non. Exemple : =SI(C2>=10 ; \"Validé\" ; \"À revoir\"). Le test utilise les opérateurs =, <> (différent), >, <, >=, <=. Au-delà de deux ou trois SI imbriqués, mieux vaut une autre approche pour rester lisible.",
                            ],
                            [
                                'titre' => 'Compter et additionner sous condition',
                                'corps' => "=NB.SI(plage ; critère) compte les cellules qui remplissent un critère (ex. =NB.SI(D2:D50 ; \"Paris\")). =SOMME.SI(plage ; critère ; plage_somme) additionne sous condition. Ces fonctions évitent de filtrer et compter à la main, et se recalculent automatiquement.",
                                'astuce' => "Mettez toujours le texte renvoyé par SI entre guillemets : =SI(A1>0 ; \"Positif\" ; \"Négatif\").",
                            ],
                            [
                                'titre' => 'En pratique',
                                'corps' => "Sur un tableau de notes, =MOYENNE(B2:B30) donne la moyenne de la classe, =NB.SI(B2:B30 ; \">=10\") compte les admis, et =SI(B2>=10 ; \"Admis\" ; \"Ajourné\") statue ligne par ligne. Le tout se recalcule instantanément si une note change.",
                            ],
                        ],
                        'resume' => [
                            "SOMME, MOYENNE, MIN, MAX, NB/NBVAL couvrent les besoins statistiques courants",
                            "SI(test ; vrai ; faux) automatise une décision selon une condition",
                            "NB.SI et SOMME.SI comptent ou additionnent selon un critère",
                        ],
                    ],
                    'questions' => [
                        [
                            'id' => 1, 'type' => 'qcm',
                            'question' => "Quelle fonction calcule la moyenne des cellules B2 à B30 ?",
                            'options' => ['=SOMME(B2:B30)', '=MOYENNE(B2:B30)', '=NB(B2:B30)', '=MAX(B2:B30)'],
                            'bonne_reponse' => 1,
                            'explication' => "=MOYENNE(B2:B30) additionne toutes les valeurs de la plage et les divise par leur nombre, en une seule formule. =SOMME ne donnerait que le total, =NB ne ferait que compter les cellules et =MAX renverrait la plus grande valeur : chaque fonction a un rôle distinct.",
                        ],
                        [
                            'id' => 2, 'type' => 'qcm',
                            'question' => "Que renvoie =SI(C2>=10 ; \"Validé\" ; \"À revoir\") si C2 vaut 8 ?",
                            'options' => ['Validé', 'À revoir', '10', 'FAUX'],
                            'bonne_reponse' => 1,
                            'explication' => "La fonction SI évalue le test C2>=10. Comme C2 vaut 8, la condition est fausse : Excel renvoie donc la valeur prévue « si faux », c'est-à-dire « À revoir ». Si C2 avait été supérieur ou égal à 10, il aurait au contraire renvoyé « Validé ».",
                        ],
                        [
                            'id' => 3, 'type' => 'qcm',
                            'question' => "Quelle fonction compte le nombre de cellules contenant « Paris » dans D2:D50 ?",
                            'options' => [
                                '=SOMME.SI(D2:D50 ; "Paris")',
                                '=NB(D2:D50)',
                                '=NB.SI(D2:D50 ; "Paris")',
                                '=SI(D2:D50 ; "Paris")',
                            ],
                            'bonne_reponse' => 2,
                            'explication' => "=NB.SI(D2:D50 ; \"Paris\") compte uniquement les cellules égales à « Paris » : NB.SI signifie « compter SI une condition est remplie ». SOMME.SI servirait à additionner des montants sous condition (pas à compter), et NB tout court compterait toutes les cellules numériques sans tenir compte du critère.",
                        ],
                        [
                            'id' => 4, 'type' => 'vrai_faux',
                            'question' => "La fonction NBVAL compte uniquement les cellules contenant des nombres.",
                            'bonne_reponse' => 'Faux',
                            'explication' => "C'est l'inverse : NBVAL compte toutes les cellules non vides, y compris celles qui contiennent du texte. C'est NB (sans « VAL ») qui ne compte que les nombres. La nuance est essentielle dès qu'une colonne mélange des chiffres et des libellés.",
                        ],
                        [
                            'id' => 5, 'type' => 'qcm',
                            'question' => "Pour compter combien d'élèves ont une note ≥ 10 dans B2:B30, vous utilisez :",
                            'options' => [
                                '=SOMME(B2:B30)',
                                '=NB.SI(B2:B30 ; ">=10")',
                                '=MOYENNE(B2:B30)',
                                '=MAX(B2:B30)',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Pour compter des cellules selon un critère chiffré, on utilise NB.SI avec le critère entre guillemets : =NB.SI(B2:B30 ; \">=10\"). SOMME donnerait le total des notes, MOYENNE leur moyenne et MAX la meilleure note : aucune de ces trois ne compte le nombre d'admis.",
                        ],
                    ],
                ],
            ],

            // ── Module 5 ──────────────────────────────────────────────
            [
                'titre'         => 'Trier, filtrer et analyser',
                'type'          => 'mixte',
                'niveau'        => 'expert',
                'xp_recompense' => 30,
                'contenu_json'  => [
                    'objectif' => "Exploiter de grands tableaux : tableau structuré, tri multi-niveaux, filtres et mise en forme conditionnelle.",
                    'lecon' => [
                        'titre' => 'Organiser et analyser de grands volumes',
                        'duree' => '8 min',
                        'intro' => "Dès qu'un tableau dépasse quelques dizaines de lignes, le tri, les filtres et la mise en forme conditionnelle deviennent indispensables pour en extraire l'information utile.",
                        'sections' => [
                            [
                                'titre' => "Le tableau structuré, base d'une bonne analyse",
                                'corps' => "Avant d'analyser, convertissez votre plage en tableau (Insertion > Tableau, ou Ctrl+L). Un tableau structuré gère automatiquement les en-têtes, les filtres, les lignes alternées et s'étend tout seul quand vous ajoutez des données. Les formules y deviennent lisibles grâce aux noms de colonnes.",
                            ],
                            [
                                'titre' => 'Trier et filtrer',
                                'corps' => "Le tri (Données > Trier) range les lignes selon une ou plusieurs colonnes. Le filtre (les flèches dans les en-têtes) masque temporairement les lignes qui ne correspondent pas à un critère, sans rien supprimer.",
                                'liste' => [
                                    "Tri → réorganise durablement l'ordre des lignes",
                                    "Filtre → masque temporairement, ne supprime rien",
                                    "Tri multi-niveaux → ex. Région croissant, puis CA décroissant",
                                ],
                            ],
                            [
                                'titre' => 'La mise en forme conditionnelle',
                                'corps' => "Elle colore automatiquement les cellules selon des règles (Accueil > Mise en forme conditionnelle) : mettre en rouge les valeurs sous un seuil, ajouter des barres de données ou un jeu d'icônes, surligner les doublons. C'est un repérage visuel instantané qui se met à jour avec les données.",
                                'astuce' => "Travaillez dans un tableau structuré (Ctrl+L) : les filtres sont activés d'office et les nouvelles lignes sont intégrées automatiquement.",
                            ],
                            [
                                'titre' => 'En pratique',
                                'corps' => "Sur un export de 1 000 commandes : convertissez en tableau (Ctrl+L), filtrez sur la région « Sud », triez par montant décroissant, puis colorez en rouge, par mise en forme conditionnelle, les commandes sous l'objectif. En quelques clics, l'information utile saute aux yeux.",
                            ],
                        ],
                        'resume' => [
                            "Convertir en tableau structuré (Ctrl+L) fiabilise et automatise l'analyse",
                            "Le tri réordonne ; le filtre masque sans supprimer",
                            "La mise en forme conditionnelle signale seuils, doublons et tendances",
                        ],
                    ],
                    'questions' => [
                        [
                            'id' => 1, 'type' => 'vrai_faux',
                            'question' => "Filtrer un tableau supprime définitivement les lignes qui ne correspondent pas au critère.",
                            'bonne_reponse' => 'Faux',
                            'explication' => "Filtrer ne supprime jamais de données : les lignes non concernées sont seulement masquées et réapparaissent dès que l'on retire le filtre. C'est précisément ce qui rend le filtre sûr pour explorer un tableau — contrairement à une suppression de lignes, qui est, elle, définitive.",
                        ],
                        [
                            'id' => 2, 'type' => 'qcm',
                            'question' => "Quel raccourci convertit une plage en tableau structuré ?",
                            'options' => ['Ctrl+L (ou Ctrl+T)', 'Ctrl+P', 'Ctrl+S', 'Ctrl+Z'],
                            'bonne_reponse' => 0,
                            'explication' => "Ctrl+L (ou Ctrl+T selon la version) transforme une plage en tableau structuré : en-têtes, filtres et lignes alternées sont ajoutés automatiquement, et le tableau s'agrandit tout seul à l'ajout de lignes. Ctrl+P sert à imprimer, Ctrl+S à enregistrer et Ctrl+Z à annuler.",
                        ],
                        [
                            'id' => 3, 'type' => 'qcm',
                            'question' => "À quoi sert la mise en forme conditionnelle ?",
                            'options' => [
                                'À protéger les cellules',
                                'À colorer automatiquement les cellules selon des règles',
                                'À imprimer la feuille',
                                'À créer un graphique',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "La mise en forme conditionnelle applique automatiquement couleurs, barres ou icônes selon des règles que vous définissez (valeur sous un seuil, doublons, top 10…). Elle offre un repérage visuel instantané et se met à jour dès que les données changent, sans intervention de votre part.",
                        ],
                        [
                            'id' => 4, 'type' => 'qcm',
                            'question' => "Un tri multi-niveaux permet de :",
                            'options' => [
                                'Trier sur une seule colonne',
                                "Trier d'abord par une colonne, puis départager par une autre",
                                'Supprimer les doublons',
                                'Filtrer par couleur',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Un tri multi-niveaux applique une première clé de tri, puis départage les ex æquo avec une seconde colonne — par exemple trier par région, puis, à l'intérieur de chaque région, par chiffre d'affaires décroissant. Cela évite d'avoir à trier manuellement en deux passes.",
                        ],
                        [
                            'id' => 5, 'type' => 'qcm',
                            'question' => "Vous voulez n'afficher que les commandes de la région « Sud » sans perdre les autres données. Vous :",
                            'options' => [
                                'Supprimez les autres lignes',
                                'Appliquez un filtre sur la colonne Région',
                                'Changez la couleur de la feuille',
                                'Créez un graphique',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "On pose un filtre sur la colonne Région et on coche « Sud » : les autres lignes sont seulement masquées et reviennent dès qu'on enlève le filtre. Supprimer les autres lignes détruirait définitivement des données, et changer la couleur de la feuille ne filtrerait rien du tout.",
                        ],
                    ],
                ],
            ],

            // ── Module 6 ──────────────────────────────────────────────
            [
                'titre'         => 'Visualiser : graphiques et tableaux croisés',
                'type'          => 'mixte',
                'niveau'        => 'expert',
                'xp_recompense' => 30,
                'contenu_json'  => [
                    'objectif' => "Synthétiser et présenter des données avec les graphiques et une introduction aux tableaux croisés dynamiques.",
                    'lecon' => [
                        'titre' => "Restituer l'information : graphiques et TCD",
                        'duree' => '9 min',
                        'intro' => "Analyser ne suffit pas : il faut restituer clairement. Le graphique parle à l'œil, et le tableau croisé dynamique synthétise des milliers de lignes en quelques clics, sans une seule formule.",
                        'sections' => [
                            [
                                'titre' => 'Choisir et créer le bon graphique',
                                'corps' => "Sélectionnez les données avec leurs en-têtes, puis Insertion > Graphique. Le type doit servir le message. Un graphique se lie aux cellules : il se met à jour quand les données changent. Ajoutez un titre clair et légendez les axes.",
                                'liste' => [
                                    "Histogramme → comparer des catégories",
                                    "Courbe → évolution dans le temps",
                                    "Secteurs → parts ou pourcentages d'un total",
                                ],
                            ],
                            [
                                'titre' => 'Le tableau croisé dynamique (TCD)',
                                'corps' => "Le TCD (Insertion > Tableau croisé dynamique) résume un grand tableau : on glisse les champs en Lignes, Colonnes et Valeurs pour obtenir instantanément des totaux par catégorie (ex. chiffre d'affaires par région et par mois). On change l'analyse en réorganisant les champs, sans toucher aux données sources.",
                            ],
                            [
                                'titre' => 'Restituer avec rigueur',
                                'corps' => "Un bon support va à l'essentiel : un graphique = une idée. Évitez les effets 3D et les couleurs criardes qui brouillent le message. Pour un rapport, accompagnez le visuel d'une phrase de lecture (« Les ventes progressent de 12 % au T2 »).",
                                'astuce' => "Commencez par un TCD pour obtenir les totaux, puis créez un graphique croisé dynamique directement à partir de ce TCD.",
                            ],
                            [
                                'titre' => 'En pratique',
                                'corps' => "Pour un comité mensuel, construisez un tableau croisé « CA par région et par mois », puis une courbe pour montrer la tendance. Ajoutez une phrase de lecture (« Le Sud progresse de 12 % ») : votre message passe en cinq secondes, sans que personne n'ait à lire le tableau brut.",
                            ],
                        ],
                        'resume' => [
                            "Le type de graphique doit servir le message (comparer, évoluer, répartir)",
                            "Le tableau croisé dynamique synthétise de gros volumes sans formule",
                            "Restitution sobre : un visuel = une idée, accompagné d'une phrase de lecture",
                        ],
                    ],
                    'questions' => [
                        [
                            'id' => 1, 'type' => 'qcm',
                            'question' => "Quel graphique convient pour montrer l'évolution d'un chiffre sur 12 mois ?",
                            'options' => ['Secteurs (camembert)', 'Courbe', 'Histogramme empilé', 'Nuage de points'],
                            'bonne_reponse' => 1,
                            'explication' => "La courbe relie des points dans le temps : c'est le graphique idéal pour visualiser une évolution sur 12 mois et faire ressortir une tendance. Le camembert, lui, montre des proportions à un instant donné et ne convient pas du tout pour représenter une évolution.",
                        ],
                        [
                            'id' => 2, 'type' => 'vrai_faux',
                            'question' => "Un tableau croisé dynamique permet de résumer un grand tableau sans écrire de formule.",
                            'bonne_reponse' => 'Vrai',
                            'explication' => "Le tableau croisé dynamique agrège les données par simple glisser-déposer des champs (en Lignes, Colonnes et Valeurs), sans qu'on ait à écrire la moindre formule. C'est l'outil le plus rapide pour synthétiser des milliers de lignes, et l'on change d'analyse en réorganisant simplement les champs.",
                        ],
                        [
                            'id' => 3, 'type' => 'qcm',
                            'question' => "Dans un TCD, où place-t-on le champ que l'on veut totaliser (ex. le montant) ?",
                            'options' => ['En Filtres', 'En Lignes', 'En Valeurs', 'En Colonnes'],
                            'bonne_reponse' => 2,
                            'explication' => "Le champ à totaliser (le montant) se place dans la zone Valeurs, où l'on choisit l'opération à appliquer : somme, moyenne, nombre… Les zones Lignes et Colonnes servent, elles, à définir les catégories d'analyse (par exemple la région en Lignes et le mois en Colonnes).",
                        ],
                        [
                            'id' => 4, 'type' => 'qcm',
                            'question' => "Pourquoi éviter les effets 3D sur un graphique de reporting ?",
                            'options' => [
                                'Ils ralentissent Excel',
                                'Ils déforment la perception et brouillent le message',
                                'Ils sont payants',
                                "Ils empêchent l'impression",
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Les effets 3D inclinent et déforment les proportions : deux parts de taille proche deviennent difficiles à comparer correctement. Pour un reporting fiable et lisible, on privilégie un graphique 2D sobre, où les valeurs se comparent sans illusion d'optique.",
                        ],
                        [
                            'id' => 5, 'type' => 'qcm',
                            'question' => "Votre direction veut rapidement le total des ventes par région à partir de 5 000 lignes. Le plus efficace :",
                            'options' => [
                                'Additionner à la main',
                                'Un tableau croisé dynamique',
                                'Un camembert par ligne',
                                'Trier seulement',
                            ],
                            'bonne_reponse' => 1,
                            'explication' => "Le tableau croisé dynamique agrège des milliers de lignes par catégorie en quelques clics : on glisse « Région » en Lignes et « Ventes » en Valeurs, et les totaux apparaissent. Additionner à la main serait interminable et truffé d'erreurs, et un simple tri ne calculerait aucun total.",
                        ],
                    ],
                ],
            ],

        ];

        $this->creerModules($excel, $modules);
    }
}
