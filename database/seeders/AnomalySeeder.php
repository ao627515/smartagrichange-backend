<?php

namespace Database\Seeders;

use App\Models\Anomaly;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnomalySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $anomaliesData = [
            [
                "name" => "Mildiou tardif",
                "description" => "Le mildiou tardif est une maladie fongique très destructrice causée par Phytophthora infestans. Elle touche principalement les pommes de terre et les tomates, et peut entraîner la perte totale des cultures si elle n'est pas maîtrisée.",
                "symptoms" => "Taches brun-gris sur les feuilles, souvent bordées de jaune\nFlétrissement rapide du feuillage\nLésions sombres sur les tiges\nPourriture brune sur les fruits ou les tubercules",
                "solutions" => "Rotation des cultures\nÉlimination des résidus végétaux\nUtilisation de variétés résistantes\nApplication de fongicides préventifs en période à risque",
                "preventions" => "Rotation des cultures\nÉlimination des résidus végétaux\nUtilisation de variétés résistantes\nApplication de fongicides préventifs en période à risque",
                "causes" => "Phytophthora infestans",
                "category" => "Maladie fongique",
                "plant_id" => 1
            ],
            [
                "name" => "Tache bactérienne",
                "description" => "La tache bactérienne, aussi appelée gale bactérienne, est une maladie causée par des bactéries du genre Xanthomonas. Elle affecte de nombreuses cultures comme les tomates, les poivrons et les pêches, provoquant des lésions caractéristiques sur les feuilles, les fruits et les tiges.",
                "symptoms" => "Petites taches sombres sur les feuilles ou les fruits\nLésions en creux ou perforées\nDécoloration des tissus\nChute prématurée des feuilles",
                "solutions" => "Élimination des plants infectés\nTraitement avec des produits à base de cuivre\nUtilisation de variétés résistantes\nDésinfection des outils de taille",
                "preventions" => "Éviter l'arrosage par aspersion\nAssurer une bonne circulation de l'air\nUtiliser des semences certifiées saines\nRotation des cultures",
                "causes" => "Xanthomonas spp.",
                "category" => "Maladie bactérienne",
                "plant_id" => 1
            ],
            [
                "name" => "Brûlure alternarienne précoce",
                "description" => "La brûlure précoce est une maladie fongique causée principalement par le champignon Alternaria solani. Elle affecte surtout les tomates et les pommes de terre, mais peut aussi toucher d'autres plantes de la famille des solanacées.",
                "symptoms" => "Taches brunes concentriques sur les feuilles, souvent en forme de cible\nJaunissement et chute des feuilles inférieures\nLésions sombres sur les tiges et les fruits\nRéduction du rendement si l'infection est sévère",
                "solutions" => "Application de fongicides spécifiques\nÉlimination des feuilles infectées\nUtilisation de variétés résistantes\nAmélioration de la circulation de l'air",
                "preventions" => "Rotation des cultures pour éviter l'accumulation du pathogène\nÉlimination des résidus végétaux infectés dans le sol\nEspacement adéquat des plants\nArrosage à la base pour éviter de mouiller le feuillage",
                "causes" => "Alternaria solani",
                "category" => "Maladie fongique",
                "plant_id" => 1
            ],
            [
                "name" => "Tétranyque à deux points",
                "description" => "Le tétranyque à deux points (Tetranychus urticae), aussi appelé araignée rouge, est un minuscule acarien nuisible très courant en agriculture. Il peut être jaune, vert ou brun avec deux taches sombres sur le dos et attaque une grande variété de plantes.",
                "symptoms" => "Petites taches jaunes sur les feuilles (aspect moucheté)\nToiles fines visibles sous les feuilles\nFeuilles qui jaunissent, se dessèchent et tombent\nCroissance ralentie de la plante",
                "solutions" => "Pulvérisation d'eau sur le feuillage pour augmenter l'humidité\nIntroduction de prédateurs naturels comme Phytoseiulus persimilis\nInsecticides biologiques : savon insecticide, huile de neem\nAcaricides en cas d'infestation sévère",
                "preventions" => "Maintenir une humidité ambiante suffisante\nSurveiller régulièrement les plantes\nÉviter la surpopulation de plantes\nAlterner les méthodes de lutte pour éviter la résistance",
                "causes" => "Tetranychus urticae",
                "category" => "Ravageur (Acarien)",
                "plant_id" => 1
            ],
            [
                "name" => "Virus des feuilles jaunes en cuillère",
                "description" => "Le virus des feuilles jaunes en cuillère de la tomate (TYLCV - Tomato Yellow Leaf Curl Virus) est une maladie virale grave qui affecte principalement les plants de tomates, mais aussi d'autres solanacées. Il est transmis par la mouche blanche (Bemisia tabaci).",
                "symptoms" => "Feuilles jaunes avec un aspect enroulé vers le haut (en cuillère)\nRalentissement de la croissance des plants\nRéduction de la floraison et de la fructification\nPlantes rabougries et déformées",
                "solutions" => "Arracher et détruire les plants malades\nÉliminer les mouches blanches avec des insecticides biologiques\nInstaller des pièges collants jaunes\nIntroduire des prédateurs naturaux comme Encarsia formosa",
                "preventions" => "Utiliser des variétés résistantes au TYLCV\nInstaller des filets anti-insectes\nÉviter de planter à proximité de cultures infectées\nAssurer une bonne ventilation en serre",
                "causes" => "TYLCV (Tomato Yellow Leaf Curl Virus) transmis par Bemisia tabaci",
                "category" => "Maladie virale",
                "plant_id" => 1
            ],
            [
                "name" => "Moisissure des feuilles",
                "description" => "La moisissure des feuilles est une maladie fongique causée par Passalora fulva (anciennement Cladosporium fulvum). Elle affecte principalement les tomates cultivées en serre ou dans des environnements humides et mal ventilés.",
                "symptoms" => "Taches jaunes pâles sur la face supérieure des feuilles\nDuvet velouté olive à brun sur la face inférieure des feuilles\nJaunissement progressif et dessèchement des feuilles\nChute prématurée du feuillage en cas d'infection sévère",
                "solutions" => "Améliorer la ventilation et réduire l'humidité\nÉliminer les feuilles infectées\nApplication de fongicides appropriés\nUtilisation de variétés résistantes",
                "preventions" => "Maintenir une bonne circulation de l'air\nÉviter l'arrosage par aspersion\nContrôler l'humidité relative en serre (maintenir sous 85%)\nEspacement adéquat des plants",
                "causes" => "Passalora fulva (Cladosporium fulvum)",
                "category" => "Maladie fongique",
                "plant_id" => 1
            ],
            [
                "name" => "Virus de la mosaïque de la tomate",
                "description" => "Le virus de la mosaïque de la tomate (ToMV - Tomato Mosaic Virus) est une maladie virale très contagieuse qui affecte les plants de tomates et autres solanacées. Il se transmet facilement par contact et peut persister sur les outils, les vêtements et les mains.",
                "symptoms" => "Motifs de mosaïque vert clair et vert foncé sur les feuilles\nDéformation et enroulement des feuilles\nNanisme et croissance ralentie des plants\nFruits déformés avec taches jaunes ou brunes\nRéduction significative du rendement",
                "solutions" => "Arracher et détruire immédiatement les plants infectés\nDésinfecter tous les outils avec une solution d'eau de javel à 10%\nLaver les mains fréquemment pendant la manipulation\nÉviter de fumer près des plants (le tabac peut transmettre le virus)",
                "preventions" => "Utiliser des variétés résistantes au ToMV\nDésinfecter les outils régulièrement\nÉviter de toucher les plants sains après avoir touché des plants malades\nUtiliser des semences certifiées exemptes de virus",
                "causes" => "ToMV (Tomato Mosaic Virus)",
                "category" => "Maladie virale",
                "plant_id" => 1
            ],
            [
                "name" => "Tache cible",
                "description" => "La tache cible est une maladie fongique causée par Corynespora cassiicola. Elle affecte les tomates et d'autres cultures, provoquant des lésions caractéristiques en forme de cible sur les feuilles, les tiges et les fruits.",
                "symptoms" => "Taches brunes circulaires avec anneaux concentriques (aspect de cible)\nLésions pouvant atteindre 1 à 2 cm de diamètre\nCentre des taches souvent gris ou brun clair\nDéfoliation en cas d'infection sévère\nTaches sur les fruits rendant la récolte non commercialisable",
                "solutions" => "Application de fongicides appropriés\nÉlimination des feuilles et fruits infectés\nAmélioration de la circulation de l'air\nUtilisation de variétés moins sensibles",
                "preventions" => "Rotation des cultures avec des plantes non-hôtes\nÉviter l'arrosage par aspersion\nÉlimination des débris végétaux après récolte\nEspacement adéquat entre les plants pour favoriser l'aération",
                "causes" => "Corynespora cassiicola",
                "category" => "Maladie fongique",
                "plant_id" => 1
            ],
            [
                "name" => "Tache septorienne",
                "description" => "La tache septorienne, aussi appelée septoriose, est une maladie fongique causée par Septoria lycopersici. C'est l'une des maladies foliaires les plus communes des tomates, particulièrement dans les régions chaudes et humides.",
                "symptoms" => "Petites taches circulaires grisâtres avec bordure sombre sur les feuilles\nPoints noirs (pycnides) visibles au centre des taches\nJaunissement et brunissement des feuilles inférieures en premier\nDéfoliation progressive de la base vers le sommet\nRéduction de la photosynthèse et du rendement",
                "solutions" => "Application de fongicides à base de cuivre ou de chlorothalonil\nÉlimination des feuilles infectées\nTaille des feuilles basses pour améliorer la circulation de l'air\nPaillage pour éviter les éclaboussures d'eau du sol",
                "preventions" => "Rotation des cultures sur 2 à 3 ans\nArrosage à la base des plants (éviter de mouiller le feuillage)\nEspacement adéquat des plants\nÉlimination complète des résidus de culture\nUtilisation de tuteurs pour éloigner les feuilles du sol",
                "causes" => "Septoria lycopersici",
                "category" => "Maladie fongique",
                "plant_id" => 1
            ]
        ];

        foreach ($anomaliesData as $anomalyData) {
            Anomaly::create($anomalyData);
        }
    }
}
