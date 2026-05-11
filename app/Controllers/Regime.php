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

    protected function getObjectifDetailLabel(?string $objectif, ?float $imc = null): string
    {
        if ($objectif === 'imc_ideal' || $objectif === 'atteindre_imc_ideal') {
            if ($imc !== null) {
                if ($imc < 22) {
                    return 'imc_ideal (augmenter_poids)';
                }

                if ($imc > 22) {
                    return 'imc_ideal (reduire_poids)';
                }
            }

            return 'imc_ideal';
        }

        return $objectif ?? '-';
    }

    protected function normalizeTaille(?float $taille): ?float
    {
        if ($taille === null || $taille <= 0) {
            return null;
        }

        return $taille > 10 ? $taille / 100 : $taille;
    }

    protected function getCurrentUserSuggestionData(): array
    {
        $session = session();
        $poidsActuel = null;
        $taille = null;
        $utilisateurNom = $session->get('user_nom');
        $utilisateurEmail = $session->get('user_email');

        if ($session->get('isLoggedIn') && $session->get('user_id')) {
            $user = $this->utilisateurModel->find($session->get('user_id'));
            if ($user) {
                $poidsActuel = (float) ($user['poids'] ?? 0);
                $taille = (float) ($user['taille'] ?? 0);
                $utilisateurNom = $user['prenom'] && $user['nom'] ? trim($user['prenom'] . ' ' . $user['nom']) : ($user['nom'] ?? $utilisateurNom);
                $utilisateurEmail = $user['email'] ?? $utilisateurEmail;
            }
        }

        return [
            'poidsActuel' => $poidsActuel,
            'taille' => $taille,
            'utilisateurNom' => $utilisateurNom,
            'utilisateurEmail' => $utilisateurEmail,
        ];
    }

    protected function calculatePoidsCible(?float $taille): ?float
    {
        $tailleEnMetres = $this->normalizeTaille($taille);

        if ($tailleEnMetres === null) {
            return null;
        }

        return 22 * ($tailleEnMetres * $tailleEnMetres);
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
            $session = session();
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
            $imc = $session->get('imc');
            $categorieSession = $session->get('categorie_imc');
        } else {
            $categorieSession = null;
        }

        if ($imc === null || $imc === '') {
            $remiseGold = $this->parametreModel->getRemiseGold();
            $isGoldActive = (bool) $session->get('is_gold');
            $userSuggestionData = $this->getCurrentUserSuggestionData();
            $tailleMetres = $this->normalizeTaille($userSuggestionData['taille']);
            
            return $this->renderSuggestionView([
                'error' => 'Valeur IMC manquante',
                'regimes' => [],
                'activites' => [],
                'imc' => null,
                'categorie' => null,
                'objectif' => null,
                'remiseGold' => $remiseGold,
                'isGoldActive' => $isGoldActive,
                'poidsActuel' => $userSuggestionData['poidsActuel'],
                'taille' => $userSuggestionData['taille'],
                'tailleMetres' => $tailleMetres,
                'poidsCibleGlobal' => $tailleMetres ? 22 * ($tailleMetres * $tailleMetres) : null,
                'utilisateurNom' => $userSuggestionData['utilisateurNom'],
                'utilisateurEmail' => $userSuggestionData['utilisateurEmail'],
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
            $isGoldActive = (bool) $session->get('is_gold');
            $userSuggestionData = $this->getCurrentUserSuggestionData();
            $tailleMetres = $this->normalizeTaille($userSuggestionData['taille']);
            
            return $this->renderSuggestionView([
                'regimes' => [],
                'activites' => [],
                'imc' => $imc,
                'categorie' => $categorie,
                'objectif' => null,
                'remiseGold' => $remiseGold,
                'isGoldActive' => $isGoldActive,
                'poidsActuel' => $userSuggestionData['poidsActuel'],
                'taille' => $userSuggestionData['taille'],
                'tailleMetres' => $tailleMetres,
                'poidsCibleGlobal' => $tailleMetres ? 22 * ($tailleMetres * $tailleMetres) : null,
                'utilisateurNom' => $userSuggestionData['utilisateurNom'],
                'utilisateurEmail' => $userSuggestionData['utilisateurEmail'],
                'objectifAjuste' => false,
            ]);
        }

        $remiseGold = $this->parametreModel->getRemiseGold();
        $isGoldActive = (bool) $session->get('is_gold');
        $objectifAffiche = $this->getObjectifDetailLabel($objectif, $imc);
        $userSuggestionData = $this->getCurrentUserSuggestionData();
        $poidsActuel = $userSuggestionData['poidsActuel'];
        $taille = $userSuggestionData['taille'];
        $tailleEnMetres = $this->normalizeTaille($taille);
        $poidsCibleGlobal = $tailleEnMetres ? 22 * ($tailleEnMetres * $tailleEnMetres) : null;

        // Enrichir les régimes avec poids cible et variation par semaine
        $regimesEnrichis = [];
        foreach ($dataSuggestion['regimes'] as $regime) {
            $regime['poids_actuel'] = $poidsActuel;
            $regime['taille'] = $taille;
            
            if ($poidsActuel && $tailleEnMetres) {
                // IMC cible = 22, poids_cible = 22 * taille²
                $poidsCible = 22 * ($tailleEnMetres * $tailleEnMetres);
                $regime['poids_cible'] = $poidsCible;
                
                // Variation par semaine = variation_poids / (duree_jours / 7)
                $variationPoids = (float) ($regime['variation_poids'] ?? 0);
                $dureeSemaines = ((int) ($regime['duree_jours'] ?? 30)) / 7;
                $regime['variation_par_semaine'] = $dureeSemaines > 0 ? $variationPoids / $dureeSemaines : 0;
            }
            
            $regimesEnrichis[] = $regime;
        }

        return $this->renderSuggestionView([
            'regimes' => $regimesEnrichis,
            'activites' => $dataSuggestion['activites'],
            'imc' => $imc,
            'categorie' => $categorie,
            'objectif' => $objectif,
            'objectifAffiche' => $objectifAffiche,
            'remiseGold' => $remiseGold,
            'isGoldActive' => $isGoldActive,
            'poidsActuel' => $poidsActuel,
            'taille' => $taille,
            'tailleMetres' => $tailleEnMetres,
            'poidsCibleGlobal' => $poidsCibleGlobal,
            'utilisateurNom' => $userSuggestionData['utilisateurNom'],
            'utilisateurEmail' => $userSuggestionData['utilisateurEmail'],
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


    public function commander()
    {
        $session = session();

        $userId = $session->get('user_id');
        if (!$userId) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Veuillez vous connecter pour commander un régime.');
        }

        $regimeId = (int) ($this->request->getPost('regime_id') ?? 0);
        $activiteId = (int) ($this->request->getPost('activite_id') ?? 0);
        $imc = $this->request->getPost('imc');
        $objectif = $this->request->getPost('objectif');

        if ($regimeId <= 0) {
            return redirect()->back()->with('error', 'Régime invalide.');
        }

        if ($activiteId <= 0) {
            return redirect()->back()->with('error', 'Activité invalide.');
        }

        $utilisateurModel = new UtilisateurModel();
        $regimeModel = new RegimeModel();

        $user = $utilisateurModel->find($userId);
        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur introuvable.');
        }

        $regime = $regimeModel->find($regimeId);
        if (!$regime) {
            return redirect()->back()->with('error', 'Régime introuvable.');
        }

        // Empêche un double clic/une double commande sur le même régime pour le même utilisateur.
        $db = \Config\Database::connect();
        $alreadyOrdered = $db->table('suggestions')
            ->where('utilisateur_id', $userId)
            ->where('regime_id', $regimeId)
            ->countAllResults();

        if ($alreadyOrdered > 0) {
            $url = site_url('regime/suggestion') . '?imc=' . urlencode((string) $imc) . '&objectif=' . urlencode((string) $objectif);
            return redirect()->to($url)->with(
                'info',
                'Vous avez déjà commandé ce régime. Aucune nouvelle insertion et aucun débit n\'ont été effectués.'
            );
        }

        $solde = (float) ($user['solde_portefeuille'] ?? 0);
        $prixBase = (float) ($regime['prix_base'] ?? 0);

        if ($prixBase <= 0) {
            return redirect()->back()->with('error', 'Ce régime ne peut pas être commandé (prix invalide).');
        }

        $isGold = (bool) $session->get('is_gold');
        $remiseGold = $this->parametreModel->getRemiseGold();
        $prixFinal = $prixBase;

        if ($isGold) {
            $prixFinal = $prixBase * (1 - ($remiseGold / 100));
        }

        if ($solde < $prixFinal) {
            $manque = $prixFinal - $solde;

            $url = site_url('regime/suggestion') . '?imc=' . urlencode((string)$imc) . '&objectif=' . urlencode((string)$objectif);
            return redirect()->to($url)->with(
                'error',
                'Solde insuffisant. Il vous manque ' . number_format($manque, 2, ',', ' ') . ' Ar pour commander.'
            );
        }

        $nouveauSolde = $solde - $prixFinal;

        $imcForSuggestions = $imc;
        if ($imcForSuggestions === null || $imcForSuggestions === '') {
            $imcForSuggestions = $session->get('imc');
        }

        $objectifForSuggestions = $objectif;
        if (empty($objectifForSuggestions) && !empty($user['objectif'])) {
            $objectifForSuggestions = $user['objectif'];
        }

        $regimesAInserer = [$regime];
        $activitesAInserer = [];

        if ($imcForSuggestions !== null && $imcForSuggestions !== '') {
            $categorieSession = null;
            if (($imc === null || $imc === '') && $session->get('categorie_imc')) {
                $categorieSession = $session->get('categorie_imc');
            }

            $dataSuggestion = $this->buildSuggestionData((float) $imcForSuggestions, $objectifForSuggestions, $categorieSession);

            if (!empty($dataSuggestion['regimes'])) {
                $regimesAInserer = $dataSuggestion['regimes'];
            }

            if (!empty($dataSuggestion['activites'])) {
                $activitesAInserer = $dataSuggestion['activites'];
            }
        }

        // Fallback: si aucune activité n'est suggérée, utiliser l'activité envoyée par le formulaire.
        if (empty($activitesAInserer) && $activiteId > 0) {
            $activite = $this->activiteModel->find($activiteId);
            if (!empty($activite)) {
                $activitesAInserer = [$activite];
            }
        }

        if (empty($activitesAInserer)) {
            return redirect()->back()->with('error', 'Aucune activité suggérée à enregistrer.');
        }

        $suggestionsTable = $db->table('suggestions');
        $db->transStart();

        // Mettre à jour le solde utilisateur
        $utilisateurModel->update($userId, [
            'solde_portefeuille' => $nouveauSolde,
        ]);

        $insertCount = 0;
        foreach ($regimesAInserer as $regimeItem) {
            $regimeItemId = (int) ($regimeItem['id'] ?? 0);
            if ($regimeItemId <= 0) {
                continue;
            }

            $regimePrixBase = (float) ($regimeItem['prix_base'] ?? $prixBase);
            $regimePrixFinal = $isGold ? $regimePrixBase * (1 - ($remiseGold / 100)) : $regimePrixBase;

            foreach ($activitesAInserer as $activiteItem) {
                $activiteItemId = (int) ($activiteItem['id'] ?? 0);
                if ($activiteItemId <= 0) {
                    continue;
                }

                $suggestionsTable->insert([
                    'utilisateur_id' => $userId,
                    'regime_id' => $regimeItemId,
                    'activite_id' => $activiteItemId,
                    'prix_final' => $regimePrixFinal,
                    'remise_gold' => $isGold ? 1 : 0,
                    'date_suggestion' => date('Y-m-d H:i:s'),
                ]);
                $insertCount++;
            }
        }

        $db->transComplete();

        if (!$db->transStatus()) {
            return redirect()->back()->with('error', 'Erreur lors de l\'enregistrement des suggestions.');
        }

        $session->setFlashdata('success',
            'Commande effectuée : "' . ($regime['nom'] ?? 'Régime') . '" — payé '
            . number_format($prixFinal, 2, ',', ' ')
            . ' Ar. Nouveau solde: ' . number_format($nouveauSolde, 2, ',', ' ') . ' Ar. '
            . $insertCount . ' suggestion(s) enregistrée(s).'
        );

        $url = site_url('regime/suggestion') . '?imc=' . urlencode((string)$imc) . '&objectif=' . urlencode((string)$objectif);
        return redirect()->to($url);
    }
}


