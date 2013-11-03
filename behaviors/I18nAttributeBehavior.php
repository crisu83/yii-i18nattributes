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

    /** @var I18nAttribute[][] */
    private static $_models = array();

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
        $modelClass = get_class($this->owner);
        if (!isset(self::$_models[$modelClass])) {
            $criteria = new CDbCriteria;
            $criteria->addCondition('locale=:locale');
            $criteria->addCondition('modelClass=:modelClass');
            $criteria->addCondition('attribute=:attribute');
            $criteria->index = 'modelId';
            $criteria->params = array(
                ':locale' => Yii::app()->language,
                ':modelClass' => $modelClass,
                ':attribute' => $name,
            );
            self::$_models[$modelClass] = I18nAttribute::model()->findAll($criteria);
        }
        $modelId = $this->resolveModelId();
        return isset(self::$_models[$modelClass][$modelId]) ? self::$_models[$modelClass][$modelId] : null;
    }

    /**
     * Returns the model id for the owner of this behavior.
     * @return int the id.
     * @throws CException if the "idAttribute" property does not exist on the owner.
     */
    protected function resolveModelId()
    {
        if (!$this->owner->hasAttribute($this->idAttribute)) {
            throw new CException(sprintf('Owner does not have a "%s" column.', $this->idAttribute));
        }
        return $this->owner->{$this->idAttribute};
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