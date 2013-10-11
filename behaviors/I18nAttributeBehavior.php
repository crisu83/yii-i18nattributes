<?php
/**
 * I18nAttributeBehavior class file.
 * @author Christoffer Niska <christoffer.niska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package crisu83.yii-i18nattributes.behaviors
 */

/**
 * Active record behavior for translating attributes.
 * @property CActiveRecord $owner
 */
class I18nAttributeBehavior extends CActiveRecordBehavior
{
    /**
     * @var array a list of translatable attributes.
     */
    public $attributes = array();

    /**
     * @var string name of the id column.
     */
    public $idAttribute = 'id';

    /**
     * Translates the given attribute into the active language.
     * @param string $name name of the attribute.
     * @return string the translation.
     */
    public function translateAttribute($name)
    {
        if ($this->isTranslatable($name) && ($model = $this->loadModel($name)) !== null) {
            return $model->text;
        }
        return null; // the owner must handle non-translatable attributes itself.
    }

    /**
     * Returns the attribute model for the given attribute.
     * @param string $name name of the attribute.
     * @return I18nAttribute the model instance.
     */
    protected function loadModel($name)
    {
        return I18nAttribute::model()->findByAttributes(
            array(
                'locale' => Yii::app()->language,
                'modelClass' => get_class($this->owner),
                'modelId' => $this->resolveModelId(),
                'attribute' => $name,
            )
        );
    }

    /**
     * Returns the model id for the owner of this behavior.
     * @return int the id.
     * @throws CException if the "idAttribute" property does not exist on the owner.
     */
    protected function resolveModelId()
    {
        if ($this->owner->hasAttribute($this->idAttribute)) {
            return $this->owner->{$this->idAttribute};
        }
        throw new CException(sprintf('Owner does not have a "%s" column.', $this->idAttribute));
    }

    /**
     * Returns whether the given attribute is translatable.
     * @param string $attribute name of the attribute.
     * @return bool the result.
     */
    protected function isTranslatable($attribute)
    {
        return in_array($attribute, $this->attributes);
    }
}