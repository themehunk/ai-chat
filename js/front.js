
jQuery( document ).ready(function() {
//   var aDay = new Date(Date.now());

//   var interval = setInterval(function() {
//   console.log(timeSince(new Date(Date.now())-aDay));
//   console.log(new Date(Date.now()));

// }, 1000);

  //get_elapsed_time_string(3600);
  function timeSince(date) {

    var seconds = Math.floor((new Date() - date) / 1000);
  
    var interval = seconds / 31536000;
  
    if (interval > 1) {
      return Math.floor(interval) + " years";
    }
    interval = seconds / 2592000;
    if (interval > 1) {
      return Math.floor(interval) + " months";
    }
    interval = seconds / 86400;
    if (interval > 1) {
      return Math.floor(interval) + " days";
    }
    interval = seconds / 3600;
    if (interval > 1) {
      return Math.floor(interval) + " hours";
    }
    interval = seconds / 60;
    if (interval > 1) {
      return Math.floor(interval) + " minutes";
    }
    return Math.floor(seconds) + " seconds";
  }












function ai_loader(){
    var loader = '<article class="msg-container msg-chat chat-auto-load" id="msg-chat"><div class="msg-box-chat"><div class="chat-loader"><div class="base-square"></div><div class="bubble"></div><div class="loading"><div class="dot dot--one"></div><div class="dot dot--two"></div><div class="dot dot--three"></div></div></div></div><audio controls autoplay audio style="display:none;"> <source src="'+ai_chatoat_ajax.ai_chatbot_audio+'"  type="audio/mpeg"> </audio></article>';

    return loader;
}



   function ajax_api(aiData){

       var panel = jQuery('#re-compare-bar');  
       jQuery.ajax({
                type : "POST",
             //   dataType : "json",
                url : ai_chatoat_ajax.ajax_url,
                data : {action: "open_ai_ajax",aidata:aiData},
                success: function(response) {
                    jQuery('.chat-window .chat-auto-load').remove();

                
                jQuery('.chat-window').animate({scrollTop: jQuery('.chat-window').prop("scrollHeight")}, 500);
                jQuery('.chat-window').append(response);
 
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

      var dp = ai_chatoat_ajax.ai_chatbot_url+'images/dp.png';
      

        var chatText = jQuery('#chatbox').val();
        jQuery('#chatbox').val('');

        jQuery('.chat-window').animate({scrollTop: jQuery('.chat-window').prop("scrollHeight")}, 500);
        ajax_api(chatText);
      if (e.type === 'click') {
         jQuery('.chat-window').append('<article class="msg-container msg-self" id="msg-0"><div class="msg-box"><div class="flr"><div class="messages"><p class="msg" id="msg-1">'+chatText+'</p></div><span class="timestamp"><span class="username">You</span>&bull;<span class="posttime">Now</span></span></div><img class="user-img" id="user-0" src="'+dp+'" /></div></article>');
         jQuery('.chat-window').append(ai_loader());
         
      }
    });
  
  
  });
  
  
  function openForm() {
    document.getElementById("chatForm").style.display = "block";
  }
  
  function closeForm() {
    document.getElementById("chatForm").style.display = "none";
  }
