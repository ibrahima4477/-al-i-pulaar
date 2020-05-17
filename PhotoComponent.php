<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Http\ServerRequest;

class PhotoComponent extends Component
{

  public function skip_chars($texte){
    $texte = strip_tags($texte);
    $texte = strtolower($texte);

    $texte = strtr($chaine, 'ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ', 'aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn');
    $texte = preg_replace('`[^a-z0-9-]+`', '-', $texte);
    $texte = preg_replace('`-{2,}`', '-', $texte);
    $texte = trim($texte, '-');

    return $texte;
  }
  public function photo($rep,$var,$image=null)
  {
    //-----------------------------------------------------------------------------------------
    //Les photos
    $action = $this->request->getParam('action');
    //debug($action); die();
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

    if ($action == 'edit') {

      if(!is_dir('img/'.$rep)){
        mkdir('img/'.$rep);
      }
      //$image = $this->request->getData();
      //$id = $this->request->getParam('pass');
      //$image = $this->$var->get($id);
      //debug($id); die();
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


    if ($action == 'delete') {
      $extension_photo = pathinfo($var->image, PATHINFO_EXTENSION);
      if (!empty($extension_photo) && is_file(WWW_ROOT.'img/'.$var->image)) {
        unlink(WWW_ROOT.'img/'.$var->image);
      }
    }
  }

  public function mois($month){
    $months = array(
      1   =>  'Janvier',
      2   =>  'Fevrier',
      3   =>  'Mars',
      4   =>  'Avril',
      5   =>  'Mai',
      6   =>  'Juin',
      7   =>  'Juillet',
      8   =>  'Aout',
      9   =>  'Septembre',
      10  =>  'Octobre',
      11  =>  'Novembre',
      12  =>  'Decembre'
    );
    return $months[$month];
  }
  public function typename($key){
    if ($key == 1) {
      $type = 'preventive';
      return $type;
    }
  }

}
