<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function ai_chatbot_enable(){
  $get_data= ai_chatbot_get();

  if(isset($get_data['adminuser']) && $get_data['adminuser']==true && current_user_can( 'administrator' )){
    ai_chatboat_live_chat();

  } elseif(isset($get_data['alluser']) && $get_data['alluser']==true){
    ai_chatboat_live_chat();
  
  }
}


// api key and option data upadte
function ai_chatboat_option(){
    if ( ! current_user_can( 'administrator' ) ) {
        wp_die( - 1, 403 );
  } 
  $nonce = isset($_REQUEST['_nonce'])?$_REQUEST['_nonce']:false;

    if ( ! wp_verify_nonce( $nonce, 'ai-chatbot-nonce' ) ) {        
                return false;
    }else{
        if(isset($_POST['aichatboat_upadte']) && !empty($_POST['aichatboat_upadte'])){
            $open_api_key = isset($_POST['open_api_key'])?sanitize_text_field($_POST['open_api_key']):'';
            $adminuser = isset($_POST['adminuser'])?sanitize_text_field($_POST['adminuser']):'';

            $alluser = isset($_POST['alluser'])?sanitize_text_field($_POST['alluser']):'';


            $api = array('api_key'=>$open_api_key,'adminuser'=>$adminuser,'alluser'=>$alluser);
            if(ai_chatbot_get()){
                update_option( 'ai-chatbot', $api );
            }else{
                add_option( 'ai-chatbot', $api );
            }
        }
    }
}

// api api key
function ai_chatbot_get($key=false){
   $open_api =  get_option( 'ai-chatbot' );
   $option = isset($open_api[$key])?$open_api[$key]:$open_api;
   return $option;
}

function ai_chatbot_backend_form(){
    $nonce = wp_create_nonce( 'ai-chatbot-nonce' );
    ai_chatboat_option();

    $get_data = ai_chatbot_get();
    $api_key = isset($get_data['api_key'])?$get_data['api_key']:'';
    $adminuser = isset($get_data['adminuser']) && $get_data['adminuser']!=''?'checked':false;
    $alluser = isset($get_data['alluser']) && $get_data['alluser']!=''?'checked':false;
?>
   <h2><?php _e('AI Chatboat (Open AI ChatGPT)','ai-chatboat'); ?></h2>
    <form method="post" action="<?php echo admin_url('admin.php?page=ai-chatbot&_nonce='.$nonce); ?>">
    <ul class="wrapper">
        <li class="form-li">
          <div class="form-row">
          <label class="ai-label" for="open_api_key"><?php _e('Open AI ChatGPT API Key','ai-chatboat'); ?></label>
          <input type="text" id="open_api_key" name="open_api_key" value="<?php echo esc_html($api_key); ?>" class="regular-text" />
      </div>
          <i>You can create your API Key from Here <a href="https://platform.openai.com/account/api-keys" target="_blank">GET API KEY</a></i>
        </li>
        <li class="form-row">
          <label class="ai-label" for="open_api_key"><?php _e('Chat Popup Visible','ai-chatboat'); ?></label>
          <label for="adminuser">
            <input name="adminuser" type="checkbox" id="adminuser" value="1" <?php echo $adminuser; ?>>Only admin</label><br>
        </li>
        <li class="form-row">
          <label class="ai-label" for="open_api_key"><?php _e('Chat Popup Visible','ai-chatboat'); ?></label>
          <label for="all_user">
            <input name="alluser" type="checkbox" id="all_user" value="1" <?php echo $alluser; ?>>All user (without login user)</label><br>
        </li>
        <li class="form-row">
        <input type="submit" value="UPDATE" name="aichatboat_upadte" class="button button-primary">
        </li>
      </ul>
    </form> 

    <?php
}





