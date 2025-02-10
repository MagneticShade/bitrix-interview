<?php
use function Facebook\WebDriver\getData;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/scrap.php");

function UpdateNews()
{
	if(CModule::IncludeModule("iblock"))
	{
		$arSelect = Array("ID", "NAME","PREVIEW_TEXT","DETAIL_PICTURE","DETAIL_TEXT" );
		$rsResCat = CIBlockElement::GetList(arSelectFields: $arSelect);
		$arItems = array();
		while($arItemCat = $rsResCat->GetNext())
		{
			$arItems[] = $arItemCat;
		}

        foreach($arItems as $item){
        
            CIBlockElement::Delete($item["ID"]);
        }

        $array = getData();
        foreach($array as $newEl){
            $el = new CIBlockElement();
            $el->Add(arFields: ["IBLOCK_ID" => 9,"ACTIVE" => 'Y',"NAME"=>$newEl["NAME"],"PREVIEW_TEXT"=>$newEl["PREVIEW_TEXT"]]);
        }

	}
	return "UpdateNews();";
}



?>