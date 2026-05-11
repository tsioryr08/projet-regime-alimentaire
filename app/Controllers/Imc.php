<?php

namespace App\Controllers;

use App\Models\ImcModel;
use App\Models\UtilisateurModel;

class Imc extends BaseController
{
    protected $imcModel;

    public function __construct()
    {
        $this->imcModel = new ImcModel();
    }

   //convertit le texte pour etre compatible avec fpdf 
    protected function pdfText(string $text): string
    {
        $encoded = @iconv('UTF-8', 'windows-1252//TRANSLIT', $text);

        if ($encoded === false) {
            return utf8_decode($text);
        }

        return $encoded;
    }

//affichage du formulaire de calcul IMC
    public function index()
    {
        $data = [
            'poids_prefill' => '',
            'taille_prefill' => '',
        ];

        if (session()->get('isLoggedIn') && session()->get('user_id')) {
            $utilisateurModel = new UtilisateurModel();
            $user = $utilisateurModel->find(session()->get('user_id'));

            if ($user) {
                $data['poids_prefill'] = isset($user['poids']) ? number_format((float) $user['poids'], 2, '.', '') : '';
                $data['taille_prefill'] = isset($user['taille']) ? number_format((float) $user['taille'], 2, '.', '') : '';
            }
        }

        return view('imc/calcul', $data);
    }

 //calcul imc via ajax
    public function calculer()
    {

        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Requête invalide']);
        }

        //recup des donnees
        $poids = floatval($this->request->getPost('poids'));
        $taille = floatval($this->request->getPost('taille'));

        // Validation
        if ($poids <= 0 || $taille <= 0) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Veuillez entrer des valeurs valides'
            ]);
        }

        // Analyser l'IMC
        $resultat = $this->imcModel->analyserImc($poids, $taille);

        // Stocker dans la session pour réutilisation par la page de suggestions
        $session = session();
        $session->set('imc', $resultat['imc']);
        $session->set('categorie_imc', $resultat['code_categorie']);

        return $this->response->setJSON([
            'success' => true,
            'data' => $resultat
        ]);
    }

   //affiche resultat du calcul imc
    public function resultat()
    {
        $data = [];
        
        if ($poids = $this->request->getPost('poids')) {
            $taille = $this->request->getPost('taille');
            $data['resultat'] = $this->imcModel->analyserImc(floatval($poids), floatval($taille));

            // Stocker dans la  toutes les infos pour pouvoir les utiliser
            $session = session();
            $session->set('imc', $data['resultat']['imc']);
            $session->set('categorie_imc', $data['resultat']['code_categorie']);
        }

        return view('imc/resultat', $data);
    }

    //export pdf via fpdf
    public function exportPdf()
    {
        require_once APPPATH . 'ThirdParty/fpdf.php';

        $session = session();

        $imc = $this->request->getGet('imc') ?? $session->get('imc');
        $poids = $this->request->getGet('poids');
        $taille = $this->request->getGet('taille');
        $categorie = $this->request->getGet('categorie') ?? $session->get('categorie_imc');

        if ($imc === null || $categorie === null) {
            return redirect()->to('/imc')->with('error', "Aucune donnée IMC disponible pour l'export PDF.");
        }

        $imc = number_format((float) $imc, 2, ',', ' ');
        $poids = $poids !== null && $poids !== '' ? number_format((float) $poids, 2, ',', ' ') . ' kg' : 'Non renseigné';
        $taille = $taille !== null && $taille !== '' ? number_format((float) $taille, 2, ',', ' ') . ' cm' : 'Non renseignée';

        $descriptions = [
            'maigreur' => 'Votre IMC indique une maigreur. Un accompagnement nutritionnel est recommandé.',
            'normal' => 'Votre IMC est dans la zone normale. Continuez à maintenir vos bonnes habitudes.',
            'surpoids' => 'Votre IMC indique un surpoids. Un régime adapté peut vous aider à retrouver l’équilibre.',
            'obesite' => 'Votre IMC indique une obésité. Un suivi progressif et personnalisé est conseillé.',
        ];

        $categorieLibelle = ucfirst($categorie);
        $description = $descriptions[$categorie] ?? 'Résultat IMC généré à partir de vos données.';

        $pdf = new \FPDF('P', 'mm', 'A4');
        $pdf->SetAutoPageBreak(true, 15);
        $pdf->AddPage();
        $pdf->SetMargins(15, 15, 15);

        $pdf->SetFillColor(79, 70, 229);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 18);
        $pdf->Cell(0, 14, $this->pdfText('Résultat IMC - Régime Alimentaire'), 0, 1, 'C', true);

        $pdf->Ln(8);
        $pdf->SetTextColor(15, 23, 42);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, $this->pdfText('Categorie : ' . $categorieLibelle), 0, 1);

        $pdf->SetFont('Arial', 'B', 24);
        $pdf->SetTextColor(212, 175, 55);
        $pdf->Cell(0, 16, $this->pdfText('IMC : ' . $imc), 0, 1, 'C');

        $pdf->Ln(4);
        $pdf->SetTextColor(15, 23, 42);
        $pdf->SetFont('Arial', '', 12);

        $pdf->Cell(35, 10, $this->pdfText('Poids'), 1, 0, 'L', false);
        $pdf->Cell(0, 10, $this->pdfText($poids), 1, 1, 'L', false);
        $pdf->Cell(35, 10, $this->pdfText('Taille'), 1, 0, 'L', false);
        $pdf->Cell(0, 10, $this->pdfText($taille), 1, 1, 'L', false);
        $pdf->Cell(35, 10, $this->pdfText('Categorie'), 1, 0, 'L', false);
        $pdf->Cell(0, 10, $this->pdfText($categorieLibelle), 1, 1, 'L', false);

        $pdf->Ln(6);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->Cell(0, 10, $this->pdfText('Analyse'), 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(0, 8, $this->pdfText($description));

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->Cell(0, 10, $this->pdfText('Rappel IMC'), 0, 1);
        $pdf->SetFont('Arial', '', 11);
        $pdf->MultiCell(0, 7, $this->pdfText('IMC = poids (kg) / (taille (m) x taille (m)).'));

        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->SetTextColor(100, 116, 139);
        $pdf->MultiCell(0, 6, $this->pdfText("Document genere automatiquement depuis l'application Regime Alimentaire."));

        $pdfContent = $pdf->Output('S', 'resultat_imc.pdf');

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="resultat_imc.pdf"')
            ->setBody($pdfContent);
    }
}
