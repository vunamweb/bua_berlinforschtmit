	
	<footer class="sitzend">
		<div class="footer_bottom">
			<div class="container">
				<div class="row">					
					<div class="col-12 col-lg-12">
						<ul class="list_nav">

<?php 
						if($userIsLogIn==$checkLogSession) echo $nav_h; 
						else { 
							echo '<li><a href="'.getUrl(1).'">Home</a></li>';
							echo $nav_h; 
							// $pages = array(4,18,);
							// foreach($pages as $key) {
							// 	echo '<li><a href="'.getUrl($key).'">'.$navarrayFULL[$key].'</a></li>';								
							// }
 					   	} 
 ?>
						</ul>
						<hr>
						<ul class="list_bottom">
							<li class="copyr"><a href="https://www.berlin-university-alliance.de/" target="_blank">© BERLIN UNIVERSITY ALLIANCE</a></li>
<?php echo $nav_meta; ?>
							<li><a href="<?php echo $dir.$lan.'/'.$navID[$loginid]; ?>"><?php echo textvorlage(22); ?></a></li> 
							<!-- <li><a href="<?php echo $dir.$lan.'/'.$navID[$registerid]; ?>"><?php echo textvorlage(35); ?></a></li>  -->
						</ul>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<div class="container partner">
		<div class="row">
			<div class="col-12 flex-container">
	<?php echo getVorlagenText(35, $lang, $dir); ?>
			</div>
		</div>
	</div>
	
	<div class='back-to-top d-none d-lg-inline-block' id='back-to-top' title='Back to top'></div>
	
	<div class="bsnav-mobile d-block d-xl-none">
		<div class="bsnav-mobile-overlay"></div>
		<div class="navbar"></div>
	</div>
	
</div>


<!-- <a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
  Link with href
</a> -->

<?php if($firstLogin) { ?> 
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="myToastStart" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="10000">
	<div class="toast-header">
	  <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#007aff"></rect></svg>

	  <strong class="me-auto">BUA message</strong>
	  <small>now</small>
	  <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
	</div>
	<div class="toast-body">
	  Welcome <?php echo $_SESSION["vname"].' '.$_SESSION["nname"]; ?> to BUA global health portal
	</div>
  </div>
</div>
<?php } ?>

<?php
if($morpheus_edit) include("design/edit.php");
?>

<script src="<?php echo $dir; ?>js/jquery.min.js"></script>
<script src="<?php echo $dir; ?>js/jquery.easing.min.js"></script>
<!-- <script src="<?php echo $dir; ?>js/popper.min.js"></script> -->
<script src="<?php echo $dir; ?>js/bootstrap.min.js"></script>
<script src="<?php echo $dir; ?>js/bootstrap-popover-x.js"></script>
<script src="<?php echo $dir; ?>js/bsnav.min.js"></script>
<!-- <script src="<?php echo $dir; ?>js/ekko-lightbox.min.js"></script> -->
<script src="<?php echo $dir; ?>js/imagesloaded.pkgd.min.js"></script>
<!-- <script src="<?php echo $dir; ?>js/isotope.pkgd.js" type="text/javascript"></script> -->
<script src="<?php echo $dir; ?>js/flickity.pkgd.min.js"></script>
<script src="<?php echo $dir; ?>js/functions.js?version=<?php echo rand(); ?>"></script>
<script src="<?php echo $dir; ?>js/recorder.js"></script>
<script src="<?php echo $dir; ?>js/app.js"></script>
<script src="<?php echo $dir; ?>js/svgTriangles.jquery.js"></script>
<script src="<?php echo $dir; ?>js/siriwave/dist/siriwave.umd.js"></script>
<script type="text/javascript" src="<?php echo $dir; ?>js/siriwave/etc/dat.gui.js"></script>
<script type="text/javascript" src="<?php echo $dir; ?>js/wavesurfer.js"></script>

