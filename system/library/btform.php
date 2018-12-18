<?php
class Btform {

	/**
	 * __construct
     * - Set ini object
     */
    public function __construct() {
    }
	
	/**
     * makeSelectHTML
     * - Make tag object SelectBox
     * @param Array $arrValue : contain value of selectBox
     * @param String $selectName : is name of selectBox
     * @param String $selectID : is id of selectBox
     * @param String $valueChoice : show type "selected" at positon $valueChoice
     * @param String $addition : use add css(ex:style="width:100px;") or javascript(onClick...)
     * @return String is html of object selectBox
     */
    public function makeSelectHTML($arrValue, $selectName, $selectID, $valueChoice = "", $addition = "class='form-control'", $flag = false) {
        $strSelectHTML = "";
        if (is_array($arrValue)) {
            $strSelectHTML = "<select name=" . trim($selectName) . " " . $addition . " id=" . $selectID . ">";
            if ($flag == true) {
                $strSelectHTML .= '<option value="">- - None - -</option>';
            }
            if (is_array($arrValue)) {
                foreach ($arrValue as $key => $value) {
                    $strSelectHTML .= '<option value="' . htmlspecialchars($key) . '"';
                    if (($valueChoice == $key) && ($valueChoice != null)) {
                        $strSelectHTML .= ' selected="selected"';
                    }
                    $strSelectHTML .= ">" . htmlspecialchars($value) . '</option>';
                }
            }
            $strSelectHTML .= "</select>";
        }
        return $strSelectHTML;
    }
	
