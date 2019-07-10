<?php
namespace common\models;
use yii;
use yii\web\Controller;


//функция удаления файла из папки
function deleteFile($directory,$filename) 
{ 
  $dir = opendir($directory);  //открытие директории
  // считываем содержание директории 
while(($file = readdir($dir))) 
{ 
  if((is_file("$directory/$file")) && ("$directory/$file" == "$directory/$filename")) 
  {  
    unlink("$directory/$file"); //удаление файла
    if(!file_exists($directory."/".$filename)) return $s = TRUE; //файл удален
  } 
}  
  closedir($dir); //закрытие директории
}

?>
