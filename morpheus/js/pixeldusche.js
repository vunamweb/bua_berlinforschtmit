//****************************************************************************************************
//****************************************************************************************************
// THNXS TO BURKHARD KRAUPA - eine Tasse Kaffee trinkend ...
//****************************************************************************************************
//****************************************************************************************************
// pixel-dusche.de  - 2007
//****************************************************************************************************
//****************************************************************************************************

/**
@param String url
@param object param {key: value} query parameter
*/
function modifyURLQuery(url, param){
    var value = {};

    var query = String(url).split('?');

    if (query[1]) {
        var part = query[1].split('&');

        for (i = 0; i < part.length; i++) {
            var data = part[i].split('=');

            if (data[0] && data[1]) {
                value[data[0]] = data[1];
            }
        }
    }

    value = $.extend(value, param);

    // Remove empty value
    for (i in value){
        if(!value[i]){
            delete value[i];
        }
    }

    // Return url with modified parameter
    if(value){
        return query[0] + '?' + $.param(value);
    } else {
        return query[0];
    }
}

function set_url(new_url) {
	if (history.pushState) {
		window.history.pushState("remove neu", "CMS Morpheus", new_url);
	} else {
		document.location.href = new_url;
	}

}

function getObjWidth (o) {
    return (o)?parseInt(o.offsetWidth):0;
}

function getObjHeight (o) {
    return (o)?parseInt(o.offsetHeight):0;
}

function addEvent (obj, evType, fn) {
    var o=(obj.id)?obj.id:obj.nodeName;
    if (obj.addEventListener) {
        obj.addEventListener(evType, fn, false);return true;
    } else if (obj.attachEvent) {
        var r = obj.attachEvent("on"+evType, fn);return r;
    } else return false;
}

function getEvTarget (e) {
    return (e.target)?e.target:e.srcElement;
}

var closedMenuHeight = 18;
var openItem = null;
var currentItem = null;
var active = null;
var speed = 2;
var itemHeight = 380;

function initMenu () {
    var menu=document.getElementById('menu'),menuHeight=getObjHeight(menu),arrItems=menu.getElementsByTagName('LI'),countItems=arrItems.length;
    //itemHeight=menuHeight-(countItems-1)*closedMenuHeight;

    for (var i=0; i<countItems; i++) {
        if (parseInt(i) === start) {
			openItem = arrItems[i];
			mh = document.getElementById('sw1').scrollHeight;
            arrItems[i].style.height=itemHeight+'px';
			 document.getElementById('sw'+i).style.background='url("images/table-header.gif")';
        } else {
            mH=getObjHeight(arrItems[i]);
            arrItems[i].style.height=closedMenuHeight+'px';
        }
        addEvent(arrItems[i],'click',showMenuPoint);
    }
}

function showMenuPoint (e) {
    var item =
getEvTarget(e);while(item.nodeName.toLowerCase()!='li')item=item.parentNode;
    if (item !== openItem && active==null) {
        currentItem = item;
        active = window.setInterval(doExpand,1);
    }
}

function doExpand () {
    currentItem.style.height = parseInt(currentItem.style.height) +
parseInt(speed) + 'px';
    openItem.style.height = parseInt(openItem.style.height) -
parseInt(speed) + 'px';

    if (parseInt(speed)>=50) {
        speed = 50;
    } else {
        speed++;
    }

    if (parseInt(currentItem.style.height)>=itemHeight) {
        currentItem.style.height = itemHeight+'px';
        openItem.style.height = closedMenuHeight+'px';
        cnameO=openItem.className;
        cnameC=currentItem.className;

 document.getElementById(cnameO).style.background='url("images/table-header-cl.gif")';


 document.getElementById(cnameC).style.background='url("images/table-header.gif")';

        openItem = currentItem;
        window.clearInterval(active);
        active = null;
        speed = 2;
    }
}

function getHashtagsProperties() {
    var result = '';
    $('.properties a.ui.label').each(function() {
      result = result + $(this).attr('data-value') + ',';
    })
    return result;
  }

function getHashtagsInterests() {
    var result = '';
    $('.interests a.ui.label').each(function() {
      result = result + $(this).attr('data-value') + ',';
    })
    return result;
}  

function getHashtagsGH() {
    var result = '';
    $('.GH a.ui.label').each(function() {
      result = result + $(this).attr('data-value') + ',';
    })
    return result;
}

function getHashtagsBC() {
    var result = '';
    $('.BC a.ui.label').each(function() {
      result = result + $(this).attr('data-value') + ',';
    })
    return result;
}

function hideButton() {
  $('.send_mail_event_user').hide();
  $('.cancel_back').hide();
}