<?php if($_REQUEST['hn'] == 'diary') {  ?>
<script type="text/javascript" src="<?php echo $dir; ?>js/semantic.js"></script>
<?php } ?>
<script type="text/javascript" src="<?php echo $dir; ?>morpheus/js/selectize.js"></script>
<!-- VU add tinymce !-->
<script type="text/javascript" src="<?php echo $dir ?>morpheus/tinymce/tinymce.min.js"></script>
<!-- END !-->
<!-- Bjorn add for animation on scroll -->
<script src="<?php echo $dir ?>js/wow.min.js"></script>
<script>
 new WOW().init();
</script>
<!-- <script src="https://unpkg.com/wavesurfer.js"></script> !-->
<?php 
global $audio;
if(true) { ?>
<script src="<?php echo $dir; ?>js/audio.js?v=<?php echo $rand; ?>"></script>
<?php } 
if($morpheus_edit) { 
?>
<script src="<?php echo $dir; ?>js/functions_edit.js?v=<?php echo $rand; ?>"></script>
<?php } ?>

<!-- VU: add js for category !-->
<?php if(getCssMorpheus()) { ?>
	<script src="https://unpkg.com/hammerjs@2.0.8/hammer.min.js"></script>
	<script type="text/javascript" src="<?php echo $dir; ?>morpheus/js/muuri.js"></script>
	
	<script>
	var grid = new Muuri('.grid', {
		dragEnabled: true,
		dragAxis: 'y',
		threshold: 10,
		action: 'swap',
		distance: 0,
		delay: 100,
		layoutOnResize: true,
		setWidth: true,
		setHeight: true,
		sortData: {
			foo: function (item, element) {
			},
			bar: function (item, element) {
			}
		  }
	});
	
	grid.on('dragEnd', function (item) {	
		var order = grid.getItems().map(item => item.getElement().getAttribute('id'));	
		pos = "reihenfolge";
		feld = "stID";
		table = "morp_stimmen";	
		request = $.ajax({
			url: "<?php echo $dir; ?>morpheus/UpdatePos.php",
			type: "post",
			data: "data="+order+"&pos="+pos+"&feld="+feld+"&table="+table,
			success: function(data) {
				// console.log(data);
			},
			error: function(data) {				
			}
		});	
		// MuuriPosition = ($.inArray(ref, order));
	
	});
	</script> 
	
<?php } ?>
<!-- END !-->

<!-- VU: add script for tinymce !-->
<script type="text/javascript">
  tinymce.init({
    selector: '.summernote',
	width: '100%',
	max_width: '100%',
	/*menubar: false,
	statusbar: false,
	toolbar: false,
	//inline: 'true',
	 skin: 'tinymce-5-dark',
    toolbar_mode: 'floating',
	// plugins: 'autoresize advlist link image lists',
	plugins: 'autoresize link lists charmap table code ',*/
	toolbar: 
    	 'customInsertButton customDateButton', 
	setup: (editor) => {
		editor.ui.registry.addButton('customInsertButton', {
      text: 'Insert comment',
      onAction: (_) => addLink(editor)//editor.insertContent(`&nbsp;<strong>It's my button!</strong>&nbsp;`)
    
	})
   },	 
    
	
//		outdent indent |   
//  	{ name: 'alignment', items: [ 'alignleft', 'aligncenter', 'alignright', 'alignjustify' ] },
  });
  </script>
<!-- END !-->

<script>
// Create a WaveSurfer instance
var wavesurfer;
var ed;

// VU: add link comment 
addLink = (editor) => {
   //alert(editor.selection.getContent());
   $('#show_list_comment').click();

   ed = editor;

   /*var value = editor.selection.getContent();
   value = '<b>' + value + '</b>';
   
   editor.selection.setContent(value);*/

   //editor.insertContent(`&nbsp;<strong>It's my button!</strong>&nbsp;`);
}
// END
// VU: add function comment
showChildren = (parent) => {
	$('.btn-link-1').each(function(){
		if($(this).hasClass('root_'+parent+'')) {
			$(this).parent().find('.btn-link .fa1').removeClass('fa-plus');
			$(this).parent().find('.btn-link .fa1').addClass('fa-minus');

			$(this).show();
		}
	})

	$('.show_comment').each(function(){
		$(this).show();
	})
}

