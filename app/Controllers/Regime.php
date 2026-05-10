<?php

namespace App\Controllers;

use App\Models\RegimeModel;
use App\Models\ActiviteModel;
use App\Models\ParametreModel;
use App\Models\UtilisateurModel;

class Regime extends BaseController
{
    private const SUGGESTION_VIEW = 'regime/suggestion';

    protected $regimeModel;
    protected $activiteModel;
    protected $parametreModel;
    protected $utilisateurModel;

    public function __construct()
    {
        $this->regimeModel = new RegimeModel();
        $this->activiteModel = new ActiviteModel();
        $this->parametreModel = new ParametreModel();
        $this->utilisateurModel = new UtilisateurModel();
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

        if ($categorie === 'maigreur') {
            $objectif = 'augmenter_poids';
        } elseif ($categorie === 'surpoids' || $categorie === 'obesite') {
            $objectif = 'reduire_poids';
        } elseif ($categorie === 'normal' && empty($objectif)) {
            $objectif = null;
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

    protected function getCategorieLabel(string $categorie): string
    {
        $labels = [
            'maigreur' => 'Maigreur',
            'normal' => 'Normal',
            'surpoids' => 'Surpoids',
            'obesite' => 'Obésité',
        ];

        return $labels[$categorie] ?? ucfirst($categorie);
    }

    protected function getObjectifLabel(?string $objectif): string
    {
        $labels = [
            'augmenter_poids' => 'Augmenter mon poids',
            'reduire_poids' => 'Réduire mon poids',
            'atteindre_imc_ideal' => 'Atteindre mon IMC idéal',
        ];

        return $labels[$objectif] ?? 'Non défini';
    }

    protected function getAjustementMessage(string $categorie, string $objectifSuggere): string
    {
        if ($categorie === 'maigreur') {
            return 'Nous vous recommandons de d’abord augmenter votre poids pour votre santé.';
        }

        if ($categorie === 'surpoids' || $categorie === 'obesite') {
            return 'Nous vous recommandons de d’abord réduire votre poids pour votre santé.';
        }

        return 'Votre objectif a été adapté en fonction de votre IMC actuel.';
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

        if (empty($objectif) && session()->get('isLoggedIn') && session()->get('user_id')) {
            $user = $this->utilisateurModel->find(session()->get('user_id'));
            if ($user && !empty($user['objectif'])) {
                $objectif = $user['objectif'];
            }
        }

        $objectifInitial = $objectif;

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
        $objectifAjuste = !empty($objectifInitial) && $objectifInitial !== $objectif;

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
                'objectifAjuste' => false,
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
            'objectifAjuste' => $objectifAjuste,
            'objectifInitialLabel' => $this->getObjectifLabel($objectifInitial ?: null),
            'objectifFinalLabel' => $this->getObjectifLabel($objectif),
            'categorieLabel' => $this->getCategorieLabel($categorie),
            'ajustementMessage' => $objectifAjuste ? $this->getAjustementMessage($categorie, $objectif) : null,
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
