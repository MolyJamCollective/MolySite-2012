<?php

/**
 * Setting the language (optional).
 *
 * Note: You must set both variables, $lang and $langWIN.
 *
 * Want to update or create translation files? There's a guide here:
 * http://forum.jigoshop.com/kb/customize-jigoshop/languages
 */

class Translate {

	function __construct() {

		/**
		 * Controls showing the PHP Gettext warning message on every page.
		 *
		 * Set this to false to hide the warning.
		 * Eg: $showError = false;
		 */
		$showError = false;

		/**
		 * Specify the language locale.
		 *
		 * Full list of locales ("abbreviations") can be found here:
		 * http://www.roseindia.net/tutorials/I18N/locales-list.shtml
		 */
		$this->lang = "en_US";
		$this->langWIN = "English";

		if ( !function_exists("gettext") ) {

			if ( $showError )
				echo '
					 <div class="alert alert-warning alert-block fade in">
						<a class="close" data-dismiss="alert" href="#">&times;</a>
						<h4 class="alert-warning">Warning, PHP Gettext not enabled</h4>
						If you would like to disable this message, open class.translate.php and set showError to false.
					 </div>
					 ';

			return false;

		}

		$this->setLang();

	}

	/**
	 * Sets the specified language across the script.
	 *
	 * Specifies the language folder to be /languages/en_US/ by default.
	 */
	private function setLang() {

		if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') :
			$charset = "";
			$this->lang = $this->langWIN;
		else :
			$charset = ".UTF8";
		endif;

		putenv("LC_ALL=" . $this->lang . $charset);
		setlocale(LC_ALL,  $this->lang . ".utf8",
                           $this->lang . ".UTF8",
                           $this->lang . ".utf-8",
                           $this->lang . ".UTF-8",
                           $this->lang);

		bindtextdomain("phplogin", str_replace("classes","languages",dirname(__FILE__)));
		textdomain("phplogin");

	}

}


/** If PHP Gettext isn't enabled, we'll still want to display content. */
if ( !function_exists("_") ) {
	function _($text) {
		return $text;
	}
}

/** Used to echo a Gettext string. */
if ( !function_exists("_e") ) {
	function _e( $text ) {
		echo _( $text );
	}
}

$setTranslate = new Translate();