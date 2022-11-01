<?php   
global $anychart;
$anychart = 1;

$output .= '
<link href="https://playground.anychart.com/gallery/src/Sunburst_Charts/Employee_Count_by_Country/iframe" rel="canonical">
<link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" rel="stylesheet" type="text/css">
<link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" rel="stylesheet" type="text/css">
<link href="'.$dir.'css/anychart-ui.min.css" rel="stylesheet" type="text/css">

  <style>
#sunburst {
  width: 100%;
  margin: 0;
  padding: 0; background:#edebe4;
}
.c100 { color: yellow !important; }
.sunburst, #sunburst { height: calc(65vH);  } 
@media (max-width: 992px) { 
  .sunburst, #sunburst { height: 850px; border: solid 1px #000; }   
}
h1 { color: green; }
</style>
';
   

global $table, $tid, $sortField, $nameField, $dropdown, $js;

$table 		  = 'morp_stimmen';
$tid 		    = 'stID';
$nameField 	= "name";
$sortField 	= 'reihenfolge';

$color1 = '#de1621';
$color2 = '#9d9c9d';
$color3 = '#98bf3d';
$color4 = '#1b3962';

// $hover1 = '#8a673d';
// $hover2 = '#126b61';
// $hover3 = '#131055';
// $hover4 = '#35106b';

$hover1 = '#de1621';
$hover2 = '#9d9c9d';
$hover3 = '#98bf3d';
$hover4 = '#1b3962';

$dropdown = '<select id="goto" class="form-control">';

