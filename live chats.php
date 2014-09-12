<?php 
/*
Plugin Name: Live Chats
Description: Select or change your live chat provider in one click.
Author: Chudesnet
Version: 1.2.3
*/


$zm_poly = new zm_chat;

$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'plugin_add_settings_link' );

function plugin_add_settings_link( $links ) {
	$settings_link = '<a href="admin.php?page=live-chats-for-woocommerce-all-in-one/live%20chats.php">Settings</a>';
	array_push( $links, $settings_link );
	return $links;
}
	
class zm_chat{
	
	function __construct(){
		add_action( "admin_menu",array($this,"reg_menu"));
		add_action( 'admin_init', array($this,'register_mysettings') );
		add_action( 'wp_footer', array($this,'print_script'));
	}
	
	function print_script(){
		$options=get_option("zm_chat_settings_group");
		echo "\n<!--Live Chats-->";
		if($options["active"]=="Zopim"){
		?>	
<!-- begin Zopim code -->
<script type="text/javascript" charset="utf-8">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='//v2.zopim.com/?<?php echo $options["Zopim"];?>';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
</script>
<!-- end Zopim code -->
		<?php		
		}
		elseif($options["active"]=="Olark"){
		?>	

<!-- begin olark code -->
<script data-cfasync="false" type='text/javascript'>/*<![CDATA[*/window.olark||(function(c){var f=window,d=document,l=f.location.protocol=="https:"?"https:":"http:",z=c.name,r="load";var nt=function(){
f[z]=function(){
(a.s=a.s||[]).push(arguments)};var a=f[z]._={
},q=c.methods.length;while(q--){(function(n){f[z][n]=function(){
f[z]("call",n,arguments)}})(c.methods[q])}a.l=c.loader;a.i=nt;a.p={
0:+new Date};a.P=function(u){
a.p[u]=new Date-a.p[0]};function s(){
a.P(r);f[z](r)}f.addEventListener?f.addEventListener(r,s,false):f.attachEvent("on"+r,s);var ld=function(){function p(hd){
hd="head";return["<",hd,"></",hd,"><",i,' onl' + 'oad="var d=',g,";d.getElementsByTagName('head')[0].",j,"(d.",h,"('script')).",k,"='",l,"//",a.l,"'",'"',"></",i,">"].join("")}var i="body",m=d[i];if(!m){
return setTimeout(ld,100)}a.P(1);var j="appendChild",h="createElement",k="src",n=d[h]("div"),v=n[j](d[h](z)),b=d[h]("iframe"),g="document",e="domain",o;n.style.display="none";m.insertBefore(n,m.firstChild).id=z;b.frameBorder="0";b.id=z+"-loader";if(/MSIE[ ]+6/.test(navigator.userAgent)){
b.src="javascript:false"}b.allowTransparency="true";v[j](b);try{
b.contentWindow[g].open()}catch(w){
c[e]=d[e];o="javascript:var d="+g+".open();d.domain='"+d.domain+"';";b[k]=o+"void(0);"}try{
var t=b.contentWindow[g];t.write(p());t.close()}catch(x){
b[k]=o+'d.write("'+p().replace(/"/g,String.fromCharCode(92)+'"')+'");d.close();'}a.P(2)};ld()};nt()})({
loader: "static.olark.com/jsclient/loader0.js",name:"olark",methods:["configure","extend","declare","identify"]});
/* custom configuration goes here (www.olark.com/documentation) */
olark.identify('<?php echo $options["Olark"];?>');/*]]>*/</script><noscript><a href="https://www.olark.com/site/<?php echo $options["Olark"];?>/contact" title="Contact us" target="_blank">Questions? Feedback?</a> powered by <a href="http://www.olark.com?welcome" title="Olark live chat software">Olark live chat software</a></noscript>
<!-- end olark code -->
		<?php		
		}
		echo "<!--End Live Chats-->\n";
	}
	
	function reg_menu(){
		$menu_slug = add_menu_page("Your Live Chat Settings","Live Chat","administrator",__FILE__, array($this, "page_content"));
	}
	
	function register_mysettings(){
		register_setting( 'zm_chat_settings_group', 'zm_chat_settings',array($this,"sanitize_settings" ));
	}
	
	function sanitize_settings($sett){
		$options=get_option("zm_chat_settings_group",array());
		if(isset($sett["Zopim"])){
			$options["Zopim"]=$sett["Zopim"];
			$options["active"]="Zopim";
		}
		elseif(isset($sett["Olark"])){
			$options["Olark"]=$sett["Olark"];
			$options["active"]="Olark";
		}
		elseif(isset($sett["reset"])){
			$options["active"]=false;
		}
		update_option("zm_chat_settings_group", $options);
	}
	
	function page_content(){
		$options=get_option("zm_chat_settings_group",array());
		?>
      <style>
	  .chats .item{
		background-color: #EAEAEA;
		margin-top: 20px;
		padding: 10px 20px;
		width: 400px;
	  }
	  .inline{
		  display:inline;
	  }
	  .disable{
			background: none;
			border: none;
			color: blue;
			cursor: pointer;
		}
	  .disable:hover{
			text-decoration: underline;
		}
		input[type="text"]{
			height: 38px;
			width: 395px;
			padding: 8px 12px;
			font-size: 14px;
			line-height: 1.42857143;
			color: #272b30;
			background-color: #ffffff;
			background-image: none;
			border: 1px solid #cccccc;
			border-radius: 4px;
			-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
			box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
			-webkit-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
			transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
		}
		.chats .item .margin_botton{
			margin-bottom:10px;
		}
		.chats .item .txtlabel{
			margin-bottom:5px;
			margin-top:5px;
			font-size:15px;
		}
		.chats .item .txtlabel a{
			font-size:13px;
			font-weight:bold;
		}
		
		.chats .item h2{
			padding-top:0px;
			font-size:20px;
		}
		.optin{
			padding:30px;
			font-size:15px;
			font-weight:bold;
		}

	  </style>
	  <div class="wrap chats">
          <h1>Your Live Chat Settings</h1><h2></h2>
			<?php
			if($options["active"]){
			  echo '<h2>Active Chat: <b>'. $options["active"] . '</b>';
			?>
              <form method="post" action="options.php" class="inline">
                <?php settings_fields( 'zm_chat_settings_group' ); ?>
                <input type="hidden" name="zm_chat_settings[reset]" value="1"/>
                <input type="submit" value="Disable" name="submit" id="submit" class="disable"  />
              </form>
          	<?php
			}
			else
			  echo "<h2 style=\"font-size:14px; color:red;\">No active chat selected. Choose your chat service from the list.";
			?>
          </h2>

			<div class="item">
				<h2>Olark Setting <?php if($options["active"]=="Olark") echo " (Active)";?></h2>
				<div class="txtlabel">Account ID <a href="http://bit.ly/1gbpDJu" target="_blank">don't have one? get on official site</a></div>
				<form method="post" action="options.php" onsubmit="return validateOlark();">
				  <?php settings_fields( 'zm_chat_settings_group' ); ?>
				  <div><input class="margin_botton" type="text" id="o_text" name="zm_chat_settings[Olark]" value="<?php echo $options["Olark"];?>" placeholder="Type your Olark Account ID here" /></div>
				  <div><input type="submit" value="Activate" name="submit" id="submit" class="button button-primary"/></div>
				  <img src="http://www.storeya.com/widgets/admin?p=allinone"/>
				</form>
			</div>        
	  
			<div class="item">
				<h2>Zopim Setting <?php if($options["active"]=="Zopim") echo " (Active)";?></h2>
				<div class="txtlabel">Widget ID <a href="http://bit.ly/1lpzAlx" target="_blank">don't have one? get on official site</a></div>
				<form method="post" action="options.php" onsubmit="return validate('zm_text');">
				  <?php settings_fields( 'zm_chat_settings_group' ); ?>
				  <div><input class="margin_botton" id="zm_text" type="text" name="zm_chat_settings[Zopim]" value="<?php echo $options["Zopim"];?>" placeholder="Type your Zopim Widget ID here" /></div>
				  <div><input type="submit" value="Activate" name="submit" id="submit" class="button button-primary"/></div>
				</form>
			</div>
 
	  <div class="optin">
 Check out the best lead-generation plugin for Wordress and <br/> <a href="http://bit.ly/TBFFlj" target="_blank">Increase Your Website's Conversion Rate NOW</a>
 </div>
	  </div>
	  
	  <script>
		function validate(inputName)
		{
			if(document.getElementById(inputName).value == '')
			{
				alert('Please fill Widget ID');
				return false;
			}
			return true;
		}
		
		function validateOlark()
		{
			if(document.getElementById("o_text").value == '')
			{
				alert('Please fill Account ID');
				return false;
			}
			return true;
		}
	  
	  </script>
	  
        <?php
	}
}
