<?php echo $alert_msg;?> 

	<script>
		$('#colorpickerField1, #colorpickerField2, #colorpickerField3, #colorpickerField4, #colorpickerField5, #colorpickerField6, #colorpickerField7').ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				$(el).val(hex);
				$(el).ColorPickerHide();
			},
			onBeforeShow: function () {
				$(this).ColorPickerSetColor(this.value);
			}
			
			onChange: function (hsb, hex, rgb) {
				$(this).css('backgroundColor', '#' + hex);
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});
	</script>

<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr valign="top">
	<td>

	
	<!-- start id-form -->
	<?php echo form_open_multipart('admin/settings');?>
	<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
		<tr>
			<th colspan="2"><h3>Tracking, Metadata and Business Info</h3></th>
		</tr>
		<tr>
			<th valign="top">Google Analytics (Tracker Code):</th>
			<td>
			<textarea cols="80" class="form-textarea" id="editor1" name="google_analytics" rows="10"><?php echo $settings_edit->google_analytics;?></textarea>
			<script type="text/javascript">
			//<![CDATA[

				CKEDITOR.replace( 'editor1', {
					removePlugins : 'resize',
					extraPlugins : 'bbcode',
					toolbar :
					[

					]								
				});

			//]]>
			</script>
			
			</td>
		</tr>
		<tr>
			<th valign="top">Keywords (Meta):</th>
			<td><input type="text" value="<?php $t = $settings_edit->keywords; $a = explode(" ", $t ); echo implode(",", $a );?>" class="inp-form-error" name="keywords">
			<br/>
			<small>use "," or " " to seperate keywords.</small>
			</td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th valign="top">Description (Meta):</th>
			<td><input type="text" value="<?php echo $settings_edit->description;?>" class="inp-form-error" name="description"></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th valign="top">Business Name:</th>
			<td><input type="text" value="<?php echo $settings_edit->business_name;?>" class="inp-form-error" name="business_name"></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th>Business Logo:</th>
			<td>
				<a href='<?php echo base_url();?>assets/images/<?php echo $settings_edit->business_logo;?>' rel="prettyPhoto">
					<img style="border: 1px silver solid;" src='<?php echo base_url();?>assets/images/<?php echo $settings_edit->business_logo;?>' width='300' style='height: auto;'/>
				</a>
			</td>
			<td></td>
		</tr>
		<tr>
		<th>&nbsp;</th>
		<td>
			<?php 
			$attr = "class='file_1'"; 
			echo form_upload('business_logo',$settings_edit->business_logo, $attr); 
			?>
			<br/>
			<?php echo anchor('admin/settings/delete_image/'.str_replace('.','_',str_replace('.png','',$settings_edit->business_logo)), 'Delete Image');?>
		</td>
		<td style="padding: 0px 95px 10px;">
			<div class="bubble-left"></div>
			<div class="bubble-inner">PNG 5MB max per image</div>
			<div class="bubble-right"></div>
		</td>
		</tr>
		<tr>
			<th valign="top">Business Email:</th>
			<td><input type="text" value="<?php echo $settings_edit->business_email;?>" class="inp-form-error" name="business_email"></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th valign="top">Paypal Email:</th>
			<td><input type="text" value="<?php echo $settings_edit->paypal_email;?>" class="inp-form-error" name="paypal_email"></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th colspan="2"><h3>Styling and Layout</h3></th>
		</tr>
		<tr>
			<th valign="top">Layout Type:</th>
			<td>
			<select style="z-index: 100;" name="layout_type" class="styledselect_form_1">
				<?php if($settings_edit->layout_type == '1'):?><option value='1'>Chrome</option><option value='2'>Web 2.0</option><option value='3'>Modern</option><option value='4'>Abstract</option><option value='5'>Professional</option><?php endif;?>
				<?php if($settings_edit->layout_type == '2'):?><option value='2'>Web 2.0</option><option value='1'>Chrome</option><option value='3'>Modern</option><option value='4'>Abstract</option><option value='5'>Professional</option><?php endif;?>
				<?php if($settings_edit->layout_type == '3'):?><option value='3'>Modern</option><option value='1'>Chrome</option><option value='2'>Web 2.0</option><option value='4'>Abstract</option><option value='5'>Professional</option><?php endif;?>
				<?php if($settings_edit->layout_type == '4'):?><option value='4'>Abstract</option><option value='1'>Chrome</option><option value='2'>Web 2.0</option><option value='3'>Modern</option><option value='5'>Professional</option><?php endif;?>
				<?php if($settings_edit->layout_type == '5'):?><option value='5'>Professional</option><option value='1'>Chrome</option><option value='2'>Web 2.0</option><option value='3'>Modern</option><option value='4'>Abstract</option><?php endif;?>
			</select>
			</td>
			</td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th>Background Image:</th>
			<td>
				<a href='<?php echo base_url();?>assets/images/<?php echo $settings_edit->background_image;?>' rel="prettyPhoto">
					<img style="border: 1px silver solid;" src='<?php echo base_url();?>assets/images/<?php echo $settings_edit->background_image;?>' width='300' style='height: auto;'/>
				</a>
			</td>
			<td></td>
		</tr>
		<tr>
		<th>&nbsp;</th>
		<td>
			<?php  
			echo form_upload('background_image',$settings_edit->background_image, $attr); 
			?>
			<br/>
			<?php echo anchor('admin/settings/delete_image/'.str_replace('.','_',str_replace('.png','',$settings_edit->background_image)), 'Delete Image');?>
		</td>
		<td style="padding: 0px 95px 10px;">
			<div class="bubble-left"></div>
			<div class="bubble-inner">PNG 5MB max per image</div>
			<div class="bubble-right"></div>
		</td>
		</tr>
		<tr>
			<th valign="top">Background Repeat:</th>
			<td>
			<select style="z-index: 100;" name="background_repeat" class="styledselect_form_1">
				<?php if(($settings_edit->background_repeat == 'repeat')||($settings_edit->background_repeat == '')):?><option value='repeat'>Repeat</option><option value='repeat-x'>Repeat Horizontal</option><option value='repeat-y'>Repeat Vertical</option><option value='no-repeat'>No Repeat</option><?php endif;?>
				<?php if($settings_edit->background_repeat == 'repeat-x'):?><option value='repeat-x'>Repeat Horizontal</option><option value='repeat'>Repeat</option><option value='repeat-y'>Repeat Vertical</option><option value='no-repeat'>No Repeat</option><?php endif;?>
				<?php if($settings_edit->background_repeat == 'repeat-y'):?><option value='repeat-y'>Repeat Vertical</option><option value='repeat'>Repeat</option><option value='repeat-x'>Repeat Horizontal</option><option value='no-repeat'>No Repeat</option><?php endif;?>
				<?php if($settings_edit->background_repeat == 'no-repeat'):?><option value='no-repeat'>No Repeat</option><option value='repeat'>Repeat</option><option value='repeat-x'>Repeat Horizontal</option><option value='repeat-y'>Repeat Vertical</option><?php endif;?>
			</select>
			</td>
		</tr>
		<tr>
			<th valign="top">Background Position:</th>
			<td>
			<select style="z-index: 100;" name="background_position" class="styledselect_form_1">
				<?php if(($settings_edit->background_position == 'top')||($settings_edit->background_position == '')):?><option value='top'>Top</option><option value='center'>Middle</option><option value='bottom'>Bottom</option><?php endif;?>
				<?php if($settings_edit->background_position == 'center'):?><option value='center'>Middle</option><option value='top'>Top</option><option value='bottom'>Bottom</option><?php endif;?>
				<?php if($settings_edit->background_position == 'bottom'):?><option value='bottom'>Bottom</option><option value='top'>Top</option><option value='center'>Middle</option><?php endif;?>
			</select>
			</td>
		</tr>
		<tr>
			<th valign="top">Current Background (Example):</th>
			<style>
			div#example_bg{
				background: <?php echo $settings_edit->color_1;?>; 
				<?php if (($settings_edit->color_2 != '')||($settings_edit->color_3 != '')):?>
					background: -moz-linear-gradient(top,  <?php echo $settings_edit->color_1;?> 0%, <?php echo $settings_edit->color_2;?> 50%, <?php echo $settings_edit->color_3;?> 100%);
					background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo $settings_edit->color_1;?>), color-stop(50%,<?php echo $settings_edit->color_2;?>), color-stop(100%,<?php echo $settings_edit->color_3;?>));
					background: -webkit-linear-gradient(top,  <?php echo $settings_edit->color_1;?> 0%,<?php echo $settings_edit->color_2;?> 50%,<?php echo $settings_edit->color_3;?> 100%); 
					background: -o-linear-gradient(top,  <?php echo $settings_edit->color_1;?> 0%,<?php echo $settings_edit->color_2;?> 50%,<?php echo $settings_edit->color_3;?> 100%); 
					background: -ms-linear-gradient(top, <?php echo $settings_edit->color_1;?> 0%,<?php echo $settings_edit->color_2;?> 50%,<?php echo $settings_edit->color_3;?> 100%); 
					background: linear-gradient(top,  <?php echo $settings_edit->color_1;?> 0%,<?php echo $settings_edit->color_2;?> 50%,<?php echo $settings_edit->color_3;?> 100%); 
					filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $settings_edit->color_1;?>', endColorstr='<?php echo $settings_edit->color_2;?>',GradientType=0 );
				<?php endif;?>
				height: 300px;
				width: 300px;
				border: 1px silver solid;
			}
			</style>
			<td>
				<div id="example_bg">
				</div>
			</td>
		</tr>
		<tr>
			<th valign="top">Color 1 (Background Gradient):</th>
			<td>
			
			<input type="text" maxlength="6" size="6" style="color:white; text-shadow: 1px 1px 1px #000000; border: 1px silver solid; background: <?php echo $settings_edit->color_1;?>" value="<?php echo str_replace('#','',$settings_edit->color_1);?>" id="colorpickerField1" class="inp-form-error" name="color_1"></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th valign="top">Color 2 (Background Gradient):</th>
			<td>
			
			<input type="text" maxlength="6" size="6" style="color:white; text-shadow: 1px 1px 1px #000000; border: 1px silver solid; background: <?php echo $settings_edit->color_2;?>" value="<?php echo str_replace('#','',$settings_edit->color_2);?>" id="colorpickerField2" class="inp-form" name="color_2"></td>
		</tr>
		<tr>
			<th valign="top">Color 3 (Background Gradient):</th>
			<td>
			
			<input type="text" maxlength="6" size="6" style="color:white; text-shadow: 1px 1px 1px #000000; border: 1px silver solid; border: 1px silver solid; background: <?php echo $settings_edit->color_3;?>" value="<?php echo str_replace('#','',$settings_edit->color_3);?>" id="colorpickerField3" class="inp-form" name="color_3"></td>
		</tr>
		<tr>
			<th>Container Image:</th>
			<td>
				<a href='<?php echo base_url();?>assets/images/<?php echo $settings_edit->container_image;?>' rel="prettyPhoto">
					<img style="border: 1px silver solid;" src='<?php echo base_url();?>assets/images/<?php echo $settings_edit->container_image;?>' width='10' style='height: auto;'/>
				</a>
			</td>
			<td></td>
		</tr>
		<tr>
		<th>&nbsp;</th>
		<td>
			<?php 
			echo form_upload('container_image',$settings_edit->container_image, $attr); 
			?>
			<br/>
			<?php echo anchor('admin/settings/delete_image/'.str_replace('.','_',str_replace('.png','',$settings_edit->container_image)), 'Delete Image');?>
		</td>
		<td style="padding: 0px 95px 10px;">
			<div class="bubble-left"></div>
			<div class="bubble-inner">PNG 5MB max per image</div>
			<div class="bubble-right"></div>
		</td>
		</tr>
		<tr>
			<th valign="top">Container Repeat:</th>
			<td>
			<select style="z-index: 100;" name="container_repeat" class="styledselect_form_1">
				<?php if(($settings_edit->container_repeat == 'repeat')||($settings_edit->container_repeat == '')):?><option value='repeat'>Repeat</option><option value='repeat-x'>Repeat Horizontal</option><option value='repeat-y'>Repeat Vertical</option><option value='no-repeat'>No Repeat</option><?php endif;?>
				<?php if($settings_edit->container_repeat == 'repeat-x'):?><option value='repeat-x'>Repeat Horizontal</option><option value='repeat'>Repeat</option><option value='repeat-y'>Repeat Vertical</option><option value='no-repeat'>No Repeat</option><?php endif;?>
				<?php if($settings_edit->container_repeat == 'repeat-y'):?><option value='repeat-y'>Repeat Vertical</option><option value='repeat'>Repeat</option><option value='repeat-x'>Repeat Horizontal</option><option value='no-repeat'>No Repeat</option><?php endif;?>
				<?php if($settings_edit->container_repeat == 'no-repeat'):?><option value='no-repeat'>No Repeat</option><option value='repeat'>Repeat</option><option value='repeat-x'>Repeat Horizontal</option><option value='repeat-y'>Repeat Vertical</option><?php endif;?>
			</select>
			</td>
		</tr>
		<tr>
			<th valign="top">Container Position:</th>
			<td>
			<select style="z-index: 100;" name="container_position" class="styledselect_form_1">
				<?php if(($settings_edit->container_position == 'top')||($settings_edit->container_position == '')):?><option value='top'>Top</option><option value='center'>Middle</option><option value='bottom'>Bottom</option><?php endif;?>
				<?php if($settings_edit->container_position == 'center'):?><option value='center'>Middle</option><option value='top'>Top</option><option value='bottom'>Bottom</option><?php endif;?>
				<?php if($settings_edit->container_position == 'bottom'):?><option value='bottom'>Bottom</option><option value='top'>Top</option><option value='center'>Middle</option><?php endif;?>
			</select>
			</td>
		</tr>
		<tr>
			<th valign="top">Current Container, Header, Text, links & border (Example):</th>
			<style>
			div#example_container{
				background: <?php echo $settings_edit->container_color_1;?>; 
				<?php if (($settings_edit->container_color_2 != '')||($settings_edit->container_color_3 != '')):?>
					background: -moz-linear-gradient(top,  <?php echo $settings_edit->container_color_1;?> 0%, <?php echo $settings_edit->container_color_2;?> 50%, <?php echo $settings_edit->container_color_3;?> 100%);
					background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo $settings_edit->container_color_1;?>), color-stop(50%,<?php echo $settings_edit->container_color_2;?>), color-stop(100%,<?php echo $settings_edit->container_color_3;?>));
					background: -webkit-linear-gradient(top,  <?php echo $settings_edit->container_color_1;?> 0%,<?php echo $settings_edit->container_color_2;?> 50%,<?php echo $settings_edit->container_color_3;?> 100%); 
					background: -o-linear-gradient(top,  <?php echo $settings_edit->container_color_1;?> 0%,<?php echo $settings_edit->container_color_2;?> 50%,<?php echo $settings_edit->container_color_3;?> 100%); 
					background: -ms-linear-gradient(top, <?php echo $settings_edit->container_color_1;?> 0%,<?php echo $settings_edit->container_color_2;?> 50%,<?php echo $settings_edit->container_color_3;?> 100%); 
					background: linear-gradient(top,  <?php echo $settings_edit->container_color_1;?> 0%,<?php echo $settings_edit->container_color_2;?> 50%,<?php echo $settings_edit->container_color_3;?> 100%); 
					filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $settings_edit->container_color_1;?>', endColorstr='<?php echo $settings_edit->container_color_2;?>',GradientType=0 );
				<?php endif;?>
				height: 300px;
				width: 300px;
				border: <?php echo $settings_edit->border_size;?>px <?php echo $settings_edit->border_style;?> <?php echo $settings_edit->border_color;?> !important;
				-moz-border-radius: <?php echo $settings_edit->corner_radius;?>px !important;
				border-radius: <?php echo $settings_edit->corner_radius;?>px !important;
				overflow: hidden;
			}
			
			div#example_container .image_wrapper{
				background-repeat: <?php echo $settings_edit->container_repeat;?> !important;
				background-position: <?php echo $settings_edit->container_position;?> !important;
				background-image:url("<?php echo base_url();?>assets/images/<?php echo $settings_edit->container_image;?>");
				height: 300px;
				width: 300px;
				padding: 5px;
			}
			
			div#example_container .image_wrapper h3{
				color: <?php echo $settings_edit->header_color;?> !important;
				font-size: <?php echo $settings_edit->header_size;?>px !important;
			}
			
			div#example_container .image_wrapper p{
				color: <?php echo $settings_edit->all_text_color;?> !important;
				font-size: <?php echo $settings_edit->all_text_size;?>px !important;
				font-family: <?php echo $settings_edit->all_text_type;?> !important;
				background-repeat: <?php echo $settings_edit->background_repeat;?> !important;
				background-position: <?php echo $settings_edit->background_position;?> !important;
			}
			
			div#example_container .image_wrapper a{
				color: <?php echo $settings_edit->link_normal_visited_color;?> !important;
				font-size: <?php echo $settings_edit->link_size;?>px !important;
			}
			
			div#example_container .image_wrapper a.active{
				color: <?php echo $settings_edit->link_hover_active_color;?> !important;
				background-image:url('<?=base_url();?>assets/images/<?php echo $settings_edit->container_image;?>') !important;
				border: <?php echo $settings_edit->border_size;?>px <?php echo $settings_edit->border_style;?> <?php echo $settings_edit->border_color;?> !important;
			}
			</style>
			<td>
				<div id="example_container">
					<div class="image_wrapper">
						<h3>Header</h3>
						<p>Here is what a paragraph should look like :P</p>
						<a>Normal/Visited Link</a>
						<a class="active">Active/Hover Link</a>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<th valign="top">Color 1 (Container Gradient):</th>
			<td>
			
			<input type="text" maxlength="6" size="6" style="color:white; text-shadow: 1px 1px 1px #000000; border: 1px silver solid; background: <?php echo $settings_edit->container_color_1;?>" value="<?php echo str_replace('#','',$settings_edit->container_color_1);?>" id="colorpickerField1" class="inp-form" name="container_color_1"></td>
		</tr>
		<tr>
			<th valign="top">Color 2 (Container Gradient):</th>
			<td>
			
			<input type="text" maxlength="6" size="6" style="color:white; text-shadow: 1px 1px 1px #000000; border: 1px silver solid; background: <?php echo $settings_edit->container_color_2;?>" value="<?php echo str_replace('#','',$settings_edit->container_color_2);?>" id="colorpickerField2" class="inp-form" name="container_color_2"></td>
		</tr>
		<tr>
			<th valign="top">Color 3 (Container Gradient):</th>
			<td>
			
			<input type="text" maxlength="6" size="6" style="color:white; text-shadow: 1px 1px 1px #000000; border: 1px silver solid; border: 1px silver solid; background: <?php echo $settings_edit->container_color_3;?>" value="<?php echo str_replace('#','',$settings_edit->container_color_3);?>" id="colorpickerField3" class="inp-form" name="container_color_3"></td>
		</tr>
		<tr>
			<th valign="top">All Text Color:</th>
			<td>
			
			<input type="text" maxlength="6" size="6" style="color:white; text-shadow: 1px 1px 1px #000000; border: 1px silver solid; background: <?php echo $settings_edit->all_text_color;?>" value="<?php echo str_replace('#','',$settings_edit->all_text_color);?>" id="colorpickerField1" class="inp-form" name="all_text_color"></td>
		</tr>
		<tr>
			<th valign="top">All Text Size:</th>
			<td><input type="text" value="<?php echo $settings_edit->all_text_size;?>" class="inp-form" name="all_text_size"></td>
		</tr>
		<tr>
			<th valign="top">All Text Type:</th>
			<td>
			<select style="z-index: 100;" name="all_text_type" class="styledselect_form_1">
				<?php if(($settings_edit->all_text_type == 'Georgia')||($settings_edit->all_text_type == '')):?><option value='Georgia'>Georgia</option><option value='Times'>Times</option><option value='Arial'>Arial</option><?php endif;?>
				<?php if($settings_edit->all_text_type == 'Times'):?><option value='Times'>Times</option><option value='Georgia'>Georgia</option><option value='Arial'>Arial</option><?php endif;?>
				<?php if($settings_edit->all_text_type == 'Arial'):?><option value='Arial'>Arial</option><option value='Georgia'>Georgia</option><option value='Times'>Times</option><?php endif;?>
			</select>
			</td>
		</tr>
		<tr>
			<th valign="top">Header Color:</th>
			<td>
			
			<input type="text" maxlength="6" size="6" style="color:white; text-shadow: 1px 1px 1px #000000; border: 1px silver solid; background: <?php echo $settings_edit->header_color;?>" value="<?php echo str_replace('#','',$settings_edit->header_color);?>" id="colorpickerField1" class="inp-form" name="header_color"></td>
		</tr>
		<tr>
			<th valign="top">Header Size:</th>
			<td><input type="text" value="<?php echo $settings_edit->header_size;?>" class="inp-form" name="header_size"></td>
		</tr>
		<tr>
			<th valign="top">Link Size:</th>
			<td><input type="text" value="<?php echo $settings_edit->link_size;?>" class="inp-form" name="link_size"></td>
		</tr>
		<tr>
			<th valign="top">Link (Normal, Visited) Color:</th>
			<td>
			
			<input type="text" maxlength="6" size="6" style="color:white; text-shadow: 1px 1px 1px #000000; border: 1px silver solid; background: <?php echo $settings_edit->link_normal_visited_color;?>" value="<?php echo str_replace('#','',$settings_edit->link_normal_visited_color);?>" id="colorpickerField1" class="inp-form" name="link_normal_visited_color"></td>
		</tr>
		<tr>
			<th valign="top">Link (Hover, Active) Color:</th>
			<td>
			
			<input type="text" maxlength="6" size="6" style="color:white; text-shadow: 1px 1px 1px #000000; border: 1px silver solid; background: <?php echo $settings_edit->link_hover_active_color;?>" value="<?php echo str_replace('#','',$settings_edit->link_hover_active_color);?>" id="colorpickerField1" class="inp-form" name="link_hover_active_color"></td>
		</tr>
		<tr>
			<th valign="top">Border Color:</th>
			<td>
			
			<input type="text" maxlength="6" size="6" style="color:white; text-shadow: 1px 1px 1px #000000; border: 1px silver solid; background: <?php echo $settings_edit->border_color;?>" value="<?php echo str_replace('#','',$settings_edit->border_color);?>" id="colorpickerField1" class="inp-form" name="border_color"></td>
		</tr>
		<tr>
			<th valign="top">Border Style:</th>
			<td>
			<select style="z-index: 100;" name="border_style" class="styledselect_form_1">
				<?php if(($settings_edit->border_style == 'none')||($settings_edit->border_style == '')):?>
					<option value='none'>None</option>
					<option value='solid'>Solid</option>
					<option value='dashed'>Dashed</option>
					<option value='dotted'>Dotted</option>
					<option value='double'>Double</option>
					<option value='groove'>Groove</option>
					<option value='ridge'>Ridge</option>
					<option value='inset'>Inset</option>
					<option value='outset'>Outset</option>
				<?php endif;?>
				<?php if($settings_edit->border_style == 'solid'):?>
					<option value='solid'>Solid</option>
					<option value='none'>None</option>
					<option value='dashed'>Dashed</option>
					<option value='dotted'>Dotted</option>
					<option value='double'>Double</option>
					<option value='groove'>Groove</option>
					<option value='ridge'>Ridge</option>
					<option value='inset'>Inset</option>
					<option value='outset'>Outset</option>
				<?php endif;?>
				<?php if($settings_edit->border_style == 'dashed'):?>
					<option value='dashed'>Dashed</option>
					<option value='none'>None</option>
					<option value='solid'>Solid</option>
					<option value='dotted'>Dotted</option>
					<option value='double'>Double</option>
					<option value='groove'>Groove</option>
					<option value='ridge'>Ridge</option>
					<option value='inset'>Inset</option>
					<option value='outset'>Outset</option>
				<?php endif;?>
				<?php if($settings_edit->border_style == 'dotted'):?>
					<option value='dotted'>Dotted</option>
					<option value='none'>None</option>
					<option value='solid'>Solid</option>
					<option value='dashed'>Dashed</option>
					<option value='double'>Double</option>
					<option value='groove'>Groove</option>
					<option value='ridge'>Ridge</option>
					<option value='inset'>Inset</option>
					<option value='outset'>Outset</option>
				<?php endif;?>
				<?php if($settings_edit->border_style == 'double'):?>
					<option value='double'>Double</option>
					<option value='none'>None</option>
					<option value='solid'>Solid</option>
					<option value='dashed'>Dashed</option>
					<option value='dotted'>Dotted</option>
					<option value='groove'>Groove</option>
					<option value='ridge'>Ridge</option>
					<option value='inset'>Inset</option>
					<option value='outset'>Outset</option>
				<?php endif;?>
				<?php if($settings_edit->border_style == 'groove'):?>
					<option value='groove'>Groove</option>
					<option value='none'>None</option>
					<option value='solid'>Solid</option>
					<option value='dashed'>Dashed</option>
					<option value='dotted'>Dotted</option>
					<option value='double'>Double</option>
					<option value='ridge'>Ridge</option>
					<option value='inset'>Inset</option>
					<option value='outset'>Outset</option>
				<?php endif;?>
				<?php if($settings_edit->border_style == 'ridge'):?>
					<option value='ridge'>Ridge</option>
					<option value='none'>None</option>
					<option value='solid'>Solid</option>
					<option value='dashed'>Dashed</option>
					<option value='dotted'>Dotted</option>
					<option value='double'>Double</option>
					<option value='groove'>Groove</option>
					<option value='inset'>Inset</option>
					<option value='outset'>Outset</option>
				<?php endif;?>
				<?php if($settings_edit->border_style == 'inset'):?>
					<option value='inset'>Inset</option>
					<option value='none'>None</option>
					<option value='solid'>Solid</option>
					<option value='dashed'>Dashed</option>
					<option value='dotted'>Dotted</option>
					<option value='double'>Double</option>
					<option value='groove'>Groove</option>
					<option value='ridge'>Ridge</option>
					<option value='outset'>Outset</option>
				<?php endif;?>
				<?php if($settings_edit->border_style == 'outset'):?>
					<option value='outset'>Outset</option>
					<option value='none'>None</option>
					<option value='solid'>Solid</option>
					<option value='dashed'>Dashed</option>
					<option value='dotted'>Dotted</option>
					<option value='double'>Double</option>
					<option value='groove'>Groove</option>
					<option value='ridge'>Ridge</option>
					<option value='inset'>Inset</option>
				<?php endif;?>
			</select>
			</td>
		</tr>
		<tr>
			<th valign="top">Border Size:</th>
			<td><input type="text" value="<?php echo $settings_edit->border_size;?>" class="inp-form" name="border_size"></td>
		</tr>
		<tr>
			<th valign="top">Corner Radius:</th>
			<td><input type="text" value="<?php echo $settings_edit->corner_radius;?>" class="inp-form" name="corner_radius"></td>
		</tr>
		<tr>
			<th>Splash Overlay Image (for Homepage):</th>
			<td>
			<div style="background: black; width: 400px; height: auto; overflow: hidden;">
				<a href='<?php echo base_url();?>assets/images/<?php echo $settings_edit->splash_overlay_image;?>' rel="prettyPhoto">
					<img style="border: 1px silver solid;" src='<?php echo base_url();?>assets/images/<?php echo $settings_edit->splash_overlay_image;?>' width='400' style='height: auto;'/>
				</a>
			</div>
			</td>
			<td></td>
		</tr>
		<tr>
		<th>&nbsp;</th>
		<td>
			<?php 
			echo form_upload('splash_overlay_image',$settings_edit->splash_overlay_image, $attr); 
			?>
			<br/>
			<?php echo anchor('admin/settings/delete_image/'.str_replace('.','_',str_replace('.png','',$settings_edit->splash_overlay_image)), 'Delete Image');?>
		</td>
		<td style="padding: 0px 95px 10px;">
			<div class="bubble-left"></div>
			<div class="bubble-inner">PNG 5MB max per image</div>
			<div class="bubble-right"></div>
		</td>
		</tr>
		
		<tr>
			<th colspan="2"><h3>Social Networks</h3></th>
		</tr>
		<tr>
			<th valign="top">Facebook:</th>
			<td>
			<input type="text" value="<?php echo $settings_edit->facebook;?>" class="inp-form" name="facebook"/>
			<?php if($settings_edit->facebook != ""): ?>
			<br/><br/>
			<div style="z-index: -100;" class="fb-like-box" data-href="<?php echo $settings_edit->facebook;?>" data-width="340" data-colorscheme="<?php echo $settings_edit->fb_color_scheme;?>" data-show-faces="false" data-stream="true" data-header="false"></div>	
			<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th valign="top">Facebook Color Scheme:</th>
			<td>
			<select style="z-index: 100;" name="fb_color_scheme" class="styledselect_form_1">
				<?php if($settings_edit->fb_color_scheme == 'dark'):?><option value='dark'>Dark</option><option value='light'>Light</option><?php endif;?>
				<?php if($settings_edit->fb_color_scheme == 'light'):?><option value='light'>Light</option><option value='dark'>Dark</option><?php endif;?>
			</select>
			</td>
			</td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th valign="top">Twitter:</th>
			<td>
			<input type="text" value="<?php echo $settings_edit->twitter;?>" class="inp-form" name="twitter"/>
			<?php if($settings_edit->twitter != ""): ?>
			<br/><br/>
				<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
				<script>
				new TWTR.Widget({
				  version: 2,
				  type: 'profile',
				  rpp: 4,
				  interval: 30000,
				  width: 340,
				  height: 300,
				  theme: {
					shell: {
						background: '<?php echo $settings_edit->color_1;?>',
						color: '<?php echo $settings_edit->all_text_color;?>'
					},
					tweets: {
								background: '<?php echo $settings_edit->color_2;?>',
								color: '<?php echo $settings_edit->link_normal_visited_color;?>',
								links: '<?php echo $settings_edit->link_hover_active_color;?>'
							}
				  },
				  features: {
					scrollbar: false,
					loop: false,
					live: false,
					behavior: 'all'
				  }
				}).render().setUser('<?php echo str_replace("https://twitter.com/#!/","@",$settings_edit->twitter);?>').start();
				</script>
			<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th colspan="2"><h3>Terms & Conditions</h3></th>
		</tr>
		<tr>
			<th valign="top">Title (Terms & Conditions):</th>
			<td><input type="text" value="<?php echo $terms_conditions_edit->title;?>" class="inp-form-error" name="title2"></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th valign="top">Description (Terms & Conditions):</th>
			<td>
			<textarea cols="80" class="form-textarea" id="editor2" name="description2" rows="10"><?php echo $terms_conditions_edit->description;?></textarea>
			<script type="text/javascript">
			//<![CDATA[

				CKEDITOR.replace( 'editor2', {
					removePlugins : 'resize',
					toolbar :
					[

					]								
				});

			//]]>
			</script>
			
			</td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td valign="top">
				<input type="submit" value="" class="form-submit" />
				<!-- <input type="reset" value="" class="form-reset"  /> -->
			</td>
			<td></td>
		</tr>
	</table>
	</form>
	<!-- end id-form  -->

	</td>

</tr>
<tr>
<td><img src="<?=base_url();?>assets/admin/images/shared/blank.gif" width="695" height="1" alt="blank" /></td>
<td></td>
</tr>
</table>