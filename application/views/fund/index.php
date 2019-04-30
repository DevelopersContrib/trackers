<?php $this->load->view('includes/header')?>
	<?php $this->load->view('includes/navigation')?>
		<style>
		/* Fund Page */
.fundht {
    border-bottom: 1px solid rgb(153, 153, 153);
    color: rgb(255, 255, 255);
    margin: 0 0 30px;
    padding-bottom: 10px;
}
.fund-container {
    background: #fff none repeat scroll 0 0;
    color: #333;
    margin-bottom: 30px;
    padding: 12px;
}
.ribbon-wrapper-green {
    height: 88px;
    margin-left: 258px;
    margin-top: -17px;
    overflow: hidden;
    position: absolute;
    width: 85px;
    z-index: 1;
}
.ribbon-green {
    font: bold 15px Sans-Serif;
    color: #fff;
    text-align: center;
    -webkit-transform: rotate(45deg);
    -moz-transform:    rotate(45deg);
    -ms-transform:     rotate(45deg);
    -o-transform:      rotate(45deg);
    position: relative;
    padding: 7px 0;
    left: -5px;
    top: 15px;
    width: 120px;
    border: solid 1px #da7c0c;
    background: #bfd255; /* Old browsers */
    background: -moz-linear-gradient(top, #bfd255 0%, #8eb92a 50%, #72aa00 51%, #9ecb2d 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#bfd255), color-stop(50%,#8eb92a), color-stop(51%,#72aa00), color-stop(100%,#9ecb2d)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top, #bfd255 0%,#8eb92a 50%,#72aa00 51%,#9ecb2d 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(top, #bfd255 0%,#8eb92a 50%,#72aa00 51%,#9ecb2d 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(top, #bfd255 0%,#8eb92a 50%,#72aa00 51%,#9ecb2d 100%); /* IE10+ */
    background: linear-gradient(to bottom, #bfd255 0%,#8eb92a 50%,#72aa00 51%,#9ecb2d 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#bfd255', endColorstr='#9ecb2d',GradientType=0 ); /* IE6-9 */
    -webkit-box-shadow: 0px 0px 3px rgba(0,0,0,0.3);
    -moz-box-shadow:    0px 0px 3px rgba(0,0,0,0.3);
    box-shadow:         0px 0px 3px rgba(0,0,0,0.3);
}

.ribbon-green:before, .ribbon-green:after {
    content: "";
    border-top:   3px solid #6e8900;   
    border-left:  3px solid transparent;
    border-right: 3px solid transparent;
    position:absolute;
    bottom: -3px;
}

.ribbon-green:before {
    left: 0;
}
.ribbon-green:after {
    right: 0;
}
.fund-container .img-responsive {
    background: #fff none repeat scroll 0 0;
    height: 140px;
    width: 254px;
    margin: auto;

}
.alink {
    color: #333;
    display: block;
    margin-top: 12px;
}
.fund-container h3 {
    background: #fafafa none repeat scroll 0 0;
    border: 1px solid #dddddd;
    font-size: 19px;
    line-height: 32px;
}
.fund-container .fund-desc {
    border-bottom: 1px solid #dedede;
    height: 120px;
    overflow: hidden;
    padding-bottom: 10px;
}
.funded-l {
    float: left;
}
.funded-l .fund-details {
    float: left;
}
.funded-l .fund-icon {
    float: left;
    font-size: 37px;
    margin-right: 10px;
}
.funded-l .fund-details p {
    margin: 0;
}
.funded-r {
    float: right;
}
.funded-r .fund-icon {
    float: left;
    font-size: 37px;
    margin-right: 10px;
}
.funded-r .fund-details {
    float: left;
}
.funded-r .fund-details p {
    margin: 0;
}

.devdesc {
    font-size: 21px;
    line-height: 27px;
    margin-bottom: 20px;
}
		</style>
		<div class="section-1">
			<div class="container">
				<div class="row">
                <div class="col-md-12 text-center">
                    <div class="blur-box">
					
                        <h2 class="fundht">Fund Our Ventures</h2>
                        <div class="row">
						<?foreach($fund_campaigns as $funds):?>
						<?if($funds['post_title'] != 'Micro Markets'):?>
                            <div class="col-sm-4 col-xs-12">
                                <div class="fund-container">
                                    <div class="ribbon-wrapper-green">
                                        <div class="ribbon-green">Staff Pick</div>
                                    </div>
									<?php if($funds['logo'] != ""):?>
                                    <img src="<?php echo $funds['logo']?>" class="img-responsive" />
									<?php endif;?>
                                    <a target="_blank" class="alink" href="<?php echo $funds['permalink']?>">
                                        <h3><?php echo $funds['post_title']?></h3>
                                    </a>
                                    <p class="fund-desc"><?php echo strip_tags($funds['post_content'])?></p>
                                    <div class="funded-l">
                                        <div class="fund-icon"><i class="fa fa-usd"></i></div>
                                        <div class="fund-details">
                                            <p>Funded</p>
                                            <p><b><?php echo number_format($funds['campaign_goal'],2)?></b></p>
                                        </div>
                                        <div style="clear:both"></div>
                                    </div>
                                    <div class="funded-r">
                                        <div class="fund-icon"><i class="fa fa-bar-chart"></i></div>
                                        <div class="fund-details">
                                            <p>Funded</p>
                                            <p><b>10%</b></p>
                                        </div>
                                        <div style="clear:both"></div>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>
                            </div>
                         <?endif;?>
						<?endforeach?>
                        </div>
                    </div>
                </div>
            </div>
			</div>
		</div>
		
	<?php $this->load->view('includes/footer')?>	