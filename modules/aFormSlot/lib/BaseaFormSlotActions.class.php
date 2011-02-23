<?php

/**
 * Base actions for the apostropheFormBuilderPlugin aFormSlot module.
 * 
 * @package     apostropheFormBuilderPlugin
 * @subpackage  aFormSlot
 * @author      Alex Gilbert
 * @version     SVN: $Id: BaseActions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
abstract class BaseaFormSlotActions extends BaseaSlotActions
{
  public function executeEdit(sfRequest $request)
  {
    $this->editSetup();
    error_log("entering");
    if (!$a_form = Doctrine::getTable('aForm')->find($this->slot->form_id))
    {
      $a_form = new aForm();
    }

    $value = $this->getRequestParameter('slot-form-' . $this->id);
    
    $this->form = new aFormForm($this->id, $a_form);
	  $this->form->bind($value);

	  if (!$this->form->isValid())
	  {
	    error_log("editRetry");
      return $this->editRetry();
	  }
    error_log("saving");
    $a_form = $this->form->save();

    if (!$this->slot->form_id)
    {
      $this->slot->form_id = $a_form->getId();
    }
    
    return $this->editSave();
  }
  
  public function executeEditForm(sfRequest $request)
  {
    $a_form = $request->getParameter('a_form');
    
    $this->a_form = Doctrine::getTable('aForm')->find($a_form['id']);
    
    $this->a_form_form = new aFormForm($this->a_form);
    
    $this->a_form_form->bind($a_form);
    
	  if ($this->a_form_form->isValid())
	  {
      $this->a_form_form->save();
	  }

    return $this->renderComponent('aForm', 'aFormEdit', array('a_form' => $this->a_form, 'a_form_form' => $this->a_form_form));
  }
  
  public function executeAddField(sfRequest $request)
  {
    $this->a_form_fieldset = new aFormFieldset();
    $this->form = new aFormFieldsetForm($this->a_form_fieldset);

    $a_form_fieldset = $request->getParameter($this->form->getName());
	  $this->form->bind($a_form_fieldset);
    
    $this->a_form = Doctrine::getTable('aForm')->find($a_form_fieldset['form_id']);

	  if ($this->form->isValid())
	  {
      $this->a_form_fieldset = $this->form->save();
	  }

    return $this->renderComponent('aForm', 'aFormEdit', array('a_form' => $this->a_form, 'a_form_fieldset_form' => $this->form));
  }

  public function executeShowField(sfRequest $request)
  {
    $this->a_form_fieldset = Doctrine::getTable('aFormFieldset')->find($request->getParameter('id'));

    return $this->renderPartial('aForm/aFormFieldsetEdit', array('a_form_fieldset' => $this->a_form_fieldset));
  }

  public function executeEditField(sfRequest $request)
  {
    $this->a_form_fieldset = Doctrine::getTable('aFormFieldset')->find($request->getParameter('id'));
    
    $this->form = new aFormFieldsetForm($this->a_form_fieldset);

    return $this->renderPartial('aForm/aFormFieldsetForm', array('a_form_fieldset' => $this->a_form_fieldset, 'a_form_fieldset_form' => $this->form));
  }

  public function executeDeleteField(sfRequest $request)
  {
    $this->a_form_fieldset = Doctrine::getTable('aFormFieldset')->find($request->getParameter('id'));
    
    $this->a_form_fieldset->delete();

    return $this->renderPartial('aForm/aFormFieldsetForm', array('a_form_fieldset' => $this->a_form_fieldset, 'a_form_fieldset_form' => $this->form));
  }
  
  public function executeUpdateField(sfRequest $request)
  {
    $a_form_fieldset = $request->getParameter('a_form_fieldset');

    $this->a_form_fieldset = Doctrine::getTable('aFormFieldset')->find($a_form_fieldset['id']);
    
    $this->form = new aFormFieldsetForm($this->a_form_fieldset);
	  $this->form->bind($a_form_fieldset);

	  if ($this->form->isValid())
	  {
      $this->a_form_fieldset = $this->form->save();
      
      return $this->renderPartial('aForm/aFormFieldsetEdit', array('a_form_fieldset' => $this->a_form_fieldset));
	  }

    return $this->renderPartial('aForm/aFormFieldsetForm', array('a_form' => $this->a_form, 'a_form_fieldset' => $this->a_form_fieldset, 'a_form_fieldset_form' => $this->form));
  }

  public function executeEditFieldOptions(sfRequest $request)
  {
    $this->a_form_fieldset = Doctrine::getTable('aFormFieldset')->find($request->getParameter('field_id'));
    
    $this->form = $this->a_form_fieldset->getOptionsForm();
    
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('option_list'));
      
      if ($this->form->isValid())
      {
        $this->form->save();
      }
    }

    $field = Doctrine::getTable('aFormFieldset')
      ->createQuery('f')
      ->where('f.id = ?', $this->a_form_fieldset->getId())
      ->leftJoin('f.aFormFieldsetOptions')
      ->fetchOne();
    
    return $this->renderPartial('aForm/aFormFieldsetEdit', array('a_form_fieldset' => $field));
  }
  
  public function executeSortFields(sfRequest $request)
  {
    Doctrine::getTable('aFormFieldset')->doSort($request->getParameter('a-form-field'));
    
    return sfView::NONE;
  }
  
  public function executeSubmit(sfRequest $request)
  {
    $form = $request->getParameter('form');
    
    $a_form = Doctrine::getTable('aForm')->find($form['form_id']);
        
    $this->form = $a_form->buildForm();
    
    $this->form->bind($request->getParameter('form'));
    
    if ($this->form->isValid())
    {
      $this->submission = $this->form->save();

      if ($a_form->getEmailTo())
      {
  			try
  			{
  			  $message = $this->getMailer()->compose(
                sfConfig::get('app_aForm_from'),
                $affiliate->getEmail(),
                'Jobeet affiliate token',
                <<<EOF
          Your Jobeet affiliate account has been activated.

          Your token is {$affiliate->getToken()}.

          The Jobeet Bot.
          EOF
              );

              $this->getMailer()->send($message);
          
  			  // Create the mailer and message objects
  			  $mailer = new Swift(new Swift_Connection_NativeMail());
  			  $message = new Swift_Message($a_form->getName().' Submission');

  			  // Render message parts
  			  $message->attach(new Swift_Message_Part($this->getComponent('aForm', 'submitEmail', array('a_form' => $a_form, 'form' => $this->form, 'submission' => $this->submission)), 'text/plain'));

  			  // Send
  			  $mailer->send($message, $a_form->getEmailTo(), sfConfig::get('app_aFormBuilder_from_address', 'noreply@trinity.duke.edu'));
  			  $mailer->disconnect();
  			}
  			catch (Exception $e)
  			{
  			  $mailer->disconnect();

  				$this->logMessage('Request email failed: '. $e->getMessage(), 'err');
  			}

        $this->form = $a_form->buildForm();
      }

      return $this->renderPartial('aForm/aFormView', array('a_form' => $a_form, 'form' => $this->form, 'submitted' => true));
    }
    
    return $this->renderPartial('aForm/aFormView', array('a_form' => $a_form, 'form' => $this->form));
  }
}
