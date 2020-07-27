<?php 
// """Наработка очистки строки от мусора"""
// function GetClearString(string $currentString){
  //   $position = 0;
  //   // echo "Start string: $currentString\n";
  //   $count = 0;
  //   while (true){
  //     $resultStart = strpos($currentString, '<', $position);
  //     // echo "Result start $resultStart\n";
  //     if (is_int($resultStart)){
  //       $position = $resultStart + 1;
  //       // echo "Current position: $position\n";
  //       $resultEnd = strpos($currentString, '>', $position);
  //       // echo "Result end: $resultEnd\n";
  //       if(is_int($resultEnd)){
  //         $position = $resultEnd;
  //         $tempString = substr($currentString, $resultStart, $resultEnd);
  //         // echo "Temp string: $tempString";
  //         $currentString = str_replace($tempString, '', $currentString);
  //         // echo "Current string: $currentString";
  //       }
  //       else{
  //         break;
  //       }
        
  //     }else{
  //       break;
  //     }
  //   }
  //     return $currentString;
  // }


?>


<?php
  function printArticle(SimpleXMLElement $item){
    echo 'Заголовок: ' . $item->title;
    echo "\n";
    echo 'Ссылка: ' . $item->link;
    echo "\n";
    echo 'Анонс: ' . $item->description;
  }


  $url = "https://habr.com/ru/rss/all/all/";
  $xml = simplexml_load_file($url);
  $counter = 0;
  $articles = array();

  foreach($xml->channel->item as $item){
    $articles[] = $item;
  }

  for($i = count($articles) - 1; $i > count($articles) - 6; $i--){
    echo "\n\nСтатья " . (string)($i + 1) . ":\n\n";
    printArticle($articles[$i]);
  }

?>