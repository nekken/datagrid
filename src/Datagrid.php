<?php
namespace Nekken\Datagrid;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
class Datagrid
{
    protected $columns;
    protected $generatedRows;
    protected $data;
    
    public function __construct()
    {
        $this->columns = new ArrayCollection();
        $this->generatedRows = new ArrayCollection();
        $this->data = new ArrayCollection();
    } 
    
    public function getColumns () 
    { 
        return $this->columns;
    }
    
	/**
     * @return the $dataRows
     */
    public function getData ()
    {
        return $this->data;
    }

	/**
     * @param field_type $dataRows
     */
    public function setData ($data)
    {
        if(!$data instanceof Collection)
        {
            throw new \Exception("Data must implement Doctrine\\Common\\Collections\\Collection interface");
        }
        $this->data = $data; 
        return $this;
    }
    
    public function generateRows($force=false)
    {
        if($this->generatedRows != null && !$force)
        {
            return $this;
        }elseif($this->generatedRows != null)
        {
            throw new \Exception("Rows already generated! Set force parameter to true to re-generate rows");
        }
        
        $generatedRows = new ArrayCollection();
        
        foreach($this->getData() as $dataRow)
        {
            $generatedColumn = new ArrayCollection();
            
            foreach($this->getColumns() as $column)
            {  
                /* @var $column Column */
                $value = $column->getValue($this,$dataRow);
                $generatedColumn->add($value);
            }
            
            $generatedRows->add($generatedColumn);
        }
        
        $this->generatedRows = $generatedRows;
        
        return $this;
    }
    
	/**  
     * @return the $generatedRows
     */
    public function getGeneratedRows ()
    {
        return $this->generatedRows;
    }
 

}