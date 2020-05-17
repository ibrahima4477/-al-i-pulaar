<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Http\ServerRequest;

class PhotoComponent extends Component
{

  public function photo($rep,$var,$image=null)
  {
    //-----------------------------------------------------------------------------------------
    //Les photos
    $action = $this->request->getParam('action');
    //Add actions
    if (in_array($action, array(
      'add',
      'addArticleComment',
      'addCommentQuestion',
      'addCommentProject',
      'addCommentIdea',
      'addCarousel',
      'addCommentRadio',
      'addCommentPodcast',
      'addCommentProcedure'
    )) ) {
      if(!is_dir('img/'.$rep)){
        mkdir('img/'.$rep);
      }
      $natal = rand(1, 100000000000000);
      $extension = strtolower(pathinfo($this->request->data['image']['name'], PATHINFO_EXTENSION));
      if (!empty($this->request->data['image']['tmp_name']) && in_array($extension, array('jpg', 'jpeg', 'png', 'gif'))) {
        move_uploaded_file($this->request->data['image']['tmp_name'], WWW_ROOT . 'img' . DS . $rep .DS. $natal . '.' . $extension);
        //$photo = WWW_ROOT . 'img' . DS . $rep . DS . $natal . '.' . $extension;
        $var->image = $rep .'/'.$natal . '.' . $extension;
        //debug($var->image); die();
      }
      if (empty($var->image)) {
        $var->image = 'no-avatar.png';
      }

    }
    
//Edit actions
    if ($action == 'edit') {
      
      if(!is_dir('img/'.$rep)){
        mkdir('img/'.$rep);
      }

      if ($var->image!=null && $var->image!='no-avatar.png') {
        unlink(WWW_ROOT.'img/'.$var->image);
      }
      $natal = rand(1, 100000000000000);
      $extension = strtolower(pathinfo($this->request->data['image']['name'], PATHINFO_EXTENSION));
      if (!empty($this->request->data['image']['tmp_name']) && in_array($extension, array('jpg', 'jpeg', 'png', 'gif'))) {
        move_uploaded_file($this->request->data['image']['tmp_name'], WWW_ROOT . 'img' . DS . $rep . DS . $natal . '.' . $extension);
        //$photo = WWW_ROOT . 'img' . DS . $rep . DS . $natal . '.' . $extension;
        $var->image = $rep .'/'.$natal . '.' . $extension;
        //supprimer l'ancienne image

      }
       else{
        $var->image=$image;
      }
    }

//Delete actions
    if ($action == 'delete') {
      $extension_photo = pathinfo($var->image, PATHINFO_EXTENSION);
      if (!empty($extension_photo) && is_file(WWW_ROOT.'img/'.$var->image)) {
        unlink(WWW_ROOT.'img/'.$var->image);
      }
    }
  }

}