function showButton() {
  $('.send_mail_event_user').show();
  $('.cancel_back').show();
}


function hideEditor() {
  tinymce.get('text_email').hide();
  $('#text_email').hide();
}

function showEditor() {
  tinymce.get('text_email').show();
  //$('#text_email').show();
}

function AddMailEvent() {
  $(".add_mail_event").on("click", function() {
    $(this).hide();
  
    showEditor();
    showButton();
  
    $('.send_mail_event_user').html('Add');
  
    tinyMCE.get('text_email').setContent('');
  });
}

function EditMailEvent() {
  $(".edit_mail_event").on("click", function() {
    var idusm = $(this).attr('href');
    idusm = idusm.replace('#', '');

    $('#idusm').val(idusm);

    $('.add_mail_event').hide();

    showEditor();
    showButton();

    var textLog = $('.text_log_'+idusm+'').html();
    tinyMCE.get('text_email').setContent(textLog);

    $('.send_mail_event_user').html('Update');
 });
}

function sendMailEvent() {
  $('.send_mail_event_confirm').click(function(){
   var idusm = $(this).attr('href');
   idusm = idusm.replace('#', '');

   $('#idusm').val(idusm);
  })
}

function getListMail() {
          var typeEvent = $('#type_event').val();
          var idEvent = $('#edit').val();

          //$('#myModal .alert_event_user').addClass('hide');

          $.ajax({
            url: 'morp_veranstaltung.php',
            type: 'get',
            data: {
              typeEvent: typeEvent,
              get_log: 'log',
              edit: idEvent
            },
            dataType: 'json',
            beforeSend: function beforeSend() {},
            complete: function complete(obj) {
              $('#log_event').html(obj.responseText);
              //$("[rel=tooltip]").tooltip({html:true});
              hideEditor();
              hideButton();

              AddMailEvent();
              EditMailEvent();
              sendMailEvent();
            },
            success: function success(result) {
              //$('#list_user_search').html(result);
            }
          });
}

