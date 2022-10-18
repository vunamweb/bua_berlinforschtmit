<?php   

$output .= '
<link href="https://playground.anychart.com/gallery/src/Sunburst_Charts/Employee_Count_by_Country/iframe" rel="canonical">
<link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" rel="stylesheet" type="text/css">
<link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" rel="stylesheet" type="text/css">

 <link href="'.$dir.'css/anychart-ui.min.css" rel="stylesheet" type="text/css">

  <style>
#container {
  width: 100%;
  margin: 0;
  padding: 0;
}
.c100 { color: yellow !important; }
.sunburst, #container { height: 570px; } 
@media (max-width: 992px) { 
  .sunburst, #container { height: 850px; border: solid 1px #000; }   
}
h1 { color: green; }
</style>
';
   

global $table, $tid, $sortField, $nameField, $dropdown, $js;

$table 		  = 'morp_stimmen';
$tid 		    = 'stID';
$nameField 	= "name";
$sortField 	= 'reihenfolge';

$color1 = '#CCA372';
$color2 = '#2EA598';
$color26 = '#1E1D70';
$color27 = '#57289C';

$hover1 = '#8a673d';
$hover2 = '#126b61';
$hover26 = '#131055';
$hover27 = '#35106b';

$dropdown = '<select id="goto" class="form-control">';

$data = '
{ name: "Berlin forscht mit", kind:"'.$row->$tid.'", value: 100, level: "0", normal: {fill: "#fff"}, "label": { "fontColor": "#2a333d","fontWeight": "bold" }, children: [';

      
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
    
	$output .= $dropdown . '</select>
	
<section class="section_heard" id="ansehen">
					<div class="container">
						<div class="row no-gutters">
							<div class="col-12 col-lg-6 align-self-center ">
								<div class="box_graphics">
									<p>Klicken Sie auf die Themen in der<br>
									Graﬁk für eine Übersicht über den aktuellen Diskurs.</p>                                
								</div>
								<div class="sunburst"><div id="container"></div></div>      
	
								<div class="w-100 text-center"><a onclick="drillUpALevel()" class="btn btn-blue btn-fl">1 Ebene zurück</a>
								<a onclick="drillToLevel(\'Berlin forscht\')" class="btn btn-blue btn-fl">Zurück zum Anfang</a></div>
								<ol id="bc"></ol>
							</div>
							<div class="col-12 col-lg-6 align-self-center">
								 <div class="box_townhall" id="gesagt"> 
									<p id="breadc">Berlin forscht</p>
									<div class="overflow-auto">       
	
	<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p> 
	
	
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
	
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

            if ($ebene_exists) {
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

    // https://docs.anychart.com/Basic_Charts/Sunburst_Chart    
    anychart.licenseKey("stimmenaufknopfdruck.de-34a259b8-8855f78");
    treeData = anychart.data.tree(data, "as-tree");
    chart = anychart.sunburst(treeData);
    // var chart = anychart.sunburst(data, "as-tree");
  
    // set the calculation mode
    // chart.calculationMode("ordinal-from-root");
    chart.calculationMode("parent-dependent");
    
    /* listen to the chartDraw event
    and add the drilldown path to the chart title */
    chart.listen("chartDraw",function(e) {
      var text = printPath(chart.getDrilldownPath());
      // var ebene = printPath(chart.getDrilldownPath());
      // console.log(\'ebene: \'+text);
      $("#bc").html(text);
    });

    // enable HTML for labels
    chart.labels().useHtml(true);

    // configure labels
    // chart.labels().format("<span style=\'font-weight:bold\'>{%name}</span><br>{%value}");
    chart.labels().format("<span class=\'c{%value}\'>{%name}</span>");

    // configure labels of leaves
    chart.leaves().labels().format("<span style=\'font-weight:normal\'>{%name}</span>");

    // configure tooltips
    // chart.tooltip().format("{%name}\n\nWert: {%value}\n{%level}");
    chart.tooltip().format("{%name}");
    
    // ausrichtung der Text quer
    // chart.labels().position("circular");
    
    
    // set the position of labels
    // chart.level().labels().position("radial");
    // chart.leaves().labels().position("circular");

    // "drill-down" (default)
    // "multi-select"
    // "single-select"
    // "none"
    
     var interactivity = chart.interactivity();
     interactivity.selectionMode("none");

    // set the container id
    chart.container("container");
    
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
        
        console.log(\'?: \'+kind+\' : \'+level);
        
        if(kind) {
          // title.text(\'The point with name \' + e.point.get(\'x\') + \' has been clicked on\')
          request = $.ajax({
  		        url: "../../get.php",
  		        type: "post",
  		        datatype:\'json\',
  		        data: \'data=\'+data+\'&level=\'+level+\'&kind=\'+kind,
  		        success: function(msg) {
                // console.log(msg);
  	            $(\'#gesagt\').html(msg);
              }
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
  
    /* convert the current drilldown path to a string */
  function printPath(path) {
    /* go through the array of data items
    and use the get() method to obtain the "name" field */
    var text = "";
    var n = 0;
    // console.log(\'path.length: \'+path.length);
    for (i = 0; i <  path.length; i++){ 
      // console.log(path[i].get("name"));
      text += \'<span class="bc" ref="\'+path[i].get("name")+\'">\'+path[i].get("name")+\'</span>\';
      n= i;
    }
    // console.log(\'n: \'+n);
    
    return text;
    // return n;
  }
  
  function fullScreen() {
    // Set fill screen mode.
    chart.fullScreen(true)
  }
      /* convert the current drilldown path to a string */
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
    // console.log(ebene);
    visible = parseInt(ebene) + 2;
    // console.log(\'e: \'+visible);
    var item = treeData.search("name", noode);
    // chart.level(visible).enabled(true);
    chart.drillTo(item);
  }
  
  // drill up a level
  function drillUpALevel() {
    // console.log(chart.current.get(\'name\'));
     chart.drillUp();
  }

function drillToLevel(goto) {
  // console.log(goto);
  var item = treeData.search(\'name\', goto);
  chart.drillTo(item);
}
  
';

