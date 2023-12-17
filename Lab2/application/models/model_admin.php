<?php

class Model_Admin extends Model
{
	private static $PDO;
	public function __construct()
	{
		require_once "application/core/constant.php";
		Model_Admin::$PDO = new PDO ("mysql:dbname=".dbname.";host=".dbhost,dbuser,dbpass);
	}
	
	
	public function delete($id)
	{	
		$title = Route::$routes[4];
		$title = str_replace("-"," ",$title);
		$select="DELETE FROM `tovar` WHERE id = :id AND title = :title";
		$PDOStatement = Model_Admin::$PDO->prepare($select);
		$PDOStatement->bindParam(':id', $id, PDO::PARAM_INT);
		$PDOStatement->bindParam(':title', $title, PDO::PARAM_STR);
		$PDOStatement->execute();
	}
	public function get_data($data = null)
	{	
		$select="SELECT id, title, description, cost_price as price FROM tovar ORDER BY id DESC";
		$PDOStatement = Model_Admin::$PDO->prepare($select);
		$PDOStatement->execute();
		return $PDOStatement->fetchAll(PDO::FETCH_BOTH);
	}
	
	public function get_tovar($id)
	{
		$title = Route::$routes[4];
		$title = str_replace("-"," ",$title);
		$select= "SELECT *  FROM tovar where id= :id and title LIKE :title";
		$PDOStatement = 	Model_Admin::$PDO->prepare($select);
		$PDOStatement->bindParam(':id', $id, PDO::PARAM_INT);
		$PDOStatement->bindParam(':title', $title, PDO::PARAM_STR);
		$PDOStatement->execute();
		
		return $PDOStatement->fetch(PDO::FETCH_BOTH);
	}
	public function set_tovar($tovar)
	{
		$select="SELECT id FROM tovar where id = :id";
		$PDOStatement = Model_Admin::$PDO->prepare($select);
		$PDOStatement->bindParam(':id', $tovar['id'], PDO::PARAM_INT);
		$PDOStatement->execute();
		$id = $PDOStatement->fetch();
		if(isset($id))
		{
			$cats=Model_Admin::get_categories($id['id']);
			
			foreach($cats as $cat)
			{
				$key=array_search ($cat[0], $tovar['categories']);
				if(!is_int($key))
				{
					$select="DELETE FROM tovar_category WHERE idtov = :tovar AND idcat = :cat";
					$PDOStatement = Model_Admin::$PDO->prepare($select);
					$PDOStatement->bindParam(':tovar', $id['id'], PDO::PARAM_INT);
					$PDOStatement->bindParam(':cat', $cat[0], PDO::PARAM_INT);
					$PDOStatement->execute();
				}
				unset($tovar['categories'][$key]);
			}
			foreach($tovar['categories'] as $cat)
			{
				$select="INSERT INTO tovar_category(idtov, idcat) VALUES ( :tovar , :cat )";
				$PDOStatement = Model_Admin::$PDO->prepare($select);
				$PDOStatement->bindParam(':tovar', $id['id'], PDO::PARAM_INT);
				$PDOStatement->bindParam(':cat', $cat, PDO::PARAM_INT);
				$PDOStatement->execute();
			}
			
			$allowedExts = array("gif", "jpeg", "jpg", "png");
			$temp = explode(".", $_FILES["file"]["name"]);
			$extension = end($temp);
			if ((($_FILES["file"]["type"] == "image/gif")
			|| ($_FILES["file"]["type"] == "image/jpeg")
			|| ($_FILES["file"]["type"] == "image/jpg")
			|| ($_FILES["file"]["type"] == "image/pjpeg")
			|| ($_FILES["file"]["type"] == "image/x-png")
			|| ($_FILES["file"]["type"] == "image/png"))
			&& ($_FILES["file"]["size"] < 50000)
			&& in_array($extension, $allowedExts))
  			{
  				if ($_FILES["file"]["error"] == 0)
  				{
  					$tmpName = $_FILES['file']['tmp_name'];
					$fp = fopen($tmpName, 'r');
					$data = fread($fp, filesize($tmpName));
					print_r($tmpName);
					fclose($fp);
					$select="UPDATE tovar SET photo=:file WHERE id = :id";
					$PDOStatement = Model_Admin::$PDO->prepare($select);
					$PDOStatement->bindParam(':id', $id['id'], PDO::PARAM_INT);
					$PDOStatement->bindParam(':file', $data, PDO::PARAM_INT);
					$res = $PDOStatement->execute();
  				}
  			}
			
				$select="UPDATE tovar SET title=:title,".
						  "description=:description,price=:price,".
						  "cost_price=:cost_price WHERE id=:id";
				$PDOStatement = Model_Admin::$PDO->prepare($select);
				$PDOStatement->bindParam(':id', $id['id'], PDO::PARAM_INT);
				$PDOStatement->bindParam(':title', $tovar['title'], PDO::PARAM_STR);
				$PDOStatement->bindParam(':description', $tovar['description'], PDO::PARAM_STR);
				
				if (!preg_match("/\d+(.\d{1,2})?/",$tovar['price']))
					$tovar['price']=0;
				$PDOStatement->bindParam(':price', $tovar['price'], PDO::PARAM_STR);
				
				if (!preg_match("/\d+(.\d{1,2})?/",$tovar['cost_price']))
					$tovar['cost_price']=0;
				$PDOStatement->bindParam(':cost_price', $tovar['cost_price'], PDO::PARAM_STR);
				
				$res = $PDOStatement->execute();
					return $res;
		}
		return false;
	}
	public function add_tovar($tovar)
	{
		$select="UPDATE tovar SET title=:title,".
				  "description=:description,price=:price,".
				  "cost_price=:cost_price WHERE id=:id";
				  
		$select ="INSERT INTO `tovar`(`title`, `description`, `price`, `cost_price`)".
					" VALUES (:title,:description,:price,:cost_price)";
		$PDOStatement = Model_Admin::$PDO->prepare($select);
		$PDOStatement->bindParam(':title', $tovar['title'], PDO::PARAM_STR);
		$PDOStatement->bindParam(':description', $tovar['description'], PDO::PARAM_STR);
				
		if (!preg_match("/\d+(.\d{1,2})?/",$tovar['price']))
			$tovar['price']=0;
		$PDOStatement->bindParam(':price', $tovar['price'], PDO::PARAM_STR);
				
		if (!preg_match("/\d+(.\d{1,2})?/",$tovar['cost_price']))
			$tovar['cost_price']=0;
		$PDOStatement->bindParam(':cost_price', $tovar['cost_price'], PDO::PARAM_STR);
				
		$res = $PDOStatement->execute();
		$id = Model_Admin::$PDO->lastInsertId();
		foreach($tovar['categories'] as $cat)
		{
			$select="INSERT INTO tovar_category(idtov, idcat) VALUES ( :tovar , :cat )";
			$PDOStatement = Model_Admin::$PDO->prepare($select);
			$PDOStatement->bindParam(':tovar', $id, PDO::PARAM_INT);
			$PDOStatement->bindParam(':cat', $cat, PDO::PARAM_INT);
			$PDOStatement->execute();
		}
		
			$allowedExts = array("gif", "jpeg", "jpg", "png");
			$temp = explode(".", $_FILES["file"]["name"]);
			$extension = end($temp);
			
			if ((($_FILES["file"]["type"] == "image/gif")
			|| ($_FILES["file"]["type"] == "image/jpeg")
			|| ($_FILES["file"]["type"] == "image/jpg")
			|| ($_FILES["file"]["type"] == "image/pjpeg")
			|| ($_FILES["file"]["type"] == "image/x-png")
			|| ($_FILES["file"]["type"] == "image/png"))
			&& ($_FILES["file"]["size"] < 50000)
			&& in_array($extension, $allowedExts))
  			{
  				if ($_FILES["file"]["error"] == 0)
  				{
  					$tmpName = $_FILES['file']['tmp_name'];
					$fp = fopen($tmpName, 'r');
					$data = fread($fp, filesize($tmpName));
					fclose($fp);
					$select="UPDATE tovar SET photo=:file WHERE id = :id";
					$PDOStatement = Model_Admin::$PDO->prepare($select);
					$PDOStatement->bindParam(':id', $id, PDO::PARAM_INT);
					$PDOStatement->bindParam(':file', $data, PDO::PARAM_INT);
					$res = $PDOStatement->execute();
					echo "-->$res<--";
					print_r($PDOStatement->errorInfo());
  				}
  			}
	}
	public static function get_photo($id)
	{
		$select="SELECT photo FROM tovar where id = :id";
		$PDOStatement = Model_Admin::$PDO->prepare($select);
		$PDOStatement->bindParam(':id', $id, PDO::PARAM_INT);
		$PDOStatement->execute();
		$photo = $PDOStatement->fetch();
		return "<img alt='##title##' id='photo' title='##title##' src='data:image/*;base64,".base64_encode($photo['photo'])."' />";
	}
	public static function get_categories($id=null)
	{
		if(!isset($id))
		{
			$select="SELECT * FROM category";
			$PDOStatement = Model_Admin::$PDO->prepare($select);
		}
		else
		{
			$select="SELECT id FROM category LEFT JOIN  tovar_category ON category.id = tovar_category.idcat where tovar_category.idtov = :id";
			$PDOStatement = Model_Admin::$PDO->prepare($select);
			$PDOStatement->bindParam(':id', $id, PDO::PARAM_INT);
		}
		$PDOStatement->execute();
		return $PDOStatement->fetchAll(PDO::FETCH_NUM);
	}
}
?>