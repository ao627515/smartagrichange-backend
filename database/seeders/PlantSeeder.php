<?php

namespace Database\Seeders;

use App\Models\Plant;
use App\Models\Rubric;
use App\Models\Info;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plantsData = [
            [
                "common_name" => "Tomate",
                "scientific_name" => "Solanum lycopersicum",
                "family" => "Solanaceae",
                "type" => "Plante herbacée",
                "life_cycle" => "Annuelle",
                "geographical_zone" => "Zone tropicale et tempérée",
                "rubrics" => [
                    [
                        "name" => "Conditions idéales",
                        "description" => "Conditions optimales de croissance pour la tomate",
                        "infos" => [
                            ["key" => "pH", "value" => "6.0 - 6.8"],
                            ["key" => "Température", "value" => "20 - 30 °C"],
                            ["key" => "Humidité du sol", "value" => "Modérée, bien drainée"],
                            ["key" => "N", "value" => "4 - 6 mg/kg"],
                            ["key" => "P", "value" => "3 - 5 mg/kg"],
                            ["key" => "K", "value" => "8 - 10 mg/kg"]
                        ]
                    ],
                    [
                        "name" => "Soins",
                        "description" => "Pratiques recommandées pour entretenir la plante",
                        "infos" => [
                            ["key" => "Arrosage", "value" => "Régulier, sans excès d'eau"],
                            ["key" => "Exposition", "value" => "Plein soleil (6-8h/jour)"],
                            ["key" => "Taille", "value" => "Éliminer les gourmands pour favoriser la fructification"],
                            ["key" => "Fertilisation", "value" => "Apport d'engrais riche en potassium pendant la floraison"],
                            ["key" => "Protection", "value" => "Surveiller le mildiou et les pucerons"]
                        ]
                    ],
                    [
                        "name" => "Morphologie",
                        "description" => "Caractéristiques physiques de la plante",
                        "infos" => [
                            ["key" => "Tige", "value" => "Herbacée, poilue, ramifiée"],
                            ["key" => "Feuille", "value" => "Verte, alternée, découpée en folioles"],
                            ["key" => "Fleur", "value" => "Jaune, à 5 pétales"],
                            ["key" => "Fruit", "value" => "Baie charnue rouge, contenant des graines"],
                            ["key" => "Racine", "value" => "Pivotante, bien développée"]
                        ]
                    ],
                    [
                        "name" => "Informations générales",
                        "description" => "Détails supplémentaires sur la culture et l'usage",
                        "infos" => [
                            ["key" => "Origine", "value" => "Amérique du Sud"],
                            ["key" => "Utilisation", "value" => "Alimentaire (crue, cuite, jus, sauce)"],
                            ["key" => "Cycle de culture", "value" => "3 à 4 mois du semis à la récolte"],
                            ["key" => "Hauteur moyenne", "value" => "0,5 à 2 mètres selon la variété"]
                        ]
                    ]
                ]
            ],
            [
                "common_name" => "Poivron",
                "scientific_name" => "Capsicum annuum",
                "family" => "Solanaceae",
                "type" => "Plante herbacée",
                "life_cycle" => "Annuelle",
                "geographical_zone" => "Zone tropicale et subtropicale",
                "rubrics" => [
                    [
                        "name" => "Conditions idéales",
                        "description" => "Conditions optimales de croissance pour le poivron au Burkina Faso",
                        "infos" => [
                            ["key" => "pH", "value" => "6.0 - 7.0"],
                            ["key" => "Température", "value" => "25 - 30 °C"],
                            ["key" => "Humidité du sol", "value" => "Modérée à élevée, bien drainée"],
                            ["key" => "N", "value" => "5 - 7 mg/kg"],
                            ["key" => "P", "value" => "4 - 6 mg/kg"],
                            ["key" => "K", "value" => "8 - 12 mg/kg"]
                        ]
                    ],
                    [
                        "name" => "Soins",
                        "description" => "Pratiques recommandées pour entretenir la plante",
                        "infos" => [
                            ["key" => "Arrosage", "value" => "Régulier et abondant, surtout en saison sèche"],
                            ["key" => "Exposition", "value" => "Plein soleil avec ombrage léger en période chaude"],
                            ["key" => "Taille", "value" => "Pincer l'apex pour favoriser la ramification"],
                            ["key" => "Fertilisation", "value" => "Compost organique et engrais NPK pendant la croissance"],
                            ["key" => "Protection", "value" => "Surveiller les pucerons, acariens et anthracnose"]
                        ]
                    ],
                    [
                        "name" => "Morphologie",
                        "description" => "Caractéristiques physiques de la plante",
                        "infos" => [
                            ["key" => "Tige", "value" => "Herbacée, dressée, ramifiée"],
                            ["key" => "Feuille", "value" => "Verte, ovale, alternée, simple"],
                            ["key" => "Fleur", "value" => "Blanche, petite, à 5-7 pétales"],
                            ["key" => "Fruit", "value" => "Baie creuse, charnue, verte à rouge à maturité"],
                            ["key" => "Racine", "value" => "Pivotante avec système racinaire peu profond"]
                        ]
                    ],
                    [
                        "name" => "Informations générales",
                        "description" => "Détails supplémentaires sur la culture et l'usage",
                        "infos" => [
                            ["key" => "Origine", "value" => "Amérique centrale et du Sud"],
                            ["key" => "Utilisation", "value" => "Alimentaire (cru, cuit, farci, sauce)"],
                            ["key" => "Cycle de culture", "value" => "3 à 5 mois du semis à la récolte"],
                            ["key" => "Hauteur moyenne", "value" => "0,5 à 1 mètre"],
                            ["key" => "Saison de culture BF", "value" => "Saison des pluies (juin-octobre) et culture irriguée en saison sèche"]
                        ]
                    ]
                ]
            ],
            [
                "common_name" => "Pomme de terre",
                "scientific_name" => "Solanum tuberosum",
                "family" => "Solanaceae",
                "type" => "Plante herbacée",
                "life_cycle" => "Annuelle",
                "geographical_zone" => "Zone tempérée et altitude tropicale",
                "rubrics" => [
                    [
                        "name" => "Conditions idéales",
                        "description" => "Conditions optimales de croissance pour la pomme de terre au Burkina Faso",
                        "infos" => [
                            ["key" => "pH", "value" => "5.5 - 6.5"],
                            ["key" => "Température", "value" => "15 - 20 °C (zones d'altitude)"],
                            ["key" => "Humidité du sol", "value" => "Modérée, sol meuble et bien drainé"],
                            ["key" => "N", "value" => "6 - 8 mg/kg"],
                            ["key" => "P", "value" => "5 - 7 mg/kg"],
                            ["key" => "K", "value" => "10 - 14 mg/kg"]
                        ]
                    ],
                    [
                        "name" => "Soins",
                        "description" => "Pratiques recommandées pour entretenir la plante",
                        "infos" => [
                            ["key" => "Arrosage", "value" => "Régulier, éviter l'excès d'eau"],
                            ["key" => "Exposition", "value" => "Plein soleil à mi-ombre"],
                            ["key" => "Buttage", "value" => "Butter les plants pour protéger les tubercules"],
                            ["key" => "Fertilisation", "value" => "Apport de matière organique et engrais NPK au semis"],
                            ["key" => "Protection", "value" => "Surveiller le mildiou, les doryphores et les nématodes"]
                        ]
                    ],
                    [
                        "name" => "Morphologie",
                        "description" => "Caractéristiques physiques de la plante",
                        "infos" => [
                            ["key" => "Tige", "value" => "Herbacée, dressée, anguleuse"],
                            ["key" => "Feuille", "value" => "Composée, vert foncé, alternée"],
                            ["key" => "Fleur", "value" => "Blanche à violette, en grappe"],
                            ["key" => "Tubercule", "value" => "Organe de réserve souterrain, chair blanche ou jaune"],
                            ["key" => "Racine", "value" => "Superficielle, stolons produisant les tubercules"]
                        ]
                    ],
                    [
                        "name" => "Informations générales",
                        "description" => "Détails supplémentaires sur la culture et l'usage",
                        "infos" => [
                            ["key" => "Origine", "value" => "Amérique du Sud (Andes)"],
                            ["key" => "Utilisation", "value" => "Alimentaire (bouillie, frite, purée, chips)"],
                            ["key" => "Cycle de culture", "value" => "3 à 4 mois du semis à la récolte"],
                            ["key" => "Hauteur moyenne", "value" => "0,5 à 1 mètre"],
                            ["key" => "Culture BF", "value" => "Principalement en saison fraîche (novembre-février) dans les zones d'altitude"]
                        ]
                    ]
                ]
            ]
        ];

        foreach ($plantsData as $plantData) {
            // Extraire les rubriques avant de créer/mettre à jour la plante
            $rubrics = $plantData['rubrics'];
            unset($plantData['rubrics']);

            // Créer ou mettre à jour la plante en utilisant common_name et scientific_name
            $plant = Plant::updateOrCreate(
                [
                    'common_name' => $plantData['common_name'],
                    'scientific_name' => $plantData['scientific_name']
                ],
                $plantData
            );

            // Traiter les rubriques
            foreach ($rubrics as $rubricData) {
                // Extraire les infos avant de créer/mettre à jour la rubrique
                $infos = $rubricData['infos'];
                unset($rubricData['infos']);

                // Créer ou mettre à jour la rubrique associée à la plante
                $rubric = $plant->rubrics()->updateOrCreate(
                    [
                        'name' => $rubricData['name']
                    ],
                    $rubricData
                );

                // Traiter les infos
                foreach ($infos as $infoData) {
                    $rubric->infos()->updateOrCreate(
                        [
                            'key' => $infoData['key']
                        ],
                        $infoData
                    );
                }
            }
        }
    }
}
