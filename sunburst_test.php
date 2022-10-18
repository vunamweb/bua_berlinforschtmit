<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>Employee Count by Country</title>
    <link href="https://playground.anychart.com/gallery/src/Sunburst_Charts/Employee_Count_by_Country/iframe" rel="canonical">
    <meta content="AJAX Chart,Chart from JSON,JSON Chart,JSON Plot,Sunburst Chart,Tooltip" name="keywords">
    <meta content="AnyChart - JavaScript Charts designed to be embedded and integrated" name="description">
    <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" rel="stylesheet" type="text/css">
    <style>
    html,
    body,
    #container {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
    }

    .c100 {
        color: yellow !important;
    }

    .btn {
        width: 40%;
    }

    button {
        float: left;
        margin-right: 1%;
    }

    .sunburst {
        min-height: 1100px;
    }

    h1 {
        color: green;
    }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-8 sunburst">
                <div id="container"></div>
            </div>
            <div class="col-12 card col-lg-4 align-self-center">

                <button onclick="drillUpALevel()" class="btn btn-danger">1 Level zurück</button>
                <div id="xxx">ttt</div>
            </div>
        </div>
    </div>


    <?php
include("nogo/funktion.inc");
include("nogo/config.php");
include("nogo/db.php");
dbconnect();


global $table, $tid, $sortField, $nameField, $dropdown;

$table        = 'morp_stimmen';
$tid            = 'stID';
$nameField  = "name";
$sortField  = 'reihenfolge';

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
    
// echo $dropdown .= '</select>';

 
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
    
?>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-sunburst.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-data-adapter.min.js"></script>
    <script type="text/javascript">
    anychart.onDocumentReady(function() {

        
var data = [    
    <?php echo $data; ?>
    ]},
     ]},
];
        

        anychart.licenseKey("stimmenaufknopfdruck.de-34a259b8-8855f78");
        treeData = anychart.data.tree(data, "as-tree");
        chart = anychart.sunburst(treeData);
        // var chart = anychart.sunburst(data, "as-tree");

        // var numberOfHintLevels = chart.hintDepth();
        // chart.title('The number of the hint-levels is ' + numberOfHintLevels);

        // set the calculation mode
        //   chart.calculationMode("ordinal-from-root");
         chart.calculationMode("parent-dependent");
        // chart.calculationMode("parent-independent");
        // chart.calculationMode('ordinal-from-leaves');
        // chart.level(1).enabled(false);
        // chart.level(4).enabled(false);
        // chart.level(5).enabled(false);
        // chart.startAngle(90);

        /* listen to the chartDraw event
        and add the drilldown path to the chart title */
        chart.listen("chartDraw", function(e) {
            //   var text = printPath(chart.getDrilldownPath());
            var ebene = printPath(chart.getDrilldownPath());
            console.log('akt. ebene: ' + ebene);
            if (ebene > 10) {
                // chart.level(5).enabled(true);
                //  if(ebene > 1) chart.level(5).enabled(true);
                //else chart.level(5).enabled(false);
            }
            //else chart.level(4).enabled(false);
        });

        chart.listen("drillChange", function(e) {
            // Treemap listen() Callback method. Function that looks like:
            // function(event){
            //   event.actualTarget - actual event target
            //   event.currentTarget - current event target
            //   event.iterator - event iterator
            //   event.originalEvent - original event
            //   event.point - event point
            //   event.pointIndex - event point index
            // }
            //var text = printPath(chart.getDrilldownPath());
            //console.log(e.current.get('name'));
            console.log('MEEEEEEE');
        });

        // enable HTML for labels
        chart.labels().useHtml(true);

        // configure labels
        // chart.labels().format("<span style='font-weight:bold'>{%name}</span><br>{%value}");
        chart.labels().format("<span class='c{%value}'>{%name}</span>");

        // configure labels of leaves
        chart.leaves().labels().format("<span style='font-weight:bold'>{%name}</span>");

        // configure tooltips
        chart.tooltip().format("{%name}\n\nWert: {%value}\n{%custom_field}");

        var interactivity = chart.interactivity();
        interactivity.selectionMode("singleSelect");


        // var legend = chart.legend();
        // legend.enabled(true);
        // // Listen to legendItemClick event
        // legend.listen('legendItemClick', function(e){
        //     var seriesName = chart.getSeriesAt(e.itemIndex).name();
        //     chart.title(seriesName + ' item has been clicked on');
        // });
        // 
        // set the chart title

        // chart.title().useHtml(true);
        // chart.title("<span style='font-size:12; color:red' class='xxx'>Sunburst: Labels and Tooltips (Tokens)</span></h1><br><br>" +
        //             "<span style='font-size:12; font-style:italic'>" +
        //             "Export Sales</span>");

        // set the container id
        chart.container("container");

        // https://docs.anychart.com/Common_Settings/Event_Listeners
        // chart.listen('pointsHover', function (e) {
        chart.listen('pointsSelect', function(e) {
            // chart.level(5).enabled(false);
            // $("#xxx").html(e.point.get('custom_field'));
            data = e.point.get('name');
            ebene = e.point.get('custom_field');
            drillToItem(data, ebene);
            //title.text('The point with name ' + e.point.get('x') + ' has been clicked on')
            request = $.ajax({
                url: "recorder/get.php",
                type: "post",
                datatype: 'json',
                data: 'data=' + data + '&ebene=' + ebene,
                success: function(msg) {
                    // console.log(msg);
                    $('#xxx').html(msg);
                }
            });
        });

        // chart.title().listen("click", function() {
        //   chart.level(5).enabled(false);
        //   $("#xxx").text("222");
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
        console.log('path.length: ' + path.length);
        for (i = 0; i < path.length; i++) {
            text += path[i].get("name") + "\\";
            n = i;
        }
        console.log('n: ' + n);
        // return text;
        return n;
    }

    function drillToItem(noode, ebene) {
        // console.log(ebene);
        visible = parseInt(ebene) + 2;
        console.log('e: ' + visible);
        var item = treeData.search("name", noode);
        // chart.level(visible).enabled(true);
        chart.drillTo(item);
    }

    // drill up a level
    function drillUpALevel() {
        // console.log(chart.current.get('name'));
        chart.drillUp();
    }
    </script>
</body>

</html>