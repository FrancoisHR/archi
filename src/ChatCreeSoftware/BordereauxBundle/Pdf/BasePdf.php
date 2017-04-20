<?php

namespace ChatCreeSoftware\BordereauxBundle\Pdf;

class BasePdf extends \FPDI {

    protected $pageType;
    protected $widths;
    protected $aligns;
    protected $headings;
    protected $logo;
    protected $files = array();
    protected $headerFooter = true;
    protected $titre;
    protected $date;
    protected $projet;
    protected $description;
    protected $lot;
    protected $adresseChantier;
    protected $adresseClient;
    protected $multilineHeight = 5;

    protected function setArrayWithDecode($data) {
        $target = array();
        foreach ($data as $key => $value) {
            $target[$key] = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $value);
        }
        return $target;
    }

    public function setType($type) {
        $this->pageType = $type;
    }

    public function setWidths($type, $widths) {
        if (!$this->widths) {
            $this->widths = array();
        }
        $this->widths[$type] = $widths;
    }

    public function setAligns($type, $aligns) {
        if (!$this->aligns) {
            $this->aligns = array();
        }
        $this->aligns[$type] = $aligns;
    }

    public function setHeadings($type, $headings) {
        if (!$this->headings) {
            $this->headings = array();
        }
        $this->headings[$type] = $headings;
    }

    public function setLogo($logo) {
        $this->logo = $logo;
    }

    public function setTitre($titre) {
        $this->titre = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $titre);
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function setProjet($projet) {
        $this->projet = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $projet);
    }

    public function setDescription($description) {
        $this->description = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $description);
    }

    public function setlot($lot) {
        $this->lot = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $lot);
    }

    public function setAdresseChantier($adresse) {
        $this->adresseChantier = $this->setArrayWithDecode($adresse);
    }

    public function setAdresseClient($adresse) {
        $this->adresseClient = $this->setArrayWithDecode($adresse);
    }

    public function setFiles($files) {
        $this->files = $files;
    }

    public function concat() {
        $this->headerFooter = false;
        foreach ($this->files AS $file) {
            $pageCount = $this->setSourceFile($file);
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $tplIdx = $this->ImportPage($pageNo);
                $s = $this->getTemplatesize($tplIdx);
                $this->AddPage($s['w'] > $s['h'] ? 'L' : 'P', array($s['w'], $s['h']));
                $this->useTemplate($tplIdx);
            }
        }
    }

    protected function adresse($adresse) {
        if (array_key_exists("nom", $adresse) && $adresse["nom"]) {
            $this->Cell(80, 5, $adresse["nom"], 0, 2, 'L');
        }
        $this->Cell(80, 5, $adresse["adresse1"], 0, 2, 'L');
        if ($adresse["adresse2"]) {
            $this->Cell(80, 5, $adresse["adresse2"], 0, 2, 'L');
        }
        $this->Cell(15, 5, $adresse["cp"], 0, 0, 'L');
        $this->Cell(55, 5, $adresse["ville"], 0, 2, 'L');
        if (array_key_exists("cadastre", $adresse) && $adresse["cadastre"]) {
            $this->SetX(15);
            $this->Cell(25, 5, "Cadastre : ", 0, 0, 'L');
            $this->Cell(55, 5, $adresse["cadastre"], 0, 2, 'L');
        }
        if (array_key_exists("section", $adresse) && $adresse["section"]) {
            $this->SetX(15);
            $this->Cell(25, 5, "Section : ", 0, 0, 'L');
            $this->Cell(55, 5, $adresse["section"], 0, 2, 'L');
        }
        if (array_key_exists("commune", $adresse) && $adresse["commune"]) {
            $this->SetX(15);
            $this->Cell(25, 5, "Commune : ", 0, 0, 'L');
            $this->Cell(55, 5, $adresse["commune"], 0, 2, 'L');
        }
    }

    

    public function pageGarde() {
        $this->setType("GARDE");
        $this->AddPage();
    }

    public function pageResume() {
        $this->setType("RESUME");
        $this->AddPage();
    }

    public function totalResume() {
        $this->SetFont('HelveticaNeueBd', '', 8);
        $this->SetXY(160, $this->GetY() + 2);
        $this->Cell(20, 5, "Total HTVA", 0, 0, "R");
        $this->Cell(20, 5, "", 1, 2, "L");

        $this->SetXY(160, $this->GetY() + 2);
        $this->Cell(20, 5, "TVA 17%", 0, 0, "R");
        $this->Cell(20, 5, "", 1, 2, "L");

        $this->SetXY(160, $this->GetY() + 2);
        $this->Cell(20, 5, "Total TTC", 0, 0, "R");
        $this->Cell(20, 5, "", 1, 2, "L");
    }

        function CheckPageBreak($h) {
        //Si la hauteur h provoque un débordement, saut de page manuel
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt) {
        //Calcule le nombre de lignes qu'occupe un MultiCell de largeur w
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

    function MultiCell($w, $h, $txt, $border = 0, $align = 'J', $fill = false, $maxline = 0) {
        //Output text with automatic or explicit line breaks, at most $maxline lines
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;
        $b = 0;
        if ($border) {
            if ($border == 1) {
                $border = 'LTRB';
                $b = 'LRT';
                $b2 = 'LR';
            } else {
                $b2 = '';
                if (is_int(strpos($border, 'L')))
                    $b2 .= 'L';
                if (is_int(strpos($border, 'R')))
                    $b2 .= 'R';
                $b = is_int(strpos($border, 'T')) ? $b2 . 'T' : $b2;
            }
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $ns = 0;
        $nl = 1;
        while ($i < $nb) {
            //Get next character
            $c = $s[$i];
            if ($c == "\n") {
                //Explicit line break
                if ($this->ws > 0) {
                    $this->ws = 0;
                    $this->_out('0 Tw');
                }
                $this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                $nl++;
                if ($border && $nl == 2)
                    $b = $b2;
                if ($maxline && $nl > $maxline)
                    return substr($s, $i);
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
                $ls = $l;
                $ns++;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                //Automatic line break
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                    if ($this->ws > 0) {
                        $this->ws = 0;
                        $this->_out('0 Tw');
                    }
                    $this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
                } else {
                    if ($align == 'J') {
                        $this->ws = ($ns > 1) ? ($wmax - $ls) / 1000 * $this->FontSize / ($ns - 1) : 0;
                        $this->_out(sprintf('%.3F Tw', $this->ws * $this->k));
                    }
                    $this->Cell($w, $h, substr($s, $j, $sep - $j), $b, 2, $align, $fill);
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                $nl++;
                if ($border && $nl == 2)
                    $b = $b2;
                if ($maxline && $nl > $maxline) {
                    if ($this->ws > 0) {
                        $this->ws = 0;
                        $this->_out('0 Tw');
                    }
                    return substr($s, $i);
                }
            } else
                $i++;
        }
        //Last chunk
        if ($this->ws > 0) {
            $this->ws = 0;
            $this->_out('0 Tw');
        }
        if ($border && is_int(strpos($border, 'B')))
            $b .= 'B';
        $this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
        $this->x = $this->lMargin;
        return '';
    }
    
}