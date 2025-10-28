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
            ]
        ];

        foreach ($plantsData as $plantData) {
            // Extraire les rubriques avant de créer la plante
            $rubrics = $plantData['rubrics'];
            unset($plantData['rubrics']);

            // Créer la plante
            $plant = Plant::create($plantData);

            // Créer les rubriques associées
            foreach ($rubrics as $rubricData) {
                // Extraire les infos avant de créer la rubrique
                $infos = $rubricData['infos'];
                unset($rubricData['infos']);

                // Créer la rubrique associée à la plante
                $rubric = $plant->rubrics()->create($rubricData);

                // Créer les infos associées à la rubrique
                foreach ($infos as $infoData) {
                    $rubric->infos()->create($infoData);
                }
            }
        }
    }
}
