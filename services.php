<?php

"""Метод GetListItems данного класса вернёт список(тип: CIBlockElement) элементов инфоблока. Данный метод не предусматривает кеширование."""
class IBlock1
{
    private $iblock_id;

    
    public function __construct(int $iblock_id){
        $this->$iblock_id = $iblock_id;
        CModule::IncludeModule('iblock');
    }

    function GetListItems(array $sort, array $filter, array $select){
        $list_items = CIBlockElement::GetList($sort, $filter, $select);
        return $list_items;
    }
}


"""Метод GetListItems данного класса вернёт список(тип: CIBlockElement) элементов инфоблока при отсутствии кеша, иначе список объектов CIBlockResult 
(Не нашёл путей реализации корректного кеширования объектов класса CIBlockElement)."""
class IBlock2
{
    private $iblock_id;
    private $cacheID;
    private $cacheLifeTime = 3600;
    private $cachePath = "/cache_iblocks/";

    
    public function __construct(int $iblock_id){
        
        $this->$iblock_id = $iblock_id;
        $this->$cacheID = (string)$iblock_id;
        CModule::IncludeModule('iblock');
    }

    public function GetListItems(array $sort, array $filter, array $select){
        $obCache = new CPHPCache;
        if($obCache->InitCache($this->$cacheLifeTime, $this->$cacheID, $this->$cachePath)){
            $arVars = $obCache->GetVars();
            $list_items = $arVars['list_items'];
        }
        elseif($obCache->StartDataCache()){
            $list_items = CIBlockElement::GetList($sort, $filter, $select);
            $obCache->EndDataCache(
                array('list_items' => $list_items)
            );
            
        }

        return $list_items;
    }
}


"""Метод GetListItems данного класса вернёт список элементов (массив ассоциативных массивов) вне зависимости от наличия кеша.
(Данный метод в 100% случаев выдаёт корректный резульат, но не полностью удовлетворяет условие: 'получение списка элементов инфоблока')"""
class IBlock3
{
    private $iblock_id;
    private $cacheID;
    private $cacheLifeTime = 3600;
    private $cachePath = "/cache_iblocks/";

    
    public function __construct(int $iblock_id){
        
        $this->$iblock_id = $iblock_id;
        $this->$cacheID = (string)$iblock_id;
        CModule::IncludeModule('iblock');
    }

    public function get_list_items(array $sort, array $filter, array $select){
        $obCache = new CPHPCache;
        
        if($obCache->InitCache($this->$cacheLifeTime, $this->$cacheID, $this->$cachePath)){
            $arVars = $obCache->GetVars();
            $list_items = $arVars['list_items'];
        }
        elseif($obCache->StartDataCache()){
            $list_items = CIBlockElement::GetList($sort, $filter, $select);
            $list_items = array();
            $count = 0;
        
            while($item = $list_elements->GetNextElement()){
                $list_items["$count"] = array(
                    'arFields' =>  $item->GetFields(),
                    'arProps' => $item->GetProperties()
                );
                $count++;
            }
        
            $obCache->EndDataCache(
                array('list_items' => $list_items)
            );
        }

        return $list_items;
    }
}

?>