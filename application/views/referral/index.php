<?php $this->load->view('includes/header')?>
	<?php $this->load->view('includes/navigation')?>
        <style>
            /* Referral Page */
            .blck2-box{
                padding: 25px 15px;
                margin-bottom: 25px;
                text-align: center;
                margin-top: -5px;
            }
            .wrap-allbanner {
                background: rgba(0, 0, 0, 0) url("http://d2qcctj8epnr7y.cloudfront.net/images/2013/banner-contrib-728x90-1.png") no-repeat scroll 0 0;
                box-sizing: border-box;
                height: 90px;
                position: relative;
                width: 728px;
            }
            .wrap-bannerLeft, .wrap-bannerRight {
                display: inline-block;
                float: left;
            }
            .wrap-bannerLeft {
                box-sizing: border-box;
                height: 90px;
                overflow: hidden;
                padding: 15px 5px 20px 10px;
                vertical-align: top;
                width: 245px;
            }
            .ellipsis {
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
            .aBnnrP {
                box-sizing: border-box;
                color: #0088cc;
                display: block;
                font-size: 22px;
                font-weight: bold;
                line-height: normal;
                margin: 0;
                text-align: center;
                text-decoration: none;
                text-transform: capitalize;
            }
            .logo-banners1 {
                box-sizing: border-box;
                max-height: 58px;
                max-width: 100%;
            }
            .wrap-bannerRight {
                color: #ffffff;
                height: 90px;
                margin-left: 84px;
                width: 397px;
            }
            .content-rightText {
                box-sizing: border-box;
                margin: auto;
                padding-top: 16px;
                width: 350px;
            }
            .content-rightText span {
                box-sizing: border-box;
                display: block;
            }
            .content-rightText span, .content-rightText p {
                font-size: 25px;
                text-align: center;
                text-shadow: 2px 1px 1px rgba(0, 0, 0, 0.5);
            }
            .block-group{
                border-bottom: 1px solid #fff;
                margin-bottom: 25px;
                padding-bottom: 30px;
            }
            .block-group:last-child{
                margin-bottom: 0;
                border-bottom: none;
            }
            .wrapBanner-2 {
                background: rgba(0, 0, 0, 0) url("http://d2qcctj8epnr7y.cloudfront.net/images/jayson/180x150-1.png") no-repeat scroll 0 0;
                box-sizing: border-box;
                height: 150px;
                margin: auto;
                overflow: hidden;
                position: relative;
                width: 180px;
            }
            .wrap-topBanner {
                box-sizing: border-box;
                display: block;
                margin: 37px auto 0;
                position: relative;
                width: 118px;
            }
            .wrap-contentTop {
                box-sizing: border-box;
                color: #fff;
                font-size: 20px;
                letter-spacing: 0.01em;
                line-height: 1.1em;
                text-align: center;
                text-shadow: 2px 1px 1px rgba(0, 0, 0, 0.5);
            }

            .wrap-contentTop span {
                display: block;
            }
            .wrap-downBanner {
                box-sizing: border-box;
                display: block;
                height: 37px;
                margin: 5px 0 0;
                overflow: hidden;
            }
            .wrap-contentDown {
                box-sizing: border-box;
                height: 35px;
                margin: auto;
                padding: 1px 0;
                width: 125px;
            }
            .wrap-contentDown img {
                max-height: 32px;
                max-width: 100%;
                text-align: center;
            }
            .wrap-contentDown p {
                box-sizing: border-box;
                color: #0088cc;
                display: block;
                margin: 0;
            }
            .wrapBanner-3 {
                background: rgba(0, 0, 0, 0) url("http://d2qcctj8epnr7y.cloudfront.net/images/2013/banner-contrib-160x600-1.png") no-repeat scroll 0 0;
                box-sizing: border-box;
                height: 600px;
                margin: auto;
                overflow: hidden;
                position: relative;
                width: 180px;
            }
            .wrap-topBanner3 {
                box-sizing: border-box;
                display: block;
                margin: 130px 18px 0;
                position: relative;
                width: 120px;
            }


            .wrapBanner-4 {
                background: rgba(0, 0, 0, 0) url("http://d2qcctj8epnr7y.cloudfront.net/images/2013/banner-contrib-250x250-1.png") no-repeat scroll 0 0;
                box-sizing: border-box;
                height: 250px;
                margin: auto;
                overflow: hidden;
                position: relative;
                width: 250px
            }
            .wrap-topBanner4 {
                box-sizing: border-box;
                display: block;
                margin: 76px 18px 0;
                position: relative;
                
            }
        </style>
		<div class="section-1">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="wrap-form-containter-tracker">
                            <h1 class="lead-title">
                                Refer Trackers.com
                            </h1>
                            <ul class="nav nav-tabs tabs-form-ul" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#refprograms" role="tab" aria-selected="true">Referral Programs</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#refbanners" role="tab" aria-selected="false">Banners</a>
                                </li>
                            </ul>
                            <div class="tab-content tab-content-custom-form" id="myTabContent">
								<div class="tab-pane fade show active" id="refprograms" role="tabpanel" aria-labelledby="home-tab">
									<div class="p-5">
                                        <div class="row">
    										<?php if (count($programs)>0):?>
                             	   	 			<?php foreach ($programs as $key=>$val):?>
        											<div class="col-md-12">
        												<p class="text-center">
        													Referral Program: <?php echo $val['title']?>
        												</p>
        												<p class="text-center">
        												    <?php echo $val['code']?>
        												</p>
        												<p class="text-center banner-source">Source Code - Copy/Paste Into Your Website</p>
                                                        <textarea readonly="readonly" onclick="this.focus();this.select()" rows="3" class="text-left form-control"> <?php echo $val['code']?></textarea>
                                                        <div class="clearfix"></div>
        											</div>
                             	   	 			<?php endforeach;?>
                             	   	 		<?php endif;?>	
                                        </div>
									</div>
								</div>
								<div class="tab-pane fade" id="refbanners" role="tabpanel" aria-labelledby="profile-tab">
									<div class="blck2-box">
                                        <div class="block-group">
                                            <dl class="dl-horizontal">
                                                <dt>Marketing Group</dt><dd>Contrib</dd>
                                                <dt>Banner Size</dt><dd>728 x 90</dd>
                                                <dt>Banner Description</dt><dd><?php echo $domain?> Banner</dd>
                                                <dt>Target URL</dt><dd>http://<?php echo $domain?></dd>
                                            </dl>
                                            <div class="floating text-center banner-img-cont">
                                                <div class="wrap-allbanner">
                                                    <div class="wrap-bannerLeft">
                                                        <p class="aBnnrP ellipsis">
                                                            <img alt="<?php echo $domain?>" title="<?php echo $domain ?>" src="<?echo $logo?>" class="logo-banners1">
                                                        </p>
                                                    </div>
                                                    <div class="wrap-bannerRight ">
                                                        <div class="content-rightText ">
                                                            <span class="">Follow , Join and</span>
                                                            <p class="ellipsis">Partner with Contrib.com</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br />
                                            <p class="text-center banner-source">Source Code - Copy/Paste Into Your Website</p>
                                            <textarea readonly="readonly" onclick="this.focus();this.select()" rows="3" class="text-left form-control">&lt;script type="text/javascript" src="http://www.contrib.com/widgets/leadbanner/<?php echo $domain?>/<?echo $domainid?>"&gt;&lt;/script&gt;</textarea>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="block-group">
                                            <dl class="dl-horizontal">
                                                <dt>Marketing Group</dt><dd>Contrib</dd>
                                                <dt>Banner Size</dt><dd>180 x 150</dd>
                                                <dt>Banner Description</dt><dd><?php echo $domain?> Banner</dd>
                                                <dt>Target URL</dt><dd>http://<?php echo $domain?></dd>
                                            </dl>
                                            <div class="floating text-center banner-img-cont">
                                                <div class="wrapBanner-2">
                                                    <div class="wrap-topBanner ">
                                                        <div class="wrap-contentTop">
                                                            <span>Follow, Join</span>
                                                            <span>and Partner with</span>
                                                        </div>
                                                    </div>
                                                    <div class="wrap-downBanner">
                                                        <div class="wrap-contentDown">
                                                            <p class="ellipsis">
                                                                <img alt="<?php echo $domain?>" title="<?php echo $domain; ?>" src="<?echo $logo?>">
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br />
                                            <p class="text-center banner-source">Source Code - Copy/Paste Into Your Website</p>
                                            <textarea readonly="readonly" onclick="this.focus();this.select()" rows="3" class="text-left form-control">&lt;script type="text/javascript" src="http://www.contrib.com/widgets/roundleadbanner/<?php echo $domain?>/<?echo $domainid?>"&gt;&lt;/script&gt;</textarea>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="block-group">
                                            <dl class="dl-horizontal">
                                                <dt>Marketing Group</dt><dd>Contrib</dd>
                                                <dt>Banner Size</dt><dd>728 x 90</dd>
                                                <dt>Banner Description</dt><dd><?php echo $domain?> Banner</dd>
                                                <dt>Target URL</dt><dd>http://<?php echo $domain?></dd>
                                            </dl>
                                            <div class="floating text-center banner-img-cont">
                                                <div class="wrapBanner-3">
                                                    <div class="wrap-topBanner3 ">
                                                        <div class="wrap-contentTop">
                                                            <span>Follow, Join</span>
                                                            <span>and Partner with</span>
                                                        </div>
                                                    </div>
                                                    <div class="wrap-downBanner">
                                                        <div class="wrap-contentDown">
                                                            <p class="ellipsis">
                                                                <img alt="<?php echo $domain?>" title="<?php echo $domain; ?>" src="<?echo $logo?>">
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br />
                                            <p class="text-center banner-source">Source Code - Copy/Paste Into Your Website</p>
                                            <textarea readonly="readonly" onclick="this.focus();this.select()" rows="3" class="text-left form-control">&lt;script type="text/javascript" src="http://www.contrib.com/widgets/verticalbanner<?php echo $domain?>/<?echo $domainid?>"&gt;&lt;/script&gt;</textarea>
                                        </div>
                                        <div class="block-group">
                                            <dl class="dl-horizontal">
                                                <dt>Marketing Group</dt><dd>Contrib</dd>
                                                <dt>Banner Size</dt><dd>250 x 250</dd>
                                                <dt>Banner Description</dt><dd><?php echo $domain?> Banner</dd>
                                                <dt>Target URL</dt><dd>http://<?php echo $domain?></dd>
                                            </dl>
                                            <div class="floating text-center banner-img-cont">
                                                <div class="wrapBanner-4">
                                                    <div class="wrap-topBanner4 ">
                                                        <div class="wrap-contentTop">
                                                            <span>Follow, Join</span>
                                                            <span>and Partner with</span>
                                                        </div>
                                                    </div>
                                                    <div class="wrap-downBanner">
                                                        <div class="wrap-contentDown">
                                                            <p class="ellipsis">
                                                                <img src="<?echo $logo?>" title="<?php echo $domain; ?>" alt="<?php echo $domain?>" src="">
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br />
                                            <p class="text-center banner-source">Source Code - Copy/Paste Into Your Website</p>
                                            <textarea readonly="readonly" onclick="this.focus();this.select()" rows="3" class="text-left form-control">&lt;script type="text/javascript" src="http://www.contrib.com/widgets/squarebanner/<?php echo $domain?>/<?echo $domainid?>"&gt;&lt;/script&gt;</textarea>
                                        </div>
                                    </div>
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
	<?php $this->load->view('includes/footer')?>	