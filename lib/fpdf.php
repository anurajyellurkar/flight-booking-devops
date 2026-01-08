
<?php
class FPDF{
 function AddPage(){ $this->buf=""; }
 function SetFont($f,$s,$z){}
 function Cell($w,$h,$txt){ $this->buf .= $txt."\n"; }
 function Output(){
  header("Content-Type: application/pdf");
  echo "%PDF-1.4\n"; 
  echo "% demo pdf generated\n";
  echo $this->buf;
 }
}
?>
