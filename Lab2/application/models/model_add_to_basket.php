<?php 
	class Model_Add_to_basket extends Model
	{
		public function add_data($data)
		{	
			$count=Route::$routes[4];
			if(isset($data) and isset($count))
			{
				if(is_numeric($data) and is_numeric($count))
				{
					if(!isset($_SESSION['cart']))
						$_SESSION['cart']=array();
						
					foreach($_SESSION['cart'] as $item)
					{
						if($item[0]==$data)
						{
							$key = array_search ($item, $_SESSION['cart']);
							$item[1]=$item[1]+$count;
							$_SESSION['cart'][$key][1]=$item[1];
							return true;
						}
					}
							
					array_push($_SESSION['cart'] ,array($data,$count));
					return true;
				}
			}
			return false;
		}
		public function delete_data($data)
		{	
			if(isset($data))
			{
				if(is_numeric($data))
				{
					if(!isset($_SESSION['cart']))
						$_SESSION['cart']=array();
					foreach($_SESSION['cart'] as $item)
					{
						if($item[0]==$data)
						{
							$key = array_search ($item, $_SESSION['cart']);
							unset($_SESSION['cart'][$key]);
							return true;
						}
					}
				}
			}
			return false;
		}
	}
?>