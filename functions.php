<style>
#style-3::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #F5F5F5;
}

#style-3::-webkit-scrollbar
{
	width: 6px;
	background-color: #F5F5F5;
}

#style-3::-webkit-scrollbar-thumb
{
	background-color: #ed5565;
}
</style>



<?php


	function getDistinctTags($current){
		$query="select distinct(tag) from tags";

		$query_run=mysqli_query($current,$query);
		$distinctTags=array();
		if(mysqli_num_rows($query_run)>0){
		$distinctTags[]="All";
		while($result=mysqli_fetch_array($query_run)){
			$distinctTags[]=$result['tag'];
		}
		}
		return $distinctTags;
}

	function appendString($s,$a){
		return $s.$a;
	}
	
	function makeLink($linkName, $linkCaption){
		
		if ($linkName!=Null && $linkCaption!=Null){
			return '<a href="'.$linkName.'" target="_blank">'.$linkCaption.'</a>';
		}
		else
			return '';
	}
		
	function insertPublication($num,$authors,$title,$year,$status,$publication,$link1,$link1caption,$link2,$link2caption){
			$str="";
			$str=appendString($str,$num);
			$str=appendString($str,'. ');
			$str=appendString($str,$authors);
			$str=appendString($str,' (');
			$str=appendString($str,$year);
			$str=appendString($str,')');
			$str=appendString($str,'. ');
			$str=appendString($str,$title);
			$str=appendString($str,'. ');
			if ($status=="Completed"){
				$str=appendString($str,$publication);
			}
			
			if ($status!="Completed"){
				$str=appendString($str,' (');
				$str=appendString($str,$status);
				$str=appendString($str,'). ');
			}
			$str=appendString($str,"\t");
			$str=appendString($str,makeLink($link1,$link1caption));
			$str=appendString($str," ");
			$str=appendString($str,makeLink($link2,$link2caption));
			
			return $str;
		}
		
		function insertPresentation($ptr,$presented,$name,$venue){
			$str="";
			$str=appendString($str,$ptr.". ");
			$str=appendString($str,"Presented a ");
			$str=appendString($str,strtolower($presented));
			$str=appendString($str," titled '");
			$str=appendString($str,$name);
			$str=appendString($str,"' in ");
			$str=appendString($str,$venue);
			return $str;
			
		}
		
		function insertInvolvements($ptr,$initial,$designation,$company){
			$str="";
			$str=appendString($str,$ptr.". ");
			$str=appendString($str,$initial);
			$str=appendString($str," ");
			$str=appendString($str,$designation);
			$str=appendString($str," ");
			$str=appendString($str,$company);
			return $str;
		}
		
		function arrayToString($tags){
			$fool=0;
			$str='';
			foreach ($tags as $tag){
				
				if ($fool!=0)
					$str=appendString($str,", ");
				$str=appendString($str,$tag);
				$fool=1;
				
			}
			return $str;
		}
		
		function init_well($heading){
			
			echo "<div class='well'>";
			echo '<p class="text-center"> <font size=4 color="#c11603">';
			echo $heading;
			echo "</font></p>";
			echo "</div>";
		}
		
		function projectCard($num,$image,$title,$stitle,$twoLine,$deployLink,$gitLink,$tags){	
			$id=42;	
			if($num%2!=0) $style="margin:0px;";
			else $style="";		
			$strTags='All ';
			foreach ($tags as $value){
				$strTags=$strTags.' '.str_replace(' ','_',$value);
			}
			?>	
							<div class="col-md-4<?php echo ' '.$strTags; ?>" style='<?php echo $style;?>'>
        
             <div class="card-container manual-flip" style="height:420px;">
                <div class="card" style="height:420px; min-height:130px;">
                    <div class="front" style="height:420px;">
                        <div class="cover">
						<img src='<?php echo $image;?>'/>
                           <!-- <img src="images/rotating_card_thumb.png"/>-->
                        </div>
                    
                        <div class="content" style='margin-bottom:0px; min-height:130px; height:130px;'>
                            <div class="main" style='min-height:130px; height:130px;'>
                                <h3 class="name" style="color: #c11603 !important;"><?php echo $stitle;?></h3>
                                <p class="text-center"><?php echo $title; ?></p>
								
                                
		                </div>
						<center>
							<a href="<?php echo $deployLink;?>" target="_blank">
								<button type="button" class="btn btn-info btn-sm" style="background-color:#ed5565;margin-top:0px;">
									Webpage
								</button>
							</a>
						</center>
                            <div class="footer" style='margin-top:0px;cursor:pointer;'>
								
	
								
                                <button class="btn btn-simple" id='get<?php echo $id;?>' onclick="rotateCard(this)">
                                    <font color="#c11603">
										<i class="fa fa-mail-forward"></i> Details
									</font>
                                </button>
                            </div>
                        </div>
                    </div> <!-- end front panel -->
                    <div class="back" style='cursor:pointer;height:420px;overflow-y:scroll;font-family:inherit;'  onclick="rotateCard(this)" id='style-3'>
					       
                       <div class='text-center'>
					     <div class='result<?php echo $id;?>' style='padding:20px;'>
						 
						<?php init_well("Project Details"); ?>
								<center> 
									<a href="<?php echo $gitLink;?>" target="_blank">
										<button type="button" class="btn btn-info btn-sm" style="background-color:#ed5565;margin-top:0px;">
											Gitpage
										</button>
									</a>
								</center>
						
						 <hr/>
						 
							<?php 
							$str=arrayToString($tags);
							if ($str!=''){
								init_well("Domain");
								echo $str;
							}
							?>
						  <hr/>
						 
							<?php 
							
							init_well("Two-line Summary");
							echo $twoLine; 
							
							?>
							<hr/>
						 </div>
						
					   </div>
                        

                        </div>
                    </div> <!-- end back panel -->
                </div> <!-- end card -->
            
		
        </div> <!-- end col sm 3 -->
																
					
							<script type="text/javascript">

								$().ready(function(){
									$('[rel="tooltip"]').tooltip();

								});

								function rotateCard(btn){
									var $card = $(btn).closest('.card-container');
									console.log($card);
									if($card.hasClass('hover')){
										$card.removeClass('hover');
									} else {
										$card.addClass('hover');
									}
								}
								
								
							</script>
<?php	
			
	
		}
		?>
		
		<?php	
		function internshipCard($num,$image,$companyName,$companySummary,$designation,$sdate,$edate,$category,$location,$tags){	
			$id=42;	
			if($num%2!=0) $style="margin:0px;";
			else $style="";			
			?>	
							<div class="col-md-4" style='<?php echo $style;?>'>
        
             <div class="card-container manual-flip">
                <div class="card">
                    <div class="front">
                        <div class="cover">
						<img src='<?php echo $image;?>'/>
                           <!-- <img src="images/rotating_card_thumb.png"/>-->
                        </div>
                    
                        <div class="content" style='margin-bottom:0px;'>
                            <div class="main">
                                <h3 class="name" style="color: #c11603 !important;"><?php echo $companyName;?></h3>
								<p class="text-center"><?php echo $designation;?> </p>
                                <p class="text-center"><?php echo $category; ?></p>
								
		
                            </div>
                            <div class="footer" style='margin-top:0px;cursor:pointer;'>
                                <button class="btn btn-simple" id='get<?php echo $id;?>' onclick="rotateCard(this)">
                                    <font color="#c11603">
										<i class="fa fa-mail-forward"></i> Details
									</font>
                                </button>
                            </div>
                        </div>
                    </div> <!-- end front panel -->
                    <div class="back" style='cursor:pointer;overflow-y:scroll;'  onclick="rotateCard(this)" id='style-3'>
					       
                       <div class='text-center'>
					     <div class='result<?php echo $id;?>' style='padding:20px;'>
						 <div class="well">
							<p class="text-center" style="color:#c11603;"> <font size=4> Projects </font> </p>
							<hr/>
							<?php
							foreach($tags as $name=>$link){
								echo "<a href=$link target='_blank'>".$name."</a><br/>";
							}
							?>
						 </div>
						 <hr/>
						 <div class="well">
							<p class="text-center" style="color:#c11603;"> <font size=4> Company Details </font> </p>
							<hr/>
						 </div>
							<?php echo $companySummary; ?>
						 </div>
						
					   </div>
                        

                        </div>
                    </div> <!-- end back panel -->
                </div> <!-- end card -->
            
		
        </div> <!-- end col sm 3 -->
																
					
							<script type="text/javascript">

								$().ready(function(){
									$('[rel="tooltip"]').tooltip();

								});

								function rotateCard(btn){
									var $card = $(btn).closest('.card-container');
									console.log($card);
									if($card.hasClass('hover')){
										$card.removeClass('hover');
									} else {
										$card.addClass('hover');
									}
								}
							</script>
<?php	
			
	
		}
		?>