function ai_chatboat_live_chat() {
  ?> 
  <div class="ai-chatbot">
  
  <button class="open-button" onclick="openForm()"><img class="ai-display" src="<?php echo esc_url(AI_CHATBOT_URL); ?>images/bot.png">
  <svg style="display: none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 800" height="25px" width="25px" role="img" alt="Close icon" class="ai-chatbot-icon ai-display"><path fill-rule="evenodd" clip-rule="evenodd" d="M466.24042,400.4053l272.927-275.99463c6.94586-8.76452,11.13092-20.00501,11.13092-32.20959 s-4.18506-23.42317-11.21857-32.29724l0.08765,0.10955c-8.76453-6.94588-20.005-11.13094-32.20959-11.13094 c-12.20453,0-23.42316,4.18505-32.29724,11.21858l0.10956-0.08765L401.84311,336.008L125.84851,60.0134 c-8.76452-6.94588-20.00501-11.13094-32.2096-11.13094s-23.42316,4.18506-32.29724,11.21858l0.10955-0.08765 C54.50535,68.77792,50.32029,80.01842,50.32029,92.223s4.18505,23.42317,11.21858,32.29724l-0.08764-0.10956l275.9946,275.99463 L61.45122,673.33234c-6.94588,8.76453-11.13094,20.005-11.13094,32.20959s4.18506,23.42316,11.21858,32.29724l-0.08765-0.1095 c8.19483,7.64703,19.2162,12.33606,31.33314,12.33606c0.83263,0,1.68717-0.02191,2.49789-0.06573h-0.10957 c0.54779,0.02191,1.20512,0.04382,1.86246,0.04382c11.32813,0,21.5388-4.71094,28.79144-12.29224l0.0219-0.02191 l275.99463-272.92703l272.92703,272.92703c7.2746,7.58136,17.48523,12.31415,28.81335,12.31415 c0.65735,0,1.29279-0.02191,1.95013-0.04382h-0.08765c0.72308,0.04382,1.55573,0.06573,2.38831,0.06573 c12.11694,0,23.16022-4.68903,31.37695-12.35797l-0.02185,0.02191c6.94586-8.76447,11.13092-20.005,11.13092-32.20959 c0-12.20453-4.18506-23.42316-11.21857-32.29724l0.08765,0.10956L466.24042,400.4053z"></path></svg>
 </button>
 
 <div class="chat-popup" id="chatForm">
   <div class="form-container ">
     <div class="ai-header" onclick="openForm()"> <img class="ai-head-img" id="user-0" src="<?php echo esc_url(AI_CHATBOT_URL); ?>images/bot-chat.png"><h2><?php _e('Live AI Chatbot','ai-chatboat'); ?></h2></div>
      <section class="chat-window" id="chat-window">
         <article class="msg-container msg-remote first-msg" id="msg-0">
         <div class="msg-box">
           <div class="flr">
             <div class="messages">
               <p class="msg" id="msg-0"><?php _e('This is a Ai Chatbot. You can ask anything to this Chatbot Like What is the theory of evolution.','ai-chatboat');?>
               </p>
             </div>
             <span class="timestamp"><span class="username"><?php _e('AI Chatbot','ai-chatboat'); ?></span></span>
           </div>
         </div>
       </article>
     </section>
 </div>
       <form class="chat-input" id="chat-input" onsubmit="return false;">
       <input type="text" autocomplete="on" placeholder="Type a message" id="chatbox" name="chatbox" />
       <button id="chatClick">
       <img class="chat-arrow" src="<?php echo esc_url(AI_CHATBOT_URL); ?>images/arrow-icon.png" style="display:block;">
                 </button>
        <div class="ai-chat-powerd-by"><?php _e('Powerd by','ai-chatboat'); ?></a> <a href="https://themehunk.com" target="_blank"><?php _e('ThemeHunk','ai-chatboat'); ?></a></div>
     </form>
 </div>

</div>
 <?php
 }
 
 
 
 add_action( 'wp_footer', 'ai_chatbot_enable', 100 );