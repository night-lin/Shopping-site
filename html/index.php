<!Doctype html>
	<head>
		<meta charset="utf-8">
		<title>E-shop</title>
		<link href="../css/index.css"  type="text/css" rel="stylesheet"/>
		<script src="../js/jquery.min.js"></script>
		<script src="../js/ajaxCart.js"></script>
	</head>
	<body>
		<div id="nav">
			<div id="nav-bar">
			 	<img src="../images/logo-nav.png">
			 	<ul class="nav-ul">
			 		<li class="li-now"><a class="nav-a" href="index.php">首页</a></li>
			 		<li><a class="nav-a" href="account.php">账户设置</a></li>
			 		<li><a class="nav-a" href="order-info.php">订单情况</a></li>
			 	</ul>
			 	<div id="search-area">
			 		
			 	      <form action="../html/search.php" method='post'>
			 	      	<input placeholder="请输入想要搜索的商品" type="text" name="goods-name">
			 	      	<button class="btn-default btn-search">搜索</button>
				 	  </form>	
			 		
			 	</div>	
			</div>
		</div>
		
				<!--这里动态读取最常购买类型商品中热度最高-->
				<?php
                 session_start();

                 $username = $_SESSION["temp"][0];
                 header("Content-type: text/html; charset:utf-8");                 
                   $con = mysql_connect("localhost","root","");
                   if (!$con)
                  {
                         die('Could not connect: ' . mysql_error());
                  }
                  else
                  {

            
                      mysql_select_db("shopping_system", $con);
                      mysql_query("SET NAMES UTF8");
                      $result2 = mysql_query("SELECT * FROM user where id = '$username'");
                      if(mysql_num_rows($result2)>0)
                      {
                        $row2 = mysql_fetch_array($result2);

                      }
                      echo'
                      <div id="main-content">
			          <div class="status">
				      <div class="status-box user-info">欢迎，<span>'.$row2["name"].'</span> </div>
				      <div class="status-box balance">账户余额<span>'.$row2["accountBalance"].'</span></div>
				      <div id="cart" class=" status-box cart">购物车';

                      require  'cart-content.php';
 					   echo'</div>';
				     echo'  <div style="clear:both;"></div>
			          </div>
			          <div class="banner">
					  <div class="b-img">
					  	<a href="javascript:void(0)" style="background:url(../images/banner1.jpg) center no-repeat;"></a>
					  	<a href="javascript:void(0)" style="background:url(../images/banner2.jpg) center no-repeat;"></a>
					  	<a href="javascript:void(0)" style="background:url(../images/banner1.jpg) center no-repeat;"></a>
					  </div>
					  <div class="b-list-bg"></div>
					  <div class="b-list"></div>
					  <a class="bar-left" href="javascript:void(0)"><em></em></a>
					  <a class="bar-right" href="javascript:void(0)"><em></em></a>
			          </div>	
			          <div class="goods-list">
				      <div class="nav-title">
					  可能喜欢的商品
				      </div>';


                      $result = mysql_query("SELECT classId FROM orderinfo 
				                             where  userId = '$username'
				                             group by goodsid,classId
				                             order by count(*) desc 
				                             limit 1");
                      if(mysql_num_rows($result)>0)
                      {
                        $row = mysql_fetch_array($result);
                        $favorate = $row['classId'];

                      }
                      else{
                      	$arr=array("bags","book","cellphone","clothes","shoes");
                      	$x=mt_rand(0, 4);
                      	$favorate=$arr[$x];
                      }
                      $result1 = mysql_query("SELECT * FROM goodsinfo where classId ='$favorate' order by count desc limit 8" );

                      if(mysql_num_rows($result1)>0)
                      {
                      echo '<ul class="goods-ul">';
                      while($row1 = mysql_fetch_array($result1))
                      {
                      	$classId=$row1['classId'];
                      	$goodsId=$row1['goodsId'];
                        $imageId = $row1['imageId'];
                        $price = $row1['price'];
                        $goodsName = $row1['goodsName'];
                      	echo '<li><a href="goods-detail.php?goodsId='.$goodsId.'"><img src="../images/'.$classId.'/small/'.$imageId.'.jpg" width="220" height="220"></a><div class="good-price">'.'￥'.$price.'</div><div class="good-introduce">'.$goodsName.'</div></li>';
                        
                      }
                      }	
                      echo "</ul>";

                  }
              
				?>
				
			</div>
		</div>
		<div id="footer">
			Design by   web 6 group
		</div>
	</body>
	<script src="../js/banner.js"></script>
	<script type="text/javascript">
		window.onload=function(){
			var cart = document.getElementById("cart");
			var cartCon = document.getElementById("cart-content");
			cart.onclick=cartConShow;
			function cartConShow(){
					if(cartCon.style.display == "block")				
					cartCon.style.display = "none";	
					else		
					cartCon.style.display ="block";
			}

			
		}
		
	</script>;

	

	

	



</html>