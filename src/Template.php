<?php
namespace VictorYoalli\LaravelCodeGenerator;

class Template {

  public static function structure($dir,$files=[],$output=''){
    $output = $output;
    // print "OUT: ".$output."\n";
      // echo $dir."\n";
      $ffs = scandir($dir);

      unset($ffs[array_search('.', $ffs, true)]);
      unset($ffs[array_search('..', $ffs, true)]);

      // ($ffs);

      // prevent empty ordered elements
      if (count($ffs) < 1)
          return;

      foreach($ffs as $ff){
          if(is_dir($dir.'/'.$ff)){
            // print "inner=>\n".$dir."\n";
            $output = $output.DIRECTORY_SEPARATOR.$ff.DIRECTORY_SEPARATOR;
            $files[$ff] = self::structure($dir.DIRECTORY_SEPARATOR.$ff,$files,$output);
          }
          else {
            $files[$ff]=$output.$ff;
          }
      }
      return $files;

  }
  // dirTree('Main Dir');

}