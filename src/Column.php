<?php
namespace Nekken\Datagrid;

interface Column
{
    public function getValue(Datagrid $datagrid, $dataRow);
}