<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// opne ai api
ob_start();
define('AI_CHATBOT_API_KEY',ai_chatbot_get('api_key'));
add_action( 'wp_ajax_nopriv_ai_chatbot_ajax', 'ai_chatbot_ajax' );
add_action( 'wp_ajax_ai_chatbot_ajax', 'ai_chatbot_ajax' );

function ai_chatbot_image_ajax(){
  $nonce = isset($_REQUEST['_anonce'])?$_REQUEST['_anonce']:false;

  if ( ! wp_verify_nonce( $nonce, 'ai-chatbot-nonec-ajax' ) ) {   

    die( __( 'Security check', 'ai-chatbot' ) ); 

}else{

    if(isset($_POST['aidata']) && !empty($_POST['aidata'])){
    $message = sanitize_text_field($_POST['aidata']);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, esc_url('https://api.openai.com/v1/images/generations'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n    \"prompt\": \"$message\",\n    \"n\": 1,\n    \"size\": \"1024x1024\"\n  }");

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Authorization: Bearer '.AI_CHATBOT_API_KEY;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

      $openai_data = json_decode($result);
      $src = $openai_data->data[0]->url;
      echo "<img width='400px' src='".$src."' />";

}

}
die();
}


//create function with an exception
function checkNum($number) {
  if($number>1) {
    throw new Exception(__("Invaild Authentication and Request Error.",'ai-chatbot'));
  }
  return true;
}

function ai_chatbot_message($content){
			
return '<article class="msg-container msg-remote" id="msg-0"><div class="msg-box"><div class="flr"><div class="messages"><p class="msg" id="msg-1">'.nl2br($content).'</p></div><span class="timestamp"><span class="username">AI Bot</span></div><img class="user-img" id="user-0" src="'.esc_url(AI_CHATBOT_IMG_BOT).'" /></div><audio controls autoplay audio style="display:none;"> <source src="'.esc_url(AI_CHATBOT_AI_AUDIO).'"  type="audio/mpeg"> </audio></article></article>';
}


function ai_chatbot_ajax(){

  $nonce = isset($_REQUEST['_anonce'])?$_REQUEST['_anonce']:false;

  if ( ! wp_verify_nonce( $nonce, 'ai-chatbot-nonec-ajax' ) ) {   

    die( __( 'Security Issue', 'ai-chatbot' ) ); 

}else{

    if(isset($_POST['aidata']) && !empty($_POST['aidata'])){
      $message = sanitize_text_field($_POST['aidata']);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, esc_url('https://api.openai.com/v1/chat/completions'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n     \"model\": \"gpt-3.5-turbo\",\n     \"messages\": [{\"role\": \"user\", \"content\": \"$message\"}],\n     \"temperature\": 0.7\n   }");

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Authorization: Bearer '.AI_CHATBOT_API_KEY;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

$openai_data = json_decode($result);

$error = isset($openai_data->choices[0]->message->content)?true:2;
		
		
		//trigger exception in a "try" block
try { 
		checkNum($error);
  //If the exception is thrown, this text will not be shown
 echo ai_chatbot_message($openai_data->choices[0]->message->content);
}

//catch exception
catch(Exception $e) {
		echo "<article class='ai-cb-error-msg'>Message: " .$e->getMessage()."(".$openai_data->error->type.")</article>";
}		

} // if isset close

}
die();
}

function ai_chatbot_backend_input(){
   ?>
   <h2><?php __('Open AI Testing data', 'ai-chatboat'); ?> </h2>
    <form method="post">
<ul class="wrapper">
    <li class="form-row">
      <label class="ai-label"  for="wurl"><?php _e('Generate AI Data', 'ai-chatboat'); ?></label>
      <input type="text" id="ai-data" name="ai-data" value="" class="regular-text"><br>
    </li>
    <li class="form-row">
    <input type="button" value="Generate" class="button button-primary" id="openai-data">
    </li>
  </ul>
</form>
<?php
}




ob_end_clean();
