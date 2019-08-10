<?php
	
	//https://arjunphp.com/speed-codeigniter-app/
	function compress() {
		$CI =& get_instance();
		$buffer = $CI->output->get_output();
		$inject_csrf = '<input type="hidden" class="'.$CI->security->get_csrf_token_name().'" name="'.$CI->security->get_csrf_token_name().'" id="'.$CI->security->get_csrf_token_name().'"  value="'.$CI->security->get_csrf_hash().'">';
		/*
		$search = array(
				'/>[^S ]+/s', 
				'/[^S ]+</s', 
				 '/(s)+/s', // shorten multiple whitespace sequences
			'#(?://)?<![CDATA[(.*?)(?://)?]]>#s' //leave CDATA alone
		);
		
		$replace = array(
				 '>',
				 '<',
				 '\1',
			"//&lt;![CDATA[n".'1'."n//]]>"
			);
		$buffer = preg_replace($search, $replace, $buffer);
		*/
		$buffer = str_replace('</form>',$inject_csrf.'</form>',$buffer);
		
		$CI->output->set_output($buffer);
		$CI->output->_display();
	}
