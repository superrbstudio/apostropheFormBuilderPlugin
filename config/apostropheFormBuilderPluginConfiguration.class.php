<?php

/**
 * apostropheFormBuilderPlugin configuration.
 * 
 * @package     apostropheFormBuilderPlugin
 * @subpackage  config
 * @author      Your name here
 * @version     SVN: $Id: PluginConfiguration.class.php 17207 2009-04-10 15:36:26Z Kris.Wallsmith $
 */
class apostropheFormBuilderPluginConfiguration extends sfPluginConfiguration
{
  const VERSION = '1.0.0-DEV';

  static $registered = false;
  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
    // Yes, this can get called twice. This is Fabien's workaround:
    // http://trac.symfony-project.org/ticket/8026
    
    if (!self::$registered)
    {
      // Hook up to apostrophe:migrate
      $this->dispatcher->connect('command.post_command', array('apostropheFormBuilderPluginConfiguration',  
        'listenToCommandPostCommandEvent'));
      
      self::$registered = true;
    }
  }
  
  static public function migrate()
  {
    $migrate = new aMigrate(Doctrine_Manager::connection()->getDbh());
    echo("Migrating apostropheFormBuilderPlugin...\n");
    if ((!$migrate->tableExists('a_form')) && ($migrate->tableExists('pk_form')))
    {
      $migrate->sql(array(
        'RENAME TABLE pk_form TO a_form',
        // Yes really, a new layer was added
        'RENAME TABLE pk_form_field TO a_form_fieldset',
        // TODO: field_id has to become fieldset_id, and field_id has to get added and
        // reference the new a_form_field object which has to be created
        'RENAME TABLE pk_form_field_submission to a_form_field_submission',
        // field_id has to become fieldset_id
        'RENAME TABLE pk_form_field_option to a_form_fieldset_option',
        'RENAME TABLE pk_form_submission to a_form_submission',
        'ALTER TABLE a_form_field_submission CHANGE field_id fieldset_id BIGINT',
        'ALTER TABLE a_form_field_submission ADD COLUMN field_id BIGINT',
        'ALTER TABLE a_form_fieldset_option CHANGE field_id fieldset_id BIGINT',
        'CREATE TABLE a_form_field (id BIGINT AUTO_INCREMENT, fieldset_id BIGINT, name TEXT, INDEX fieldset_id_idx (fieldset_id), PRIMARY KEY(id)) ENGINE = INNODB'
      ));
      $fieldsets = $migrate->query('SELECT * FROM a_form_fieldset');
      foreach ($fieldsets as $fieldset)
      {
        $migrate->query('INSERT INTO a_form_field (fieldset_id, name) VALUES (:fieldset_id, :name)', array('fieldset_id' => $fieldset['id'], 'name' => 'value'));
        $id = $migrate->lastInsertId();
        $migrate->query('UPDATE a_form_field_submission SET field_id = :field_id WHERE fieldset_id = :fieldset_id', array('field_id' => $id, 'fieldset_id' => $fieldset['id']));
      }
    }
    if (!$migrate->columnExists('a_form', 'action'))
    {
      $migrate->sql(array(
        'ALTER TABLE a_form ADD COLUMN action VARCHAR(255)'
      ));
    }
    if (!$migrate->columnExists('a_form_fieldset_option', 'value'))
    {
      $migrate->sql(array(
        'ALTER TABLE a_form_fieldset_option ADD COLUMN value VARCHAR(255)',
        'UPDATE a_form_fieldset_option SET value = name'
      ));
    }

    if (!$migrate->getCommandsRun())
    {
      echo("Your database is already up to date.\n\n");
    }
    else
    {
      echo($migrate->getCommandsRun() . " SQL commands were run.\n\n");
    }
    echo("Done!\n");
    
  }
  
  // command.post_command
  static public function listenToCommandPostCommandEvent(sfEvent $event)
  {
    $task = $event->getSubject();
    
    if ($task->getFullName() === 'apostrophe:migrate')
    {
      self::migrate();
    }
  }
}
