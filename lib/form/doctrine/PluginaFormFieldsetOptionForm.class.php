<?php

/**
 * PluginaFormFieldsetOption form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginaFormFieldsetOptionForm extends BaseaFormFieldsetOptionForm
{
  public function setup()
  {
    parent::setup();
    unset($this['fieldset_id'], $this['rank']);
  }
}