	/**
     * checkBoxHTML
     * - Make tag object CheckBox
     * @param Array $arrValue : contain value of CheckBox
     * @param String $checkBoxName : is name of CheckBox
     * @param Array $checkBoxID : contain id of checkbox
     * @param Array $arrChoice : contain values want display type "checked"
     * @param Array $arrDisabled : contain values want display type "disable='disable'"
     * @param string $addition : use add css(ex:style="width:100px;") or javascript(onClick...)
     * @return Array contain value is html of object CheckBox
     */
    public function checkBoxHTML($arrValue, $checkBoxName , $arrChoice = array(), $arrDisabled = array(), $addition = "") {
        $strHTML = "";
		if($arrDisabled==''){
			$arrDisabled = array();
		}
        $arrayCheckBox = array();
        $i = 0;
        if (is_array($arrValue) && (count($arrValue) > 0)) {
            foreach ($arrValue as $key => $value) {
                $strHTML .= '<div><input type="checkbox" name="' . trim($checkBoxName) . '"';
                $strHTML .= ' value="' . $key . '" ';
                if (is_array($arrChoice) && in_array($key, $arrChoice)) {
                    $strHTML .= "checked = 'checked '";
                }
                if (count($arrDisabled) != 0) {
                    if (in_array($key, $arrDisabled)) {
                        $strHTML .= "disabled='disabled'";
                    }
                }
                $strHTML .= $addition. ' />' . " <label>" . $value . "</label>".'</div>';
                $i++;
            }
        }
        return $strHTML;
    }
	/**
     * checkboxField
     * - Define checkbox field
     * @param String $name field name
	 * @param Integer $formValue value in the form
	 * @param Integer $value current value
	 * @param String $class is class style
	 * @param String $addition Addition more
	 * @param String $id. Id of checkbox field
     * @return String html for it
     */
	function checkboxField($name, $formValue, $value, $class = '', $addition = '', $id = "") {
		$id = $id == "" ? $name : $id;
		return "<input type = 'checkbox' value = '" . $formValue . "' name = '$name' id = '$id' ".((($value !== NULL) && (in_array($formValue,$value))) ? ' checked' : '') . " class = '$class' $addition />";
	}
	/**
     * radioField
     * - Define radio field
     * @param: $name string field name
	 * @param: $formValues array values in radio field in the form
	 * @param: $value string value of radio field
	 * @param: $addition string
     * @return array of html for it
     */
	function radioField($name, $formValue, $value, $labelname = "", $addition = "") {
		$r = "<label class='radio-inline'><input type = 'radio' name = '$name' value = '$formValue'" . (($value !== NULL) && ($value == $formValue) ? ' checked' : '')." $addition />".$labelname."</label>";
		return $r;
	}
	/**
     * textField
     * - Define text field
     * @param: $name string field name
	 * @param: $value integer value of textfield
	 * @param: $size integer size of textfield
	 * @param: $addition String: id,class, onclick....
     * @return string html for it
     */
	function textField($name, $value, $size = 3, $addition = 'class="form-control"') {
		return "<input type = 'text' name = '$name' value = '" . htmlspecialchars($value, ENT_QUOTES)."' size= '$size' $addition />";
	}
	/**
     * passwordField
     * - Define password field
     * @param: $name string field name
	 * @param: $width integer width of textfield
	 * @param: $value integer value of textfield
	 * @param: $addition String
     * @return string html for it
     */
	function passwordField($name, $width, $value, $maxlength = 100, $addition = "class = 'inputText fontGothic'") {
		return "<input type = 'password' style = 'width:{$width}px' name = '$name' id = '$name' value = '" . htmlspecialchars($value, ENT_QUOTES)."' maxlength = '$maxlength' $addition />";
	}
	/**
     * textareaField
     * - Define textarea field
     * @param: $name string field name
	 * @param: $style string CSS style for textarea field
	 * @param: $value string value of textarea field
	 * @param: $addition string is js or class or...
     * @return string html for it
     */
	function textareaField($name, $style, $value, $addition = "") {
		return "<textarea style='border: 1px solid #736F6E;{$style}' name='$name' $addition>". htmlspecialchars($value, ENT_QUOTES) . "</textarea>";
	}
    /**
     * makeRadioHTML
     * - Make tag object RadioBox
     * @param Array $arrValue : contain value of RadioBox
     * @param String $radioName : is name of RadioBox
     * @param Array $radioID : contain id of RadioBox
     * @param String $valueChoice : show type "checked" at positon $valueChoice
     * @param Array $arrDisabled : contain values want display type "disable='disable'"
     * @param String $addition : use add css(ex:style="width:100px;") or javascript(onClick...)
     * @return Array contain value is html of object RadioBox
     */
    public function makeRadioHTML($arrValue, $radioName, $radioID , $valueChoice = "", $arrDisabled = array(), $addition = ""){
        $strHTML = "";
        $arrayRadioBox = array();
        $i = 0;
        if (is_array($arrValue) && (count($arrValue) > 0)) {
            foreach ($arrValue as $key => $value) {
                $strHTML .= '<input type="radio" name="' . trim($radioName) . '" id= "' . $radioID[$i] . '"';
                $strHTML .= ' value="' . $key . '" ';
                if (isset($valueChoice) && ($key == $valueChoice)) {
                    $strHTML .= 'checked ';
                }
                if (count($arrDisabled) != 0) {
                    if (in_array($key, $arrDisabled)) {
                        $strHTML .= "disabled='disabled'";
                    }
                }
                $strHTML .= $addition . ' />' . "<label for= '" . $radioID[$i] . "'>" . $value . "</label>";
                $i++;
            }
        }
        return $strHTML;
    }
	/**
	 * createFieldHidden
	 * - Use create all field hidden for form input
	 * @param Array $data Key is name field, value is value of field
	 * @return String $htmlHidden Use view field hidden of templates
	 */
	public function createFieldHidden($hiddenname = "", $hiddenvalue, $addition = "") {
		$htmlHidden = "";
		$htmlHidden .= '<input type="hidden" name="' . $hiddenname . '" value="' . htmlspecialchars($hiddenvalue, ENT_QUOTES) . '" '.$addition.' />';
		return $htmlHidden;
	}
	
}
?>