hideChildren = (parent) => {
	$('.btn-link-1').each(function(){
		if($(this).hasClass('root_'+parent+'')) {
			$(this).parent().find('.btn-link .fa1').removeClass('fa-minus');
			$(this).parent().find('.btn-link .fa1').addClass('fa-plus');

			$(this).hide();
		}
	})

	$('.show_comment').each(function(){
		if($(this).hasClass('root_'+parent+'')) {
			$(this).hide();
		}
	})
}

updateComment = (noteId, message) => {
	$('#data_'+noteId+'').html(message);
}

function getHashtags() {
    var result = '';
    $('.hashtag a.ui.label').each(function() {
      result = result + $(this).attr('data-value') + ',';
    })
    return result;
  }

function getCategories() {
    var result = '';
    $('.categories a.ui.label').each(function() {
      result = result + $(this).attr('data-value') + ',';
    })
    return result;
}

removeBg = (parent) => {
	$('.cid').each(function(){
		$(this).removeClass('bg_link');
	})
}
// END

// VU: script for saving comment of comment
eventComment = () => {
	$("#accordionShowComment a.btn-link").on("click", function() {
		var idComment = $(this).attr("data-target");
        idComment = idComment.replace('#collapse', '');
        $('#parent_comment').val(idComment);

		var parent = $(this).attr("parent");
		
        // if already open
		if($(this).parent().find('.btn-link .fa').hasClass('fa-minus')) {
			$(this).parent().find('.btn-link .fa1').removeClass('fa-minus');
			$(this).parent().find('.btn-link .fa1').addClass('fa-plus');

			// hide comment of comment
			hideChildren(idComment);

			// hide all comment save form
			$('.block_comment').hide();
			// open parent's comment save form
			//$('#block_comment_'+parent+'').show();
		} 
		// if not open
		else {
			$(this).parent().find('.btn-link .fa1').removeClass('fa-plus');
			$(this).parent().find('.btn-link .fa1').addClass('fa-minus');

			// show comment of comment
			showChildren(idComment);

			// hide all comment save form
			$('.block_comment').hide();

			//if is parent, then show this comment save form
			if(!$(this).hasClass('btn-link-1'))
			  $('#block_comment_'+idComment+'').show();
        }
	});

	$('.show_comment').click(function(){
		$('.block_comment').hide();

		var id = $(this).attr("data");
		$('#block_comment_'+id+'').show();

		$('#parent_comment').val(id);
    })
}
// END

  
  // Init on DOM ready
  if($('#waveform').length > 0) {
	document.addEventListener('DOMContentLoaded', function() {
      wavesurfer = WaveSurfer.create({
          container: '#waveform',
          waveColor: '#428bca',
          progressColor: '#31708f',
          height: 80,
          barWidth: 3
      });
    });
  }
  
  // Bind controls
  document.addEventListener('DOMContentLoaded', function() {
      var playPause = document.querySelector('#playPause');

	  if(playPause != null)
		playPause.addEventListener('click', function() {
			wavesurfer.playPause();
		});

	  if(wavesurfer != null && wavesurfer != undefined) {
		wavesurfer.on('play', function() {
          document.querySelector('#play').style.display = 'none';
          document.querySelector('#pause').style.display = '';
        });

        wavesurfer.on('pause', function() {
          document.querySelector('#play').style.display = '';
          document.querySelector('#pause').style.display = 'none';
        });
	  }
	  
      // The playlist links
      var links = document.querySelectorAll('.slider__item a');
      var currentTrack = 0;
      // Load a track by index and highlight the corresponding link
      var setCurrentSong = function(index) {
          links[currentTrack].classList.remove('active');
          currentTrack = index;
          links[currentTrack].classList.add('active');
          wavesurfer.load(links[currentTrack].href);
      };
      // Load the track on click
      Array.prototype.forEach.call(links, function(link, index) {
          link.addEventListener('click', function(e) {
              e.preventDefault();
              setCurrentSong(index);
              // wavesurfer.playPause();
              $('.btn-berlin').addClass("show");
          });
      });
      // Play on audio load
	  if(wavesurfer != null && wavesurfer != undefined) {
		wavesurfer.on('ready', function() {
           wavesurfer.play();
        });
		wavesurfer.on('error', function(e) {
			//  console.warn(e);
		})
      // Go to the next track on finish
		wavesurfer.on('finish', function() {
			setCurrentSong((currentTrack + 1) % links.length);
		});
	  }
	  // Load the first track
      // setCurrentSong(currentTrack);
  });


