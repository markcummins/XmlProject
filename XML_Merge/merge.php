 <?php

$docA = new DOMDocument("1.0", 'UTF-8');
$docA->formatOutput = true;
$docA->preserveWhiteSpace = false;
$docA->Load($file1)or die ( "Can't Open File: $file1" );
$xpathA = new DOMXPath($docA);

$docB = new DOMDocument("1.0", 'UTF-8');
$docB->Load($file2)or die ( "Can't Open File: $file2" );
$xpathB = new DOMXPath($docB);


    $stringNameB = $docB->getElementsByTagName('string');

        foreach ($stringNameB as $stringName_B) {
             $NameB = $stringName_B->getAttribute('name');

             $q = '//resources/string[@name="'.$NameB.'"]';
             $stringNameA = $xpathA->query($q);

                    if($stringNameA->length > 0){
                        
                              foreach ($stringNameA as $stringName_A) {
                                  
                                  $StringA = innerXML($stringName_A);
                                  $StringB = innerXML($stringName_B);


                                       if ( strcmp ( $StringA, $StringB) != 0  ){

                                          $fullNameB =  $docA->saveXML($stringName_A);        
                                          $node = $docA->importNode($stringName_B, true);
                                          $stringName_A->parentNode->replaceChild($node, $stringName_A);
                                          $docA->saveXML();     
                                        }
                              }
                    }
                    else {
                        $StringB = innerXML($stringName_B);
                        
                        $fullNameB =  $docB->saveXML($stringName_B);
                        $f = $docA->createDocumentFragment();
                        $f->appendXML($fullNameB);
                        $docA->documentElement->appendChild($f);
                        $docA->saveXML();
                        
                    }
             }  

        $fh = fopen( $file1, 'w') or die ( "Can't Write File: $file1" );
        fwrite( $fh, $docA->saveXML() );
        echo "<br><br><br><br><b>Success, <u>". $_FILES["file"]["name"] ."</u> has been Merged with <u>". $filetype ."</u></b><br><br>";
	fclose( $fh );

        function innerXML($node) 
          { 
              $doc = $node->ownerDocument; 
              $frag = $doc->createDocumentFragment(); 

                  foreach ($node->childNodes as $child) { 
                      $frag->appendChild($child->cloneNode(TRUE));         
                  } 
              return $doc->saveXML($frag); 
          }           