<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CafeMenuSeeder extends Seeder
{
    // Options partagées
    private const COFFEE_CHOICES = [
        'name'     => 'Choix du café',
        'required' => true,
        'choices'  => ['Espresso', 'Macchiato', 'American', 'Latte Macchiato', 'Néscafé / Ricoré', 'Cappuccino'],
    ];

    // Petit-déj : pas de cappuccino
    private const BREAKFAST_COFFEE_CHOICES = [
        'name'     => 'Choix du café',
        'required' => true,
        'choices'  => ['Espresso', 'Macchiato', 'American', 'Latte Macchiato', 'Néscafé / Ricoré'],
    ];

    private const JUICE_CHOICES = [
        'name'     => 'Choix du jus frais',
        'required' => true,
        'choices'  => ['Jus d\'Orange', 'Jus de Fraise', 'Citronnade'],
    ];

    private const SPICE_CHOICES = [
        'name'     => 'Niveau de piquant',
        'required' => true,
        'choices'  => ['Doux', 'Moyen', 'Épicé', 'Très épicé'],
    ];

    private const FLAVOR_CHOICES = [
        'name'     => 'Arôme',
        'required' => true,
        'choices'  => ['Caramel', 'Vanille', 'Noisette', 'Cookies'],
    ];

    private const MOJITO_COLOR = [
        'name'     => 'Couleur',
        'required' => true,
        'choices'  => ['Red', 'Bleu'],
    ];

    // Arôme optionnel (+1 DT) pour les cafés
    private const AROMA_CHOICES = [
        'name'       => 'Arôme',
        'required'   => false,
        'surcharge'  => 1.0,
        'none_value' => 'Sans arôme',
        'choices'    => ['Sans arôme', 'Caramel', 'Vanille', 'Noisette', 'Cookies', 'Nestlé'],
    ];

    public function run(): void
    {
        $breakfastOptions        = [self::BREAKFAST_COFFEE_CHOICES, self::JUICE_CHOICES];
        $breakfastSpiceOptions   = [self::BREAKFAST_COFFEE_CHOICES, self::JUICE_CHOICES, self::SPICE_CHOICES];
        $spiceOptions            = [self::SPICE_CHOICES];

        // Duo · pour 2 : 2 cafés + 2 jus (sans niveau de piquant)
        $duoOptions = [
            array_merge(self::BREAKFAST_COFFEE_CHOICES, ['name' => 'Café 1']),
            array_merge(self::BREAKFAST_COFFEE_CHOICES, ['name' => 'Café 2']),
            array_merge(self::JUICE_CHOICES,            ['name' => 'Jus 1']),
            array_merge(self::JUICE_CHOICES,            ['name' => 'Jus 2']),
        ];

        $menu = [
            // ─── Petit-déj ──────────────────────────────────────────────────
            [
                'name' => 'Petit-déj',
                'note' => null,
                'items' => [
                    // [$name, $description, $price, $image, $options_config]
                    ['Quickly',     'Café au choix · Eau 0.5L · Jus frais · Viennoiserie',                                                          8.5, 'images/products/breakfast.svg',   $breakfastOptions],
                    ['Yogurt Bowl', 'Café · Eau · Jus frais · Granola maison · Fruit de saison',                                                    12,  'images/products/yogurt_bowl.svg', $breakfastOptions],
                    ['Salty',       'Café · Eau · Jus frais · Viennoiserie · Confiture/Beurre/Chocolat · Omelette salade & charcuterie',            19,  'images/products/breakfast.svg',   $breakfastOptions],
                    ['Duo · pour 2','2 Cafés, eaux, 2 jus, viennoiseries, omelettes, mini-crêpes, yaourts granola, charcuterie & salades de fruits',               40,  'images/products/yogurt_bowl.svg', $duoOptions],
                ],
            ],

            // ─── Coffee ─────────────────────────────────────────────────────
            [
                'name' => 'Coffee',
                'note' => null,
                'items' => [
                    ['Espresso',            null, 3.5, 'images/products/espresso.svg',   [self::AROMA_CHOICES]],
                    ['Macchiato',           null, 4,   'images/products/espresso.svg',   [self::AROMA_CHOICES]],
                    ['American',            null, 4,   'images/products/americano.svg',  [self::AROMA_CHOICES]],
                    ['Latte Macchiato',     null, 4.5, 'images/products/latte.svg',      [self::AROMA_CHOICES]],
                    ['Néscafé / Ricoré',   null, 6,   'images/products/nescafe.svg',    [self::AROMA_CHOICES]],
                    ['Capsule / Décaféiné', null, 5,   'images/products/capsule.svg',    [self::AROMA_CHOICES]],
                    ['Affogato',            null, 7,   'images/products/affogato.svg',   [self::AROMA_CHOICES]],
                    ['Mochaccino',          null, 7,   'images/products/mochaccino.svg', [self::AROMA_CHOICES]],
                    ['Chocolat au lait',    null, 5,   'images/products/choc_lait.svg',  [self::AROMA_CHOICES]],
                    ['Cacao au lait',       null, 5,   'images/products/choc_lait.svg',  [self::AROMA_CHOICES]],
                    ['Nutella au lait',     null, 8,   'images/products/choc_lait.svg',  [self::AROMA_CHOICES]],
                    ['Cappuccino',          null, 8,   'images/products/cappuccino.svg', [self::AROMA_CHOICES]],
                ],
            ],

            // ─── Macchiato & Café glacé ──────────────────────────────────────
            [
                'name' => 'Macchiato & Café glacé',
                'note' => null,
                'items' => [
                    ['Macchiato aromatisé', 'Caramel · Vanille · Noisette · Cookies', 7, 'images/products/iced_coffee.svg', [self::FLAVOR_CHOICES]],
                    ['Café Glacé',          'Caramel · Vanille · Noisette · Cookies', 8, 'images/products/iced_coffee.svg', [self::FLAVOR_CHOICES]],
                ],
            ],

            // ─── Thés ────────────────────────────────────────────────────────
            [
                'name' => 'Thés',
                'note' => null,
                'items' => [
                    ['Thé à la Menthe', null, 3.5, 'images/products/tea.svg', null],
                    ['Thé Infusion',    null, 5,   'images/products/tea.svg', null],
                    ['Thé aux Amandes', null, 7,   'images/products/tea.svg', null],
                    ['Thé aux Pignons', null, 8,   'images/products/tea.svg', null],
                ],
            ],

            // ─── Frappuccino ─────────────────────────────────────────────────
            [
                'name' => 'Frappuccino',
                'note' => null,
                'items' => [
                    ['Café',     null, 8,  'images/products/frappuccino.svg', null],
                    ['Caramel',  null, 9,  'images/products/frappuccino.svg', null],
                    ['Noisette', null, 9,  'images/products/frappuccino.svg', null],
                    ['Fraise',   null, 9,  'images/products/frappuccino.svg', null],
                    ['Cookies',  null, 10, 'images/products/frappuccino.svg', null],
                    ['Oreo',     null, 10, 'images/products/frappuccino.svg', null],
                ],
            ],

            // ─── Chocolat chaud & glacé ──────────────────────────────────────
            [
                'name' => 'Chocolat chaud & glacé',
                'note' => 'Chaud ou glacé, même prix.',
                'items' => [
                    ['Dark',     null, 8,  'images/products/hot_chocolate.svg', null],
                    ['Snickers', null, 9,  'images/products/hot_chocolate.svg', null],
                    ['Caramel',  null, 9,  'images/products/hot_chocolate.svg', null],
                    ['Bounty',   null, 10, 'images/products/hot_chocolate.svg', null],
                    ['Fraise',   null, 10, 'images/products/hot_chocolate.svg', null],
                ],
            ],

            // ─── Milkshakes ───────────────────────────────────────────────────
            [
                'name' => 'Milkshakes',
                'note' => null,
                'items' => [
                    ['Vanille',      null,                               9,  'images/products/milkshake.svg', null],
                    ['Nutella',      null,                               10, 'images/products/milkshake.svg', null],
                    ['Oreo',         null,                               10, 'images/products/milkshake.svg', null],
                    ['Speculoos',    null,                               10, 'images/products/milkshake.svg', null],
                    ['Snickers',     null,                               10, 'images/products/milkshake.svg', null],
                    ['Bounty',       null,                               10, 'images/products/milkshake.svg', null],
                    ['Café Cookies', null,                               11, 'images/products/milkshake.svg', null],
                    ['Workshop',     "Nutella, M&M's, Milka & Snickers", 15, 'images/products/milkshake.svg', null],
                ],
            ],

            // ─── Mojitos ─────────────────────────────────────────────────────
            [
                'name' => 'Mojitos',
                'note' => null,
                'items' => [
                    ['Virgin',    null,                  7.5, 'images/products/mojito.svg', null],
                    ['Red / Blue',null,                  8.5, 'images/products/mojito.svg', [self::MOJITO_COLOR]],
                    ['Space',     null,                  9.5, 'images/products/mojito.svg', null],
                    ['Exotic',    null,                  9.5, 'images/products/mojito.svg', null],
                    ['Tropical',  null,                  9.5, 'images/products/mojito.svg', null],
                    ['Power',     'Boisson énergétique', 14,  'images/products/energy.svg', null],
                ],
            ],

            // ─── Smoothies ───────────────────────────────────────────────────
            [
                'name' => 'Smoothies',
                'note' => 'Sans sucre ajouté.',
                'items' => [
                    ['Banane & Ananas',                    null, 9.5,  'images/products/smoothie.svg', null],
                    ['Banane Pomme & Épinard',             null, 9.5,  'images/products/smoothie.svg', null],
                    ['Banane & Fraise / Framboise',        null, 9.5,  'images/products/smoothie.svg', null],
                    ['Banane Cacao & Beurre de cacahuète', null, 10.5, 'images/products/smoothie.svg', null],
                ],
            ],

            // ─── Classics ────────────────────────────────────────────────────
            [
                'name' => 'Classics',
                'note' => null,
                'items' => [
                    ['Eau 0.5L',           null, 2,    'images/products/water.svg',      null],
                    ['Eau 1L',             null, 3,    'images/products/water.svg',      null],
                    ['Soda',               null, 4,    'images/products/soda.svg',       null],
                    ['Citronnade',         null, 4.5,  'images/products/citronnade.svg', null],
                    ["Jus d'Orange",       null, 4.5,  'images/products/jus_orange.svg', null],
                    ['Jus de Fraise',      null, 6,    'images/products/jus_fraise.svg', null],
                    ['Lait de Poule',      null, 8.5,  'images/products/lait_poule.svg', null],
                    ['Boisson Énergétique',null, 11,   'images/products/energy.svg',     null],
                ],
            ],

            // ─── Crêpes sucrées ───────────────────────────────────────────────
            [
                'name' => 'Crêpes sucrées',
                'note' => null,
                'items' => [
                    ['Nutella',    'The Original',                                                          12, 'images/products/crepe_sucree.svg', null],
                    ['Othello',    'Nutella, Banane & Oreo',                                               14, 'images/products/crepe_sucree.svg', null],
                    ["L'Amandine", 'Nutella & Amande',                                                     14, 'images/products/crepe_sucree.svg', null],
                    ['Snickers',   'Nutella, Snickers, Caramel, Beurre de cacahuète & Cacahuète',          14, 'images/products/crepe_sucree.svg', null],
                    ['Pistache',   'Nutella & Pistache',                                                   14, 'images/products/crepe_sucree.svg', null],
                    ['Rocher',     'Nutella, Noisette & Ferrero Rocher',                                   14, 'images/products/crepe_sucree.svg', null],
                    ['Speculoos',  'Nutella, Speculoos & Lotus',                                           14, 'images/products/crepe_sucree.svg', null],
                    ['Workshop',   "Nutella, Kinder, M&M's, Milka, Oreo & Pépites de Chocolat",           16, 'images/products/crepe_sucree.svg', null],
                ],
            ],

            // ─── Gaufres sucrées ──────────────────────────────────────────────
            [
                'name'    => 'Gaufres sucrées',
                'note'    => null,
                'visible' => false,          // masqué du menu client
                'items' => [
                    ['Nutella',   null, 9,  'images/products/gaufre.svg', null],
                    ['Othello',   null, 10, 'images/products/gaufre.svg', null],
                    ['Speculoos', null, 11, 'images/products/gaufre.svg', null],
                    ['Crispy',    null, 11, 'images/products/gaufre.svg', null],
                    ['Workshop',  null, 14, 'images/products/gaufre.svg', null],
                ],
            ],

            // ─── Crêpes salées ────────────────────────────────────────────────
            [
                'name' => 'Crêpes salées',
                'note' => null,
                'items' => [
                    ['Classic Thon',   'Thon, Fromage & Harissa',                          12, 'images/products/crepe_salee.svg', $spiceOptions],
                    ['Classic Jambon', 'Jambon, Fromage & Harissa',                        12, 'images/products/crepe_salee.svg', $spiceOptions],
                    ['Classic Duo',    'Thon, Jambon, Fromage & Harissa',                  14, 'images/products/crepe_salee.svg', $spiceOptions],
                    ['Tunisienne',     'Thon, Fromage, Harissa, Œuf & Olive',              14, 'images/products/crepe_salee.svg', $spiceOptions],
                    ['Française',      'Sauce Blanche, Fromage, Jambon & Champignons',     14, 'images/products/crepe_salee.svg', $spiceOptions],
                    ['Mexicaine',      'Sauce Blanche, Sauce Piquante, Fromage & Poulet',  14, 'images/products/crepe_salee.svg', $spiceOptions],
                ],
            ],

            // ─── Paninis ──────────────────────────────────────────────────────
            [
                'name' => 'Paninis',
                'note' => null,
                'items' => [
                    ['Thon',  'Thon, Fromage, Mayonnaise & Harissa',                      10, 'images/products/panini.svg', $spiceOptions],
                    ['Jambon','Jambon, Fromage, Mayonnaise & Harissa',                     10, 'images/products/panini.svg', $spiceOptions],
                    ['Trio',  'Thon, Jambon, Œuf, Fromage, Mayonnaise & Harissa',         12, 'images/products/panini.svg', $spiceOptions],
                ],
            ],

            // ─── Omelettes ────────────────────────────────────────────────────
            [
                'name' => 'Omelettes',
                'note' => 'Servies avec salade verte.',
                'items' => [
                    ['Fromage',                   'Œuf, Fromage fondu',                   8,  'images/products/omelette.svg', $spiceOptions],
                    ['Thon & Fromage',            'Œuf, Thon & Fromage fondu',            9,  'images/products/omelette.svg', $spiceOptions],
                    ['Thon Champignon & Fromage', 'Œuf, Thon, Champignons & Fromage fondu', 11, 'images/products/omelette.svg', $spiceOptions],
                ],
            ],
        ];

        foreach ($menu as $categoryData) {
            $category = Category::updateOrCreate(
                ['name' => $categoryData['name']],
                [
                    'note'    => $categoryData['note'],
                    'visible' => $categoryData['visible'] ?? true,
                ]
            );

            foreach ($categoryData['items'] as [$name, $description, $price, $image, $optionsConfig]) {
                Product::updateOrCreate(
                    ['category_id' => $category->id, 'name' => $name],
                    [
                        'description'    => $description,
                        'price'          => $price,
                        'image'          => $image,
                        'available'      => true,
                        'options_config' => $optionsConfig,
                    ]
                );
            }
        }
    }
}