$(document).ready(function() {
	$('.uploadimg').click(function() {
		console.log('hit');
		$('#imgModal .modal-body').load($(this).data('href'), function(e) {
			$('#imgModal').modal('show')
		});
	});

	// VU: display select by simantic
	$('.selection.hashtag').dropdown({
      maxSelections: 3
	});
	
	$('.selection.categories').dropdown({
      maxSelections: 3
    });
	// END

	// VU: make hightlight category of export
	$('.show_category').click(function(){
		$('.show_category').each(function(){
			$(this).removeClass('bg_link');
			$(this).parent().find('.show_list_media').removeClass('show');
		})
		
		$(this).addClass('bg_link');
		$(this).parent().find('.show_list_media').addClass('show');
	})
	// END

	// VU: search form
	$('.navbar-form').click(function(e) {
        var search = $('#suche').val();

        $('#waitbg').removeClass('hide');
        $('#wave1').removeClass('hide');

        //call ajax to change content
        $.ajax({
          url: './',
          type: 'get',
          data: {
            search_value: search,
            hashtags: getHashtags(),
            categories: getCategories(),
            search_combine: 'search',
          },
          dataType: 'json',
          beforeSend: function beforeSend() {},
          complete: function complete(obj) {
			$('#list_comment').html(obj.responseText);
			
			eventComment();

            $('#waitbg').addClass('hide');
            $('#wave1').addClass('hide');
          },
          success: function success(result) {
            //$('#list_user_search').html(result);
          }
        });
      })
	// END

	// VU: show media list of category
	$('.show_list_media').click(function(){
		var idCategory = $('#category_select').val();

		request = $.ajax({
            url: "./",
            type: "get",
            data: "show_list_media=1&idCategory="+idCategory+"",
            success: function(data) {
              $('#show_list_media .modal-body .data').html(data)
            }
          });
	})
	// END

	// VU: click of category of export
	$('.show_category').click(function(){
		var idCategory = $(this).attr("href");
		idCategory = idCategory.replace('#', '');
		
		$('#category_select').val(idCategory);
	})
	// END

	// VU: click of add media of category
	$('#add_media_category').click(function(){
		$('.modal_checkbox_properties').each(function(){
            if($(this).is(':checked')) {
			  var data = $('#media_select').val();

			  data = data + $(this).attr('value') + ',';

			  $('#media_select').val(data);			  
            }
		})
		
		$('#show_list_media .close').click();
	})
	// END

	// VU: add script for deleting and adding audio
	$('.add_properties').click(function(){
        var data = '';

        $('.td_checkbox').each(function(){
            if($(this).is(':checked')) {
               data = data + $(this).attr('value') + ';';
            }
        })

        $('#list').val(data);

        request = $.ajax({
            url: "./",
            type: "get",
            data: "add_properties=1",
            success: function(data) {
              $('#myModal .modal-body').html(data)
            }
          });
	})
	
	$('.save_properties').click(function(){
        var data = '';

        var userList = $('#list').val();

        $('.modal_checkbox_properties').each(function(){
            if($(this).is(':checked')) {
               data = data + $(this).attr('value') + ';';
            }
        })

        request = $.ajax({
            url: "./",
            type: "get",
            data: "list_properties="+data+"&list="+userList+"",
            success: function(data) {
              $('.message_info').removeClass('hide');
              $('.message_info').css('color', 'green');
              $('.message_info').html('Add successfully');
            }
          });
	})

	$('.delete_properties').click(function(){
        var data = '';

        var userList = $('#list').val();

        $('.modal_checkbox_properties').each(function(){
            if($(this).is(':checked')) {
               data = data + $(this).attr('value') + ';';
            }
        })

        request = $.ajax({
            url: "./",
            type: "get",
            data: "list_properties="+data+"&list="+userList+"&delete=1",
            success: function(data) {
              $('.message_info').removeClass('hide');
              $('.message_info').css('color', 'green');
              $('.message_info').html('Delete successfully');
            }
          });
    })
	// END

	// VU: call event click comment
	eventComment();
	// END

	// VU: show comment
    $(".message_comment").on("change keyup paste", function() {
		var message = $(this).val();

		$('#message_comment').val(message);
	});
	// END 

	// VU: add script for button savebtn2
	$("#savebtn2").on("click", function() {
	  	$("#back").val(1);
	});
	// END
	
	// VU: add script for comment
	$(".add_note").click(function() {
       var noteID = $(this).attr("id");
	   var message = $(this).attr('data');

       $('#save_note').attr('ref', noteID);

       // if is first time, then set value of field message
	   if($('#message').val() == '')
	     $('#message').val(message);
	})
	
	$("#save_note").click(function() {
      var noteId = $(this).attr("ref");
      var message = $('#message').val();

      request = $.ajax({
            url: "./",
            type: "get",
            data: "myNote=" + message + "&noteId=" +noteId+"",
            success: function(data) {
              // close modal note
			  $('#add_note .close').click();

			  // show successfuly message
			  $('.message_info').html('Update comment successful');
			  $('.message_info').addClass('success');

			  // update this comment text
			  updateComment(noteId, message);
            },
            error: function(data){
              data = JSON.stringify(data);
              console.log(data);
            }
          });
	})
	
	$(".show_note").click(function() {
      var idNote = $(this).attr("href");
      idNote = idNote.replace('#', '');
      $('#id_show_note').val(idNote);

      $('.body2').html('');

      request = $.ajax({
        url: "./",
        type: "get",
        data: "idNote="+idNote+"",
        success: function(data) {
    		  // update note value on the list
          $('#show_note .body1').html(data);

          //setEventClickEditComment();
        },
		    error: function(data){
			    data = JSON.stringify(data);
    		  console.log(data);
  		  }
      });
    })
	// END

	// VU: save navid when click navid on modal
	$(".navid").click(function() {
      var navid = $(this).attr("href");
	  navid = navid.replace('#', '');
	  
	  var setlink = $(this).attr('data');

	  var value = navid + ',' + setlink;
	  
	  $('#navid').val(value);
    })
	// END

	// VU: add link when click comment on modal
	$(".cid").click(function() {
      var cid = $(this).attr("href");
	  cid = cid.replace('#', '');

	  var url = '<?php echo $dir; ?>' + 'de/diary/?show='+cid+''; 
	  
	  var value = ed.selection.getContent();
	  value = '<a href='+url+' target="_blank">' + value + '</a>';
	  
	  $('#show_link .close').click();
   
      ed.selection.setContent(value);

    })
	// END

	// VU: click save link
	$("#save_link").click(function() {
      $('#show_link .close').click();
    })
	// END

	// VU: click input search
	$('#suche').keypress(function(e){
	   e.preventDefault()
	   
	   $('.navbar-form').click();
	})
	// END
	
	// target = window.location.hash;
	// if(target) {
	// 	wW = $(window).width();
	// 	$("html, body").animate({scrollTop: 0}, 0);
    //     $('html, body').stop().animate({
    //         scrollTop: $(target).offset().top - 100
	// 	}, 2500, 'easeInOutExpo');
	// }
	setSection();

	$("#myBtn").click(function(){
		$("#myToast").toast("show");
	});

	$("#myToastStart").toast("show");
	
	$('svg').svgTriangles();

});

