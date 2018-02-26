<?php
require_once("include_path_inc.php");

require_once("jpgraph.php");
require_once("jpgraph_line.php");
require_once("jpgraph_bar.php");

$donnees = array(12,23,9,58,23,26,57,48,12);

$largeur = 250;
$hauteur = 200;

// Initialisation du graphique
$graphe = new Graph($largeur, $hauteur);
// Echelle lineaire ('lin') en ordonnee et pas de valeur en abscisse ('text')
// Valeurs min et max seront determinees automatiquement
$graphe->setScale("textlin");

// Creation de l'histogramme
$histo = new BarPlot($donnees);
// Ajout de l'histogramme au graphique
$graphe->add($histo);

// Creation de la courbe
$courbe = new LinePlot($donnees);
// Ajout de la courbe au graphique
$graphe->add($courbe);

// Ajout du titre du graphique
$graphe->title->set("Courbe et Histo");

// Affichage du graphique
$graphe->stroke();
?>

<?php
require_once("include_path_inc.php");

require_once("jpgraph/src/jpgraph.php");
require_once("jpgraph/src/jpgraph_line.php");
require_once("jpgraph/src/jpgraph_bar.php");


// Connexion à la base de données 
//include("mysql/db-include.inc"); 

// Connexion à la BDD
$bddname = 'db_gescolaire_2017';
$hostname = 'localhost';
$username = 'root';
$password = 'houeto';




//connection string with database  
$dbhandle = mysqli_connect($hostname, $username, $password)  
or die("Unable to connect to MySQL");  
echo "";  
// connect with database  
$selected = mysqli_select_db($dbhandle, "db_gescolaire_2017")  
or die("Could not select examples");  
//query fire  
$result = mysqli_query($dbhandle,"SELECT idclasse FROM ges_classe;");  
//$json_response = array();  
// fetch data in array format 
$i=0; 
while ($tableau = mysqli_fetch_array($result, MYSQLI_ASSOC)) {  
// Fetch data of Fname Column and store in array of row_array
//$row_array['tete'] = $row['code_classe'];   
$ydata[$i++]=$tableau['idclasse'];
//push the values in the array  
//array_push($json_response,$row_array);  
}  
//  
//echo json_encode($json_response); 
//mysqli_free_result($result);

// Il faut mettre des valeurs dans un tableau. 


// On créé l'objet Graph. Ces deux appels sont toujours necessaires. 

$n = count($ydata);

$xmin = $ydata[0];
$xmax = $ydata[$n-1];

$graph = new Graph(1000,900); 
//$graph->SetScale("textlin"); 

$graph->SetScale('textlin',0,0,$xmin,$xmax);
$graph->title->Set('Example with manual tick labels');
$graph->title->SetFont(FF_ARIAL,FS_NORMAL,12);
$graph->xaxis->SetPos('min');
//$graph->xaxis->SetMajTickPositions($tickPositions,$tickLabels);
$graph->xaxis->SetFont(FF_TIMES,FS_NORMAL,10) ;

$graph->xgrid->Show();
$theme_class=new UniversalTheme;

$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);
$graph->title->Set('test de graph:');
$graph->SetBox(false);

$graph->img->SetAntiAliasing();

$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("solid");
//$graph->xaxis->SetTickLabels($ydata);
//$graph->xgrid->SetColor('#E3E3E3');


// On créé un tracé 
$lineplot = new LinePlot($ydata); 
// On ajoute ce tracé au graph 
$graph->Add($lineplot); 

// On affiche le graphique 
$graph->Stroke(); 


?>




 