$(document).ready(function() { 
    $('.selection.interests').dropdown({
        //maxSelections: 1
    });

    $('.selection.properties').dropdown({
        //maxSelections: 2
    });

    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
    });

    $('.add_properties').click(function(){
        var data = '';

        $('.td_checkbox').each(function(){
            if($(this).is(':checked')) {
               data = data + $(this).attr('value') + ';';
            }
        })

        $('#list_user').val(data);

        request = $.ajax({
            url: "user_intranet.php",
            type: "get",
            data: "add_properties=1",
            success: function(data) {
              $('#myModal .modal-body').html(data)
            }
          });
    })

    $('.save_properties').click(function(){
        var data = '';

        var userList = $('#list_user').val();

        $('.modal_checkbox_properties').each(function(){
            if($(this).is(':checked')) {
               data = data + $(this).attr('value') + ';';
            }
        })

        request = $.ajax({
            url: "user_intranet.php",
            type: "get",
            data: "list_properties="+data+"&list_user="+userList+"",
            success: function(data) {
              $('.message_info').removeClass('hide');
              $('.message_info').css('color', 'green');
              $('.message_info').html('Add successfully');
            }
          });
    })

    $('.delete_properties').click(function(){
        var data = '';

        var userList = $('#list_user').val();

        $('.modal_checkbox_properties').each(function(){
            if($(this).is(':checked')) {
               data = data + $(this).attr('value') + ';';
            }
        })

        request = $.ajax({
            url: "user_intranet.php",
            type: "get",
            data: "list_properties="+data+"&list_user="+userList+"&delete=1",
            success: function(data) {
              $('.message_info').removeClass('hide');
              $('.message_info').css('color', 'green');
              $('.message_info').html('Delete successfully');
            }
          });
    })

    $('.navbar-form').submit(function(e) {
        e.preventDefault();

        var search = $('#suche').val();

        $('#waitbg').removeClass('hide');
        $('#wave1').removeClass('hide');

        var GH = $('#GH').is(':checked') ? 'on' : '';
		var BC = $('#BC').is(':checked') ? 'on' : '';
		var SC  = $('#SC').is(':checked') ? 'on' : '';
		var NGC  = $('#NGC').is(':checked') ? 'on' : '';
		var KnEx  = $('#KnEx').is(':checked') ? 'on' : '';
		var Pol  = $('#Pol').is(':checked') ? 'on' : '';
		var Kul  = $('#Kul').is(':checked') ? 'on' : '';
		var ExLab  = $('#ExLab').is(':checked') ? 'on' : '';
        
        //call ajax to change content
        $.ajax({
          url: 'user_intranet.php',
          type: 'get',
          data: {
            search_value: search,
            hashtags: getHashtagsProperties(),
            hashtags_interests: getHashtagsInterests(),
            search_combine: 'search',
            GH: GH,
			BC: BC,
			SC: SC,
			NGC: NGC,
			KnEx: KnEx,
			Pol: Pol,
			Kul: Kul,
			ExLab: ExLab
          },
          dataType: 'json',
          beforeSend: function beforeSend() {},
          complete: function complete(obj) {
            $('#list_user_search').html(obj.responseText);

            $('#waitbg').addClass('hide');
            $('#wave1').addClass('hide');
          },
          success: function success(result) {
            //$('#list_user_search').html(result);
          }
        });
      })

      $('.send_mail').click(function(){
        var typeEvent = $('#type_event_send_mail').val();
    
        var eventId = $('#edit').val();
    
        var idusm = $('#idusm').val();

        var textMail = $('.text_log_'+idusm+'').html();

        $('#myModal_send_mail .fa-spinner').show();
    
        $.ajax({
          url: 'morp_veranstaltung.php',
          type: 'post',
          data: {
            edit: eventId,
            value_text_mail: textMail,
            value_type_event: typeEvent,
            idusm: idusm,
            sendMail: true,
            back: 2,
            save: 1
          },
          dataType: 'json',
          beforeSend: function beforeSend() {},
          complete: function complete(obj) {
            /*var data = obj.responseText;
            data = data.data;

            var title = '';

            for (i = 0; i < data.length; i++){
               title = title + data[i] + ',';
            }

            $('a.text_log_'+idusm+'').attr('title', title); */
            
            $('#myModal_send_mail .fa-spinner').hide();
            $('#myModal_send_mail .close').click();

            $('#myModal .alert_event_user').removeClass('hide');
    
            var message = 'Send Mail Successfully'; 
            $('#myModal .alert_event_user').html(message);
          },
          success: function success(result) {
            //$('#list_user_search').html(result);
          }
        });
        
       })

       $('.cancel_back_send_mail').click(function(){
          $('#myModal_send_mail .close').click();
       })

      $('.search-event').click(function(e) {
        var search = $('#suche').val();
        var fromDate = $('#from-date').val();
        var toDate = $('#to-date').val();
        var edit = $('#edit').val();

        $('#waitbg').removeClass('hide');
        $('#wave1').removeClass('hide');

        //call ajax to change content
        $.ajax({
          url: 'morp_veranstaltung.php',
          type: 'get',
          data: {
            search_value: search,
            fromDate: fromDate,
            toDate: toDate,
            eventId: edit,
            search_event: 'search',
          },
          dataType: 'json',
          beforeSend: function beforeSend() {},
          complete: function complete(obj) {
            $('#list_user_search').html(obj.responseText);

            $('#waitbg').addClass('hide');
            $('#wave1').addClass('hide');
          },
          success: function success(result) {
            //$('#list_user_search').html(result);
          }
        });
      })

      $('.submit_user_intranet').click(function(){
        $('#waitbg').removeClass('hide');
        $('#wave1').removeClass('hide');

        $('#form_user_intranet').submit();
      })

      $('#nlid_tracking').change(function(){
          $("#save").val(2);
          $('#dat').submit();
      })

      $('.all_checkbox').change(function(){
          if($(this).is(':checked'))
            $('.td_checkbox').prop('checked', true);
          else 
            $('.td_checkbox').prop('checked', false);  
      })

      $('.save_newletters').click(function(){
          var dateSendMail = $('#date_send_mail').val();

          $('#value_date_send_mail').val(dateSendMail);

          $('#dat').submit();
      })

      $('.send_mail_event_user').click(function(){
        var typeEvent = $('#type_event').val();
        var textMail = tinyMCE.get('text_email').getContent();
        var edit = $('#edit').val();
        var idusm = $('#idusm').val();

        $.ajax({
          url: 'morp_veranstaltung.php',
          type: 'post',
          data: {
            edit: edit,
            value_text_mail: textMail,
            value_type_event: typeEvent,
            idusm: idusm,
            back: 2,
            save: 1
          },
          dataType: 'json',
          beforeSend: function beforeSend() {},
          complete: function complete(obj) {
            $('#myModal .alert_event_user').removeClass('hide');

            var message = (idusm > 0) ? 'Update Successfully' : 'Save Successfully'; 
            $('#myModal .alert_event_user').html(message);

            //$('.text_log_'+idusm+'').html(textMail);

            getListMail();
          },
          success: function success(result) {
            //$('#list_user_search').html(result);
          }
        });
        //$('#verwaltung').submit();
      })

      $('#type_event').change(function(){
        $('#myModal .alert_event_user').addClass('hide');
        getListMail();
      })
});

//****************************************************************************************************