$(window).resize(function() {
	setSection();
});

$(document).on('click', '[data-toggle="lightbox"]', function(event) {
	console.log(8);
	event.preventDefault();
	$(this).ekkoLightbox({
		alwaysShowClose: true
	});
});

$(function() {
	var tri = $('div#svg svg').svgTriangles({
		size: {w: 100, h: 200},
		speed: 500
	});

	var defaultRorateRight = 50;
    var defaultRorateLeft = 15;
    var time = 10;

    $('img').show();
	tri.switchRandomOn();
	
	var i = true;
	setInterval(function() {
		if ( i ) {
			tri.switchRandomOff();
		} else tri.switchRandomOn();		
		i = !i;
	}, 2000);
	
	$(window).scroll(function(){
           var rorateRight = defaultRorateRight + $(this).scrollTop()/time;
           var rorateLeft = defaultRorateLeft + $(this).scrollTop()/time;
           
           var x = $(this).scrollTop()/time;
           var y = $(this).scrollTop()/time;

           if(rorateRight <= 90) {
            var styleRight = "will-change: transform;transform: translateX("+x+"px) translateY("+y+"px) rotate(-"+rorateRight+"deg);";
            
            $('.curtain__right').attr('style', styleRight);
           }

           if(rorateLeft <= 90) {
            var styleLeft = "will-change: transform;transform: translateX("+(x*-1)+"px) translateY("+y+"px) rotate("+rorateLeft+"deg);";

            $('.curtain__left').attr('style', styleLeft);
           }
        });
});

