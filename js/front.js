
jQuery( document ).ready(function() {
function ai_loader(){
    var loader = '<article class="msg-container msg-chat chat-auto-load" id="msg-chat"><div class="msg-box-chat"><div class="chat-loader"><div class="base-square"></div><div class="bubble"></div><div class="loading"><div class="dot dot--one"></div><div class="dot dot--two"></div><div class="dot dot--three"></div></div></div></div><audio controls autoplay audio style="display:none;"> <source src="'+ai_chat_ajax.ai_chat_audio+'"  type="audio/mpeg"> </audio></article>';

    return loader;
}
   function ajax_api(aiData){
       var panel = jQuery('#re-compare-bar');  
       jQuery.ajax({
                type : "POST",
                url : ai_chat_ajax.ajax_url,
                data : {action: "ai_chat_ajax",aidata:aiData,_anonce:ai_chat_ajax._anonce},
                success: function(response) {
                    jQuery('.chat-window .chat-auto-load').remove();
                jQuery('.chat-window').animate({scrollTop: jQuery('.chat-window').prop("scrollHeight")}, 500);
                jQuery('.chat-window').append(response);
                jQuery("#chatbox").removeAttr('disabled');
                jQuery( "#chatbox" ).css( "background-color","#fff" );
                jQuery("#chatbox").attr('placeholder','Type a Question');

                   }
          });   
 
        }
 

jQuery('.chat-input input').keyup(function(e) {
    if (jQuery(this).val() == '')
      jQuery(this).removeAttr('good');
    else
      jQuery(this).attr('good', '');
  });
  
  
    jQuery('#chatClick').on('click', function(e){
      

      var dp = ai_chat_ajax.ai_chat_url+'images/dp.png';
        var chatText = jQuery.trim(jQuery('#chatbox').val());
        let stringLength = chatText.length;
        if(chatText==='') return;

        jQuery("#chatbox").attr('disabled','disabled');
        jQuery("#chatbox").attr('placeholder','Waiting...');
        jQuery( "#chatbox" ).css( "background-color","#c9c9c9" );

        jQuery('#chatbox').val('');
        jQuery('.chat-window').animate({scrollTop: jQuery('.chat-window').prop("scrollHeight")}, 500);

        ajax_api(chatText);
      if (e.type === 'click') {
         jQuery('.chat-window').append('<article class="msg-container msg-self" id="msg-0"><div class="msg-box"><div class="flr"><div class="messages"><p class="msg" id="msg-1">'+chatText+'</p></div><span class="timestamp"><span class="username">You</span></div><img class="user-img" id="user-0" src="'+dp+'" /></div></article>');
         jQuery('.chat-window').append(ai_loader());
         
      }
    });
  
  
  });
  
  
  function openForm(e) {
    jQuery("#chatForm").toggle();
    jQuery(".ai-display").toggle();
  }
