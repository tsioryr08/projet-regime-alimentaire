<?php

namespace App\Controllers;

use App\Models\RegimeModel;
use App\Models\ActiviteModel;
use App\Models\ParametreModel;

class Regime extends BaseController
{
    private const SUGGESTION_VIEW = 'regime/suggestion';

    protected $regimeModel;
    protected $activiteModel;
    protected $parametreModel;

    public function __construct()
    {
        $this->regimeModel = new RegimeModel();
        $this->activiteModel = new ActiviteModel();
        $this->parametreModel = new ParametreModel();
    }

    //prepare les données de suggestion à partir de l imc, de l objectif et de la session
    protected function buildSuggestionData(float $imc, ?string $objectif = null, ?string $categorieSession = null): array
    {
        if ($categorieSession) {
            $categorie = $categorieSession;
        } else {
            if ($imc < 18.5) {
                $categorie = 'maigreur';
            } elseif ($imc < 25) {
                $categorie = 'normal';
            } elseif ($imc < 30) {
                $categorie = 'surpoids';
            } else {
                $categorie = 'obesite';
            }
        }

        if (empty($objectif)) {
            if ($categorie === 'maigreur') {
                $objectif = 'augmenter_poids';
            } elseif ($categorie === 'surpoids' || $categorie === 'obesite') {
                $objectif = 'reduire_poids';
            } else {
                $objectif = null;
            }
        }

        $regimes = [];
        $activites = [];

        if (!($categorie === 'normal' && $objectif === null)) {
            $regimes = $this->regimeModel->suggestRegimes($categorie, $objectif);
            $activites = $this->activiteModel->suggestActivites($categorie, $objectif);
        }

        return [
            'categorie' => $categorie,
            'objectif' => $objectif,
            'regimes' => $regimes,
            'activites' => $activites,
        ];
    }

    protected function getSuggestionDescription(string $categorie): string
    {
        $descriptions = [
            'maigreur' => 'Votre IMC indique une maigreur. Un accompagnement nutritionnel est recommandé.',
            'normal' => 'Votre IMC est dans la zone normale. Continuez à maintenir vos bonnes habitudes.',
            'surpoids' => 'Votre IMC indique un surpoids. Un régime adapté peut vous aider à retrouver l’équilibre.',
            'obesite' => 'Votre IMC indique une obésité. Un suivi progressif et personnalisé est conseillé.',
        ];

        return $descriptions[$categorie] ?? 'Résultat généré à partir de vos données.';
    }

    /**
     * Rend une vue de suggestion avec les données standardisées.
     */
    protected function renderSuggestionView(array $data)
    {
        return view(self::SUGGESTION_VIEW, $data);
    }

    //page suggestion:GET/POST 
    public function suggestion()
    {
        // Recuperer IMC depuis param ou session
        $imc = $this->request->getVar('imc');
        $objectif = $this->request->getVar('objectif');

        if ($imc === null || $imc === '') {
            $session = session();
            $imc = $session->get('imc');
            $categorieSession = $session->get('categorie_imc');
        } else {
            $categorieSession = null;
        }

        if ($imc === null || $imc === '') {
            $remiseGold = $this->parametreModel->getRemiseGold();
            return $this->renderSuggestionView([
                'error' => 'Valeur IMC manquante',
                'regimes' => [],
                'activites' => [],
                'imc' => null,
                'categorie' => null,
                'objectif' => null,
                'remiseGold' => $remiseGold,
            ]);
        }

        $imc = floatval($imc);

        $dataSuggestion = $this->buildSuggestionData($imc, $objectif, $categorieSession ?? null);
        $categorie = $dataSuggestion['categorie'];
        $objectif = $dataSuggestion['objectif'];

        // Si categorie normale et aucun objectif choisi, afficher choix a l'utilisateur
        if ($categorie === 'normal' && $objectif === null) {
            $remiseGold = $this->parametreModel->getRemiseGold();
            return $this->renderSuggestionView([
                'regimes' => [],
                'activites' => [],
                'imc' => $imc,
                'categorie' => $categorie,
                'objectif' => null,
                'remiseGold' => $remiseGold,
            ]);
        }

        $remiseGold = $this->parametreModel->getRemiseGold();
        return $this->renderSuggestionView([
            'regimes' => $dataSuggestion['regimes'],
            'activites' => $dataSuggestion['activites'],
            'imc' => $imc,
            'categorie' => $categorie,
            'objectif' => $objectif,
            'remiseGold' => $remiseGold,
        ]);
    }

    /**
     * Endpoint AJAX pour toggler l'option Gold et récupérer les infos de remise
     */
    public function toggleGold()
    {
        if (!$this->request->isAJAX() || !$this->request->is('POST')) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Bad request']);
        }

        $session = session();
        $isGold = $this->request->getJSON()->is_gold ?? false;

        // Stocker dans la session
        $session->set('is_gold', $isGold ? 1 : 0);

        // Recuperer la remise Gold depuis parametres (dynamique)
        $remiseGold = $this->parametreModel->getRemiseGold();

        return $this->response->setJSON([
            'success' => true,
            'is_gold' => $isGold,
            'remise_gold' => $remiseGold,
        ]);
    }

}
