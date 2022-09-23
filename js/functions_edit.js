var refresh = false;

var setWidthHeightIframe = function() {
	var iframe = document.querySelectorAll('iframe');

	if(iframe.length >0) {
	 iframe = iframe[0];

	 var height = iframe.contentWindow.document.body.scrollHeight;
	 var width = iframe.contentWindow.document.body.scrollWidth
	 // console.log(height);
	 $(iframe).attr('width', width);
	 $(iframe).attr('height', height);
	}
}

$(function(){
	$('.show_area').click(function() {
		var url = $(this).attr('ref');
		document.location.href=url;
	})

	$('.box_current_content .btn_close').click(function() {
		$('.box_current_content').parent().hide();
	})

	$('.edit_item').click(function() {
		refresh = true;

		var href = $(this).attr('ref');
		href = href.replace('#', '');
		href = href.split(',');

		var edit = href[0];
		var navId = href[1];
		
		var url = $('#url').val();
		url = url + 'morpheus/content_edit_live.php?edit='+edit+'&navid='+navId+'&navbar=0';

		var str = '<iframe src="'+url+'"></iframe>';
		$("#edit_area .modal-body").html(str);

		setInterval(function(){
			setWidthHeightIframe();
		}, 200);
	})
	$('.edit_templ').click(function() {
		refresh = true;

		var href = $(this).attr('ref');
		href = href.replace('#', '');
		href = href.split(',');

		var edit = href[0];
		var navId = href[1];
		
		var url = $('#url').val();
		url = url + 'morpheus/content_template.php?edit='+edit+'&navid='+navId+'&navbar=0';

		var str = '<iframe src="'+url+'"></iframe>';
		$("#edit_area .modal-body").html(str);

		setInterval(function(){
			setWidthHeightIframe();
		}, 200);
	})
	$('.templ_settings').click(function() {
		var href = $(this).attr('ref');
		href = href.replace('#', '');
		href = href.split(',');

		var edit = href[0];
		var navId = href[1];
		var func = href[2];
		
		var url = $('#url').val();
		url = url + 'morpheus/content.php?edit='+navId+'&'+func+'='+edit+'&navbar=0';
		// console.log(url);
		request = $.ajax({
	        url: url,
	        type: "get",
	        success: function(msg) {
				request = $.ajax({
					url: window.location.href,
					type: "get",
					success: function(data) {
			  			$('body').html(data);
					}
		  		});
            }
	    });		
	})
	$('.pos_change').click(function() {
		var href = $(this).attr('ref');
		href = href.replace('#', '');
		href = href.split(',');
		var edit = href[0];
		var navId = href[1];
		var pos = href[2];
		var updown = href[3];
		var url = $('#url').val();
		url = url + 'morpheus/content.php?edit='+navId+'&cid='+edit+'&sortid='+pos+'&sort='+updown;
		request = $.ajax({
	        url: url,
	        type: "get",
	        success: function(msg) {
				refresh = false;
				request = $.ajax({
					url: window.location.href,
					type: "get",
					success: function(data) {
			  			$('body').html(data);
					}
		  		});
            }
	    });
	})
	$('.templ_add').click(function() {
		var href = $(this).attr('ref');
		href = href.replace('#', '');
		href = href.split(',');
		var navId = href[0];
		var pos = href[1];
		var url = $('#url').val();
		url = url + 'morpheus/content_new.php?neu=1&edit='+navId+'&position='+pos;
		// console.log(url);
		request = $.ajax({
	        url: url,
	        type: "get",
	        success: function(msg) {
				refresh = false;
				request = $.ajax({
					url: window.location.href,
					type: "get",
					success: function(data) {
			  			$('body').html(data);
					}
		  		});
            }
	    });
	})
		
	$('#edit_area .btn-close').click(function() {
		refresh = false;
		request = $.ajax({
			url: window.location.href,
			type: "get",
			success: function(data) {
			  $('body').html(data);
			}
		});
	})


	
	$('body').click(function(event) {
		if(!$(event.target).closest('#edit_area').length && !$(event.target).is('#edit_area')) {
	      // nothing		
		} else {
			if(refresh)
			 $('#edit_area .btn-close').click();
		}    
	});
	
	
});
