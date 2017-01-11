<?php

include '/home/mussmann/public_html/includes/php_db.php';

$connection = connect_db();

$select = "select s.ITC,o.Orders,f.Family,p.Species,s.Quantity,s.Storage,s.Comment,s.OrigNum,loc.Locality,wb.WaterBody,LI.Description,LI.County,LI.States
  from specimens s 
  INNER JOIN species p ON s.SpeciesID=p.SpeciesID 
  INNER JOIN lookupFamily l ON s.SpeciesID=l.SpeciesID 
  INNER JOIN family f ON f.FamilyID=l.FamilyID 
  INNER JOIN lookupOrder lo ON l.FamilyID=lo.FamilyID 
  INNER JOIN orders o ON o.OrderID=lo.OrderID
  INNER JOIN localities loc ON s.LocalityID=loc.LocalityID
  INNER JOIN waterBodies wb ON s.WaterBodyID=wb.WaterBodyID
  INNER JOIN localityInfo LI ON s.LocalityID=LI.LocalityID AND s.WaterBodyID=LI.WaterBodyID
  ORDER BY ITC";

$export = $connection->query($select);
$fields = mysqli_fetch_fields($export);

$col_title = "";
foreach( $fields as $field ){
	$col_title .= '<Cell ss:StyleID="2"><Data ss:Type="String">' . $field->name . '</Data></Cell>';
}

$col_title = '<Row>'.$col_title.'</Row>';

$data="";

while($row = mysqli_fetch_row($export)) {
	$line = '';
	foreach($row as $value) {
		if ((!isset($value)) OR ($value == "")) {
			$value = '<Cell ss:StyleID="1"><Data ss:Type="String"></Data></Cell>\t';
		}else{
			$value = str_replace('"', '', $value);
			$value = '<Cell ss:StyleID="1"><Data ss:Type="String">' . $value . '</Data></Cell>\t';
		}
		$line .= $value;
	}
	$data .= trim("<Row>".$line."</Row>")."\n";
}

$data = str_replace("\r","",$data);

header("Content-Type: application/vnd.ms-excel;");
header("Content-Disposition: attachment; filename=uark_ichthyology_database.xls");
header("Pragma: no-cache");
header("Expires: 0");

$xls_header = '<?xml version="1.0" encoding="utf-8"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet" xmlns:html="http://www.w3.org/TR/REC-html40">
<DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
<Author></Author>
<LastAuthor></LastAuthor>
<Company></Company>
</DocumentProperties>
<Styles>
<Style ss:ID="1">
<Alignment ss:Horizontal="Left"/>
</Style>
<Style ss:ID="2">
<Alignment ss:Horizontal="Left"/>
<Font ss:Bold="1"/>
</Style>

</Styles>
<Worksheet ss:Name="Export">
<Table>';

$xls_footer = '</Table>
<WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
<Selected/>
<FreezePanes/>
<FrozenNoSplit/>
<SplitHorizontal>1</SplitHorizontal>
<TopRowBottomPane>1</TopRowBottomPane>
</WorksheetOptions>
</Worksheet>
</Workbook>';

print $xls_header.$col_title.$data.$xls_footer;
exit;

?>
