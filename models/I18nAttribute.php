<?php
/**
 * I18nAttribute class file.
 * @author Christoffer Niska <christoffer.niska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package crisu83.yii-i18nattributes.models
 */

/**
 * This is the model class for table "i18n_attribute".
 *
 * The followings are the available columns in table 'i18n_attribute':
 * @property int $id
 * @property string $locale
 * @property string $modelClass
 * @property int $modelId
 * @property string $attribute
 * @property string $text
 *
 * The followings are the available model relations:
 * @property Language $language
 */
class I18nAttribute extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'i18n_attribute';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('locale, modelClass, attribute, text', 'required'),
            array('modelId', 'numerical', 'integerOnly' => true),
            array('locale, modelClass, attribute, text', 'length', 'max' => 255),
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return I18nAttribute the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
