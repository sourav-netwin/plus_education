<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* * ****************** PAGE DETAILS ******************* */
/* @Programmer  : SK.
 * @Maintainer  : SK.
 * @Created     : 
 * @Modified    : 
 * @Description : This is a library for cropping.
 * ****************************************************** */

class Cropping {
    private $isFront = 0;
    private $uploadedImg = "";
    private $imageNewName = "";
    private $imagePath = "";
    private $imageAbsPath = "";
    private $imageDestPath = "";
    private $imgWidth = "";
    private $imgHeight = "";
    private $thumbWidth = "";
    private $thumbHeight = "";
    private $redirectTo = "";
    private $formCallbackAction = "";

    public function __construct($param) {
        $this->isFront = isset($param['isFront']) ? $param['isFront'] : 0;
        $this->uploadedImg = $param['imageName'];
        $this->imageNewName = $param['imageNewName'];
        $this->imagePath = $param['imagePath'];
        $this->imageAbsPath = $param['imageAbsPath'];
        $this->imageDestPath = $param['imageDestPath'];
        $this->imgWidth = $param['imageWidth'];
        $this->imgHeight = $param['imageHeight'];
        $this->thumbWidth = $param['thumbWidth'];
        $this->thumbHeight = $param['thumbHeight'];
        $this->redirectTo = $param['redirectTo'];
        $this->formCallbackAction = $param['formCallbackAction'];
    }

    /**
     * image()
     * Call this function after library initialization
     * This function will show a modal popup with image and provide user ability to crop.
     * Preview with crop option and close button.
     * Button:
     * Crop: this will crop image for the selected area as per size and ratio provide.
     * Close: this button will cancel the cropping functionality but resize the image for the given size and ratio.
     */
    public function image() {
        $data['sBrowserTitle'] = "";
        # PROCESSING ------------------------------------------------------------------
        $this->loadImageView($data);
    }

