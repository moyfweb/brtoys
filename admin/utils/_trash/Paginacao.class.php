<?
/**
* @class 			Paginacao
* @description		This class is meant to present the records of a database query split between multiple pages	
* @autor			Olavo Alexandrino
* @contact  		oalexandrino@yahoo.com.br
* @country  		BRAZIL, RECIFE - PE
* @date				2003,January
* @ps				Class Paginacao is tested using Class ADODB (http://php.weblogs.com/adodb#downloads)
* @dataBaseTested	MySQL version 3.23.56-nt, Microsoft SQL Server 2000 and Microsoft Access 2002 (using Class ADODB)
*/
Class Paginacao
{
	public $model;
	public $getsVars;
	public $recordByPage;
	public $PagesFound;
	public $totalRecords;
	public $currentPage;
	public $msg_initialPage;
	public $msg_finalPage;	
	public $msg_previousPage;
	public $msg_nextPage;
	public $msg_next10Results;
	public $msg_previous10Results;	
	public $msg_page;
	public $msg_of;
	public $msg_even;
	public $gets = array();

   	/**
    * Setting Language, Current Page and Records by Page
	* Language Default: Brazilian Portuguese
	* @access public
    */
	public function Paginacao($model,$recordByPage)
	{
		$this->gets = $_GET;
		$this->model = $model;
		$this->currentPage =  isset($this->gets['page']) ? $this->gets['page'] : 1;
		$this->recordByPage = $recordByPage;
		$this->totalRecords = $model->sqlb->total();
		if($this->totalRecords % $this->recordByPage != 0 && $this->totalRecords != 0):
			$this->PagesFound = (($this->totalRecords - ($this->totalRecords % $this->recordByPage))/$this->recordByPage)+1;
		else:
			$this->PagesFound = $this->totalRecords/$this->recordByPage;
		endif;
		
		$limit_start = ($this->currentPage-1) * $this->recordByPage;
		$this->model->sqlb->limit = 'LIMIT '.$limit_start.','.$this->recordByPage;

		$this->msg_initialPage  = "Página Inicial";
		$this->msg_finalPage    = "Página Final";
		$this->msg_previousPage = "Anterior";
		$this->msg_nextPage	    = "Próxima";
		$this->msg_next10Results = "Próximas 10 páginas";
		$this->msg_previous10Results = "10 Páginas anteriores";
		$this->msg_page		    = "Ir para Página";
		$this->msg_of		     = "De";
		$this->msg_to		     = "a";

	}


	
	public function getParams()	{  	return http_build_query($this->gets); }
	
	public function addGetParams($key,$value)
	{
		$this->gets = array_merge($this->gets,array($key=>$value));
		return http_build_query($this->gets);
	}
	
   	/**
    * Outputs the total number of pages
	* @access 	public
    */
	public function getPagesFound()
	{
		return $this->PagesFound;
	}

   	/**
    * Outputs the Navigation links
	* @access 	public
    */
	public function linkPrev($show=true)
	{
		if($this->currentPage > 1)
			return '<li class="prev"><a href="?'.$this->addGetParams('page',$this->currentPage-1).'">'.$this->msg_previousPage.'</a></li>';
		else if($show)
			return '<li class="prev"><span >'.$this->msg_previousPage.'</span></li>';
		else
			return '';
	}

   	/**
    * Outputs the Navigation links
	* @access 	public
    */
	public function linkNext($show=true)
	{
		if($this->currentPage < $this->PagesFound )
			return '<li class="next"><a href="?'.$this->addGetParams('page',$this->currentPage+1).'">'.$this->msg_nextPage.'</a></li>';
		else if($show)
			return '<li class="next"><span>'.$this->msg_nextPage.'</span></li>';
		else
			return '';
	}
	
   	/**
    * Outputs Navigation records list based in current page
	* @access 	public
    */
	public function getCurrentPages()
	{
		$result='';
		$totalRecordsControl = $this->totalRecords;
		if (($totalRecordsControl%$this->recordByPage!=0)):
			while($totalRecordsControl%$this->recordByPage!=0):
				$totalRecordsControl++;
			endWhile;
		endif;
		$ultimo = substr($this->currentPage,-1);  
		if ($ultimo == 0):
			$begin = ($this->currentPage-9);
			$pageInicial = ($this->currentPage - $ultimo);
			$end = $this->currentPage;			
		else:
			$pageInicial = ($this->currentPage - $ultimo);			
			$begin = ($this->currentPage-$ultimo)+1;
			$end = $pageInicial+10;				
		endif;
		$num = $this->PagesFound;
		if ($end>$num):
		    $end = $num; 
		endif;
		for ($a = $begin; $a <= $end ; $a++):
			if ($a!=$this->currentPage):
				$result .= "<li class='pag'><a href='?".$this->addGetParams('page',$a)."' title='".$this->msg_page.": $a'>$a</a></li>";
			else:
				$result .= "<li class='pag ativo'>$a</li>";		
			endif;
		endfor;	
		return $result;
	}

   	/**
    * Outputs the records list based in current page
	* @access 	public
    */
	public function getListCurrentRecords()
	{
		$regFinal = $this->recordByPage * $this->currentPage;
		$regInicial = $regFinal - $this->recordByPage;
		if ($regInicial == 0): 
			$regInicial++; 
		endif;
		if ($this->currentPage == $this->PagesFound): 
			$regFinal = $this->totalRecords; 
		endif;	
		if ($this->currentPage > 1):  
			$regInicial++; 
		endif;
		$result = $this->msg_of." <font class='paginacao_color'>$regInicial</font> ".$this->msg_to." <font class='paginacao_color'>$regFinal</font>";
		return $result;
	}

   	/**
    * Outputs the links for browsing from 1 to 10, 11 to 20, 21 to 30, and so forth
	* @access 	public
    */
	public function getNavigationGroupLinks()
	{
			$result='';
			if (($this->currentPage <= 10) && ($this->PagesFound >= 1)):
				$end = 11;
			else:
				$last  = substr($this->currentPage,-1);  
				$first = substr($this->currentPage,0,1);
				if ($last != 0):
					$aux1  = $first + 1;
					$aux1  = $aux1."0";
					$aux1  = ($aux1 - $this->currentPage)+1;
					$end   = $this->currentPage + $aux1;
				else:
					$end  = $this->currentPage + 1;
				endif;
				$begin = $end - 20;				
			endif;
			if ( !(($this->currentPage>= 1)&&($this->currentPage<=10)) ):
				$result  = "<a href='?page=".($begin)."&".$this->getsVars."' title='".$this->msg_previous10Results."' onMouseOver=\"window.status='".$this->msg_previous10Results."';return true\" onMouseOut=\"window.status='';return true\" class = paginacao>".$this->msg_previous10Results."</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; 
			endif;
			if ($end <= $this->PagesFound):
				$result .= " <a href='?page=".($end)."&".$this->getsVars."'  title='".$this->msg_next10Results."' onMouseOver=\"window.status='".$this->msg_next10Results."';return true\" onMouseOut=\"window.status='';return true\" class = paginacao>".$this->msg_next10Results."</a>";
			endif;
			return $result;
	}
}