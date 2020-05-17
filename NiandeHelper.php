<?php
namespace App\View\Helper;

use Cake\View\Helper;

class NiandeHelper extends Helper
{
  public function niande_e_waktu($date){
    return $this->niande($date).' '.$this->waktu($date);
  }

  public function waktu($date){

    //Heure
    $heures = $date->format('H');
    //Minutes
    $minutes = $date->format('i');

    return $heures.':'.$minutes;
  }

  public function niande($date){

    //extraire le jour
    $jour_en_lettres = $this->nialawma($date);
    //extraire la date (0-31)
    $jour = date('j',strtotime($date));
    // Extraire le Mois
    $mois = $this->lewru($date);
    //Extraire annéecho
    $annee = $date->format('Y');

    return $jour_en_lettres.' '.$jour.'-'.$mois.'-'.$annee;
  }

  public function nialawma($date){
        $nialawma = date('l',strtotime($date));
    switch($nialawma)
    {
      case 'Monday': return'Aaɓnde';
      case 'Tuesday': return'Mawbaare';
      case 'Wednesday': return'Njeslaare';
      case 'Thursday': return'Naasaande';
      case 'Friday': return'Mawnde';
      case 'Saturday': return'Hoore-biir';
      case 'Sunday': return'Dewo hoore-biir';
      default : return 'mi anndaa' ;
    }
  }

  public function lewru($date){
        $lewru = date('F',strtotime($date));
    switch($lewru)
    {
      case 'January': return'siilo';
      case 'February': return'colite';
      case 'March': return'mbooy';
      case 'April': return'seeɗto';
      case 'May': return'duuƴal';
      case 'June': return'korse';
      case 'July': return'morso';
      case 'August': return'juko';
      case 'September': return'silto';
      case 'October': return'yarkoma';
      case 'November': return'jolal';
      case 'December': return'bowte';
      default : return 'mi anndaa' ;
    }
  }
}
