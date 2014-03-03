<?php if(!defined('IS_CMS')) die();

/**
 * Plugin:   slideText
 * @author:  HPdesigner (hpdesigner[at]web[dot]de)
 * @version: v0.0.2013-10-14
 * @license: GPL
 * @see:     Verse
 *           The name of the LORD is a strong tower; the righteous run to it and are safe. - The Bible
 *
 * Plugin created by DEVMOUNT
 * www.devmount.de
 *
**/

class slideText extends Plugin {

	public $admin_lang;
	private $cms_lang;

	function getContent($value) {

		global $CMS_CONF;
		global $syntax;
		
		$this->cms_lang = new Language(PLUGIN_DIR_REL . 'slideText/sprachen/cms_language_' . $CMS_CONF->get('cmslanguage') . '.txt');
				
		// get params
		$values = explode('|', $value);
		$question = trim($values['0']);
		$answere = trim($values['1']);
		 
		// handle input
		if ($question == '') return $this->cms_lang->getLanguageValue('error_toclick');

		// get and check conf
		$conf = array(
			'duration'	=> ($this->settings->get('duration') != '') ? $this->settings->get('duration') : '400',
			'easing'	=> ($this->settings->get('easing') != '') ? $this->settings->get('easing') : 'swing'		// swing, linear
		);
		
		// include jquery and slideText javascript
		$syntax->insert_jquery_in_head('jquery');
		$js = '';
		$js .= '<script type="text/javascript">
					$(document).ready(function(){
						$(".question").click(function(event){
							$(this).children("div").slideToggle("' . $conf['duration'] . '","' . $conf['easing'] . '");
						});
					});
				</script>';
		$syntax->insert_in_head($js);
		
		// build return content
		$content = '<div class="question">' . $question . '<div>' . $answere . '</div></div>';

		// return content
		return $content;

	} // function getContent
	
	
	function getConfig() {

		$config = array();
		
		// duration of animation in milliseconds
		$config['duration']  = array(
			'type' => 'text',
			'description' => $this->admin_lang->getLanguageValue('config_duration'),
			'maxlength' => '100',
			'size' => '5',
			'regex' => "/^[0-9]{0,4}$/",
			'regex_error' => $this->admin_lang->getLanguageValue('config_duration_error')
		);
		
		
		// easing of animation
		$config['easing']  = array(
			'type' => 'select',
			'description' => $this->admin_lang->getLanguageValue('config_easing'),
			'descriptions' => array(
				'swing' => 'swing',
				'linear' => 'linear'
			),
			'multiple' => false
		);
		
		return $config;
		
	} // function getConfig    
	
	
	function getInfo() {

		global $ADMIN_CONF;

		$this->admin_lang = new Language(PLUGIN_DIR_REL . 'slideText/sprachen/admin_language_' . $ADMIN_CONF->get('language') . '.txt');
				
		$info = array(
			// Plugin-Name + Version
			'<b>slideText</b> v0.0.2013-10-14',
			// moziloCMS-Version
			'2.0',
			// Kurzbeschreibung nur <span> und <br /> sind erlaubt
			$this->admin_lang->getLanguageValue('description'), 
			// Name des Autors
			'HPdesigner',
			// Docu-URL
			'http://www.devmount.de/Develop/Mozilo%20Plugins/slideText.html',
			// Platzhalter für die Selectbox in der Editieransicht 
			// - ist das Array leer, erscheint das Plugin nicht in der Selectbox
			array(
				'{slideText|toclick|toshow}' => $this->admin_lang->getLanguageValue('placeholder'),
			)
		);
		// return plugin information
		return $info;
		
	} // function getInfo

}

?>