// $('svg').svgTriangles({
//   
//   // default: size: {w: 50, h: 50}
//   size: {
// 	w: 150, 
// 	h: 150
//   }
// 
// });
// instance.switchRandomOn(SPEED);
// instance.switchRandomOff(SPEED);
// $('svg').svgTriangles({
//   
//   speed: 5
// 
// });
// $('svg').svgTriangles({
//   
//   className: 'off',
//   classNameOn: 'on',
//   classNameTmp: 'tmp'
// 
// });

function setSection() {
	wW = $(window).width();
	faktor = 911/1920;
	nH = ( wW * faktor );
	nLeftH = ( wW / 1200 );
	left = 350;
	right = 80;
	if(wW >= 1200) {
		$('.box_topbanner_item').css({"height":"500px"});
		$('.section_topbanner').css({"height":"600px"});
		$('.top-left').css({"width":left+"px","top":"140px"});
		$('.top-right').css({"width":right+"px","top":"350px"});
	}
	else {
		nL = left * nLeftH;
		nR = right * nLeftH;
		topfaktor = (100 * nLeftH) * -1;
		if(wW > 992) topfaktor = 130;
		else if(wW > 800) topfaktor = 10;
		else if(wW > 769) topfaktor = 0;
		else topfaktor = 0;
		$('.box_topbanner_item').css({"height":nH+"px"});
		nH = nH+40;
		$('.section_topbanner').css({"height":nH+"px"});
		$('.top-left').css({"width":nL+"px","top":topfaktor+"px"});
		$('.top-right').css({"width":nR+"px","top":topfaktor+"px"});
	}
}
$(document).ready(function() {
	// $('a.dd').on("click", function() {
	// 	ref = $(this).attr("href");
	// 	if(ref) location.href = ref;
	// 	event.preventDefault();
	// });
});

