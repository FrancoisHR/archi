<?php

namespace ChatCreeSoftware\BordereauxBundle\Pdf;

class BordereauPdf extends BasePdf {

public function Header() {
        if ($this->headerFooter) {
            // Logo
            switch ($this->pageType) {
                case "GARDE":
                    $this->Image($this->logo, 10, 10, 0, 20);
                    $this->setXY(150, 27);
                    $this->SetFont('HelveticaNeue', '', 10);
                    $this->Cell(50, 5, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Tél : +352 27.76.75.01"), 0, 2, "R");
                    $this->Cell(50, 5, "Fax : +352 24.61.11.57", 0, 2, "R");
                    $this->Cell(50, 5, "info@rl-architecture.lu", 0, 2, "R");

                    $this->setXY(10, 32);
                    $this->SetFont('HelveticaNeue', '', 10);
                    $this->Cell(50, 5, "52, rue de Koerich L-8437 Steinfort", 0, 2, "L");
                    $this->Cell(50, 5, "www.rlambay.lu", 0, 2, "L");

                    $this->Line(10, 45, 200, 43);

                    $this->SetFont('HelveticaNeue', '', 10);
                    $this->setXY(150, 45);
                    $this->Cell(0, 4, "Projet : " . $this->projet, 0, 2, 'R');
                    $this->Cell(0, 4, "Lot : " . $this->lot, 0, 2, 'R');

                    $this->SetFont('HelveticaNeueBd', '', 18);
                    $this->setXY(15, 100);
                    $this->Cell(0, 10, "BORDEREAU DE SOUMISSION", 0, 2, 'L');
                    $this->SetFontSize(16);
                    $this->Cell(0, 8, $this->description, 0, 2, 'L');

                    $this->setXY(15, 180);
                    $this->SetFontSize(14);
                    $this->Cell(80, 8, "Adresse du chantier", "B", 2, 'L');
                    $this->SetFontSize(10);
                    if( $this->adresseChantier ) {
                        $this->adresse($this->adresseChantier);
                    }

                    $this->setXY(105, 180);
                    $this->SetFontSize(14);
                    $this->Cell(80, 8, "Adresse du client", "B", 2, 'L');
                    $this->SetFontSize(10);
                    if( $this->adresseClient ) {
                        $this->adresse($this->adresseClient);
                    }
                    break;

                case "RESUME":
                    $this->Image($this->logo, 10, 10, 0, 20);

                    $this->setFontSize(9);
                    $this->setXY(-70, 10);
                    $this->Cell(60, 4, "BORDEREAU DE SOUMISSION", 0, 2, 'R');
                    $this->SetFont('HelveticaNeue', '', 9);
                    $this->Cell(60, 4, $this->description, 0, 2, 'R');
                    $this->Cell(60, 4, $this->projet, 0, 2, 'R');
                    $this->Cell(60, 4, $this->lot, 0, 2, 'R');

                    $this->setXY(10, 35);
                    $this->SetFont('HelveticaNeueBd', '', 18);
                    $this->Cell(0, 10, $this->titre, 'B', 0, 'C');

                    $this->setFontSize(9);
                    $this->setXY(10, 50);
                    $this->SetTextColor(255);
                    $this->SetFillColor(77);
                    $this->Row($this->headings[$this->pageType], true);
                    $this->SetTextColor(77);
                    $this->SetFillColor(255);
                    break;

                case "NORMAL":
                    $this->Image($this->logo, 10, 10, 0, 20);
                    $this->setFontSize(9);
                    $this->setXY(-70, 10);
                    $this->Cell(60, 4, "BORDEREAU DE SOUMISSION", 0, 2, 'R');
                    $this->SetFont('HelveticaNeue', '', 9);
                    $this->Cell(60, 4, $this->description, 0, 2, 'R');
                    $this->Cell(60, 4, $this->projet, 0, 2, 'R');
                    $this->Cell(60, 4, $this->lot, 0, 2, 'R');

                    $this->setXY(10, 35);
                    $this->SetFont('HelveticaNeueBd', '', 18);
                    $this->Cell(0, 10, $this->titre, 'B', 0, 'C');

                    $this->setFontSize(9);
                    $this->setXY(10, 50);
                    $this->SetTextColor(255);
                    $this->SetFillColor(77);
                    $this->Row($this->headings[$this->pageType], true);
                    $this->SetTextColor(77);
                    $this->SetFillColor(255);
            }
        }
    }

    public function Footer() {
        if ($this->headerFooter) {
            switch ($this->pageType) {
                case "GARDE":
                    break;

                case "RESUME":
                case "NORMAL":
                    $this->SetY(-15);
                    $this->SetFontSize(8);

                    $this->Cell(30, 10, $this->date, 'T', 0, 'C');
                    $this->Cell(130, 5, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "52, rue de Koerich L-8437 Steinfort - Tél : +352 27.76.75.01 - Fax : +352 24.61.11.57"), 'T', 2, 'C');
                    $this->Cell(130, 5, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "info@rl-architecture.lu - www.rlambay.lu"), 0, 0, 'C');
                    $this->SetXY(170, -15);
                    $this->Cell(30, 10, 'Page ' . $this->PageNo() . '/{nb}', 'T', 0, 'C');
            }
        }
    }    
    
    public function printLigne( $bordereau, $ligne) {
        $position = $ligne->getPosition();
        if ($ligne->getPrestation()) {
            $titre = $ligne->getPrestation()->getTitre();
            $description = str_replace("<br>", "", $ligne->getPrestation()->getDescription());

            $description = str_replace("<ul bullet=\"-\">", "", $description);
            $description = str_replace("<li>", "- ", $description);
            $description = str_replace("</li>", "", $description);
            $description = str_replace("</ul>", "", $description);


            $unite = $ligne->getPrestation()->getUnite();

            if ($ligne->getParametres()) {
                $description .= "\n";
            }
            foreach ($ligne->getParametres() as $parametre) {
                $description .= $parametre->getTitre() . "\n";
            }
            if( $ligne->getPrestation()->getQuestions() ){
                $description .= "\n";
            }
            foreach ($ligne->getPrestation()->getQuestions() as $question ) {
                $description .= $question->getQuestion() . " ……………………………………………………………………………………\n";
            }
        } else {
            $titre = $ligne->getTitre();
            $description = $ligne->getDescription();
            $unite = $ligne->getUnite();
        }
        $quantite = $ligne->getQuantite();
        if ($quantite == 0) {
            $quantite = "";
        }
        if (strpos($position, ".") === false) {
            $this->SetFont('HelveticaNeueBd', '', 10);
            if ($this->GetPageHeight() - ($this->getY() + 10) < 50) {
                $this->AddPage($this->CurOrientation);
            }
        }
        $type = "";
        if ($ligne->getType()) {
            $type = "** " . strtoupper($ligne->getType()) . " ** ";
        }
        switch ($this->pageType) {
            case "NORMAL":
                if($ligne->getPhoto()){
                    $filepath = $bordereau->getProject()->getProjectPath() . "/.bordereaux/" . $bordereau->getId() . "/" . $ligne->getPhoto();
                    $this->Row(array($position, $type . $titre . "\n" . $description, $unite, $quantite, "", ""), false, $filepath, $ligne->getRapportPhoto() );
                }else {
                    $this->Row(array($position, $type . $titre . "\n" . $description, $unite, $quantite, "", ""));
                }
                break;
            case "RESUME":
                $this->Row(array($position, $type . $titre, ""));
                break;
        }
        if (strpos($position, ".") === false) {
            $this->SetFont('HelveticaNeue', '', 10);
        }

        foreach ($ligne->getFilles() as $fille) {
            $this->printLigne( $bordereau, $fille);
        }
        foreach ($ligne->getAlternatives() as $alternative) {
            $this->printLigne( $bordereau, $alternative);
        }
    }

    function Row($data, $fill = false, $image = null, $ratio=1 ) {
        //Calcule la hauteur de la ligne
        $nb = 0;
        $imageMargin = 0;
        $imageBoxHeight = 0;
        $imageWidth = 0;
        $imageHeight = 0;
        if( $image ){
            $imageSize = getimagesize( $image );
            $targetSize = ($this->widths[$this->pageType][1]*$ratio) - 10.0;
            
            $widthScale = $targetSize / $imageSize[0];
            $heightScale = $targetSize / $imageSize[1];
            
            $imageScale = min( $widthScale, $heightScale );
            
            $imageWidth = $imageSize[0] * $imageScale ;
            $imageHeight = $imageSize[1] * $imageScale ;
            
            $imageBoxHeight = ceil($imageHeight)+10;
            
            $imageMargin = ($this->widths[$this->pageType][1]-10-$imageWidth)/2;
        }
        

        $dataCount = count($data);
        for ($i = 0; $i < $dataCount; $i++) {
            $data[$i] = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $data[$i]);
            if( $image && $i == 1 ){
                $nb = max($nb, $this->NbLines($this->widths[$this->pageType][$i], $data[$i]) + $imageBoxHeight / $this->multilineHeight );
            } else {
                $nb = max($nb, $this->NbLines($this->widths[$this->pageType][$i], $data[$i]));
            }
        }
       
        while ($nb) {
            $nb = 0;
            for ($i = 0; $i < $dataCount; $i++) {
                if( $image && $i == 1 ){
                    $nb = max($nb, $this->NbLines($this->widths[$this->pageType][$i], $data[$i]) + $imageBoxHeight / $this->multilineHeight );
                } else {
                    $nb = max($nb, $this->NbLines($this->widths[$this->pageType][$i], $data[$i]));
                }
            }

            $remainingLinesOnPage = ($this->PageBreakTrigger - $this->GetY()) / $this->multilineHeight;

            if ($remainingLinesOnPage < 5 && $remainingLinesOnPage - $nb < 0) {
                $this->AddPage($this->CurOrientation);
                $remainingLinesOnPage = ($this->PageBreakTrigger - $this->GetY()) / $this->multilineHeight;
            }

            $linesToPrint = min($nb, $remainingLinesOnPage);
            $h = $this->multilineHeight * $linesToPrint;

            $remainingText = array();
            for ($i = 0; $i < $dataCount; $i++) {
                $w = $this->widths[$this->pageType][$i];
                $a = isset($this->aligns[$this->pageType][$i]) ? $this->aligns[$this->pageType][$i] : 'L';
                //Sauve la position courante
                $x = $this->GetX();
                $y = $this->GetY();
                //Dessine le cadre
                $this->Rect($x, $y, $w, $h);
                //Imprime le texte
                $remainingText[$i] = $this->MultiCell($w, $this->multilineHeight, $data[$i], 0, $a, $fill, $linesToPrint);
                $imageY = $this->GetY();
                if( $i == 1 && $image && $nb<=$linesToPrint ) {
                    $this->Image( $image, $x+5+$imageMargin , $imageY+5, $imageWidth, $imageHeight );
                }
                //Repositionne à droite
                $this->SetXY($x + $w, $y);
            }

            $nb -= $linesToPrint;
            if ($nb > 0) {
                $this->AddPage($this->CurOrientation);
                $data = $remainingText;
            }
        }
        //Va à la ligne
        $this->Ln($h);
    }
}
