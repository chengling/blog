<?php
namespace Apps\Common\Lib;
class Page{
	public $page;
	/**
	 * 
	 * @param int $currentPage当前页
	 * @param int $totalPage 总页数
	 */
	public function __construct($currentPage,$totalPage){
		$currentPage=intval($currentPage)+0;
		$currentPage<1?1:$currentPage;
		$currentPage>$totalPage?$totalPage:$currentPage;
		$start=($currentPage<5)?1:$currentPage-3;
		$self=$_SERVER['REDIRECT_URL'];
		$this->page.='<a href="'.$self.'?page=1">首页</a>';
		if($currentPage==1){
			$this->page.='上一页';
		}else{
			$this->page.='<a href="'.$self.'?page='.($currentPage-1).'">上一页</a>';
		}
		$end=$start+9;
		$end=$end>$totalPage?$totalPage:$end;
		$start=(($end-$start)<9?$end-9:$start)<1?1:(($end-$start)<9?$end-9:$start);
		for(;$start<=$end;$start++){
			if($start==$currentPage){
				$this->page.='<a style="color:red" href="'.$self.'?page='.($start).'">['.$start.']</a>';
			}else{
				$this->page.='<a href="'.$self.'?page='.($start).'">['.$start.']</a>';
			}
		}
		if($currentPage==$totalPage){
			$this->page.='下一页';
		}else{
			$this->page.='<a href="'.$self.'?page='.($currentPage+1).'">下一页</a>';
		}
		$this->page.='<a href="'.$self.'?page='.$totalPage.'">尾页</a>';
		
	}
}