$(function() {
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this).attr('href');
        $anchor = $anchor.split('#');
        $('html, body').stop().animate({
            scrollTop: $("#"+$anchor[1]).offset().top - 100
        }, 1500, 'easeInOutExpo');
		$(".collapse").removeClass("show");
        event.preventDefault();
    });
});
$('.linkbox').on("click", function() {
	event.preventDefault();
	ref = $(this).attr("ref");
	location.href = (ref);
});
  
<?php
	global $jsFunc, $js;

	echo $js . $jsFunc;

	global $formMailAntwort, $plichtArray, $isForm;
	if($formMailAntwort) {
		$pflicht = '
		var warn = "<br><br>";
		pr=$("#datenschutz").prop("checked"); if(pr==false) { pflicht=0; warn += "• Bitte Datenschutzbestimmung akzeptieren<br><br>"; } ';

		foreach($plichtArray as $arr) {
			$nm = $arr[0];
			$feld = $arr[1];
			$art = $arr[2];
			if($art == "Radiobutton")$pflicht .= '		if ($("input:radio[name=\''.$feld.'\']").is(":checked")) {} else { pflicht=0; warn += "• '.$nm.'<br>"; }
			';
			else if($art == "Checkbox")$pflicht .= '		if ($("#'.$feld.'").prop("checked") == false) { pflicht=0; warn += "• '.$nm.'<br>"; }
			';
			else $pflicht .= '		pr = $("#'.$feld.'").val(); if(pr=="") { pflicht=0; warn += "• '.$nm.'<br>"; }
			';
		}
?>		
		
    $(".sendform").on("click", function(event) {
		var data = $("#kontaktf").serializeArray();
		data = JSON.stringify(data);
		var pflicht=1;
<?php 
if($isForm==6) { ?>
		var warnInfo = "";
		if ($("#infos").prop("checked") == true) {
			var nms = $("#name_stimme").val(); 
			var ems = $("#email_stimme").val(); 
			// console.log("will: "+nm+":"+em+":");
			if(nms=="" || ems=="") { 
				pflicht=0; 
				warnInfo = "<br>Wenn Sie weitere Infos bekommen möchten, benötigen wir Ihren <b>Namen</b> und <b>E-Mail Adresse</b>.<br>"; 
			}
		}
<?php	
	} 

	global $register_form;
	echo $pflicht; 
?>

		if(pflicht==1) {
			event.preventDefault();
		    request = $.ajax({
		        url: "<?php echo $dir; ?>page/sendmail<?php echo $register_form ? '_register' : ''; ?><?php echo $isForm==6 ? '_stimme' : ''; ?>.php",
		        type: "post",
		        datatype:'json',
		        data: 'mystring=<?php echo md5("pd?x".date("ymd")); ?>&data='+data,
		        success: function(msg) {
	                console.log(msg);
	                if(msg == "Mail sent") $('#kontaktformular').html("<div class='alert alert-primary' role='alert'><?php echo str_replace("\n", "", $formMailAntwort); ?></div>");
	                 //else if(msg == "Captcha") $('#kontaktformular').html("Die Anfrage wurde nicht gesendet. Es gab einen Fehler.");
	                // else $('#kontaktformular').html("The request was not sent. There was an error: "+msg+". Please contact us directly.<br/><br/>Die Anfrage wurde nicht gesendet. Es gab einen Fehler: "+msg+". Bitte nehmen Sie direkt Kontakt zu uns auf.");
	            }
		    });
		} else {			
			event.preventDefault();
			$("#message").html("Bitte füllen Sie alle Pflichtfelder aus"+warn+warnInfo);
			$("#message").addClass("auto");
			$("#message").removeClass("hide");
			setTimeout(function(){
				$("#message").addClass("hide");
				$("#message").removeClass("auto");
			},3000);
			$(".miss").on("click", function() {
				$(this).removeClass("miss");
			 });	
			// console.log("form not sent");
		}
    });
<?php } ?>

</script>