$data = '
{ name: "Berlin forscht mit", kind:"'.$row->$tid.'", value: 100, level: "0", normal: {fill: "#1b3a63"}, "label": { "fontColor": "#fff","fontWeight": "normal" }, children: [';

      
    $sql = "SELECT * FROM $table WHERE ebene=1 ORDER BY $sortField";
    $res = safe_query($sql);
    $n = mysqli_num_rows($res);
    $percent = 100 / $n;
    $y = 0;
        while ($row = mysqli_fetch_object($res)) {
            if ($y) {
                $data .= '
                ]},
';
            }
            $wert = $row->wert;
            $color = 'color'.$row->$tid;
            $hover = 'hover'.$row->$tid;
            $data .= '
      {name: "'.$row->name.'", kind:"'.$row->$tid.'", level: "1", value: '.$wert.', normal: {fill: "'.$$color.'"}, selected: {fill: "'.$$hover.'"}, children: [';
            $data .= get_par($row->$tid, 2, $wert, $$color, $$hover);
      
            $dropdown .= '<option value="'.$row->name.'">'.$row->name.'</option>';
            $y++;
        }
								// <h4>Alle Themen in der Schnellauswahl:</h4>'.$dropdown. '</select>
    
	$output .= '					<div class="container">
						<div class="row no-gutters">
							<div class="col-12 col-lg-7 align-self-center ">
								
								<div class="box_graphics">
									<h4>Klicken Sie auf die Themen in der<br>
									Graﬁk für eine Übersicht über den aktuellen Diskurs.</h4> 
								</div>
								<div class="sunburst"><div id="sunburst"></div></div>      
	
								<div class="w-100 text-center mb2">
									<a onclick="drillUpALevel()" class="btn btn-info">1 Ebene zurück</a>
									<a onclick="drillToLevel(\'Berlin forscht mit\')" class="btn btn-info">Zurück zum Anfang</a>
								</div>
							</div>
							<div class="col-12 col-lg-5 align-self-center">
								<ol id="bc"></ol>
								 <div class="box_townhall" id="gesagt"> 
									<p id="breadc">Berlin forscht</p>
									<div class="overflow-auto">       
										<p>'.textvorlage(69).'</p> 	
									</div>
								</div>
							</div>
						</div>
					</div>
				
	
	';

 
function get_par($id, $ebene, $percent, $color, $hover)
{
    global $table, $tid, $sortField, $nameField, $dropdown;
    
    $sql = "SELECT * FROM $table WHERE ebene=$ebene AND parent=$id";
    $res = safe_query($sql);
    $n = mysqli_num_rows($res);
    
    if ($n) {
        $data = '';
        $next_ebene = $ebene+1;
  
        while ($row = mysqli_fetch_object($res)) {
            $this_id = $row->$tid;
 
            $wert = $row->wert / 100;
            $parent_percent = $percent * $wert;

            // is children?
            $sql = "SELECT * FROM $table WHERE ebene=$next_ebene AND parent=$this_id";
            $rs = safe_query($sql);
            $ebene_exists = mysqli_num_rows($rs);

            $dropdown .= '<option value="'.$row->name.'">'.$row->name.'</option>';

            if ($ebene_exists && $parent_percent > 0) {
                $data .= '
          {name: "'.$row->name.'", kind:"'.$row->$tid.'", value: '.$parent_percent.', level: "'.$ebene.'", normal: {fill: "'.$color.'"}, selected: {fill: "'.$hover.'"}, children: [';
                $data .= get_par($this_id, $next_ebene, $parent_percent, $color, $hover);
                $data .= '
                ]},
';
            } else {
                $data .= '
              {name: "'.$row->name.'", kind:"'.$row->$tid.'", value: '.$parent_percent.', level: "'.$ebene.'", normal: {fill: "'.$color.'"}, selected: {fill: "'.$hover.'"} },';
            }
        }
    }
    
    return $data;
}

    
 // echo '<pre>'.$data.'</pre>';
    
$js .= '

  
 anychart.onDocumentReady(function () {
    
var data = [    
    '.$data.'
    ]},
  ]},       
];

    // https://docs.anychart.com/Basic_Charts/Sunburst_Chart anychart.licenseKey("stimmenaufknopfdruck.de-34a259b8-8855f78");
    treeData = anychart.data.tree(data, "as-tree");
    chart = anychart.sunburst(treeData);
    // alle bereiche gleich gross
	// chart.calculationMode("ordinal-from-root");
    chart.calculationMode("parent-dependent");
    
    /* listen to the chartDraw event and add the drilldown path to the chart title */
    chart.listen("chartDraw",function(e) {
      var text = printPath(chart.getDrilldownPath());
      // var ebene = printPath(chart.getDrilldownPath());      
      $("#bc").html(text);
    });
    chart.labels().useHtml(true);
    chart.labels().format("<span class=\'c{%value}\'>{%name}</span>");
    chart.leaves().labels().format("<span class=\'sun_span\' style=\'font-weight:normal;font-size:11px;\'>{%name}</span>");
    // chart.tooltip().format("{%name}\n\nWert: {%value}\n{%level}");
    chart.tooltip().format("{%name}");
    
    // ausrichtung der Text quer
    // chart.labels().position("circular");    
    
    // chart.level().labels().position("radial");
    // chart.leaves().labels().position("circular");

    // "drill-down" (default)
    // "multi-select"
    // "single-select"
    // "none"
    
    var interactivity = chart.interactivity();
    interactivity.selectionMode("none");
    chart.container("sunburst");
    chart.background().fill("#edebe4");
    // https://docs.anychart.com/Common_Settings/Event_Listeners
    // chart.listen(\'pointsHover\', function (e) {
    chart.listen(\'pointClick\', function (e) {
    // chart.listen(\'pointsSelect\', function (e) {
      // chart.level(5).enabled(false);
        // $("#xxx").html(e.point.get(\'level\'));
        data = e.point.get(\'name\');
        level = e.point.get(\'level\');
        kind = e.point.get(\'kind\');        
        // level = getlvl(chart.getDrilldownPath());
        drillToItem(data, level);
        // kind = getkind(chart.getDrilldownPath());
        
        if(kind) {
          request = $.ajax({
  		        url: "../../get.php", type: "post", datatype:\'json\', data: \'data=\'+data+\'&level=\'+level+\'&kind=\'+kind,success: function(msg) {  $(\'#gesagt\').html(msg); }
  		    });
        }
    });
    
  // chart.title().listen("click", function() {
  // //   chart.level(5).enabled(false);
  //    $("#xxx").text("222");
  // });
  // initiate drawing the chart

  chart.draw();
}); 
  
  function printPath(path) {
    var text = "";
    var n = 0;
    // console.log(\'path.length: \'+path.length);
    for (i = 0; i <  path.length; i++){ 
      // console.log(path[i].get("name"));
      text += \'<span class="bc" ref="\'+path[i].get("name")+\'">\'+path[i].get("name")+\'</span>\';
      n= i;
    }    
    return text;
    // return n;
  }
  
  function fullScreen() {
    chart.fullScreen(true)
  }
  function getkind(path) {
    for (i = 0; i <  path.length; i++){ 
      text = path[i].get("kind");
    }
    return text;
  }
  function getlvl(path) {
    for (i = 0; i <  path.length; i++){ 
      text = path[i].get("level");
    }
    return text;
  }

  function drillToItem(noode, ebene) {
    visible = parseInt(ebene) + 2;
    var item = treeData.search("name", noode);
    chart.drillTo(item);
  }  
  function drillUpALevel() {
     chart.drillUp();
  }
  function drillToLevel(goto) {  	
  	var item = treeData.search(\'name\', goto);
  	chart.drillTo(item);
  }

';

