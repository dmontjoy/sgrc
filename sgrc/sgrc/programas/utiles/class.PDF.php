<?php

class PDF extends FPDF
{
    function Header()
    {
        $x1=30;
        $w1=148;
        $y1=16;
        
        $this->SetFont('Arial','',12);
        //$pdf->Text($x1, $y1-4, "Nombre de la propuesta");
        $this->Text($x1, $y1-1, "Social Capital Group");
        //$pdf->Text($x1+115, $y1-4, "Propuesta técnica");
        //$pdf->Text($x1+125, $y1-1, "Mes, Año");    
        $this->Image("../../../img/logo2.png", $x1+$w1-10, $y1-14);
        $this->Line($x1, $y1, $x1+$w1, $y1);
        $this->Ln(10);
        
    }
    
    function Footer()
    {
        $fecha = date('d/m/Y');
        // Go to 1.5 cm from bottom
        $x1=30;
        $w1=148;
        $y1=280;
        $this->Line($x1, $y1, $x1+$w1, $y1);
        
        $this->SetFont('Arial','',7);
        
        $this->Text($x1+2, $y1+4, "SCG © (Impreso el $fecha)");
        $this->Text($x1+$w1-2, $y1+4, $this->PageNo());
       
        $this->SetY(-16);

        $this->Cell(0,3,'Calle Tacna 445, Miraflores. Lima,Perú',0,1,'C');
        $this->Cell(0,3,'Tel +51-1-4441300/ 444 2002 Fax +51-1 446 9299',0,1,'C');
        $this->Cell(0,3,'Apartado Postal N° 18-1303 Lima 18, Perú.',0,1,'C');
        $this->SetTextColor(101 , 138, 107);
        $this->Cell(0,3,'www.s-c-g.net',0,1,'C',false,'http://www.s-c-g.net');
                
        
    }
    
  

}

?>