    /**
     * This function will actually perform the cropping action
     * @param type $action 
     */
    public function process($action = "") {
        if ($action == "closed") {
            $upload_data = array(
                'file_name' => $this->uploadedImg,
                'full_path' => $this->imageAbsPath . $this->uploadedImg
            );
            $this->resize_uploaded_if_cancel($upload_data);
            redirect($this->redirectTo);
        } else {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if ($_POST['dataW'] > 0 && $_POST['dataH'] > 0) {
                    //------------------------CROP LARGE SIZE IMAGE ---//
                    $image_path = $this->imageAbsPath . $this->uploadedImg;
					
                    $targ_w = $this->imgWidth;
                    $targ_h = $this->imgHeight;
                    $jpeg_quality = 90;
                    $img_r = imagecreatefromjpeg($image_path);
                    $dst_r = ImageCreateTrueColor($targ_w, $targ_h);
                    $x = $_POST['dataX'];
                    $y = $_POST['dataY'];
                    $w = $_POST['dataW'];
                    $h = $_POST['dataH'];
                    //$ext = pathinfo($dst_r, PATHINFO_EXTENSION);
                    imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $targ_w, $targ_h, $w, $h);
                    $destinationFile = $this->imageDestPath . $this->imageNewName;
                    imagejpeg($dst_r, $destinationFile, $jpeg_quality);
                    // Remove from memory
                    imagedestroy($dst_r);
                    //RESIZE IMAGE TO GET THUMBNAIL, LARGE SIZE IMAGES
                    $upload_data = array(
                        'file_name' => $this->imageNewName,
                        'full_path' => $destinationFile
                    );
                    $this->create_thumbnail($upload_data);
                    redirect($this->redirectTo);
                }
            }
        }
    }

    /**
     * This function will create the thumbnail for the provided image
     * @param array $upload_data (source_image,file_name)
     */
    public function create_thumbnail($upload_data = array()) {
        $config_resize['image_library'] = 'gd2';
        $config_resize['source_image'] = $upload_data['full_path'];
        $config_resize['width'] = $this->thumbWidth;
        $config_resize['height'] = $this->thumbHeight;
        $config_resize['maintain_ratio'] = TRUE;
        $config_resize['create_thumb'] = TRUE;
        $CI = &get_instance();
        $CI->load->library('image_lib', $config_resize);
        $CI->image_lib->resize();
    }

    /**
     * This function will just resize the provided image into give size and ratio
     * @param array $upload_data (source_image,file_name)
     */
    public function resize_uploaded_if_cancel($upload_data = array()) {
        $CI = &get_instance();
        $CI->load->library('image_lib');
        /* First size */
        // create main image
        $configSize['image_library'] = 'gd2';
        $configSize['source_image'] = $upload_data['full_path'];
        $configSize['create_thumb'] = FALSE;
		if($this->isFront)
			$configSize['maintain_ratio'] = FALSE;
		else
			$configSize['maintain_ratio'] = TRUE;
		$configSize['maintain_ratio'] = TRUE;
        $configSize['width'] = $this->imgWidth;
        $configSize['height'] = $this->imgHeight;
        $configSize['new_image'] = $this->imageDestPath . $this->imageNewName;
        $CI->image_lib->initialize($configSize);
        $CI->image_lib->resize();
        $CI->image_lib->clear();
        // create thumb image
        $configSize2['image_library'] = 'gd2';
        $configSize2['source_image'] = $upload_data['full_path'];
        $configSize2['create_thumb'] = TRUE;
        $configSize2['maintain_ratio'] = TRUE;
		if($this->isFront)
			$configSize2['maintain_ratio'] = FALSE;
		else
			$configSize2['maintain_ratio'] = TRUE;
        $configSize2['width'] = $this->thumbWidth;
        $configSize2['height'] = $this->thumbHeight;
        $configSize2['new_image'] = $this->imageDestPath . $this->imageNewName;
        $CI->image_lib->initialize($configSize2);
        $CI->image_lib->resize();
        
    }

    /**
     * this function will provide cropping modal popup
     * @param type $data 
     */
    private function loadImageView($data) {
        $CI = &get_instance();
        $assetsPath = $CI->config->item('base_url') . CROPPING_ASSETS_PATH;
        $data['title'] = 'Crop image';
        $headerHtml = "";
        ob_start();
        ?>
		<!DOCTYPE html>
		<html lang="en">
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				<meta charset="utf-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<meta name="viewport" content="width=device-width, initial-scale=1">

				<title><?php echo $CI->lang->line('plus_educational_developments'); ?></title>

				<link href="<?php echo base_url(); ?>css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
				<link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet">
				<link href="<?php echo base_url(); ?>css/admin/nprogress.css" type="text/css" rel="stylesheet" media="all">
				<link href="<?php echo base_url(); ?>css/admin/prettify.min.css" type="text/css" rel="stylesheet" media="all">
				<link href="<?php echo base_url(); ?>css/admin/custom.min.css" type="text/css" rel="stylesheet" media="all">
				<link href="<?php echo base_url(); ?>css/admin/style.css" type="text/css" rel="stylesheet" media="all">

				<script src="<?php echo base_url(); ?>js/jquery-2.1.0.js"></script>
				<script src="<?php echo base_url(); ?>js/admin/jquery.validate.min.js"></script>
			</head>

			<body class="nav-md">
				<div class="container body">
					<div class="main_container">

				<!---------------------Left Menu Section------------------->
				<?php $CI->load->view('admin/left_menu'); ?>

				<!---------------------Header Section------------------->
				<?php $CI->load->view('admin/header'); ?>
				<?php 
				$headerHtml = ob_get_contents();
				ob_get_clean();
				echo $headerHtml;
				?>
				<link rel="stylesheet" href="<?php echo $assetsPath; ?>css/cropper.css">
				<div class="content">
					<div class="header">
						<h1 class="page-title"><?php if(!$this->isFront){?>Image Crop<?php }?></h1>
					</div><!-- header -->

					<div class="main-content addstanding">
						<div id="test-modal" style="margin-top:50px;" class="white-popup-block mfp-hide">
							<div class="container-fluid eg-container" id="basic-example">
								<div class="eg-main">
									<div class="col-sm-9">
										<div class="eg-wrapper">
											<img class="cropper" src="<?php echo $this->imagePath . $this->uploadedImg; ?>" alt="Picture">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="eg-preview clearfix">
											<div class="preview preview-lg"></div>
											<!--          <div class="preview preview-md"></div>
													  <div class="preview preview-sm"></div>
													  <div class="preview preview-xs"></div>-->
										</div>
										<?php
										$attribute = array("method" => "post");
										echo form_open($this->formCallbackAction, $attribute);
										?>
										<div class="eg-data">

											<input class="form-control" id="dataX" name="dataX" type="hidden" placeholder="x">

											<input class="form-control" id="dataY" name="dataY" type="hidden" placeholder="y">

											<input class="form-control" id="dataW" name="dataW" type="hidden" placeholder="width">

											<input class="form-control" id="dataH" name="dataH" type="hidden" placeholder="height">

											<input class="form-control" id="uploadedImg" name="uploadedImg" type="hidden" value="<?php echo $this->uploadedImg; ?>">

											<input class="form-control" id="imagePath" name="imagePath" type="hidden" value="<?php echo $this->imagePath; ?>">

											<input id="cropSubmit" type="submit" value="Crop Image" class="btn btn-primary" />
										</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div><!-- main-content -->
				</div><!-- content -->
				<link href="<?php echo $assetsPath; ?>css/magnific-popup.css" rel="stylesheet" type="text/css" />
				<script type="text/javascript" language="javascript" src="<?php echo $assetsPath; ?>js/jquery.magnific-popup.js"></script>
				<script type="text/javascript">
					$(document).ready(function(){
						(function($) {
							$(window).load(function () {
								$.magnificPopup.open({
									items: {
										src: '#test-modal'
									},
									type: 'inline'
								});
							});
						})(jQuery);
					});
				</script>
				<style>
					.preview-lg {
						height: <?php echo $this->thumbHeight; ?>px;
						width: <?php echo $this->thumbWidth; ?>px;
						border: 2px solid rgb(143, 21, 50);
					}
					.mfp-close-btn-in .mfp-close {
						margin-right: 50px;
						margin-top: 60px;
					}
					.eg-wrapper {
						background: none;
						border: none;
						box-shadow: none;
					}
					.cropper-container{
						border: 1px solid rgb(143, 21, 50);
					}
					.eg-data {
						/*padding-left: 40px;*/
					}

					@media screen and (max-width:767px){
						.preview-lg {
							display: none;
						}
						.mfp-close-btn-in .mfp-close {
							margin-right: -10px;
							margin-top: 30px;
						}
						.eg-data {
							padding-left: 0;
						}
					}
				</style>
				<script src="<?php echo $assetsPath; ?>js/cropper.js"></script>
				<script>
					$(window).load(function () {
						var $cropper = $(".cropper"),
						$dataX = $("#dataX"),
						$dataY = $("#dataY"),
						$dataH = $("#dataH"),
						$dataW = $("#dataW"),
						cropper;
								
						$cropper.cropper({
							aspectRatio: <?php echo $this->imgWidth; ?> / <?php echo $this->imgHeight; ?>,
							data: {
								x: 100,
								y: 100,
								width: <?php echo $this->thumbWidth; ?>,
								height: <?php echo $this->thumbHeight; ?>
							},
							preview: ".preview",
									
							// autoCrop: false,
							// dragCrop: false,
							// modal: false,
							// moveable: false,
							// resizeable: false,
									
							// maxWidth: 480,
							// maxHeight: 270,
							// minWidth: 160,
							// minHeight: 90,
									
							done: function(data) {
								$dataX.val(data.x);
								$dataY.val(data.y);
								$dataH.val(data.height);
								$dataW.val(data.width);
							}
						});
								
						cropper = $cropper.data("cropper");
								
						$cropper.on({
							"build.cropper": function(e) {
								console.log(e.type);
								// e.preventDefault();
							},
							"built.cropper": function(e) {
								console.log(e.type);
								// e.preventDefault();
							},
							"render.cropper": function(e) {
								console.log(e.type);
								// e.preventDefault();
							}
						});
								
						$("#enable").click(function() {
							$cropper.cropper("enable");
						});
								
						$("#disable").click(function() {
							$cropper.cropper("disable");
						});
								
						$("#reset").click(function() {
							$cropper.cropper("reset");
						});
								
						$("#reset-deep").click(function() {
							$cropper.cropper("reset", true);
						});
								
						$("#release").click(function() {
							$cropper.cropper("release");
						});
								
						$("#destroy").click(function() {
							$cropper.cropper("destroy");
						});
								
						$("#setData").click(function() {
							$cropper.cropper("setData", {
								x: $dataX.val(),
								y: $dataY.val(),
								width: $dataW.val(),
								height:$dataH.val()
							});
						});
								
						$("#setAspectRatio").click(function() {
							$cropper.cropper("setAspectRatio", $("#aspectRatio").val());
						});
								
						$("#setImgSrc").click(function() {
							$cropper.cropper("setImgSrc", $("#imgSrc").val());
						});
								
						$("#getImgInfo").click(function() {
							$("#showInfo").val(JSON.stringify($cropper.cropper("getImgInfo")));
						});
								
						$("#getData").click(function() {
							$("#showData").val(JSON.stringify($cropper.cropper("getData")));
						});
					});
					$.magnificPopup.instance.close = function () {
						window.location.href="<?php echo $this->formCallbackAction . "/closed";?>";
						$.magnificPopup.proto.close.call(this);
					};
				</script>
				<?php 
				$footerHtml = "";
				ob_start();
				?>
				<!---------------Footer section--------------->
						<?php $CI->load->view('admin/footer'); ?>

						<script src="<?php echo base_url(); ?>js/bootstrap.js"></script>
						<script src="<?php echo base_url(); ?>js/admin/custom.min.js"></script>
					</div>
				</div>
			</body>
		</html>
		<?php 
        $footerHtml = ob_get_contents();
        ob_get_clean();
        echo $footerHtml;
    }

}// END Cropit class